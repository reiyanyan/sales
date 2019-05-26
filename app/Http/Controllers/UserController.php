<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{

    public function index(){
        return view('user_management');
    }

    public function laporan(){
        return view('laporan');
    }

    public function job_management(){
        return view('job_management');
    }

    //Semua API di bawah ini
    public function signin(Request $request){
        $user = User::where('email',$request->email)->where('role','!=',3)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    'message' => 'success',
                    'user_id' => $user->id
                ], 200);
            }else{
                return response()->json([
                    'message' => 'fails',
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'fails',
            ], 401);
        }
    }

    public function list_sales(){
        $user = User::where('role', 1)->get();
        return response()->json( $user );
    }

    public function update(Request $request){
        $user = User::where('id', $request->id)->first();
        $user->identitas = $request->identitas;
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->save();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function store(Request $request){
        $user = new User;
        $user->identitas = $request->identitas;
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->password = $request->password;
        $user->save();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function delete(Request $request){
        User::where('id', $request->id)->delete();
        return response()->json([
            'message' => 'success'
        ]);
    }

    public function simpleApi(){
        return response()->json([
            'message' => 'oke'
        ]);
    }

}
