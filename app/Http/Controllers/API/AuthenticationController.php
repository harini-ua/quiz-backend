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
    public function login(Request $request) {

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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'newsletter' => 'boolean',
            'language' =>'string'
        ]);

        Log::info($request->all());

        $user = new User;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->language = $request['language'];

        $user->ip = geoip(\request()->ip())->ip;
        $user->city = geoip(\request()->ip())->city;
        $user->state = geoip(\request()->ip())->state_name;
        $user->country = geoip(\request()->ip())->country;

        $user->save();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        $token->save();

        Log::info('/auth/register');

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        Log::info('/auth/logout');

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        Log::info('/auth/user');
        return response()->json($request->user());
    }

    public function set_language(Request $request)
    {
        Log::info('/API/set-language');

        /** @var User $user */
        $user = Auth::user();
        $user->language = $request['language'];
        $user->save();

        return response()->json('success',200);
    }

    public function login_facebook(Request $request)
    {
        Log::alert('BEGINNING OF FB');

        $user_facebook = Socialite::driver('facebook')->userFromToken($request['accessToken']);

        $user_db = User::where('email','=',$user_facebook->getEmail())->first();

        if ($user_db){
            $user = $user_db;
        }
        else {
            $user = new User;
            $user->name = $user_facebook->getName();
            $user->email = $user_facebook->getEmail();
            $user->password = 'fb-login';
            $user->language = $request['language'];
        }

        $user->ip = geoip(\request()->ip())->ip;
        $user->city = geoip(\request()->ip())->city;
        $user->state = geoip(\request()->ip())->state_name;
        $user->country = geoip(\request()->ip())->country;
        $user->save();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
}
