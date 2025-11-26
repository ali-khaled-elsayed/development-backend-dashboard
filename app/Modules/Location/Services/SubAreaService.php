<?php

namespace App\Modules\Location\Services;

use App\Modules\Location\Repositories\SubAreaRepository;
use App\Modules\Location\Requests\ListAllSubAreasRequest;

class SubAreaService {

    public function __construct(private SubAreaRepository $subAreaRepository) {
    }

    public function listAllSubAreas($queryParameters) {

        $listAllAreas = (new ListAllSubAreasRequest)->constructQueryCriteria($queryParameters);
        $Areas = $this->subAreaRepository->getAllSubAreas($listAllAreas);

        return [
            'data' => $Areas['data'],
            'count' => $Areas['count']
        ];
    }
}
