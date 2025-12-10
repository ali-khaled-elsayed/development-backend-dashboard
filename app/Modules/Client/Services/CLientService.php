<?php

namespace App\Modules\Client\Services;

use App\Modules\Client\Repositories\ClientRepository;
use App\Modules\Client\Requests\ListAllClientsRequest;
use App\Modules\Client\Resources\ClientCollection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClientService
{
    public function __construct(private ClientRepository $clientRepository) {}

    public function createClient($request)
    {
        $clientData = $this->constructClientModel($request);
        $client = $this->clientRepository->create($clientData);

        // Step 2: Call CRM API
        // $this->sendClientToCrm($client);

        return $client;
    }

    public function updateClient($id, $request)
    {
        $client = $this->constructClientModel($request);
        return $this->clientRepository->update($id, $client);
    }

    public function deleteClient($id)
    {
        return $this->clientRepository->delete($id);
    }

    public function listAllClients(array $queryParameters)
    {
        $listAllClients = (new ListAllClientsRequest)->constructQueryCriteria($queryParameters);
        $clients = $this->clientRepository->findAllBy($listAllClients);

        return [
            'data' => new ClientCollection($clients['data']),
            'count' => $clients['count']
        ];
    }

    public function getClientById($id)
    {
        return $this->clientRepository->find($id);
    }

    public function constructClientModel($request)
    {
        $clientModel = [
            'name' => $request['name'],
            'email' => $request['email'],
            'message' => $request['message'],
            'unit_type' => $request['unitType'],
            'phone' => $request['phone'],
            'city_id' => $request['cityId'],
            'area_id' => $request['areaId'],
            'project_id' => $request['projectId'],
        ];

        return $clientModel;
    }

    private function sendClientToCrm($client)
    {
        $url = 'https://crm.leaderdevelop.com/api/register_landingpage';

        try {
            $response = Http::asForm()->post($url, [
                // 'title'      => 'mr',
                'name'       => $client->name,
                'mobile'     => $client->phone,
                'email'      => $client->email,
                'fromwhere'  => 'landing',
                'applink_id' => 10,
            ]);

            if ($response->failed()) {
                Log::error('CRM Sync Failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('CRM API Error', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}
