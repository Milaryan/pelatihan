<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function  __construct()
    { 
        $this->middleware('guest')->except('logout'); 
    }

    public function login(Request $request){
        return view('admin.login');
    }

    public function postLogin(Request $request){
        // return $request->all();

        $email = strip_tags($request->email);
        $password = strip_tags($request->password);

        if (empty($email)){
            return redirect()->route('login')->with('status', 'error')->with('message', 'Email harus di-isi');
        }
        if (empty($password)){
            return redirect()->route('login')->with('status', 'error')->with('message', 'Password harus di-isi');
        }
        
        $users = Users::where('email', $email)->first();
        
        //cek email pada tabel user
        if (!empty($users)) {
            $data=[
                'email' => $users->email,
                'password' => $password
            ];
            
            if (Auth::attempt($data)) {
                if ($users->level_user == 'Admin') {
                    return redirect()->route('dashboard')->with('status', 'success')->with('message', 'Selamat datang '.$users->nama_lengkap);
                }else{
                    return redirect()->route('userDashboard')->with('status', 'success')->with('message', 'Selamat Datang '.$users->nama_lengkap);
                }
            }else {
                return redirect()->route('login')->with('status', 'error')->with('message', 'Akun tidak terdaftar');
            }
        }else {
        return redirect()->route('login')->with('status', 'error')->with('message', 'Akun tidak terdaftar');
        }
    }

    public function logout(){
        Auth::logout();
        session_start();
        session_destroy();

        return redirect()->route('login')->with('status', 'success')->with('message', 'Berhasil Logout');
    }
}
