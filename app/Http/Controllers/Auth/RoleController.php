<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $roles = Role::all();
        
        foreach($roles as $role){
            $data = [
                'name' => $role->name,
            ];
        }
        return $data;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Role::create([
            'name' => $request->name,
        ]);
        return $this->storeResponse($request->name);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = Role::with('users')->where('id',$id);

    
        return $this->showResponse($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findorfail($id);
        if($role){
        
            $role->update([
            'name' => $request->name
        ]);
        return $this->updateResponse($role);
    }else{
        return $this->notfoundResponse('Role Not Found');
    }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $role = Role::findOrFail($id);
        if (!$role) {
            return $this->notfoundResponse('Role Not Found');
        }
         $role->delete();
 
         return $this->successResponse($role,'Deleted',200);
         }
  
}
