<?php

namespace App\Modules\Project;

use App\Http\Controllers\Controller;
use App\Modules\User\Resources\UserResource;
use App\Modules\Project\Services\ProjectService;
use App\Modules\Shared\Enums\HttpStatusCodeEnum;
use App\Modules\Project\Requests\ListProjectsRequest;
use App\Modules\Project\Requests\CreateProjectRequest;
use App\Modules\Project\Requests\UpdateProjectRequest;
use App\Modules\Project\Resources\ProjectResource;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projectService) {}

    public function createProject(CreateProjectRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('masterPlan')) {
            $path = $request->file('masterPlan')->store('master_plans', 'public');
            $data['masterPlan'] = $path;
        }
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        $project = $this->projectService->createProject($data);
        if ($request->has('galleries')) {
            foreach ($request->galleries as $galleryItem) {
                $file = $galleryItem['file'];
                $type = $galleryItem['type']; // image or video

                $path = $file->store("projects/galleries", 'public');

                $project->galleries()->create([
                    'url' => $path,
                    'type' => $type,
                ]);
            }
        }

        // ✅ Handle services (many-to-many)
        if ($request->has('services')) {
            $project->services()->sync($request->services);
        }

        return successJsonResponse(new ProjectResource($project), __('Project.success.create_Project'));
    }

    public function updateProject($id, UpdateProjectRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('masterPlan')) {
            $path = $request->file('masterPlan')->store('master_plans', 'public');
            $data['masterPlan'] = $path;
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }
        $project = $this->projectService->updateProject($id, $data);

        if ($request->has('galleries')) {
            foreach ($request->galleries as $galleryItem) {
                $file = $galleryItem['file'];
                $type = $galleryItem['type'];

                $path = $file->store('projects/galleries', 'public');

                $project->galleries()->create([
                    'url' => $path,
                    'type' => $type,
                ]);
            }
        }

        if ($request->has('services')) {
            $project->services()->sync($request->services);
        } else {
            $project->services()->detach(); // remove all if not sent
        }

        // ✅ Handle gallery deletions (optional)
        if ($request->has('deleted_gallery_ids')) {
            $deletedIds = $request->deleted_gallery_ids;
            $project->galleries()->whereIn('id', $deletedIds)->delete();
        }
        return successJsonResponse(new ProjectResource($project), __('Project.success.update_Project'));
    }

    public function deleteProject($id)
    {
        $project = $this->projectService->deleteProject($id);
        if ($project == true) {
            return successJsonResponse([], __('Project.success.delete_Project project_id = ' . $project['id']));
        } else {
            return errorJsonResponse("There is No Project with id = " . $id, HttpStatusCodeEnum::Not_Found->value);
        }
    }

    public function listAllProjects(ListProjectsRequest $request)
    {
        $projects = $this->projectService->listAllProjects($request->validated());
        return successJsonResponse(data_get($projects, 'data'), __('Projects.success.get_all_Projects'), data_get($projects, 'count'));
    }

    public function getProjectById($projectId)
    {
        $project = $this->projectService->getProjectById($projectId);
        if (!$project) {
            return errorJsonResponse("Project $projectId is not found!", HttpStatusCodeEnum::Not_Found->value);
        }
        return successJsonResponse(new ProjectResource($project), __('Project.success.Project_details'));
    }

    public function a(Request $request, $projectId)
    {
        $request->validate([
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        $project = $this->projectService->getProjectById($projectId);

        // attach or sync services
        $project->services()->sync($request->services);

        return response()->json([
            'message' => 'Services assigned successfully',
            'project' => $project->load('services')
        ]);
    }
}
