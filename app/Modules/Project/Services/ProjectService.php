<?php

namespace App\Modules\Project\Services;

use App\Modules\Project\Repositories\ProjectRepository;
use App\Modules\Project\Requests\ListAllProjectsRequest;
use App\Modules\Project\Resources\ProjectCollection;

class ProjectService
{
    public function __construct(private ProjectRepository $projectRepository) {}

    public function createProject($request)
    {
        $project = $this->constructProjectModel($request);
        return $this->projectRepository->create($project);
    }

    public function updateProject($id, $request)
    {
        $project = $this->constructProjectModel($request);
        return $this->projectRepository->update($id, $project);
    }

    public function deleteProject($id)
    {
        return $this->projectRepository->delete($id);
    }

    public function listAllProjects(array $queryParameters)
    {
        $listAllProjects = (new ListAllProjectsRequest)->constructQueryCriteria($queryParameters);

        // Get Countries from Database
        $projects = $this->projectRepository->findAllWithFilters($listAllProjects);

        return [
            'data' => new ProjectCollection($projects['data']),
            'count' => $projects['count']
        ];
    }

    public function getProjectById($id)
    {
        return $this->projectRepository->find($id);
    }

    public function constructProjectModel($request)
    {
        $projectModel = [
            'title_en' => $request['title_en'],
            'title_ar' => $request['title_ar'],
            'description_en' => $request['description_en'],
            'description_ar' => $request['description_ar'],
            'short_description_en' => $request['short_description_en'],
            'short_description_ar' => $request['short_description_ar'],
            'meta_title_en' => $request['metaTitle_en'],
            'meta_title_ar' => $request['metaTitle_ar'],
            'meta_description_en' => $request['metaDescription_en'],
            'meta_description_ar' => $request['metaDescription_ar'],
            'project_area' => $request['area'],
            'location' => $request['location'],
            'type' => $request['type'],
            'city_id' => $request['cityId'],
            'area_id' => $request['areaId'],
            'delivery_date' => $request['deliveryDate'],
            'video_link' => $request['videoLink'],
            'payment_plan' => $request['paymentPlan'] ?? [],
        ];

        if (isset($request['masterPlan'])) {
            $projectModel['master_plan'] = $request['masterPlan'];
        }

        if (isset($request['logo'])) {
            $projectModel['logo'] = $request['logo'];
        }

        return $projectModel;
    }
}
