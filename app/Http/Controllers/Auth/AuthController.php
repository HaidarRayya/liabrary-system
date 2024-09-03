<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * login 
     *
     * @param LoginRequest $request 
     *
     * @return response  of the status of operation : message the user data and the token
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', '=',  $credentials['email'])->first();
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'البيانات المدخلة خاطئة',
            ], 401);
        }
        if ($user->stauts == 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'حسابك تم حظره لا يمكنك تسجيل دخول من جديد ',
            ], 401);
        }
        $token = Auth::login($user);
        $user = UserResource::make($user);
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' =>  $user
            ],
            'message' => 'تم تسجيل الدخول بنجاح',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 200);
    }

    /**
     * logout
     *
     * @param Request $request 
     *
     * @return response  of the status of operation : message 
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'تم تسجيل الخروج بنجاح'
        ], 200);
    }
    /**
     * logout
     *
     * @param RegisterRequest $request 
     *
     * @return response  of the status of operation : message the user data and the token
     */
    public function register(RegisterRequest $request)
    {
        $registerData = $request->all();
        $registerData['password'] = Hash::make($registerData['password']);

        $user = User::create($registerData);
        $user = User::find($user->id);
        $token = Auth::login($user);
        $user = UserResource::make($user);
        return response()->json([
            'status' => 'success',
            'message' => 'تم التسجيل بنجاح',
            'data' => [
                'user' =>  $user
            ],
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 201);
    }
}
