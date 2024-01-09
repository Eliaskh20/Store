<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        //
        $users = User::all();
        $data = [
            'name' => $users->name,
            'email' => $users->email
        ];
        
        return $this->indexResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //

            $user = Auth::user();
        
            if ($user) {
                $user->update([
                    'name' => $request->name?:$user->name,
                    'email' => $request->email?:$user->email,
                    'password'=> $request->password?:$user->password
                ]);

                $data =[
                    'name' => $user->name,
                    'email' => $user->email
                ];
                return $this->updateResponse($data);
            } else {
                return $this->errorResponse('Unauthorized', 401);
            }
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
            $user = Auth::user();
            if(!$user){
                return $this->errorResponse('You Dont have pirmation ',404);
            
            }
            $user->delete();
            return $this->destroyResponse();
    }

   
}
