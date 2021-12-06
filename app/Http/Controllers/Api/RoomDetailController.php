<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class RoomDetailController extends Controller
{
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'room_id' => 'required',
            'description' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $rooms = room::create($storeData);
        return response([
            'message' => 'Add Room Detail Success',
            'data' => [$rooms]
        ], 200);
    }

    public function show($id)
    {
//        $rooms = RoomDetail::find($id);

        $rooms = DB::table('room_details')
            ->where('room_id', '=', $id)
            ->get();

        if (!is_null($rooms)) {
            return response([
                'message' => 'Retrieve Room Detail Success',
                'data' => $rooms
            ], 200);
        }

        return response([
            'message' => 'Room Detail Not Found',
            'data' => null
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $roomDetail = RoomDetail::find($id);

        if (is_null($roomDetail)) {
            return response([
                'message' => 'Room Detail Not Found',
                'data' => [$roomDetail]
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'room_id' => 'required',
            'description' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $roomDetail->room_id = $updateData['room_id'];
        $roomDetail->description = $updateData['description'];

        if ($roomDetail->save()) {
            return response([
                'message' => 'Update room detail  Success',
                'data' => [$roomDetail]
            ], 200);
        }

        return response([
            'message' => 'Update room detail Failed',
            'data' => null
        ], 400);
    }
}
