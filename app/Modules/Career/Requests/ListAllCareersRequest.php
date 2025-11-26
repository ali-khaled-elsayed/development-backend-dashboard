<?php

namespace App\Modules\Career\Requests;


use App\Modules\Shared\Requests\BaseRequest;

class ListAllCareersRequest extends BaseRequest
{
    public function getFilters()
    {
        return [
            'title' => 'title',
        ];
    }

    public function constructQueryCriteria(array $queryParameters)
    {
        $filters = $this->setFilters(data_get($queryParameters, 'filters'));
        return array_merge($this->constructBaseGetQuery($queryParameters), ['filters' => $filters]);
    }
}
