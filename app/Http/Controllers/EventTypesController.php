<?php

namespace App\Http\Controllers;

use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class EventTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $eventTypes = EventType::all();

        return view('event-types.index', compact('eventTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('event-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validation = [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'title_spanish' => 'required|min:3|max:255',
            'description_spanish' => 'required|min:3|max:255',
            'title_german' => 'required|min:3|max:255',
            'description_german' => 'required|min:3|max:255',
            'image_file' => 'required|image|max:8096',
        ];

        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('image_file');
        $fileName = $file->hashName();

        $path ='event-types/' . $fileName;

        $image = Image::make($file);
        $image->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::put($path, $image->stream('jpg', 100));

        $request['image'] = $fileName;

        EventType::create($request->all());

        return redirect()->route('event-types.index');
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
     * @return View
     */
    public function edit($id)
    {
        $eventType = EventType::find($id);

        return view('event-types.edit', compact('eventType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validation = [
            'title' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'title_spanish' => 'required|min:3|max:255',
            'description_spanish' => 'required|min:3|max:255',
            'title_german' => 'required|min:3|max:255',
            'description_german' => 'required|min:3|max:255',
            'image_file' => 'nullable|image|max:8096',
        ];

        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $eventType = EventType::find($id);

        if ($request->file('image_file')) {
            Storage::delete('event-types/' . $eventType->image);

            $file = $request->file('image_file');
            $fileName = $file->hashName();

            $path = 'event-types/' . $fileName;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $fileName;
        }

        $eventType->fill($request->all());
        $eventType->save();

        return redirect()->route('event-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        EventType::destroy($id);

        return redirect()->route('event-types.index');
    }
}
