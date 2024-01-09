<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
   * Display a listing of the resource.
     */
    use ApiResponseTrait;
    public function index()
    {
        //
        $roleuser = RoleUser::all();
        foreach($roleuser as $row){
            $data =[
                'role_name' => $row->users->name,
                'user_name'=> $row->roles->name
            ];
        }
        return $this->indexResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$id)
    {
        //
        $user_id = User::find($id);
        
        $role = $request->name;
        $role_id = Role::where('name',$role)->first();
        $user_id->roles()->attach($role_id);
        return $this->successResponse($request->name,'Create Successfully',201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role_user =  RoleUser::findorfail($id);
        if($role_user){
         $data =[
            'role_name' =>$role_user->roles->name,
            'user_name' =>$role_user->users->name
         ]   ;
         return $this->showResponse($data);
        }else{
            return $this->notfoundResponse('This Role_User Not Found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $user = User::where('name',$request->user_name)->first();
        $role = Role::where('name',$request->role_name)->first();
        $role_user = RoleUser::find($id);
        if($role_user){
            if($user and $role){
                $role_user->update([
                    'role_id' => $role->id,
                    'user_id' => $user->id
                ]);

            $data = [
                'Role_name' =>$role_user->roles->name,
                'User_name' =>$role_user->users->name
            ];
        }else{
            return $this->notfoundResponse('The User Or The Role Not Found');
        }
        }else{
            return $this->notfoundResponse('Role_User Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role_user = RoleUser::find($id);
        if (!$role_user) {
            return $this->notfoundResponse('Role_User Not Found');
        }
        $role_user->delete();
        return $this->destroyResponse();
    }
}
