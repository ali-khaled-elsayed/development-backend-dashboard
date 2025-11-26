<?php

namespace App\Modules\Career\Services;

use App\Modules\Career\Resources\CareerCollection;
use App\Modules\Career\Repositories\CareerRepository;
use App\Modules\Career\Requests\ListAllCareersRequest;

class CareerService
{
    public function __construct(private CareerRepository $careerRepository) {}

    public function createCareer($request)
    {
        $career = $this->constructCareerModel($request);
        return $this->careerRepository->create($career);
    }

    public function updateCareer($id, $request)
    {
        $career = $this->constructCareerModel($request);
        return $this->careerRepository->update($id, $career);
    }

    public function deleteCareer($id)
    {
        return $this->careerRepository->delete($id);
    }

    public function listAllCareers(array $queryParameters)
    {
        $listAllCareers = (new ListAllCareersRequest)->constructQueryCriteria($queryParameters);

        // Get Countries from Database
        $careers = $this->careerRepository->findAllBy($listAllCareers);

        return [
            'data' => new CareerCollection($careers['data']),
            'count' => $careers['count']
        ];
    }

    public function getCareerById($id)
    {
        return $this->careerRepository->find($id);
    }

    public function constructCareerModel($request)
    {
        $careerModel = [
            'title_en' => $request['title_en'],
            'title_ar' => $request['title_ar'],
            'type' => $request['type'] ?? null,
            'description_en' => $request['description_en'],
            'description_ar' => $request['description_ar'],
        ];

        if (isset($request['image'])) {
            $careerModel['image'] = $request['image'];
        }

        return $careerModel;
    }
}
