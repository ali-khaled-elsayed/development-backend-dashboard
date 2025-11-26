<?php

namespace App\Modules\PropertyTypes;

use App\Http\Controllers\Controller;
use App\Modules\Shared\Enums\HttpStatusCodeEnum;
use App\Modules\PropertyTypes\Services\PropertyService;
use App\Modules\PropertyTypes\Resources\PropertyResource;
use App\Modules\PropertyTypes\Requests\CreatePropertyRequest;
use App\Modules\PropertyTypes\Requests\ListPropertiesRequest;
use App\Modules\PropertyTypes\Requests\UpdatePropertyRequest;

class PropertyController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function createProperty(CreatePropertyRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
            $data['image'] = $path;
        }
        $property = $this->propertyService->createProperty($data);
        return successJsonResponse(new PropertyResource($property), __('property.success.create_Property'));
    }

    public function updateProperty($id, UpdatePropertyRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('image', 'public');
            $data['image'] = $path;
        }
        $property = $this->propertyService->updateProperty($id, $data);
        return successJsonResponse(new PropertyResource($property), __('property.success.update_Property'));
    }

    public function deleteProperty($id)
    {
        $property = $this->propertyService->deleteProperty($id);
        if ($property == true) {
            return successJsonResponse([], __('property.success.delete_property property_id = ' . $property['id']));
        } else {
            return errorJsonResponse("There is No property with id = " . $id, HttpStatusCodeEnum::Not_Found->value);
        }
    }

    public function listAllProperties(ListPropertiesRequest $request)
    {
        $properties = $this->propertyService->listAllProperties($request->validated());
        return successJsonResponse(data_get($properties, 'data'), __('Projects.success.get_all_Projects'), data_get($properties, 'count'));
    }

    public function getPropertyById($propertyId)
    {
        $property = $this->propertyService->getPropertyById($propertyId);
        if (!$property) {
            return errorJsonResponse("property $propertyId is not found!", HttpStatusCodeEnum::Not_Found->value);
        }
        return successJsonResponse(new PropertyResource($property), __('property.success.property_details'));
    }
}
