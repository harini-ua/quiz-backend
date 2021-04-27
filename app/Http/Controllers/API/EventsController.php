<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Event;
use App\Models\EventType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    public function types()
    {
        if (Auth::user()->language === 'english') {
            $eventTypes = EventType::select('id', 'title', 'description', 'image')->get();

        } else {
            $eventTypes = EventType::select(
                'id', 'title_'. Auth::user()->language. ' as title', 'description_'. Auth::user()->language. ' as description', 'image'
            )->get();
        }

        Log::info('/events/types');

        return response()->json($eventTypes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $eventType = EventType::find($request->get('event_type_id'));

        $event = new Event;
        $event->name = $request->get('name');
        $event->date_time = Carbon::parse($request->get('dateAndTime'))->toDateTimeString();
        $event->location = $request->get('location');
        $event->whatsapp_code = Str::random();
        $event->user()->associate($request->user());
        $event->event_type()->associate($eventType);
        $event->save();

        Log::debug('/events/store');
        Log::debug($event);

        return response()->json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Event by whatsapp code
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function whatsapp_code(Request $request)
    {
        $event = Event::where('whatsapp_code', $request->get('whatsapp_code'))
            ->with('user')->first();

        return response()->json($event);
    }

    /**
     * Whatsapp attending
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function whatsapp_attending(Request $request)
    {
        $event = Event::find($request->get('event_id'));

        $contact = new Contact;
        $contact->name = $request->get('name');
        $contact->user()->associate($event->user);
        $contact->save();

        $contact->events()->attach($request->get('event_id'), [
            'attending' => $request->get('attending')
        ]);

        return response()->json(['status' => 'success']);
    }

    /**
     * Email code
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function email_code(Request $request)
    {
        $event = Event::whereHas('contacts', function($query) use ($request) {
            $query->where('email_code', $request->get('email_code'));
        })->with('user')->first();

        return response()->json([
            'event_name' => $event->name,
            'host_name' => $event->user->name
        ]);
    }

    /**
     * Email attending
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function email_attending(Request $request)
    {
        $event = Event::whereHas('contacts', function($query) use ($request) {
            $query->where('email_code', $request->get('email_code'));
        })->with('user')->first();

        $contact = Contact::whereHas('events', function($query) use ($request) {
            $query->where('email_code', $request->get('email_code'));
        })->first();

        $contact->events()->updateExistingPivot($event->id, [
            'email_code' => null,
            'attending' => $request->get('attending')
        ]);

        return response()->json(['status' => 'success']);
    }
}
