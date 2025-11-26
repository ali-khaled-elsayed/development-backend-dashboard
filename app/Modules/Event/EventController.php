<?php

namespace App\Modules\Event;

use App\Http\Controllers\Controller;
use App\Modules\Event\Services\EventService;
use App\Modules\Event\Resources\EventResource;
use App\Modules\Shared\Enums\HttpStatusCodeEnum;
use App\Modules\Event\Requests\ListEventsRequest;
use App\Modules\Event\Requests\CreateEventRequest;
use App\Modules\Event\Requests\UpdateEventRequest;

class EventController extends Controller
{
    public function __construct(private EventService $eventService) {}

    public function createEvent(CreateEventRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $data['image'] = $path;
        }
        $event = $this->eventService->createEvent($data);
        if ($request->has('galleries')) {
            foreach ($request->galleries as $galleryItem) {
                $file = $galleryItem['file'];
                $type = $galleryItem['type'];

                $path = $file->store("events/galleries", 'public');

                $event->galleries()->create([
                    'url' => $path,
                    'type' => $type,
                ]);
            }
        }
        return successJsonResponse(new EventResource($event), __('event.success.create_event'));
    }

    public function updateEvent($id, UpdateEventRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
            $data['image'] = $path;
        }
        $event = $this->eventService->updateEvent($id, $data);
        if ($request->has('galleries')) {
            foreach ($request->galleries as $galleryItem) {
                $file = $galleryItem['file'];
                $type = $galleryItem['type'];

                $path = $file->store("events/galleries", 'public');

                $event->galleries()->create([
                    'url' => $path,
                    'type' => $type,
                ]);
            }
        }
        return successJsonResponse(new EventResource($event), __('event.success.update_event'));
    }

    public function deleteEvent($id)
    {
        $event = $this->eventService->deleteEvent($id);
        if ($event == true) {
            return successJsonResponse([], __('event.success.delete_event event_id = ' . $event['id']));
        } else {
            return errorJsonResponse("There is No event with id = " . $id, HttpStatusCodeEnum::Not_Found->value);
        }
    }

    public function listAllEvents(ListEventsRequest $request)
    {
        $events = $this->eventService->listAllEvents($request->validated());
        return successJsonResponse(data_get($events, 'data'), __('events.success.get_all_events'), data_get($events, 'count'));
    }

    public function getEventById($eventId)
    {
        $event = $this->eventService->getEventById($eventId);
        if (!$event) {
            return errorJsonResponse("event $eventId is not found!", HttpStatusCodeEnum::Not_Found->value);
        }
        return successJsonResponse(new EventResource($event), __('event.success.event_details'));
    }
}
