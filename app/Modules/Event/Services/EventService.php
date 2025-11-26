<?php

namespace App\Modules\Event\Services;

use App\Modules\Event\Repositories\EventRepository;
use App\Modules\Event\Requests\ListAllEventsRequest;
use App\Modules\Event\Resources\EventCollection;

class EventService
{
    public function __construct(private EventRepository $eventRepository) {}

    public function createEvent($request)
    {
        $event = $this->constructEventModel($request);
        return $this->eventRepository->create($event);
    }

    public function updateEvent($id, $request)
    {
        $event = $this->constructEventModel($request);
        return $this->eventRepository->update($id, $event);
    }

    public function deleteEvent($id)
    {
        return $this->eventRepository->delete($id);
    }

    public function listAllEvents(array $queryParameters)
    {
        $listAllEvents = (new ListAllEventsRequest)->constructQueryCriteria($queryParameters);

        // Get Countries from Database
        $events = $this->eventRepository->findAllBy($listAllEvents);

        return [
            'data' => new EventCollection($events['data']),
            'count' => $events['count']
        ];
    }

    public function getEventById($id)
    {
        return $this->eventRepository->find($id);
    }

    public function constructEventModel($request)
    {
        $eventModel = [
            'title_en' => $request['title_en'],
            'title_ar' => $request['title_ar'],
            'date' => $request['date'] ?? null,
            'start_time' => $request['start_time'] ?? null,
            'end_time' => $request['end_time'] ?? null,
            'description_en' => $request['description_en'],
            'description_ar' => $request['description_ar'],
        ];

        if (isset($request['image'])) {
            $eventModel['image'] = $request['image'];
        }

        return $eventModel;
    }
}
