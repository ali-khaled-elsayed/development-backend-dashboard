<?php

namespace App\Modules\Client;

use App\Http\Controllers\Controller;
use App\Modules\Client\Requests\CreateClientRequest;
use App\Modules\Client\Requests\ListClientsRequest;
use App\Modules\Client\Requests\UpdateClientRequest;
use App\Modules\Client\Resources\ClientResource;
use App\Modules\Client\Services\ClientService;
use App\Modules\Shared\Enums\HttpStatusCodeEnum;

class ClientController extends Controller
{
    public function __construct(private ClientService $clientService) {}

    public function createClient(CreateClientRequest $request)
    {
        $client = $this->clientService->createClient($request->validated());
        return successJsonResponse(new ClientResource($client), __('client.success.create_client'));
    }

    public function updateClient($id, UpdateClientRequest $request)
    {
        $client = $this->clientService->updateClient($id, $request->validated());
        return successJsonResponse(new ClientResource($client), __('client.success.update_client'));
    }

    public function deleteClient($id)
    {
        $client = $this->clientService->deleteClient($id);
        if ($client == true) {
            return successJsonResponse([], __('client.success.delete_client client_id = ' . $client['id']));
        } else {
            return errorJsonResponse("There is No client with id = " . $id, HttpStatusCodeEnum::Not_Found->value);
        }
    }

    public function listAllClients(ListClientsRequest $request)
    {
        $clients = $this->clientService->listAllClients($request->validated());
        return successJsonResponse(data_get($clients, 'data'), __('clients.success.get_all_clients'), data_get($clients, 'count'));
    }

    public function getClientById($clientId)
    {
        $client = $this->clientService->getClientById($clientId);
        if (!$client) {
            return errorJsonResponse("Project $clientId is not found!", HttpStatusCodeEnum::Not_Found->value);
        }
        return successJsonResponse(new ClientResource($client), __('client.success.client_details'));
    }
}
