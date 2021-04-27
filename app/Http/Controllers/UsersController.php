<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Set user as admin
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setAdmin(Request $request)
    {
        $user = User::find($request->get('id'));
        $user->is_admin = true;
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Remove user admin
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeAdmin(Request $request)
    {
        $user = User::find($request->get('id'));
        $user->is_admin = false;
        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Test broadcast
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function testBroadcast(Request $request)
    {
        TestEvent::dispatch($request->get('id'), 'message-test');

        return redirect()->route('users.index');
    }

    /**
     * Download users
     *
     * @throws \League\Csv\CannotInsertRecord
     */
    public function users_download()
    {
        $users = User::get(); // All users
        $csvExporter = new \Laracsv\Export();

        foreach ($users as $user)
        {
            if($user->password === 'fb-login') {
                $user->type = "Facebook User";
            } else {
                $user->type = "Licor43 User";
            }
        }

        $csvExporter->build($users, [
            'email', 'name', 'ip', 'city', 'state', 'country', 'type'
        ])->download();
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
        //
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->route('users.index');
    }
}
