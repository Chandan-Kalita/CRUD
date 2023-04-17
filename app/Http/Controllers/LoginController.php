<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    //
    function index(Request $r){
        if($r->session()->has('username')){
            return redirect('/dashboard');
        }else{
            return view('login');
        }
    }
    function login_submit(Request $r){

        $validator = Validator::make($r->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        extract($r->post());

        if ($validator->passes()) {
            $user = DB::table('users')->select('user_id', 'username','password')->where('username', $username)->first();
            if($user){
                if(Hash::check($password, $user->password)){
                    $r->session()->put('USERID',$user->user_id);
                    $r->session()->put('USERNAME',$user->username);
                    return redirect('/dashboard');
                }
            }
        }
        $r->session()->flash('status', 'Invalid username or password!');
        return redirect('/');
    }
    function logout(Request $r){
        $r->session()->forget('USERID');
        $r->session()->forget('USERNAME');
        return redirect('/');
    }
}
