<?php

namespace App\Modules\Project\Requests;


use App\Modules\Shared\Requests\BaseRequest;

class ListAllProjectsRequest extends BaseRequest
{
    public function getFilters()
    {
        return [
            'area' => 'area_id',
            'city' => 'city_id',
            'projectType' => 'type',
            'propertyType' => 'propertyType',
            'priceMin' => 'priceMin',
            'priceMax' => 'priceMax',
            'areaMin' => 'areaMin',
            'areaMax' => 'areaMax',
            'noOfRooms' => 'noOfRooms',
        ];
    }

    public function constructQueryCriteria(array $queryParameters)
    {
        $filters = $this->setFilters(data_get($queryParameters, 'filters'));
        return array_merge($this->constructBaseGetQuery($queryParameters), ['filters' => $filters]);
    }
}
