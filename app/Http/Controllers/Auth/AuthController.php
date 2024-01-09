<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()  {
        $users = User::all();

        return $this->successResponse($users,'sucess',200);

    }

    //
    public function register(RegisterRequest $request)  {
        
        $user  = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password'=>bcrypt( $request->password),
            'status' => 0
    
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;
      return $this->registerResponse($user->name);

        
    }


    public function login(LoginRequest $request ) {
        if (!Auth::attempt($request->only('email','password'))){
            return $this->errorResponse('Faild Login');
        }
        $user = User::where('email',$request->email)->findOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->loginResponse(   $user->name,$token);
    }



    public function logout()
    {
        auth()->user::currentAccessToken()->delete();

        return $this->logoutResponse('Logout Successfully');
    }
}
