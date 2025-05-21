<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Traits\HttpResponse;
use Auth;

class AuthController extends Controller
{
    use HttpResponse;

    public function index(LoginRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|string|email',
        //     'password' => 'required|string'
        // ]);

        // if ($validator->fails()) {
        //     return $this->validationError($validator->errors());
        // }

        try {
            $credentials = $request->only(['email', 'password']);
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                return $this->success([
                    'user' => $user,
                    'token' => $user->createToken('myApp')->plainTextToken,
                ], 'Login Successful');
            } else {
                return $this->error('', 'Invalid Credentials');
            }
        } catch (\Throwable $e) {
            return $this->internalError($e->getMessage());
        }
    }
}
