<?php

namespace App\Http\Controllers;

use App\Models;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    use GeneralTrait;

    public function register(Request $request)
    {
        
        $ruls = [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'phone'=> 'required|string|min:10|max:10',
            'is_admin'=> 'required|numeric|max:10'
        ];

        $validate = Validator($request->all(), $ruls);

        $message = $this->getMessageError($validate);

        if ($validate->fails()) {
            return response($this->getResponseAuth($message, false), 422);
        }
      
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' =>  bcrypt($request['password']),
            'phone' => $request['phone'],
            'is_admin' => $request['is_admin'],
        ]);

        return response($this->getResponseAuth(__('my_keywords.createdAccount'), true), 201);
    }

    public function login(Request $request)
    {
        $ruls = [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8'
        ];

        $validate = Validator($request->all(), $ruls);

        $message = $this->getMessageError($validate);

        if ($validate->fails()) {
            return response($this->getResponseAuth($message, false), 422);
        }

        // Check email
        $user = User::where('email', $request['email'])->first();

        // Check password
        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response($this->getResponseAuth(__('my_keywords.invaledLogin'), false), 401);
        }

        if ($user['email_verified_at'] == null) {
            return response($this->getResponseAuth(__('my_keywords.emailNotVerifed'), false), 403);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;

        return response($this->getResponseAuthWithTokenAndUser(__('my_keywords.loggedSuccessfully'), $token, $user, true), 200);
    }

    public function logout()
    {

        $user = request()->user(); //or Auth::user()
        // Revoke current user token
        $user->tokens()->delete(); //->where('id', $user->currentAccessToken()->id)

        return [
            'message' => 'Logged out'
        ];
    }


    public function forget(Request $request)
    {
        $ruls = [
            'email' => 'required|string|email',
        ];

        $validate = Validator($request->all(), $ruls);

        $message = $this->getMessageError($validate);

        if ($validate->fails()) {
            return response($this->getResponseAuth($message, false), 422);
        }

        $status = Password::sendResetLink(
            request()->only('email')
        );


        if ($status == Password::RESET_LINK_SENT) {
            return response($this->getResponseAuth(__($status), true), 200);
        }

        return response($this->getResponseAuth(trans($status), false), 422);
    }

    public function reset(Request $request)
    {
        $ruls = [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed'],
        ];

        $validate = Validator($request->all(), $ruls);

        $message = $this->getMessageError($validate);

        if ($validate->fails()) {
            return response($this->getResponseAuth($message, false), 422);
        }


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    // 'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response($this->getResponseAuth(__($status), true), 200);
        }

        return response($this->getResponseAuth(trans($status), false), 422);
    }

    public function sendVerificationEmail(Request $request)
    {
        $ruls = [
            'email' => 'required|email',
        ];

        $validate = Validator($request->all(), $ruls);

        $message = $this->getMessageError($validate);

        if ($validate->fails()) {
            return response($this->getResponseAuth($message, false), 422);
        }

        $user = User::where('email', $request->email)->first();
        // print($user);
        if ($user != null) {

            if ($user['email_verified_at'] != null) {
                return response($this->getResponseAuth(__('my_keywords.accountVerified'), true), 200);
            }

            $user->sendEmailVerificationNotification();

            return response($this->getResponseAuth(__('my_keywords.verificationSent'), true), 201);
        } else {
            return response($this->getResponseAuth(__('my_keywords.emailNotFound'), false), 403);
        }
    }

    public function verify(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // print($user);
        if ($user['email_verified_at'] != null) {
            return response($this->getResponseAuth(__('my_keywords.accountVerified'), true), 200);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return response($this->getResponseAuth(__('my_keywords.emailVerified'), true), 200);
    }
}
