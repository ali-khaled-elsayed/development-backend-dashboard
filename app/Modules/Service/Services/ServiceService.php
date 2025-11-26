<?php

namespace App\Modules\Service\Services;

use App\Modules\Service\Repositories\ServiceRepository;
use App\Modules\Service\Requests\ListAllServicesRequest;
use App\Modules\Service\Resources\ServiceCollection;

class ServiceService
{
    public function __construct(private ServiceRepository $serviceRepository) {}

    public function createService($request)
    {
        $service = $this->constructServiceModel($request);
        return $this->serviceRepository->create($service);
    }

    public function updateService($id, $request)
    {
        $service = $this->constructServiceModel($request);
        return $this->serviceRepository->update($id, $service);
    }

    public function deleteService($id)
    {
        return $this->serviceRepository->delete($id);
    }

    public function listAllServices(array $queryParameters)
    {
        $listAllServices = (new ListAllServicesRequest)->constructQueryCriteria($queryParameters);

        // Get Countries from Database
        $services = $this->serviceRepository->findAllBy($listAllServices);

        return [
            'data' => new ServiceCollection($services['data']),
            'count' => $services['count']
        ];
    }

    public function getServiceById($id)
    {
        return $this->serviceRepository->find($id);
    }

    public function constructServiceModel($request)
    {
        $serviceModel = [
            'name_en' => $request['name_en'],
            'name_ar' => $request['name_ar'],
        ];

        if (isset($request['image'])) {
            $serviceModel['image'] = $request['image'];
        }

        return $serviceModel;
    }
}
