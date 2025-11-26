<?php

namespace App\Modules\Location\Repositories;

use App\Models\SubArea;
use App\Modules\Shared\Repositories\BaseRepository;

class SubAreaRepository extends BaseRepository
{

    public function __construct(private SubArea $model)
    {

        parent::__construct($model);
    }
    public function getAllSubAreas($queryCriteria)
    {
        $query = $this->model;

        $limit = data_get($queryCriteria, 'limit', 10);
        $offset = data_get($queryCriteria, 'offset', 0);
        $sortBy = data_get($queryCriteria, 'sortBy', 'id');
        $sort = data_get($queryCriteria, 'sort', 'DESC');
        $filters = data_get($queryCriteria, 'filters', []);

        if (!empty($filters['sub_area_name'])) {
            $query = $query->where(function ($q) use ($filters) {
                $q->where('name_en', $filters['sub_area_name'])
                    ->orWhere('name_ar', $filters['sub_area_name']);
            });
        }

        if (!empty($filters['area_id'])) {
            $query = $query->where('area_id', $filters['area_id']);
        }
        return [
            'count' => $query->count(),
            'data' => $query->skip($offset)->take($limit)->orderBy($sortBy, $sort)->get(),
        ];
    }
}
