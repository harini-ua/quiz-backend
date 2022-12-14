<?php

namespace App\Http\Controllers\API;

use App\Events\Notifications;
use App\Events\PlayersPointsEvent;
use App\Events\QuestionsEvent;
use App\Events\QuizEndedEvent;
use App\Events\TestEvent;
use App\Events\VotingEvent;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizPlayer;
use App\Models\QuizQuestion;
use App\Models\QuizUsedQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    /**
     * Generate quiz
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function generate_quiz(Request $request)
    {
        Log::debug($request->get('quiz_name'));

        $quiz = Quiz::create([
            'players' => 0,
            'name' => $request->get('quiz_name'),
            'quiz_rounds' => $request->get('quiz_rounds'),
            'code' => mb_strtoupper(Str::random(4))
        ]);

        $quiz->user()->associate($request->user());
        $quiz->save();

        Log::info('/quiz/generate');

        return response()->json($quiz);
    }

    /**
     * Join quiz
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function join_quiz(Request $request)
    {
        $quiz = Quiz::where('code', $request->get('code'))->with('user')->first();

        Log::warning($request->all());

        $quizLanguage = $quiz->user->language;

        Log::info('/quiz/join');

        return response()->json([
            'quiz_name' => $quiz->name,
            'quiz_code' => $quiz->code,
            'quiz_language' => $quizLanguage
        ]);
    }

    /**
     * Presence quiz
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function presence(Request $request)
    {
        $quiz = Quiz::where('code', $request->get('code'))->first()
            ->increment('players');

        event(new Notifications($quiz->code, $request->get('name') . ' joined quiz.'));
        event(new TestEvent($quiz->code, $request->get('name') . ' joined quiz.'));

        Log::info('Presence ' . $request->get('name'));

        return response()->json('success');
    }

    /**
     * Unused question
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unused_question(Request $request)
    {
        $usedQuestions = QuizUsedQuestion::where('quiz_id', $request->get('quiz_id'));
        $quizQuestionIds = $usedQuestions->pluck('quiz_question_id')->toArray();

        $questions = QuizQuestion::where('category', $request->get('category'))
            ->whereNotIn('id', $quizQuestionIds)
            ->get();

        if ($questions->isEmpty()) {
            return response()->json(['questions' => false]);
        }

        $question = $questions->random();

        $quiz = Quiz::find($request->get('quiz_id'));

        Log::warning($quiz);
        Log::warning($question);

        $used = new QuizUsedQuestion;
        $used->quiz()->associate($quiz);
        $used->quizQuestion()->associate($question);
        $used->save();

        Log::info($request->get('category'));

        event(new QuestionsEvent($quiz->code, $question));

        return response()->json(['questions' => true]);
    }

    /**
     * Answer question
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function answer_question(Request $request)
    {
        $quizPlayer = QuizPlayer::where('socket_id', $request->get('socket_id'))->first();
        $quizQuestion = QuizQuestion::find($request->get('question_id'));

        $quiz = $quizPlayer->quiz;

        $answer = ' ';
        if ($request->get('answer') !== '') {
            $answer = $request->get('answer');
        }

        $quizAnswer = new QuizAnswer;
        $quizAnswer->answer = $answer;
        $quizAnswer->quizPlayer()->associate($quizPlayer);
        $quizAnswer->quizQuestion()->associate($quizQuestion);
        $quizAnswer->quiz()->associate($quiz);
        $quizAnswer->save();

        $quizAnswers = $quiz->quizAnswersByQuestion($request->get('question_id'))->count();

        Log::info($quizAnswers . ' COUNT');

        if ($quizAnswers == $quiz->players) {
            Log::info('VotingEvent');

            $quizAnswers = $quiz->quizAnswersByQuestionByVote($request->get('question_id'))
                ->with('quizPlayer')->get();

            event(new VotingEvent($quiz->code, $quizAnswers));
        }

        return response()->json([
            'left' => $quiz->players - $quizAnswers->count()
        ]);
    }

    /**
     * Answer vote
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function answer_vote(Request $request)
    {
        if ($request->get('answer_id') == -1 || $request->get('answer_id') == null) {
            $quizPlayer = QuizPlayer::find($request->get('player_id'));
            $quizAnswer = QuizAnswer::where('quiz_id', $quizPlayer->quiz_id)
                ->with('quizQuestion')
                ->orderBy('updated_at', 'DESC')->first();
        } else {
            $quizAnswer = QuizAnswer::find($request->get('answer_id'));
        }

        ++$quizAnswer->points;

        if ($quizAnswer->quiz_player_ids != null) {
            $quizAnswer->quiz_player_ids .= ','.$request->get('player_id');
        } else {
            $quizAnswer->quiz_player_ids = (string) $request->get('player_id');
        }

        $quizAnswer->save();
        $quiz = $quizAnswer->quiz;

        $quizQuestionId = $quizAnswer->quizQuestion->id;

        if ($quiz->players == $quiz->quizAnswersByQuestion($quizQuestionId)->sum('points')) {
            $favorite = $quiz->quizAnswersByQuestion($quizQuestionId)
                ->with('quizPlayer')->orderBy('points', 'DESC')->first();

            $quizPlayer = $favorite->quizPlayer;
            $quizPlayer->increment('points', 3);

            ++$quiz->answered_question;
            $quiz->save();

            $roundsLeft = $quiz->quiz_rounds - $quiz->answered_question;

            if ($roundsLeft == 0) {
                event(new QuizEndedEvent($quiz->code, $quiz->quizPlayers(), $quiz->quizPlayers()->first()));
            } else {
                event(new PlayersPointsEvent($quiz->code, $quiz->quizPlayers(), $quizPlayer, $favorite->answer, $roundsLeft));
            }
        }

        return response()->json([
            'left' => $quiz->players - $quiz->quizAnswersByQuestion($quizQuestionId)->sum('points')
        ]);
    }

    /**
     * Winner
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function winner(Request $request)
    {
        $player = QuizPlayer::find($request->get('player_id'));

        $quiz = $player->quiz;

        if ($quiz->quizPlayers()->first()->id == $player->id) {
            return response()->json([
                'qr_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png'
            ]);
        }

        return response()->json('you are not winner');
    }

    /**
     * Change host
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function change_host(Request $request)
    {
        $gameEnd = false;
        $quiz = Quiz::find($request->get('quiz_id'));

        if ($quiz->players <= 2 ) {
            event(new QuizEndedEvent($quiz->code, $quiz->quizPlayers(), $quiz->quizPlayers()->first()));
            $gameEnd = true;
        } else if($request->get('event_id') == 3) {
            $quizAnswers = $quiz->quizAnswersByQuestion($request->get('question_id'))->count();

            $left = $quiz->players - $quizAnswers;
            $hostAnswer = $quiz->quizHostAnswersByQuestion($request->get('question_id'), $request->get('player_id'))->count();

            if ($left == 1 && $hostAnswer == 0 ) {
                $quizAnswers = $quiz->quizAnswersByQuestionByVote($request->get('question_id'))
                    ->with('quizPlayer')
                    ->get();

                event(new VotingEvent($quiz->code, $quizAnswers));
            } else if($hostAnswer == 1) {
                QuizAnswer::where('quiz_question_id', $request->get('question_id'))
                    ->where('quiz_player_id', $request->get('player_id'))
                    ->delete();
            }
        } else if ($request->get('event_id') == 2) {
            QuizAnswer::where('quiz_question_id', $request->get('question_id'))
                ->where('quiz_player_id', $request->get('player_id'))
                ->delete();
        } else if($request->get('event_id') == 5) {
            $hostVote = false;

            $left = $quiz->players - $quiz->quizAnswersByQuestion($request->get('question_id'))->sum('points');

            $quizAnswers =  QuizAnswer::where('quiz_question_id', $request->get('question_id'))
                ->where('quiz_id', $request->get('quiz_id'))->get();

            $favorite = $quiz->quizAnswersByQuestion($request->get('question_id'))
                ->with('quizPlayer')->orderBy('points', 'DESC')->first();

            $quizPlayer = $favorite->quizPlayer;
            $quizPlayer->increment('points', 3);

            $roundsLeft = $quiz->quiz_rounds - $quiz->answered_question;
            $answerId = null;

            foreach ($quizAnswers as $answers) {
                if($answers->quiz_player_ids != null){
                    $voterIds = explode(' ', $answers->quiz_player_ids);
                    if (in_array((string) $request->get('player_id'), $voterIds, true)) {
                        $hostVote = true;
                        $answerId = $answers->id;
                        break;
                    }
                }
            }

            if ($left == 1 && !$hostVote) {
                if ($roundsLeft == 0) {
                    event(new QuizEndedEvent($quiz->code, $quiz->quizPlayers(), $quiz->quizPlayers()->first()));
                } else {
                    event(new PlayersPointsEvent($quiz->code, $quiz->quizPlayers(), $quizPlayer, $favorite->answer, $roundsLeft));
                }
            } else if($hostVote) {
                $quizAnswer = QuizAnswer::find($answerId);
                --$quizAnswer->points;

                $playerIds = null;
                for ($i = 0, $iMax = count($voterIds); $i< $iMax; $i++) {
                    if ($voterIds[$i] != (string) $request->get('player_id')) {
                        if ($playerIds == null) {
                            $playerIds = $voterIds[$i];
                        } else if ($playerIds != null) {
                            $playerIds .= ','.$voterIds[$i];
                        }
                    }
                }

                $quizAnswer->quiz_player_ids = $playerIds;
                $quizAnswer->save();
            }
        } else if($request->get('event_id') == 4) {
            $quizAnswers = QuizAnswer::where('quiz_question_id', $request->get('question_id'))
                ->where('quiz_id', $request->get('quiz_id'))->get();

            foreach ($quizAnswers as $key => $answers) {
                if ($answers->quiz_player_ids != null) {
                    $voterIds = explode(' ', $answers->quiz_player_ids);

                    if(in_array((string) $request->get('player_id'), $voterIds, true)){
                        $quizAnswer = QuizAnswer::find($answers->id);
                        --$quizAnswer->points;

                        $playerIds = null;
                        for ($i = 0, $iMax = count($voterIds); $i < $iMax; $i++) {
                            if ($voterIds[$i] != (string) $request->get('player_id')) {
                                if ($playerIds == null) {
                                    $playerIds = $voterIds[$i];
                                } else if ($playerIds != null) {
                                    $playerIds .= ','.$voterIds[$i];
                                }
                            }
                        }

                        $quizAnswer->quiz_player_ids = $playerIds;
                        $quizAnswer->save();
                        break;
                    }
                }
            }
        }

        --$quiz->players;
        $quiz->save();

        return response()->json([
            'quiz_id' => $quiz->id,
            'game_end' => $gameEnd
        ]);
    }

    /**
     * Player left
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function player_left(Request $request)
    {
        $gameEnd = false;
        $quiz = Quiz::find($request->get('quiz_id'));

        if ($quiz->players <= 2 ) {
            event(new QuizEndedEvent($quiz->code, $quiz->quizPlayers(), $quiz->quizPlayers()->first()));
            $gameEnd = true;
        } else if ($request->get('event_id') == 3) {
            $quizAnswers = $quiz->quizAnswersByQuestion($request->get('question_id'))->count();
            $left = $quiz->players - $quizAnswers;

            $hostAnswer = $quiz->quizHostAnswersByQuestion($request->get('question_id'), $request->get('player_id'))->count();

            if ($left == 1 && $hostAnswer == 0 ) {
                event(new VotingEvent($quiz->code, $quiz->quizAnswersByQuestionByVote($request->get('question_id'))->with('quizPlayer')->get()));
            } else if ($hostAnswer == 1) {
                QuizAnswer::where('quiz_question_id', $request->get('question_id'))
                    ->where('quiz_player_id', $request->get('player_id'))
                    ->delete();
            }
        } else if ($request->get('event_id') == 2) {
            QuizAnswer::where('quiz_question_id', $request->get('question_id'))
                ->where('quiz_player_id', $request->get('player_id'))
                ->delete();
        } else if ($request->get('event_id') == 5) {
            $left = $quiz->players - $quiz->quizAnswersByQuestion($request->get('question_id'))->sum('points');
            $quizAnswers =  QuizAnswer::where('quiz_question_id', $request->get('question_id'))
                ->where('quiz_id', $request->get('quiz_id'))->get();

            $hostVote = false;

            $favorite = $quiz->quizAnswersByQuestion($request->get('question_id'))
                ->with('quizPlayer')->orderBy('points', 'DESC')->first();

            $quizPlayer = $favorite->quizPlayer;
            $quizPlayer->increment('points', 3);

            $roundsLeft = $quiz->quiz_rounds - $quiz->answered_question;

            $answerId = null;
            foreach ($quizAnswers as $answers) {
                if($answers->quiz_player_ids != null){
                    $voterIds = explode(' ', $answers->quiz_player_ids);
                    if(in_array((string) $request->get('player_id'), $voterIds, true)){
                        $hostVote = true;
                        $answerId = $answers->id;
                        break;
                    }
                }
            }

            if ($left == 1 && !$hostVote) {
                if ($roundsLeft == 0) {
                    event(new QuizEndedEvent($quiz->code, $quiz->quizPlayers(), $quiz->quizPlayers()->first()));
                } else {
                    event(new PlayersPointsEvent($quiz->code, $quiz->quizPlayers(), $quizPlayer, $favorite->answer, $roundsLeft));
                }
            } else if($hostVote) {
                $quizAnswer = QuizAnswer::find($answerId);
                $quizAnswer->points -= 1;
                $playerIds = null;

                for ($i = 0, $iMax = count($voterIds); $i< $iMax; $i++) {
                    if ($voterIds[$i] != (string)$request->get('player_id')) {
                        if ($playerIds == null) {
                            $playerIds = $voterIds[$i];
                        } else if($playerIds != null) {
                            $playerIds .= ','.$voterIds[$i];
                        }
                    }
                }

                $quizAnswer->quiz_player_ids = $playerIds;
                $quizAnswer->save();
            }
        } else if($request->get('event_id') == 4) {
            $quizAnswers = QuizAnswer::where('quiz_question_id', $request->get('question_id'))
                ->where('quiz_id', $request->get('quiz_id'))->get();

            foreach ($quizAnswers as $answers) {
                if ($answers->quiz_player_ids != null) {
                    $voterIds = explode(' ', $answers->quiz_player_ids);

                    if (in_array((string) $request->get('player_id'), $voterIds, true)) {
                        $quizAnswer = QuizAnswer::find($answers->id);
                        $quizAnswer->points -= 1;

                        $playerIds = null;
                        for ($i = 0, $iMax = count($voterIds); $i< $iMax; $i++){
                            if ($voterIds[$i] != (string) $request->get('player_id')) {
                                if ($playerIds == null) {
                                    $playerIds = $voterIds[$i];
                                } else if ($playerIds != null) {
                                    $playerIds .= ",".$voterIds[$i];
                                }
                            }
                        }

                        $quizAnswer->quiz_player_ids = $playerIds;
                        $quizAnswer->save();
                        break;
                    }
                }
            }
        }

        --$quiz->players;
        $quiz->save();

        return response()->json([
            'quiz_id' => $quiz->id,
            'game_end' => $gameEnd
        ]);
    }
}
