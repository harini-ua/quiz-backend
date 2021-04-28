<?php

namespace App\Http\Controllers;

use App\Enums\CategoryQuizQuestions;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

class QuizQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $questions = QuizQuestion::all();

        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $category = CategoryQuizQuestions::asSelectArray();

        return view('questions.create', compact('category'));
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
            'description' => 'nullable|min:3|max:255',
            'description_spanish' => 'nullable|min:3|max:255',
            'description_english' => 'nullable|min:3|max:255',
            'image_file' => 'nullable|image|max:8096',
            'audio_file' => 'nullable|file|max:8096',
            'category' => 'required',
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

            $path = 'questions/' . $fileName;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $fileName;
        }

        if ($request->file('audio_file')) {
            $request['audio'] = Storage::putFile('questions', $request->file('audio_file'));
        }

        $question = QuizQuestion::create($request->all());

        return redirect()->route('questions.index');
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
        $question = QuizQuestion::find($id);

        return view('questions.edit', compact('question'));
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
            'description' => 'nullable|min:3|max:255',
            'description_spanish' => 'nullable|min:3|max:255',
            'description_english' => 'nullable|min:3|max:255',
            'image_file' => 'nullable|image|max:8096',
            'audio_file' => 'nullable|file|max:8096',
            'category' => 'required',
        ];

        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $question = QuizQuestion::find($id);

        if ($request->file('image_file')) {
            Storage::delete('questions/' . $question->image);

            $file = $request->file('image_file');
            $fileName = $file->hashName();

            $path ='questions/' . $fileName;

            $image = Image::make($file);
            $image->resize(1080, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($path, $image->stream('jpg', 100));

            $request['image'] = $fileName;
        }

        if ($request->file('audio_file')) {
            Storage::delete($question->audio);

            $request['audio'] = Storage::putFile('questions', $request->file('audio_file'));
        }

        $question->fill($request->all());
        $question->save();

        return redirect()->route('questions.index');
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
        $quizQuestion = QuizQuestion::destroy($id);

        return redirect()->route('questions.index');
    }
}
