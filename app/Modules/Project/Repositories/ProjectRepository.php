<?php

namespace App\Modules\Project\Repositories;

use App\Models\Project;
use App\Modules\Shared\Repositories\BaseRepository;

class ProjectRepository extends BaseRepository
{
    public function __construct(private Project $model)
    {
        parent::__construct($model);
    }

    public function findAllWithFilters($queryCriteria = [])
    {
        $query = $this->model->newQuery();
        $limit = data_get($queryCriteria, 'limit', 10);
        $offset = data_get($queryCriteria, 'offset', 0);
        $sortBy = data_get($queryCriteria, 'sortBy', 'id');
        $sort = data_get($queryCriteria, 'sort', 'DESC');
        $filters = data_get($queryCriteria, 'filters', []);

        if (!empty($filters)) {
            if (!empty($filters['city_id'])) {
                $query->where('city_id', $filters['city_id']);
            }

            if (!empty($filters['area_id'])) {
                $query->where('area_id', $filters['area_id']);
            }

            if (!empty($filters['type'])) {
                $query->where('type', $filters['type']);
            }
        }

        // === 🏠 Property-level filters (related table) ===
        if (
            isset($filters['propertyType']) ||
            isset($filters['priceMin']) ||
            isset($filters['priceMax']) ||
            isset($filters['noOfRooms'])
        ) {
            $query->whereHas('propertyTypes', function ($propertyQuery) use ($filters) {
                if (!empty($filters['propertyType'])) {
                    $propertyQuery->where('type', $filters['propertyType']);
                }

                if (!empty($filters['priceMin'])) {
                    $propertyQuery->where('price_min', '>=', $filters['priceMin']);
                }

                if (!empty($filters['priceMax'])) {
                    $propertyQuery->where('price_max', '<=', $filters['priceMax']);
                }

                if (!empty($filters['areaMin'])) {
                    $propertyQuery->where('area_min', '>=', $filters['areaMin']);
                }

                if (!empty($filters['areaMax'])) {
                    $propertyQuery->where('area_max', '<=', $filters['areaMax']);
                }

                if (!empty($filters['noOfRooms'])) {
                    $propertyQuery
                        ->where('no_of_bedrooms_min', '<=', $filters['noOfRooms'])
                        ->where('no_of_bedrooms_max', '>=', $filters['noOfRooms']);
                }
            });
        }

        return [
            'count' => $query->count(),
            'data' => $query->skip($offset)->take($limit)->orderBy($sortBy, $sort)->get(),
        ];
    }
}
