<?php

namespace App\Modules\Service;

use App\Http\Controllers\Controller;
use App\Modules\Service\Requests\CreateServiceRequest;
use App\Modules\Service\Requests\ListServicesRequest;
use App\Modules\Service\Requests\UpdateServiceRequest;
use App\Modules\Service\Resources\ServiceResource;
use App\Modules\Service\Services\ServiceService;
use App\Modules\Shared\Enums\HttpStatusCodeEnum;


class ServiceController extends Controller
{
    public function __construct(private ServiceService $serviceService) {}

    public function createService(CreateServiceRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }
        $service = $this->serviceService->createService($data);
        return successJsonResponse(new ServiceResource($service), __('service.success.create_service'));
    }

    public function updateService($id, UpdateServiceRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $data['image'] = $path;
        }
        $service = $this->serviceService->updateService($id, $data);
        return successJsonResponse(new ServiceResource($service), __('service.success.update_service'));
    }

    public function deleteService($id)
    {
        $service = $this->serviceService->deleteService($id);
        if ($service == true) {
            return successJsonResponse([], __('service.success.delete_service service_id = ' . $service['id']));
        } else {
            return errorJsonResponse("There is No service with id = " . $id, HttpStatusCodeEnum::Not_Found->value);
        }
    }

    public function listAllServices(ListServicesRequest $request)
    {
        $services = $this->serviceService->listAllServices($request->validated());
        return successJsonResponse(data_get($services, 'data'), __('services.success.get_all_services'), data_get($services, 'count'));
    }

    public function getServiceById($serviceId)
    {
        $service = $this->serviceService->getServiceById($serviceId);
        if (!$service) {
            return errorJsonResponse("Project $serviceId is not found!", HttpStatusCodeEnum::Not_Found->value);
        }
        return successJsonResponse(new ServiceResource($service), __('service.success.service_details'));
    }
}
