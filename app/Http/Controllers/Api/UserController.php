<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function index(){
        $users = user::all();

        if(count($users)> 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $users
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id){
        $users = user::find($id);

        if(!is_null($users)){
            return response([
                'message' => 'Retrieve User Success',
                'data' => $users
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'name' => 'required|max:60|alpha',
            'email' => 'required|unique:users',
            'password'=>'required',
            'photo'=>'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

            $users = User::create($storeData);
        return response([
            'message' => 'Add User Success',
            'data' => $users
        ], 200);
    }

    public function destroy($id){
        $users = User::find($id);

        if(is_null($users)){
            return rensponse([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        if($users->delete()){
            return response([
                'message' => 'Delete User Success',
                'data' => $users
            ], 200);
        }

        return response([
            'message' => 'Delete Student Failed',
            'data' => null
        ], 400);
    }
    public function update(Request $request, $id){
        $users = User::find($id);

        if(is_null($users)){
            return response([
                'message' => 'User Not Found',
                'data' => $users
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'email' => 'required',Rule::unique('user')->ignore($users),
            'password' => 'required',
            'photo' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
            
            $users->name= $updateData['name'];
            $users->email = $updateData['email'];
            $users->password = $updateData['password'];
            $users->photo = $updateData['photo'];

        if($users->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => $users
            ], 200);
        }
        
        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400);
}
}