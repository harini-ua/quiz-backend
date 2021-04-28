<?php

namespace App\Http\Controllers\API;

use App\Models\Drink;
use App\Models\DrinkIngredient;
use App\Models\EventType;
use App\Models\Food;
use App\Models\FoodIngredient;
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
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function drinks(Request $request)
    {
        Log::debug('/drinks before');
        Log::debug((string) $request->all());

        $matchDrinks = Food::find($request->get('food_id'))->drinks()
            ->get(['drinks.id', 'name', 'description', 'complexity_number', 'ingredients_number', 'minutes', 'image']);
        Log::debug($matchDrinks);

        $matchDrinksIds = $matchDrinks->pluck('id')->toArray();

        $otherDrinks = Drink::whereNotIn('id', $matchDrinksIds)->get();
        Log::debug($otherDrinks);

        Log::info('/drinks');

        return response()->json([
            'match_drinks' => $matchDrinks,
            'other_drinks' => $otherDrinks
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function foods(Request $request)
    {
        $eventType = EventType::find($request->get('event_type_id'));
        $foods = $eventType->foods;

        Log::info('/foods');

        return response()->json($foods);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ingredients(Request $request)
    {
        $foodIngredients = Food::find($request->get('food_id'))->food_ingredients;
        $drinkIngredients = Drink::find($request->get('drink_id'))->drink_ingredients;

        return response()->json([
            'food_ingredients' => $foodIngredients,
            'drink_ingredients' => $drinkIngredients
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function missing_ingredients(Request $request)
    {
        $foodIngredients = FoodIngredient::find($request->get('food_ingredients'));

        $foodIngredientsText = "";
        foreach ($foodIngredients as $fIngredient) {
            $foodIngredientsText .= "-  **" . $fIngredient->name . "**" . " (*" . $fIngredient->quantity ."*) \n";
        }

        $drinkIngredients = DrinkIngredient::find($request->get('drink_ingredients'));

        $drinkIngredientsText = "";
        foreach ($drinkIngredients as $dIngredient) {
            $drinkIngredientsText .= "-  **" . $dIngredient->name . "**" . " (*" . $dIngredient->quantity ."*) \n";
        }

        Mail::to(Auth::user())
            ->send(
                new IngredientsEmail(
                    $foodIngredients->first()->food->name,
                    $drinkIngredients->first()->drink->name,
                    $foodIngredientsText,
                    $drinkIngredientsText
                )
            );

        return response()->json('success');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function steps(Request $request)
    {
        Log::debug('/API/steps');
        Log::debug((string) $request->all());

        $foodSteps = Food::find($request->get('food_id'))->food_steps;
        $drinkSteps = Drink::find($request->get('drink_id'))->drink_steps;

        return response()->json([
            'food_steps' => $foodSteps,
            'drink_steps' => $drinkSteps
        ]);
    }

    /**
     * @param Request $request
     */
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
            'Text' => "<speak><prosody rate='medium'>" . $request->get('text') ."</prosody></speak>",
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

    /**
     * @param Request $request
     */
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
            'Text' => "<speak><prosody rate='medium'>" . $request->get('text') ."</prosody></speak>",
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

    /**
     * @param Request $request
     */
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
            'Text' => "<speak><prosody rate='medium'>" . $request->get('text') ."</prosody></speak>",
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
