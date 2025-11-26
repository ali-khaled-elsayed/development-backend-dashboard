<?php

namespace App\Modules\Client\Requests;


use App\Modules\Shared\Requests\BaseRequest;

class ListAllClientsRequest extends BaseRequest
{
    public function getFilters()
    {
        return [
            'unitType' => 'unit_type',
        ];
    }

    public function constructQueryCriteria(array $queryParameters)
    {
        $filters = $this->setFilters(data_get($queryParameters, 'filters'));
        return array_merge($this->constructBaseGetQuery($queryParameters), ['filters' => $filters]);
    }
}
