<?php

namespace App\Http\Controllers\API;

use App\Contact;
use App\Event;
use App\EventType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EventsController extends Controller
{
    public function types()
    {
        if (Auth::user()->language === 'english') {
            $event_types = EventType::select('id','title','description','image')->get();

        } else {
            $event_types = EventType::select(
                'id', 'title_'. Auth::user()->language. ' as title', 'description_'. Auth::user()->language. ' as description', 'image'
            )->get();
        }

        Log::info('/events/types');

        return response()->json($event_types);
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event_type = EventType::find($request['event_type_id']);

        $event = new Event;
        $event->name = $request['name'];
        $event->date_time = Carbon::parse($request['dateAndTime'])->toDateTimeString();
        $event->location = $request['location'];
        $event->whatsapp_code = Str::random();
        $event->user()->associate($request->user());
        $event->event_type()->associate($event_type);
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

    public function whatsapp_code(Request $request)
    {
        $event = Event::where('whatsapp_code', '=', $request['whatsapp_code'])
            ->with('user')->first();

        return response()->json($event);
    }

    public function whatsapp_attending(Request $request)
    {
        $event = Event::find($request['event_id']);

        $contact = new Contact;
        $contact->name = $request['name'];
        $contact->user()->associate($event->user);
        $contact->save();

        $contact->events()->attach($request['event_id'],['attending' => $request['attending']]);

        return response()->json(['status' => 'success']);
    }

    public function email_code (Request $request)
    {
        $event = Event::whereHas('contacts', function($query) use ($request) {
            $query->where('email_code','=',$request['email_code']);
        })->with('user')->first();

        return response()->json([
            'event_name' => $event->name,
            'host_name' => $event->user->name]
        );
    }

    public function email_attending (Request $request)
    {
        $event = Event::whereHas('contacts', function($query) use ($request) {
            $query->where('email_code','=',$request['email_code']);
        })->with('user')->first();

        $contact = Contact::whereHas('events', function($query) use ($request) {
            $query->where('email_code','=',$request['email_code']);
        })->first();

        $contact->events()->updateExistingPivot($event->id,['email_code'=>null,'attending'=>$request['attending']]);

        return response()->json(['status' => 'success']);
    }
}
