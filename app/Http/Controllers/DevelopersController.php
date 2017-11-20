<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevelopersController extends Controller
{
    public function index() {
    	return view('developers.index');
    }

    public function apply(Request $request) {
    	$this->validate($request, [
    		'full_name' => 'required',
    		'email' => 'required|email',
    		'phone_num' => 'required|integer',
    		'body' => 'required',
    	]);

    	$name = $request->input('full_name');
    	$email = $request->input('email');
    	$phone = $request->input('phone_num');
    	$body = $request->input('body');

    	DB::insert('insert into applications (name, email, phone, body) values (?, ?, ?, ?)', [$name, $email, $phone, $body]);

    	return redirect()->back()->with('success', 'Başvurunuz işleme alınmıştır. En yakın zamanda size geri bildirim yapmaya çalışacağız. Teşekkürler!');
    }


}
