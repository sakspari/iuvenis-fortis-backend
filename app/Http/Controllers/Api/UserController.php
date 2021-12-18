<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = user::all();

        if (count($users) > 0) {
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

    public function show($email)
    {
//        $users = user::find($email);
        $users = DB::table('users')
            ->where('email', $email)
            ->get();

        if (!is_null($users)) {
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

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'name' => 'required|max:60|alpha',
            'email' => 'required|unique:users',
            'password' => 'required',
            'photo',
            'status' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);
        $storeData['password'] = bcrypt($request->password); //enkripsi password
        if ($storeData['status'] == 1) {
            $storeData['status'] = "true";
        } else {
            $storeData['status'] = "false";
        }
        $users = User::create($storeData);
        return response([
            'message' => 'Add User Success',
            'data' => [$users]
        ], 200);
    }

    public function destroy($id)
    {
        $users = User::find($id);

        if (is_null($users)) {
            return rensponse([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        if ($users->delete()) {
            return response([
                'message' => 'Delete User Success',
                'data' => [$users]
            ], 200);
        }

        return response([
            'message' => 'Delete Student Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $users = User::find($id);

        if (is_null($users)) {
            return response([
                'message' => 'User Not Found',
                'data' => [$users]
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'photo',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        if(password_verify($updateData['password'],$users['password']))
            return response(['message' => 'password Incorrect'], 400);

        $users->name = $updateData['name'];
        $users->photo = $updateData['photo'];
//        if ($updateData['status'] == 1) {
//            $users->status = "true";
//        } else {
//            $users->status = "false";
//        }
//             = $updateData['status'];

        if ($users->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => [$users]
            ], 200);
        }

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400);
    }
}
