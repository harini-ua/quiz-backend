<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\DrinkIngredient;
use App\Models\DrinkStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class DrinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $drinks = Drink::all();

        return view('drinks.index', compact('drinks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('drinks.create');
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
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'name_spanish' => 'required|min:3|max:255',
            'description_spanish' => 'required|min:3|max:255',
            'name_german' => 'required|min:3|max:255',
            'description_german' => 'required|min:3|max:255',
            'image_file' => 'required|image|max:8096',
            'complexity_number' => 'required|numeric|min:1|max:5',
            'ingredients_number' => 'required|numeric|min:1|max:5',
            'minutes' => 'required|numeric|min:1|max:500'
        ];

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('image_file');
        $file_name = $file->hashName();

        $path = 'drinks/' . $file_name;

        $image = Image::make($file);
        $image->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::put($path, $image->stream('jpg', 100));

        $request['image'] = $file_name;

        $drink = Drink::create($request->all());

        return redirect()->route('drinks.show', ['drink' => $drink->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        $drink = Drink::find($id);

        return view('drinks.show', compact('drink'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        $food = Drink::find($id);

        return view('drinks.edit', compact('food'));
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
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:3|max:255',
            'name_spanish' => 'required|min:3|max:255',
            'description_spanish' => 'required|min:3|max:255',
            'name_german' => 'required|min:3|max:255',
            'description_german' => 'required|min:3|max:255',
            'image_file' => 'nullable|image|max:8096',
            'complexity_number' => 'required|numeric|min:1|max:5',
            'ingredients_number' => 'required|numeric|min:1|max:5',
            'minutes' => 'required|numeric|min:1|max:500'
        ];

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $drink = Drink::find($id);

        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $file_name = $file->hashName();

            $path = 'drinks/' . $file_name;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $file_name;
        }

        $drink->fill($request->all());
        $drink->save();

        return redirect()->route('drinks.edit', ['drink' => $id]);
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
        Drink::destroy($id);

        return redirect()->route('drinks.index');
    }

    /**
     * Create ingredients
     *
     * @param $id
     *
     * @return View
     */
    public function ingredients_create($id)
    {
        $drink = Drink::find($id);

        return view('drinks.ingredients.create', compact('drink'));
    }

    /**
     * Destroy ingredient
     *
     * @param $drink_id
     * @param $ingredient_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ingredient_destroy($drink_id,$ingredient_id)
    {
        $ingredient = DrinkIngredient::destroy($ingredient_id);

        return redirect()->route('drinks.show', ['drink'=>$drink_id]);
    }

    /**
     * Store ingredients
     *
     * @param         $id
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ingredients_store($id, Request $request)
    {
        $validation = [
            'name' => 'required|min:3|max:255',
            'quantity' => 'required|min:3|max:255'
        ];

        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $drink = Drink::find($id);

        $drink_ingredient = DrinkIngredient::create($request->all());
        $drink_ingredient->drink()->associate($drink);
        $drink_ingredient->save();

        return redirect()->route('drinks.show', ['drink' => $id]);
    }

    /**
     * Create Steps
     *
     * @param $id
     *
     * @return View
     */
    public function steps_create($id)
    {
        $drink = Drink::find($id);

        return view('drinks.steps.create', compact('drink'));
    }

    /**
     * Edit Steps
     *
     * @param $id
     * @param $step
     *
     * @return View
     */
    public function steps_edit($id,$step)
    {
        $drink = Drink::find($id);
        $step = DrinkStep::find($step);

        return view('drinks.steps.edit', compact('drink', 'step'));
    }

    /**
     * Update steps
     *
     * @param         $id
     * @param         $step
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function steps_update($id,$step,Request $request)
    {
        $validation = [
            'description' => 'required|min:3|max:255',
            'image_file' => 'nullable|image|max:8096',
            'video_file' => 'nullable|file|max:8096',
            'description_spanish' => 'required|min:3|max:255',
            'description_german' => 'required|min:3|max:255',
        ];

        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $drink_step = DrinkStep::find($step);

        if ($request->file('video_file')) {
            $request['video'] = Storage::putFile('drink-steps', $request->file('video_file'));
            $request['image'] = null;
            if ($drink_step->video){
                Storage::delete($drink_step->video);
            }
            if ($drink_step->image){
                Storage::delete('drink-steps/' . $drink_step->image);
            }
        }
        if ($request->file('image_file')){
            $file = $request->file('image_file');
            $file_name = $file->hashName();

            $path = 'drink-steps/' . $file_name;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $file_name;
            $request['video'] = null;

            if ($drink_step->video){
                Storage::delete($drink_step->video);
            }
            if ($drink_step->image){
                Storage::delete('drink-steps/' . $drink_step->image);
            }
        }

        $drink_step->fill($request->all());
        $drink_step->save();

        return redirect()->route('drinks.show', ['drink' => $id]);
    }

    /**
     * Destroy step
     *
     * @param $drink_id
     * @param $step_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function step_destroy($drink_id, $step_id)
    {
        $step = DrinkStep::destroy($step_id);

        return redirect()->route('drinks.show', ['drink' => $drink_id]);
    }

    /**
     * Store step
     *
     * @param         $id
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function steps_store($id, Request $request)
    {
        $validation = [
            'description' => 'required|min:3|max:255',
            'image_file' => 'nullable|image|max:8096',
            'video_file' => 'nullable|file|max:8096',
            'description_spanish' => 'required|min:3|max:255',
            'description_german' => 'required|min:3|max:255',
        ];

        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->file('image_file')){
            $file = $request->file('image_file');
            $file_name = $file->hashName();

            $path = 'drink-steps/' . $file_name;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $file_name;
        }

        if ($request->file('video_file')) {
            $request['video'] = Storage::putFile('drink-steps', $request->file('video_file'));
        }

        $drink = Drink::find($id);

        $drink_step = DrinkStep::create($request->all());
        $drink_step->drink()->associate($drink);
        $drink_step->save();

        return redirect()->route('drinks.show', ['drink' => $id]);
    }
}
