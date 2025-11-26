<?php

use App\Modules\Blog\BlogController;
use Illuminate\Support\Facades\Route;
use App\Modules\Event\EventController;
use App\Modules\Career\CareerController;
use App\Modules\Client\ClientController;
use App\Modules\Project\ProjectController;
use App\Modules\Service\ServiceController;
use App\Modules\Location\LocationController;
use App\Modules\PropertyTypes\PropertyController;
use App\Modules\Client\Resources\ClientCollection;


Route::get('test', function () {
    return response()->json(['message' => 'It works!']);
});

// Route::controller(UserController::class)->prefix('users')->middleware('api') ->group(function () {
//     // Route::get('', 'listAllUsers');
//     Route::get('/test', 'test');
//     Route::post('', 'createUser');
//     Route::get('{userId}', 'getUserById');
//     Route::put('{userId}', 'updateUser');
//     Route::delete('{userId}', 'deleteUser');
//     Route::put('{userId}/toggle-status', 'toggleUserStatus');
//     Route::post('/change-password', 'changePassword');
// });

Route::controller(ProjectController::class)->prefix('projects')->group(function () {
    Route::get('', 'listAllProjects');
    Route::post('', 'createProject');
    Route::get('{projectId}', 'getProjectById');
    Route::post('{projectId}', 'updateProject');
    Route::post('{projectId}/assign-services', 'assignServices');
    Route::delete('{projectId}', 'deleteProject');
});

Route::controller(BlogController::class)->prefix('blogs')->group(function () {
    Route::get('', 'listAllBlogs');
    Route::post('', 'createBlog');
    Route::get('{blogId}', 'getBlogById');
    Route::post('{blogId}', 'updateBlog');
    Route::delete('{blogId}', 'deleteBlog');
});

Route::controller(PropertyController::class)->prefix('properties')->group(function () {
    Route::get('', 'listAllProperties');
    Route::post('', 'createProperty');
    Route::get('{propertyId}', 'getPropertyById');
    Route::post('{propertyId}', 'updateProperty');
    Route::delete('{propertyId}', 'deleteProperty');
});

Route::controller(ClientController::class)->prefix('clients')->group(function () {
    Route::get('', 'listAllClients');
    Route::post('', 'createClient');
    Route::get('{clientId}', 'getClientById');
    Route::post('{clientId}', 'updateClient');
    Route::delete('{clientId}', 'deleteClient');
});

Route::controller(ServiceController::class)->prefix('services')->group(function () {
    Route::get('', 'listAllServices');
    Route::post('', 'createService');
    Route::get('{serviceId}', 'getServiceById');
    Route::post('{serviceId}', 'updateService');
    Route::delete('{ServiceId}', 'deleteService');
});

Route::controller(LocationController::class)->prefix('locations')->group(function () {
    Route::get('/cities', 'listAllCites');
    Route::get('/areas', 'listAllAreas');
    Route::post('/cities', 'createCity');
    Route::post('/areas', 'createArea');
});

Route::controller(CareerController::class)->prefix('careers')->group(function () {
    Route::get('', 'listAllCareers');
    Route::post('', 'createCareer');
    Route::get('{careerId}', 'getCareerById');
    Route::post('{careerId}', 'updateCareer');
    Route::delete('{careerId}', 'deleteCareer');
});

Route::controller(EventController::class)->prefix('events')->group(function () {
    Route::get('', 'listAllEvents');
    Route::post('', 'createEvent');
    Route::get('{eventId}', 'getEventById');
    Route::post('{eventId}', 'updateEvent');
    Route::delete('{eventId}', 'deleteEvent');
});
