<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ReviewController extends Controller
{
    public function userRoomReview($room_id,$user_id) //parameter id kamar
    {
        //ambil data review dari kamar tertentu
        $roomReviews = DB::table('reviews')
            ->where('room_id','=',$room_id)
            ->where('user_id','=',$user_id)
            ->get();

//        [$roomReviews] = $roomReviewsAll
//        ->where('user_id','=',$user_id);

        if(count($roomReviews)>0){
            return response([
                'message' => 'Retrive All Success',
                'data' => $roomReviews
            ], 200);
        }
        return response([
            'message' => 'No Review for this room',
            'data' => null
        ], 400); //return message data kosong
    }

    public function reviewWithUser($id) //parameterb id kamar
    {
        //ambil data review dari kamar tertentu
        $roomReviews = DB::table('reviews')
            ->where('room_id','=',$id)
            ->leftJoin('users','reviews.user_id','=','users.id')
            ->get();

//        $roomReviews = DB::table('reviews')
//            ->where('room_id','=',$id)
//            ->get();


        if(count($roomReviews)>0){
            return response([
                'message' => 'Retrive All Success',
                'data' => $roomReviews
            ], 200);
        }
        return response([
            'message' => 'No Review for this room',
            'data' => null
        ], 400); //return message data kosong
    }



//    public function userReviewRoom($id_kamar,$id_user)
//    {
//        //ambil data review dari kamar tertentu
//        $roomReviews = DB::table('reviews')
//            ->where('room_id','=',$id_kamar) ->get();
//
//
//        if(count($roomReviews)>0){
//            return response([
//                'message' => 'Retrive All Success',
//                'data' => $roomReviews
//            ], 200);
//        }
//        return response([
//            'message' => 'No Review for this room',
//            'data' => null
//        ], 400); //return message data kosong
//    }

    public function show($id)
    {
        $review = Review::find($id); //mencari booking detail berdasarkan data id

        if (!is_null($review)) {
            return response([
                'message' => 'Retrive All Success',
                'data' => [$review]
            ], 200);
        }

        return response([
            'message' => 'Review Not Found',
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
            'review_date' => 'required|date',
            'description' => 'required',
        ]); // validasi inputan

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $review = Review::create($storeData);
        return response([
            'message' => 'Add Review Success',
            'data' => [$review]
        ], 200); //return data review dalam bentuk JSON
    }

//    method untuk menghapus data review tertentu
    public function destroy($id)
    {
        $review = Review::find($id);

        if(is_null($review)){
            return response([
                'message'=>'Review Not Found',
                'data'=>null
            ],400);
        }//return message saat database tidak ditemukan

        if($review->delete()){
            return response([
                'message'=>'Delete Review Success',
                'data'=>[$review]
            ],200);
        }

        return response([
            'message'=>'Delete Booking Failed',
            'data'=>null
        ],400);
    }

    public function update(Request $request, $id){
        $review = Review::find($id);
        if(is_null($review)){
            return response([
                'message'=>'Review Not Found',
                'data'=>null
            ],400);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'room_id' => 'required',
            'user_id' => 'required',
            'review_date' => 'required|date',
            'description' => 'required',
        ]); // validasi data

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }
        $review->room_id = $updateData['room_id'];
        $review->user_id = $updateData['user_id'];
        $review->review_date = $updateData['review_date'];
        $review->description = $updateData['description'];

        if($review->save()){
            return response([
                'message'=> 'Update Review Success',
                'data'=>[$review]
            ],200);
        }
        return response([
            'message'=>'Update Review Failed',
            'data'=>null
        ],400);
    }
}
