<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

            $students = Student::create($storeData);
        return response([
            'message' => 'Add Student Success',
            'data' => $students
        ], 200);
    }

    public function destroy($id){
        $students = Student::find($id);

        if(is_null($students)){
            return rensponse([
                'message' => 'student Not Found',
                'data' => null
            ], 404);
        }

        if($students->delete()){
            return response([
                'message' => 'Delete Student Success',
                'data' => $students
            ], 200);
        }

        return response([
            'message' => 'Delete Student Failed',
            'data' => null
        ], 400);
    }
    public function update(Request $request, $id){
        $students = Student::find($id);

        if(is_null($students)){
            return response([
                'message' => 'Student Not Found',
                'data' => $students
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama' => 'required|max:60',Rule::unique('student')->ignore($students),
            'npm' => 'required|numeric',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'no_telp' => 'required|numeric|regex:/^08\d{11,13}$/'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
            
            $students->nama= $updateData['nama'];
            $students->npm = $updateData['npm'];
            $students->tanggal_lahir = $updateData['tanggal_lahir'];
            $students->no_telp = $updateData['no_telp'];

        if($students->save()) {
            return response([
                'message' => 'Update student Success',
                'data' => $students
            ], 200);
        }
        
        return response([
            'message' => 'Update student Failed',
            'data' => null
        ], 400);
}
