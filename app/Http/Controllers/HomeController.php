<?php

namespace App\Http\Controllers;

use App\Mail\InviteEmail;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizUsedQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse|View
     */

    public function guests() {
        if (Auth::user()->is_admin){
            return redirect()->route('admin-home');
        }

        return view('user-landing');
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function test (Request $request) {
        $quiz = Quiz::find(110);
        $nswers = $quiz->quiz_answers()->with('quiz_player')->get();

        $used_questions = QuizUsedQuestion::where('quiz_id', '=', 146);
        $question = QuizQuestion::where('category', '=', 1)
            ->whereNotIn('id',$used_questions->pluck('quiz_question_id')->toArray())->get();

        dd($question->pluck('id'));

        return view('test');
    }

    public function quiz_hook (Request $request)
    {
        Log::debug($request->all());
    }

    public function email_template ()
    {
        return new InviteEmail();
    }

    public function email_send()
    {
        $to = [
            [
                'email' => 'lazic.stefan93@gmail.com',
                'name' => 'Stefan',
            ]
        ];

        Mail::to($to)->send(new InviteEmail());
    }
}
