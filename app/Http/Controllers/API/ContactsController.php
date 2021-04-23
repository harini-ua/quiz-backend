<?php

namespace App\Http\Controllers\API;

use App\Contact;
use App\Event;
use App\Mail\InvitedEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $contacts = $user->contacts()->where(function ($query) {
            $query->where('email', '!=', null)->orWhere('number', '!=', null);
        })->orderBy('name', 'asc')->get();

        Log::info($contacts);

        return response()->json($contacts);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = new Contact;
        $contact->name = $request['name'];
        $contact->number = $request['number'];
        $contact->email = $request['email'];
        $contact->location = $request['location'];
        $contact->user()->associate($request->user());
        $contact->save();

        Log::debug('/contacts/store');
        Log::debug($contact);

        return response()->json($contact);
    }


    public function invite(Request $request)
    {
        $event = Event::with('user')->find($request['event_id']);

        Log::alert($event);

        $contacts = $request['contacts'];

        $contacts_collection = Contact::find($contacts);

        foreach ($contacts_collection as $contact)
        {
            if ($contact->email){
                $to = [['email'=>$contact->email, 'name'=>$contact->name]];
                $email_code = Str::random();
                Mail::to($to)->send(new InvitedEmail($contact->name, $event->user->name, $event->location, $email_code, $event->date_time));
                $event->contacts()->attach($contact->id,['email_code'=>$email_code]);
            }
        }

        Log::debug('/contacts/invite');

        return response()->json('success');
    }

    public function invited(Request $request)
    {
        $event = Event::find($request['event_id']);
        $contacts = $event->contacts;

        return response()->json($contacts);
    }

    public function attending(Request $request)
    {
        $event = Event::find($request['event_id']);
        $contacts_attending = $event->contacts()->where('attending', '=', true)->get();
        $contacts_not_attending = $event->contacts()->where('attending', '=', false)->get();
        $contacts_pending = $event->contacts()->where('attending','=',null)->get();

        return response()->json([
            'contacts_attending' => $contacts_attending,
            'contacts_not_attending' => $contacts_not_attending,
            'contacts_pending'=>$contacts_pending
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
