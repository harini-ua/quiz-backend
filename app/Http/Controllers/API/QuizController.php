<?php

namespace App\Http\Controllers\API;

use App\Events\Notifications;
use App\Events\PlayersPointsEvent;
use App\Events\QuestionsEvent;
use App\Events\QuizEndedEvent;
use App\Events\TestEvent;
use App\Events\VotingEvent;
use App\Quiz;
use App\QuizAnswer;
use App\QuizPlayer;
use App\QuizQuestion;
use App\QuizUsedQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{

    public function generate_quiz(Request $request)
    {
        Log::debug($request['quiz_name']);
        $code = $this->generateRandomString();
        $quiz = Quiz::create([
            'players' => 0,
            'name' => $request['quiz_name'],
            'quiz_rounds' => $request['quiz_rounds'],
            'code' => $code
        ]);
        $quiz->user()->associate($request->user());
        $quiz->save();

        Log::info('/quiz/generate');

        return response()->json($quiz, 200);
    }

    function generateRandomString($length = 4)
    {
        $characters = '123456789ABCDEFGHJKLMNPRSTVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function join_quiz(Request $request)
    {
        $quiz = Quiz::where('code', '=', $request['code'])->with('user')->first();
        Log::warning($request->all());
        $quiz_language = $quiz->user->language;

        Log::info('/quiz/join');

        return response()->json(['quiz_name' => $quiz->name, 'quiz_code' => $quiz->code,'quiz_language'=>$quiz_language], 200);
    }

    public function presence(Request $request)
    {
        $quiz = \App\Quiz::where('code', '=', $request['code'])->first();
        $quiz->players = $quiz->players + 1;
        $quiz->save();

        event(new Notifications($quiz->code, $request['name'] . ' joined quiz.'));
        event(new TestEvent($quiz->code, $request['name'] . ' joined quiz.'));

        Log::info('Presence ' . $request['name']);

        return response()->json('success', 200);
    }

    public function unused_question(Request $request)
    {
        $used_questions = QuizUsedQuestion::where('quiz_id', '=', $request['quiz_id']);

        $question = QuizQuestion::where('category', '=', $request['category'])->whereNotIn('id', $used_questions->pluck('quiz_question_id')->toArray())->get();

        if ($question->isNotEmpty()) {
            $question = $question->random();
        } else {
            return response()->json(['questions' => false], 200);
        }

        if (!$question) {
            return response()->json(['questions' => false], 200);
        }

        $quiz = Quiz::find($request['quiz_id']);
        $category = $request['category'];

        Log::warning($quiz);
        Log::warning($question);

        $used = new QuizUsedQuestion;
        $used->quiz()->associate($quiz);
        $used->quiz_question()->associate($question);
        $used->save();

        Log::info($category);

        event(new QuestionsEvent($quiz->code, $question));

        return response()->json(['questions' => true], 200);
    }

    public function answer_question(Request $request)
    {
        $quiz_player = QuizPlayer::where('socket_id', '=', $request['socket_id'])->first();
        $quiz_question = QuizQuestion::find($request['question_id']);
        $quiz = $quiz_player->quiz;

        if (strlen($request['answer']) > 0) {
            $answer = $request['answer'];
        } else {
            $answer = ' ';
        }

        $quiz_answer = new QuizAnswer;
        $quiz_answer->answer = $answer;
        $quiz_answer->quiz_player()->associate($quiz_player);
        $quiz_answer->quiz_question()->associate($quiz_question);
        $quiz_answer->quiz()->associate($quiz);
        $quiz_answer->save();

        $quiz_answers = $quiz->quiz_answers_for_question($request['question_id'])->count();
        Log::info($quiz_answers . ' COUNT');

        if ($quiz->quiz_answers_for_question($request['question_id'])->count() == $quiz->players) {
            Log::info('VotingEvent');
            event(new VotingEvent($quiz->code, $quiz->quiz_answers_for_question_for_vote($request['question_id'])->with('quiz_player')->get()));
        }

        return response()->json(['left' => $quiz->players - $quiz->quiz_answers_for_question($request['question_id'])->count()], 200);
    }

    private $quiz_rounds = 15;

    public function answer_vote(Request $request)
    {
        if($request['answer_id'] == -1 || $request['answer_id'] == null){
            $quiz_player = QuizPlayer::find($request['player_id']);
            $quiz_answer = QuizAnswer::where("quiz_id", "=",$quiz_player->quiz_id)->orderBy('updated_at', 'DESC')->first();
        }else{
            $quiz_answer = QuizAnswer::find($request['answer_id']);

        }
        $quiz_answer->points += 1;
        if($quiz_answer->quiz_player_ids != null){
            $quiz_answer->quiz_player_ids .= ",".$request['player_id'];
        }else{
            $quiz_answer->quiz_player_ids = (string)$request['player_id'];
        }
        $quiz_answer->save();
        $quiz = $quiz_answer->quiz;

        $quiz_question_id = $quiz_answer->quiz_question->id;

        if ($quiz->players == $quiz->quiz_answers_for_question($quiz_question_id)->sum('points')) {
            $favorite = $quiz->quiz_answers_for_question($quiz_question_id)->orderBy('points', 'DESC')->first();
            $quiz_player = $favorite->quiz_player;
            $quiz_player->points += 3;
            $quiz_player->save();

            $quiz->answered_question += 1;
            $quiz->save();

            $rounds_left = $quiz->quiz_rounds - $quiz->answered_question;

            if ($rounds_left == 0) {
                event(new QuizEndedEvent($quiz->code, $quiz->quiz_players, $quiz->quiz_players()->first()));
            } else {
                event(new PlayersPointsEvent($quiz->code, $quiz->quiz_players, $quiz_player, $favorite->answer, $rounds_left));
            }
        }

        return response()->json(['left' => $quiz->players - $quiz->quiz_answers_for_question($quiz_question_id)->sum('points')], 200);
    }

    public function winner(Request $request)
    {
        $player = QuizPlayer::find($request['player_id']);

        $quiz = $player->quiz;

        if ($quiz->quiz_players()->first()->id == $player->id) {
            return response()->json(['qr_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png'], 200);
        }

        return response()->json('you are not winner',200);
    }

    public function change_host(Request $request){
        $quiz = Quiz::find($request['quiz_id']);
        $game_end = false;
        if($quiz->players <= 2 ){
            event(new QuizEndedEvent($quiz->code, $quiz->quiz_players, $quiz->quiz_players()->first()));
            $game_end = true;
        }else if($request['event_id'] == 3){
            $quiz_answers = $quiz->quiz_answers_for_question($request['question_id'])->count();

            $left = $quiz->players - $quiz_answers;
            $host_answer = $quiz->quiz_host_answers_for_question($request['question_id'], $request['player_id'])->count();
            if($left == 1 && $host_answer == 0 ){
                event(new VotingEvent($quiz->code, $quiz->quiz_answers_for_question_for_vote($request['question_id'])->with('quiz_player')->get()));
            }else if($host_answer == 1){
                QuizAnswer::where('quiz_question_id','=',$request['question_id'])->where('quiz_player_id','=',$request['player_id'])->delete();
            }
        }else if($request['event_id'] == 2){
            QuizAnswer::where('quiz_question_id','=',$request['question_id'])->where('quiz_player_id','=',$request['player_id'])->delete();
        }else if($request['event_id'] == 5){
            $left = $quiz->players - $quiz->quiz_answers_for_question($request['question_id'])->sum('points');
            $quiz_answers =  QuizAnswer::where('quiz_question_id','=',$request['question_id'])->where('quiz_id','=',$request['quiz_id'])->get();
            $host_vote = false;

            $favorite = $quiz->quiz_answers_for_question($request['question_id'])->orderBy('points', 'DESC')->first();
            $quiz_player = $favorite->quiz_player;
            $quiz_player->points += 3;
            $rounds_left = $quiz->quiz_rounds - $quiz->answered_question;
            $answer_id = null;
            foreach ($quiz_answers as $answers) {
                if($answers->quiz_player_ids !=null){
                    $voter_ids = explode(" ",$answers->quiz_player_ids);
                    if(in_array((string)$request['player_id'], $voter_ids)){
                        $host_vote = true;
                        $answer_id = $answers->id;
                        break;
                    }
                }
            }
            if($left == 1 && !$host_vote) {
                if ($rounds_left == 0) {
                    event(new QuizEndedEvent($quiz->code, $quiz->quiz_players, $quiz->quiz_players()->first()));
                } else {
                    event(new PlayersPointsEvent($quiz->code, $quiz->quiz_players, $quiz_player, $favorite->answer, $rounds_left));
                }
            }else if($host_vote){
                $quiz_answer = QuizAnswer::find($answer_id);
                $quiz_answer->points -= 1;
                $player_ids = null;
                for ($i = 0; $i<count($voter_ids); $i++){
                    if($player_ids == null && $voter_ids[$i] != (string)$request['player_id']){
                        $player_ids = $voter_ids[$i];
                    }else if($player_ids != null && $voter_ids[$i] != (string)$request['player_id']){
                        $player_ids .= ",".$voter_ids[$i];
                    }
                }
                $quiz_answer->quiz_player_ids = $player_ids;
                $quiz_answer->save();
            }
        }else if($request['event_id'] == 4){
            $quiz_answers =  QuizAnswer::where('quiz_question_id','=',$request['question_id'])->where('quiz_id','=',$request['quiz_id'])->get();

            foreach ($quiz_answers as $index => $answers) {
                if($answers->quiz_player_ids !=null){
                    $voter_ids = explode(" ",$answers->quiz_player_ids);
                    if(in_array((string)$request['player_id'], $voter_ids)){
                        $quiz_answer = QuizAnswer::find($answers->id);
                        $quiz_answer->points -= 1;
                        $player_ids = null;
                        for ($i = 0; $i<count($voter_ids); $i++){
                            if($player_ids == null && $voter_ids[$i] != (string)$request['player_id']){
                                $player_ids = $voter_ids[$i];
                            }else if($player_ids != null && $voter_ids[$i] != (string)$request['player_id']){
                                $player_ids .= ",".$voter_ids[$i];
                            }
                        }
                        $quiz_answer->quiz_player_ids = $player_ids;
                        $quiz_answer->save();
                        break;
                    }
                }
            }
        }
        $quiz->players = $quiz->players - 1;
        $quiz->save();
        return response()->json(['quiz_id' => $quiz->id,'game_end' => $game_end],200);
    }

    public function player_left(Request $request){
        $quiz = Quiz::find($request['quiz_id']);
        $game_end = false;
        if($quiz->players <= 2 ){
            event(new QuizEndedEvent($quiz->code, $quiz->quiz_players, $quiz->quiz_players()->first()));
            $game_end = true;
        }else if($request['event_id'] == 3){
            $quiz_answers = $quiz->quiz_answers_for_question($request['question_id'])->count();

            $left = $quiz->players - $quiz_answers;
            $host_answer = $quiz->quiz_host_answers_for_question($request['question_id'], $request['player_id'])->count();
            if($left == 1 && $host_answer == 0 ){
                event(new VotingEvent($quiz->code, $quiz->quiz_answers_for_question_for_vote($request['question_id'])->with('quiz_player')->get()));
            }else if($host_answer == 1){
                QuizAnswer::where('quiz_question_id','=',$request['question_id'])->where('quiz_player_id','=',$request['player_id'])->delete();
            }
        }else if($request['event_id'] == 2){
            QuizAnswer::where('quiz_question_id','=',$request['question_id'])->where('quiz_player_id','=',$request['player_id'])->delete();
        }else if($request['event_id'] == 5){
            $left = $quiz->players - $quiz->quiz_answers_for_question($request['question_id'])->sum('points');
            $quiz_answers =  QuizAnswer::where('quiz_question_id','=',$request['question_id'])->where('quiz_id','=',$request['quiz_id'])->get();
            $host_vote = false;

            $favorite = $quiz->quiz_answers_for_question($request['question_id'])->orderBy('points', 'DESC')->first();
            $quiz_player = $favorite->quiz_player;
            $quiz_player->points += 3;
            $rounds_left = $quiz->quiz_rounds - $quiz->answered_question;
            $answer_id = null;
            foreach ($quiz_answers as $answers) {
                if($answers->quiz_player_ids !=null){
                    $voter_ids = explode(" ",$answers->quiz_player_ids);
                    if(in_array((string)$request['player_id'], $voter_ids)){
                        $host_vote = true;
                        $answer_id = $answers->id;
                        break;
                    }
                }
            }
            if($left == 1 && !$host_vote) {
                if ($rounds_left == 0) {
                    event(new QuizEndedEvent($quiz->code, $quiz->quiz_players, $quiz->quiz_players()->first()));
                } else {
                    event(new PlayersPointsEvent($quiz->code, $quiz->quiz_players, $quiz_player, $favorite->answer, $rounds_left));
                }
            }else if($host_vote){
                $quiz_answer = QuizAnswer::find($answer_id);
                $quiz_answer->points -= 1;
                $player_ids = null;
                for ($i = 0; $i<count($voter_ids); $i++){
                    if($player_ids == null && $voter_ids[$i] != (string)$request['player_id']){
                        $player_ids = $voter_ids[$i];
                    }else if($player_ids != null && $voter_ids[$i] != (string)$request['player_id']){
                        $player_ids .= ",".$voter_ids[$i];
                    }
                }
                $quiz_answer->quiz_player_ids = $player_ids;
                $quiz_answer->save();
            }
        }else if($request['event_id'] == 4){
            $quiz_answers =  QuizAnswer::where('quiz_question_id','=',$request['question_id'])->where('quiz_id','=',$request['quiz_id'])->get();

            foreach ($quiz_answers as $index => $answers) {
                if($answers->quiz_player_ids !=null){
                    $voter_ids = explode(" ",$answers->quiz_player_ids);
                    if(in_array((string)$request['player_id'], $voter_ids)){
                        $quiz_answer = QuizAnswer::find($answers->id);
                        $quiz_answer->points -= 1;
                        $player_ids = null;
                        for ($i = 0; $i<count($voter_ids); $i++){
                            if($player_ids == null && $voter_ids[$i] != (string)$request['player_id']){
                                $player_ids = $voter_ids[$i];
                            }else if($player_ids != null && $voter_ids[$i] != (string)$request['player_id']){
                                $player_ids .= ",".$voter_ids[$i];
                            }
                        }
                        $quiz_answer->quiz_player_ids = $player_ids;
                        $quiz_answer->save();
                        break;
                    }
                }
            }
        }
        $quiz->players = $quiz->players - 1;
        $quiz->save();
        return response()->json(['quiz_id' => $quiz->id,'game_end' => $game_end],200);
    }
}
