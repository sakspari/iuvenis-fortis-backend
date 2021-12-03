<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
            'nama_kelas' => 'required|max:60|unique:courses',
            'kode' => 'required',
            'biaya_pendaftaran' => 'required|numeric',
            'kapasitas' => 'required|numeric',
        ]); // validasi inputan

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $course = Course::create($storeData);
        return response([
            'message' => 'Add Course Success',
            'data' => $course
        ], 200); //return data course dalam bentuk JSON
    }

//    method untuk menghapus data tertentu
    public function destroy($id)
    {
        $course = Course::find($id);

        if(is_null($course)){
            return response([
                'message'=>'Course Not Found',
                'data'=>null
            ],400);
        }//return message saat database tidak ditemukan

        if($course->delete()){
            return response([
                'message'=>'Delete Course Success',
                'data'=>$course
            ],200);
        }

        return response([
            'message'=>'Delete Course Failed',
            'data'=>null
        ],400);
    }

    public function update(Request $request, $id){
        $course = Course::find($id);
        if(is_null($course)){
            return response([
                'message'=>'Course Not Found',
                'data'=>null
            ],400);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_kelas' => ['max:60','required', Rule::unique('courses')->ignore($course)],
            'kode' => 'required',
            'biaya_pendaftaran' => 'required|numeric',
            'kapasitas' => 'required|numeric',
        ]); // validasi data

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }
        $course->nama_kelas = $updateData['nama_kelas']; //edit nama kelas
        $course->kode = $updateData['kode'];
        $course->biaya_pendaftaran = $updateData['biaya_pendaftaran']; //edit nama kelas
        $course->kapasitas = $updateData['kapasitas']; //edit nama kelas

        if($course->save()){
            return response([
                'message'=> 'Update Course Success',
                'data'=>$course
            ],200);
        }
        return response([
            'message'=>'Update Course Failed',
            'data'=>null
        ],400);
    }
}
