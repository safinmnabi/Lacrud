<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class todo extends Controller
{
    public function index()
    {
        if (session()->exists('islogged')) {
            if (session('role') == 0) {
                $todo = DB::table('todo')->get();
                return view('index', ['data' => $todo]);
            }else{
                return redirect('/login');
            }
        }else{
            return redirect('/login');
        }

    	// $todo = DB::table('todo')->get();
    	// $todo = DB::table('todo')->where(['id'=>2 , 'descr' => 'Test 2'])->get();
    	// return response()->json($todo);
    	// return view('index', ['data' => $todo]);
    }

    public function add(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$task = $request->input('task');
    		$descr = $request->input('description');
    		$result = DB::table('todo')->insert([
    			'task' => $task,
			    'descr' => $descr
			]);
			if ($result) {
				// return response()->json(['status' => true, 'message'=>"Data add successfully"]);
				return redirect('/');
			}else{
				return response()->json(['status' => false, 'message' => "Technical Problem"]);
			}
		    
		}    	
    	
    	return view('add');
    }

    public function edit(Request $request, $id)
    {
    	if ($request->isMethod('post')) {
    		$task = $request->input('task');
    		$descr = $request->input('description');

    		$result = DB::table('todo')
              ->where('id', $id)
              ->update([
              	'task' => $task,
			    'descr' => $descr
              ]);
			if ($result) {
				// return response()->json(['status' => true, 'message'=>"Data add successfully"]);
				return redirect('/');
			}else{
				return response()->json(['status' => false, 'message' => "Technical Problem"]);
			}
		    
		}

		$s_todo = DB::table('todo')->where('id', $id)->first();	
    	
    	return view('add', ['single' => $s_todo]);
    }

    public function delete($id)
    {

		$result = DB::table('todo')->where('id', $id)->delete();
		if ($result) {
			return redirect('/');
		}else{
			return response()->json(['status' => false, 'message' => "Technical Problem"]);
		}
    }
}
