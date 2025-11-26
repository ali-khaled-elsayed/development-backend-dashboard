<?php

namespace App\Modules\PropertyTypes\Services;

use App\Modules\PropertyTypes\Repositories\PropertyRepository;
use App\Modules\PropertyTypes\Resources\PropertyCollection;
use App\Modules\PropertyTypes\Requests\ListAllPropertiesRequest;

class PropertyService
{
    public function __construct(private PropertyRepository $propertyRepository) {}

    public function createProperty($request)
    {
        $property = $this->constructPropertyModel($request);
        return $this->propertyRepository->create($property);
    }

    public function updateProperty($id, $request)
    {
        $property = $this->constructPropertyModel($request);
        return $this->propertyRepository->update($id, $property);
    }

    public function deleteProperty($id)
    {
        return $this->propertyRepository->delete($id);
    }

    public function listAllProperties(array $queryParameters)
    {
        $listAllProperties = (new ListAllPropertiesRequest)->constructQueryCriteria($queryParameters);
        $properties = $this->propertyRepository->findAllBy($listAllProperties);
        return [
            'data' => new PropertyCollection($properties['data']),
            'count' => $properties['count']
        ];
    }

    public function getPropertyById($id)
    {
        return $this->propertyRepository->find($id);
    }

    public function constructPropertyModel($request)
    {
        $propertyModel = [
            'type' => $request['type'],
            'area_min' => $request['areaMin'],
            'area_max' => $request['areaMax'],
            'price_min' => $request['priceMin'],
            'price_max' => $request['priceMax'],
            'no_of_bedrooms_min' => $request['noOfBedroomsMin'],
            'no_of_bedrooms_max' => $request['noOfBedroomsMax'],
            'no_of_bathrooms_min' => $request['noOfBathroomsMin'],
            'no_of_bathrooms_max' => $request['noOfBathroomsMax'],
            'project_id' => $request['projectId'],
        ];

        if (isset($request['image'])) {
            $propertyModel['image'] = $request['image'];
        }

        return $propertyModel;
    }
}
