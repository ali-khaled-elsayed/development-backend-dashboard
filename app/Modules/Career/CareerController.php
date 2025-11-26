<?php

namespace App\Modules\Career;

use App\Http\Controllers\Controller;
use App\Modules\Career\Services\CareerService;
use App\Modules\Career\Resources\CareerResource;
use App\Modules\Shared\Enums\HttpStatusCodeEnum;
use App\Modules\Career\Requests\ListCareersRequest;
use App\Modules\Career\Requests\CreateCareerRequest;
use App\Modules\Career\Requests\UpdateCareerRequest;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function __construct(private CareerService $careerService) {}

    public function createCareer(CreateCareerRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('careers', 'public');
            $data['image'] = $path;
        }
        $career = $this->careerService->createCareer($data);
        return successJsonResponse(new CareerResource($career), __('career.success.create_career'));
    }

    public function updateCareer($id, UpdateCareerRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('careers', 'public');
            $data['image'] = $path;
        }
        $career = $this->careerService->updateCareer($id, $data);
        return successJsonResponse(new CareerResource($career), __('career.success.update_career'));
    }

    public function deleteCareer($id)
    {
        $career = $this->careerService->deleteCareer($id);
        if ($career == true) {
            return successJsonResponse([], __('career.success.delete_career career_id = ' . $career['id']));
        } else {
            return errorJsonResponse("There is No career with id = " . $id, HttpStatusCodeEnum::Not_Found->value);
        }
    }

    public function listAllCareers(ListCareersRequest $request)
    {
        $careers = $this->careerService->listAllCareers($request->validated());
        return successJsonResponse(data_get($careers, 'data'), __('careers.success.get_all_careers'), data_get($careers, 'count'));
    }

    public function getCareerById($careerId)
    {
        $career = $this->careerService->getCareerById($careerId);
        if (!$career) {
            return errorJsonResponse("career $careerId is not found!", HttpStatusCodeEnum::Not_Found->value);
        }
        return successJsonResponse(new CareerResource($career), __('career.success.career_details'));
    }
}
