<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Login extends Controller
{
    public function index(Request $res)
    {
    	if ($res->isMethod('post')) {

    		$email = $res->input('email');
    		$pass = $res->input('password');

    		$result = DB::table('users')->where('email',$email)->first();
    		if (Hash::check($pass, $result->password)) {
    			if ($result->status == 1) {
    				if ($result->role == 1) {
    					session(['islogged' => true]);
    					session(['email' => $email]);
    					session(['role' => 1]);
    					return redirect('/admin');
    				}else{
    					session(['islogged' => true]);
    					session(['email' => $email]);
    					session(['role' => 0]);
    					return redirect('/');
    				}   				
    				
    			}else{
    				return response()->json(['status' => false, 'message' => "Your account disable"]);
    			}
    			
    		}
    		
			// if ($result) {
			// 	// return response()->json(['status' => true, 'message'=>"Data add successfully"]);
			// 	return redirect('/login');
			// }else{
			// 	return response()->json(['status' => false, 'message' => "Technical Problem"]);
			// }
		    
		}
		if (session()->exists('islogged')) {
			if (session('role') == 1) {
				return redirect('/admin');
			}elseif (session('role') == 0) {
				return redirect('/');
			}else{
				return view('login');
			}			
		}
    	return view('login');
    }

    public function register(Request $res)
    {
    	if ($res->isMethod('post')) {

    		$fname = $res->input('fullname');
    		$email = $res->input('email');
    		$pass = $res->input('password');
    		$role = $res->input('role');
    		$hash_pass = Hash::make($pass);

    		$result = DB::table('users')->insert([
    			'fullname' => $fname,
    			'email' => $email,
    			'password' => $hash_pass,
			    'role' => $role
			]);
			if ($result) {
				// return response()->json(['status' => true, 'message'=>"Data add successfully"]);
				return redirect('/login');
			}else{
				return response()->json(['status' => false, 'message' => "Technical Problem"]);
			}
		    
		}
    	return view('register');
    }

    public function admin_home()
    {
    	if (session()->exists('islogged')) {
    		if (session('role') == 1) {
    			return view('admin');
    		}else{
    			return redirect('/login');
    		}
    	}else{
    		return redirect('/login');
    	}
    	// return view('admin');
    }

    public function logout()
    {
    	if (session()->flush()) {
    		return redirect('/login');
    	}else{
    		return redirect('/login');
    	}
    }
}
