<?php

namespace App\Modules\PropertyTypes\Requests;


use App\Modules\Shared\Requests\BaseRequest;

class ListAllPropertiesRequest extends BaseRequest
{
    public function getFilters()
    {
        return [
            'projectId' => 'project_id',
        ];
    }

    public function constructQueryCriteria(array $queryParameters)
    {
        $filters = $this->setFilters(data_get($queryParameters, 'filters'));
        return array_merge($this->constructBaseGetQuery($queryParameters), ['filters' => $filters]);
    }
}
