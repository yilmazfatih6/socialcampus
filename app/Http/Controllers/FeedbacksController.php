<?php

namespace App\Http\Controllers;

use Auth;
use App\Feedback;
use Illuminate\Http\Request;

class FeedbacksController extends Controller
{
    public function index() {
    	return view('feedback.index');
    }

    // Sending feedback for non auth users
    public function send(Request $request) {
    	$this->validate($request, [
    		'title' => 'max:150',
    		'body' => 'required'
    	]);

    	Feedback::create([
    		'title' => $request->input('title'),
    		'body' => $request->input('body'),
    	]);

        if($request->ajax()){
            return response()->json(['message' => 'Geri bildiriminiz alındı. Teşekkürler!']);
        } else {
           return redirect()->back()->with('success', 'Geri bildiriminiz alındı. Teşekkürler!');
        }
    }

    // Sending feedback for auth users
    public function sendAuth(Request $request) {
    	$this->validate($request, [
    		'title' => 'max:150',
    		'body' => 'required'
    	]);

    	Auth::user()->feedbacks()->create([
    		'title' => $request->input('title'),
    		'body' => $request->input('body'),
    	]);

    	if($request->ajax()){
            return response()->json(['message' => 'Geri bildiriminiz alındı. Teşekkürler!']);
        } else {
           return redirect()->back()->with('success', 'Geri bildiriminiz alındı. Teşekkürler!');
        }

    }
}
