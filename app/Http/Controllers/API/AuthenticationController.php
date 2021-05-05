<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationController extends Controller
{
    /**
     * Login
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            //'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)){
            Log::info('Unauthorized');
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();

        $user->ip = geoip(\request()->ip())->ip;
        $user->city = geoip(\request()->ip())->city;
        $user->state = geoip(\request()->ip())->state_name;
        $user->country = geoip(\request()->ip())->country;

        $user->save();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        Log::info('/auth/login');

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        Log::info('/auth/user');

        return response()->json($request->user());
    }

    /**
     * Set language
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function set_language(Request $request)
    {
        Log::info('/API/set-language');

        /** @var User $user */
        $user = Auth::user();
        $user->language = $request->get('language');
        $user->save();

        return response()->json('success');
    }
}
