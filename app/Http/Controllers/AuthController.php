<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\User;
Use App\Mail\NewUserValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function getSignup()
    {
        return view('auth.signup');
    }

    public function postSignup(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users|email|max:200',//array isimleri formlardaki name değerleri ile eşleşmelidir.
            'username' => 'required|unique:users|alpha_dash|max:50',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'first_name' => 'required|max:50',
            'last_name' => 'required|alpha|max:50',
        ]);

        User::create([
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'department' => $request->input('department'),
        ]);

        Auth::attempt($request->only(['username','password']), $request->has('remember'));

        /*
        // Send email for validation
        Mail::to(Auth::user()->email)
            ->send(new NewUserValidation());
        */
        // Hesabınız oluşturuldu lütfen email adresinize gönderilen email ile doğrulama yapınız.
        return redirect()->route('home')->with('info', 'Hesabınız başarılı bir şekilde oluşturuldu.');
    }

    //Get Login Page
    public function getSignin()
    {
        return view('auth.signin')->with('username', '');
    }

    public function postSignin(Request $request)
    {

        //Validation of Form Infos
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        //Checking if username exists
        $user = User::where( 'username', $request->input('username') )->count();
        //If not execute below
        if (!$user) {
            return response()->json(['message' => 'Böyle bir kullanıcı bulunamadı.',
                                                   'status'  => '0'
                                                ]);
        }
        //If password doesn't macthes executes below
        elseif (!Auth::attempt($request->only(['username','password']), $request->has('remember'))) {
            return response()->json(['message' => 'Şifre yanlış.',
                                     'status'  => '1'
                                    ]);
        }
        //If everything is ok executes below
        else {
            return response()->json(['status' => '2']);
        }
    }

    public function getSignout()
    {
        Auth::logout();

        return redirect()->route('home')->with('warning', 'Çıkış yapıldı.');
    }

}
