<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    //
    public function index()
    {
        $rooms = room::all();

        if (count($rooms) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $rooms
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        $rooms = room::find($id);

        if (!is_null($rooms)) {
            return response([
                'message' => 'Retrieve Room Success',
                'data' => [$rooms]
            ], 200);
        }

        return response([
            'message' => 'Room Not Found',
            'data' => null
        ], 404);
    }

    public function roomWithDetail($id)
    {
        $rooms = DB::table('rooms')
            ->leftJoin('room_details','rooms.id','=','room_details.room_id')
            ->get();

        if (!is_null($rooms)) {
            return response([
                'message' => 'Retrieve Room Success',
                'data' => [$rooms]
            ], 200);
        }

        return response([
            'message' => 'Room Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'room_type' => 'required',
            'photo' => 'required',
            'facility_type' => 'required',
            'room_status' => 'required',
            'price' => 'required'

        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $rooms = room::create($storeData);
        return response([
            'message' => 'Add Room Success',
            'data' => [$rooms]
        ], 200);
    }

    public function destroy($id)
    {
        $rooms = room::find($id);

        if (is_null($rooms)) {
            return rensponse([
                'message' => 'Room Not Found',
                'data' => null
            ], 404);
        }

        if ($rooms->delete()) {
            return response([
                'message' => 'Delete Room Success',
                'data' => [$rooms]
            ], 200);
        }

        return response([
            'message' => 'Delete Room Failed',
            'data' => null
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $rooms = Student::find($id);

        if (is_null($rooms)) {
            return response([
                'message' => 'Room Not Found',
                'data' => [$rooms]
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'room_type' => 'required|max:60',
            'photo' => 'required',
            'facility_type' => 'required',
            'room_status' => 'required',
            'price' => 'required|double'

        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $rooms->room_type = $updateData['room_type'];
        $rooms->photo = $updateData['photo'];
        $rooms->facility_type = $updateData['facility_type'];
        $rooms->room_status = $updateData['room_status'];
        $rooms->price = $updateData['price'];

        if ($rooms->save()) {
            return response([
                'message' => 'Update rooms Success',
                'data' => $rooms
            ], 200);
        }

        return response([
            'message' => 'Update rooms Failed',
            'data' => null
        ], 400);
    }
}
