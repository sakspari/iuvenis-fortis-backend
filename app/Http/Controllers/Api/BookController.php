<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Validator;

class BookController extends Controller
{
    public function index($id)
    {
        //ambil data user beseta dengan bookingan
        $userBookings = DB::table('book_details')
            ->where('user_id','=',$id)->get();

//        $userBookings = BookDetail::

        if(count($userBookings)>0){
            return response([
                'message' => 'Retrive All Success',
                'data' => $userBookings
            ], 200);
        }
        return response([
            'message' => 'No Bookings yet!',
            'data' => null
        ], 400); //return message data kosong
    }

    public function show($id)
    {
        $booking = BookDetail::find($id); //mencari booking detail berdasarkan data id

        if (!is_null($booking)) {
            return response([
                'message' => 'Retrive All Success',
                'data' => $booking
            ], 200);
        }

        return response([
            'message' => 'Booking Not Found',
            'data' => null
        ], 404);
    }

//    method untuk menambah booking baru
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'room_id' => 'required',
            'user_id' => 'required',
            'booking_date' => 'required|date',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
        ]); // validasi inputan

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $booking = BookDetail::create($storeData);
        return response([
            'message' => 'Add Booking Success',
            'data' => $booking
        ], 200); //return data boking dalam bentuk JSON
    }

//    method untuk menghapus data booking tertentu
    public function destroy($id)
    {
        $booking = BookDetail::find($id);

        if(is_null($booking)){
            return response([
                'message'=>'Booking Not Found',
                'data'=>null
            ],400);
        }//return message saat database tidak ditemukan

        if($booking->delete()){
            return response([
                'message'=>'Delete Booking Success',
                'data'=>$booking
            ],200);
        }

        return response([
            'message'=>'Delete Booking Failed',
            'data'=>null
        ],400);
    }

    public function update(Request $request, $id){
        $booking = BookDetail::find($id);
        if(is_null($booking)){
            return response([
                'message'=>'Booking Not Found',
                'data'=>null
            ],400);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'room_id' => 'required',
            'user_id' => 'required',
            'booking_date' => 'required|date',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
        ]); // validasi data

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }
        $booking->room_id = $updateData['room_id'];
        $booking->user_id = $updateData['user_id'];
        $booking->booking_date = $updateData['booking_date'];
        $booking->check_in_date = $updateData['check_in_date'];
        $booking->check_out_date = $updateData['check_out_date'];

        if($booking->save()){
            return response([
                'message'=> 'Update Booking Success',
                'data'=>$booking
            ],200);
        }
        return response([
            'message'=>'Update Booking Failed',
            'data'=>null
        ],400);
    }
}
