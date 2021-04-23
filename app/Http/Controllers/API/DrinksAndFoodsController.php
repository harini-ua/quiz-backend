<?php

namespace App\Http\Controllers\API;

use App\Drink;
use App\DrinkIngredient;
use App\EventType;
use App\Food;
use App\FoodIngredient;
use App\Mail\IngredientsEmail;
use Aws\Polly\PollyClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DrinksAndFoodsController extends Controller
{
    public function drinks(Request $request)
    {
        Log::debug('/drinks before');
        Log::debug($request->all());

        $match_drinks = Food::find($request['food_id'])->drinks()
            ->get(['drinks.id', 'name', 'description', 'complexity_number', 'ingredients_number', 'minutes', 'image']);
        Log::debug($match_drinks);

        $other_drinks = Drink::whereNotIn('id', $match_drinks->pluck('id')->toArray())->get();;
        Log::debug($other_drinks);

        Log::info('/drinks');

        return response()->json(['match_drinks' => $match_drinks, 'other_drinks' => $other_drinks]);
    }

    public function foods(Request $request)
    {
        $event_type = EventType::find($request['event_type_id']);
        $foods = $event_type->foods;

        Log::info('/foods');

        return response()->json($foods);
    }

    public function ingredients(Request $request)
    {
        $food_ingredients = Food::find($request['food_id'])->food_ingredients;
        $drink_ingredients = Drink::find($request['drink_id'])->drink_ingredients;

        return response()->json([
            'food_ingredients' => $food_ingredients,
            'drink_ingredients' => $drink_ingredients
        ]);
    }

    public function missing_ingredients (Request $request)
    {
        $food_ingredients = FoodIngredient::find($request['food_ingredients']);
        $food_ingredients_text = "";
        foreach ($food_ingredients as $f_ingredient) {
            $food_ingredients_text.="-  **" . $f_ingredient->name . "**" . " (*" . $f_ingredient->quantity ."*) \n";
        }

        $drink_ingredients = DrinkIngredient::find($request['drink_ingredients']);
        $drink_ingredients_text = "";
        foreach ($drink_ingredients as $d_ingredient) {
            $drink_ingredients_text.="-  **" . $d_ingredient->name . "**" . " (*" . $d_ingredient->quantity ."*) \n";
        }

        Mail::to(Auth::user())
            ->send(
                new IngredientsEmail(
                    $food_ingredients->first()->food->name,
                    $drink_ingredients->first()->drink->name,
                    $food_ingredients_text,
                    $drink_ingredients_text
                )
            );

        return response()->json('success');
    }

    public function steps (Request $request)
    {
        Log::debug('/API/steps');
        Log::debug($request->all());

        $food_steps = Food::find($request['food_id'])->food_steps;
        $drink_steps = Drink::find($request['drink_id'])->drink_steps;

        return response()->json([
            'food_steps' => $food_steps,
            'drink_steps' => $drink_steps
        ]);
    }

    public function alexa_english(Request $request)
    {
        $config = [
            'version' => 'latest',
            'region' => 'eu-west-2', //region
            'credentials' => [
                'key' => 'AKIAXOJUA65XZ3TFYOOL',
                'secret' => '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',
            ]
        ];

        $client = new PollyClient($config);

        $args = [
            'OutputFormat' => 'mp3',
            'Text' => "<speak><prosody rate='medium'>" . $request->input('text') ."</prosody></speak>",
            'TextType' => 'ssml',
            'VoiceId' => 'Joanna',
        ];

        $result = $client->synthesizeSpeech($args);

        $resultData = $result->get('AudioStream')->getContents();

        $size = strlen($resultData); // File size
        $length = $size; // Content length
        $start = 0; // Start byte
        $end = $size - 1; // End byte
        header('Content-Transfer-Encoding:chunked');
        header("Content-Type: audio/mpeg");
        header("Accept-Ranges: 0-$length");
        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: $length");

        echo $resultData;
    }

    public function alexa_spanish(Request $request)
    {
        $config = [
            'version' => 'latest',
            'region' => 'eu-west-2', //region
            'credentials' => [
                'key' => 'AKIAXOJUA65XZ3TFYOOL',
                'secret' => '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',
            ]];

        $client = new PollyClient($config);

        $args = [
            'OutputFormat' => 'mp3',
            'Text' => "<speak><prosody rate='medium'>" . $request->input('text') ."</prosody></speak>",
            'TextType' => 'ssml',
            'VoiceId' => 'Conchita',
        ];

        $result = $client->synthesizeSpeech($args);

        $resultData = $result->get('AudioStream')->getContents();

        $size = strlen($resultData); // File size
        $length = $size; // Content length
        $start = 0; // Start byte
        $end = $size - 1; // End byte
        header('Content-Transfer-Encoding:chunked');
        header("Content-Type: audio/mpeg");
        header("Accept-Ranges: 0-$length");
        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: $length");

        echo $resultData;
    }

    public function alexa_german(Request $request)
    {
        $config = [
            'version' => 'latest',
            'region' => 'eu-west-2', //region
            'credentials' => [
                'key' => 'AKIAXOJUA65XZ3TFYOOL',
                'secret' => '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',
            ]];

        $client = new PollyClient($config);

        $args = [
            'OutputFormat' => 'mp3',
            'Text' => "<speak><prosody rate='medium'>" . $request->input('text') ."</prosody></speak>",
            'TextType' => 'ssml',
            'VoiceId' => 'Marlene',
        ];

        $result = $client->synthesizeSpeech($args);

        $resultData = $result->get('AudioStream')->getContents();

        $size = strlen($resultData); // File size
        $length = $size; // Content length
        $start = 0; // Start byte
        $end = $size - 1; // End byte
        header('Content-Transfer-Encoding:chunked');
        header("Content-Type: audio/mpeg");
        header("Accept-Ranges: 0-$length");
        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: $length");

        echo $resultData;
    }
}
