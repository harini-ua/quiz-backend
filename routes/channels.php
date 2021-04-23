<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('quiz.{id}', function ($id) {
//    \Illuminate\Support\Facades\Log::debug('broadcast:channel quiz'.$id);
//    $quiz = \App\Quiz::where('code','=',$id)->first();
//    $quiz->players = $quiz->player + 1;
//    $quiz->save();
//
//    \App\Events\TestEvent::dispatch($id, 'Ušo neko');
//
////    return true;
//
//});




Route::post('/api/broadcast/auth/guest', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info($request->headers->get('Authorization'));
    \Illuminate\Support\Facades\Log::info($request);

    $name =  substr($request->headers->get('Authorization'),5);
    $user = new \Illuminate\Auth\GenericUser(['id' => $request->socket_id,'name'=>$name]);

    request()->setUserResolver(function () use ($user) {
        return $user;
    });

    return Broadcast::auth(request());
});


Broadcast::channel('quiz.{roomId}', function ($user,$roomId) {
    \Illuminate\Support\Facades\Log::info('PRESENCE CHANNEL');
    \Illuminate\Support\Facades\Log::info(print_r($user,true));

    $quiz = \App\Quiz::where('code','=',$roomId)->first();
    $quiz_player = new \App\QuizPlayer;
    $quiz_player->name = $user->name;
    $quiz_player->socket_id = $user->id;
    $quiz_player->quiz()->associate($quiz);
    $quiz_player->save();
    if($quiz->players==0){
        $host = true;
    }else{
        $host = false;
    }
    $quiz->players = $quiz->players + 1;
    $quiz->save();

    return ['id' => $user->id, 'name' => $user->name, 'ovo'=>'ono', 'quiz_id' => $quiz->id, 'host' => $host, 'player_position' =>  $quiz->players, 'quiz_player_id' => $quiz_player->id];
});

//Broadcast::channel('backoffice-activity', function () {
////    return Auth::check();
////});
