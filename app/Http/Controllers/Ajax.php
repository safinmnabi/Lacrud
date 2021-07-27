<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class Ajax extends Controller
{
    public function index()
    {
    	return view('Ajax');
    }

    public function AllData()
    {
    	$todo = DB::table('todo')->get();
    	return $todo;
    }

    public function Single_Data($id)
    {
    	$todo = DB::table('todo')->where(['id' => $id])->get();

    	if (count($todo) > 0) {
			return response()->json(['status' => true, 'data' => $todo[0]]);
		}else{
			return response()->json(['status' => false, 'message' => "Data not found"]);
		}
    }

    public function add(Request $request)
    {
    	if ($request->input('operation') == "insert") {
    		$task = $request->input('task');
	    	$descr = $request->input('description');
	    	$result = DB::table('todo')->insert([
	    		'task' => $task,
				'descr' => $descr
			]);
			if ($result) {
				return response()->json(['status' => true, 'message'=>"Data add successfully"]);
			}else{
				return response()->json(['status' => false, 'message' => "Technical Problem"]);
			}
    	}elseif ($request->input('operation') == "edit") {
    		$task = $request->input('task');
    		$descr = $request->input('description');
    		$id = $request->input('id');


    		$result = DB::table('todo')
              ->where('id', $id)
              ->update([
              	'task' => $task,
			    'descr' => $descr
              ]);
			if ($result) {
				return response()->json(['status' => true, 'message'=>"Data update successfully"]);
			}else{
				return response()->json(['status' => false, 'message' => "Technical Problem"]);
			}
    	}
    	
    }

    public function delete($id)
    {

		$result = DB::table('todo')->where('id', $id)->delete();
		if ($result) {
			return response()->json(['status' => true, 'message'=>"Data delete successfully"]);
		}else{
			return response()->json(['status' => false, 'message' => "Technical Problem"]);
		}
    }

    public function storeapi(Request $request)
    {
        $task = $request->input('task');
        $descr = $request->input('description');
        $uid = $request->input('userid');
        $result = DB::table('todo')->insert([
            'task' => $task,
            'descr' => $descr,
            'userid' => $uid
        ]);
        if ($result) {
            return response()->json(['status' => true, 'message'=>"Data add successfully"]);
        }else{
            return response()->json(['status' => false, 'message' => "Technical Problem"]);
        }
    }

    public function updateapi(Request $request)
    {
        $task = $request->input('task');
        $descr = $request->input('description');
        $id = $request->input('id');


        $result = DB::table('todo')
            ->where('id', $id)
            ->update([
            'task' => $task,
            'descr' => $descr
            ]);
        if ($result) {
            return response()->json(['status' => true, 'message'=>"Data update successfully"]);
        }else{
            return response()->json(['status' => false, 'message' => "Technical Problem"]);
        }    
    }

    public function deleteapi($id)
    {
        $result = DB::table('todo')->where('id', $id)->delete();
        if ($result) {
            return response()->json(['status' => true, 'message'=>"Data delete successfully"]);
        }else{
            return response()->json(['status' => false, 'message' => "Technical Problem"]);
        }
    }

    public function loginapi(Request $res)
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
                        // return redirect('/admin');
                    return response()->json(['status' => true, 'message' => "Your Admin already loggined"]);

                    }else{
                        session(['islogged' => true]);
                        session(['email' => $email]);
                        session(['role' => 0]);
                        // return redirect('/');
                    return response()->json(['status' => true, 'message' => "You are already loggined"]);

                    }                   
                    
                }else{
                    return response()->json(['status' => false, 'message' => "Your account disable"]);
                }
                
            }
            
            // if ($result) {
            //  // return response()->json(['status' => true, 'message'=>"Data add successfully"]);
            //  return redirect('/login');
            // }else{
            //  return response()->json(['status' => false, 'message' => "Technical Problem"]);
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

    public function usershow($eid)
    {
        

        $todo = DB::table('todo')->where('userid', $eid)->get();
        return response()->json($todo);
        
        // return json_encode($todo);
        // return $header;
    }
}
