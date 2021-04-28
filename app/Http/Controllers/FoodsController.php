<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\EventType;
use App\Models\Food;
use App\Models\FoodIngredient;
use App\Models\FoodStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class FoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $foods = Food::all();

        return view('foods.index', compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $drinks = Drink::all();
        $eventTypes = EventType::all();

        return view('foods.create', compact('drinks','eventTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
        $fileName = $file->hashName();

        $path = 'foods/' . $fileName;

        $image = Image::make($file);
        $image->resize(1080, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        Storage::put($path, $image->stream('jpg', 100));

        $request['image'] = $fileName;

        $food = Food::create($request->all());

        $food->drinks()->attach($request->get('drinks'));
        $food->eventTypes()->sync($request->get('event_types'));

        return redirect()->route('foods.show', ['food' => $food->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function show($id)
    {
        $food = Food::find($id);
        $eventTypes = EventType::all();

        return view('foods.show', compact('food', 'eventTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $food = Food::find($id);
        $drinks = Drink::all();
        $eventTypes = EventType::all();

        return view('foods.edit', compact('food', 'drinks', 'eventTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
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
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $food = Food::find($id);

        if ($request->file('image_file')) {
            Storage::delete('event-types/' . $food->image);

            $file = $request->file('image_file');
            $fileName = $file->hashName();

            $path = 'foods/' . $fileName;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $fileName;
        }

        $food->fill($request->all());
        $food->drinks()->sync($request->get('drinks'));
        $food->eventTypes()->sync($request->get('event_types'));
        $food->save();

        return redirect()->route('foods.edit', ['food' => $id]);
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
        Food::destroy($id);

        return redirect()->route('foods.index');
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
        $food = Food::find($id);

        return view('foods.ingredients.create', compact('food'));
    }

    /**
     * Destroy ingredient
     *
     * @param $food_id
     * @param $ingredient_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ingredient_destroy($food_id,$ingredient_id)
    {
        $ingredient = FoodIngredient::destroy($ingredient_id);

        return redirect()->route('foods.show', ['food' => $food_id]);
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

        $food = Food::find($id);

        $foodIngredient = FoodIngredient::create($request->all());
        $foodIngredient->food()->associate($food);
        $foodIngredient->save();

        return redirect()->route('foods.show', ['food' => $id]);
    }

    /**
     * Create steps
     *
     * @param $id
     *
     * @return View
     */
    public function steps_create($id)
    {
        $food = Food::find($id);

        return view('foods.steps.create', compact('food'));
    }

    /**
     * Edit step
     *
     * @param $id
     * @param $step
     *
     * @return View
     */
    public function step_edit($id,$step)
    {
        $food = Food::find($id);
        $step = FoodStep::find($step);

        return view('foods.steps.edit', compact('food', 'step'));
    }

    /**
     * Update step
     *
     * @param         $id
     * @param         $step
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function step_update($id, $step, Request $request)
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

        $foodStep = FoodStep::find($step);

        if ($request->file('video_file')) {
            $request['video'] = Storage::putFile('food-steps', $request->file('video_file'));
            $request['image'] = null;
            if ($foodStep->video){
                Storage::delete($foodStep->video);
            }
            if ($foodStep->image){
                Storage::delete('food-steps/' . $foodStep->image);
            }
        }
        elseif ($request->file('image_file')) {
            $file = $request->file('image_file');
            $fileName = $file->hashName();

            $path = 'food-steps/' . $fileName;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $fileName;
            $request['video'] = null;

            if ($foodStep->video){
                Storage::delete($foodStep->video);
            }
            if ($foodStep->image){
                Storage::delete('food-steps/' . $foodStep->image);
            }
        }

        $foodStep->fill($request->all());
        $foodStep->save();

        return redirect()->route('foods.show', ['food' => $id]);
    }

    /**
     * Destroy step
     *
     * @param $food_id
     * @param $step_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function step_destroy($food_id, $step_id)
    {
        $step = FoodStep::destroy($step_id);

        return redirect()->route('foods.show', ['food' => $food_id]);
    }

    /**
     * Store steps
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

        if ($request->file('image_file')) {
            $file = $request->file('image_file');
            $fileName = $file->hashName();

            $path = 'food-steps/' . $fileName;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $fileName;
        }

        if ($request->file('video_file')) {
            $request['video'] = Storage::putFile('food-steps', $request->file('video_file'));
        }

        $food = Food::find($id);

        $foodStep = FoodStep::create($request->all());
        $foodStep->food()->associate($food);
        $foodStep->save();

        return redirect()->route('foods.show', ['food' => $id]);
    }
}
