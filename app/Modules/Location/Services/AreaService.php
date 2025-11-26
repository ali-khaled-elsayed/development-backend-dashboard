<?php

namespace App\Modules\Location\Services;

use App\Modules\Location\Repositories\AreaRepository;
use App\Modules\Location\Requests\ListAllAreasRequest;

class AreaService
{
    public function __construct(private AreaRepository $areaRepository) {}

    public function listAllAreas($queryParameters)
    {

        $listAllAreas = (new ListAllAreasRequest)->constructQueryCriteria($queryParameters);
        $Areas = $this->areaRepository->getAllAreas($listAllAreas);

        return [
            'data' => $Areas['data'],
            'count' => $Areas['count']
        ];
    }

    public function create($areaId, $userId)
    {

        return $this->areaRepository->create(['area_id' => $areaId, 'user_id' => $userId]);
    }

    public function createArea($request)
    {
        return $this->areaRepository->create($request);
    }
}
