<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\InvitedEmail;
use App\Models\Contact;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $contacts = $user->contacts()->where(function ($query) {
            $query->whereNotNull('email')
                ->orWhereNotNull('number');
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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->get('name');
        $contact->number = $request->get('number');
        $contact->email = $request->get('email');
        $contact->location = $request->get('location');

        $contact->user()->associate($request->user());
        $contact->save();

        Log::debug('/contacts/store');
        Log::debug($contact);

        return response()->json($contact);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(Request $request)
    {
        $event = Event::with('user')->find($request->get('event_id'));

        Log::alert($event);

        $contacts = Contact::find($request->get('contacts'));
        foreach ($contacts as $contact)
        {
            if ($contact->email) {
                $to = [
                    [
                        'email' => $contact->email,
                        'name' => $contact->name
                    ]
                ];

                $email_code = Str::random();

                Mail::to($to)->send(
                    new InvitedEmail(
                        $contact->name,
                        $event->user->name,
                        $event->location,
                        $email_code,
                        $event->date_time
                    )
                );

                $event->contacts()->attach($contact->id, ['email_code' => $email_code]);
            }
        }

        Log::debug('/contacts/invite');

        return response()->json('success');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function invited(Request $request)
    {
        $event = Event::find($request->get('event_id'));
        $contacts = $event->contacts;

        return response()->json($contacts);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function attending(Request $request)
    {
        $event = Event::find($request->get('event_id'));
        $contactsAttending = $event->contacts()->where('attending', true)->get();
        $contactsNotAttending = $event->contacts()->where('attending', false)->get();
        $contactsPending = $event->contacts()->whereNull('attending')->get();

        return response()->json([
            'contacts_attending' => $contactsAttending,
            'contacts_not_attending' => $contactsNotAttending,
            'contacts_pending' => $contactsPending
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
