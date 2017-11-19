<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\User;
Use App\Mail\PasswordReset;
Use App\Mail\NewUserValidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        
        $user = User::create([
                    'email' => $request->input('email'),
                    'username' => $request->input('username'),
                    'password' => bcrypt($request->input('password')),
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'department' => $request->input('department'),
                    'email_token' => base64_encode(bcrypt($request->input('email'))),
                ]);
        
        Auth::attempt($request->only(['username','password']), $request->has('remember'));
        
        // Send email for validation
        Mail::to(Auth::user()->email)
            ->send(new NewUserValidation($user));

        return redirect()->route('home')->with('info', 'Hesabınız oluşturuldu lütfen email adresinize gönderilen email ile doğrulama yapınız. Email outlook hesaplarında gereksizlerde görünebilir.');
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

    // Verify user by email
    public function verifyUser($token) {
        $user = User::where('email_token', $token)->first();
        if($user) {
            $user->verified = true;
            $user->email_token = null;
            $user->save();
            return view('auth.verify')->with('user', $user);
        } else {
            return view('auth.verify')->with('error', 'Doğrulama işlemi yapılırken bir hata oluştu.');
        }
    }

    // Get password reset page
    public function getPasswordForgotten() {
        return view('auth.passwordForgotten');
    }

    // Post Email for Password Reset
    public function postPasswordForgotten(Request $request) {
        
        $this->validate($request, [
            'email' => 'email|required',
        ]);
        
        $email = $request->input('email');
        $token = base64_encode(bcrypt($email));

        if(User::where('email', $request->input('email'))->first()) {
            // Insert new record to password_resets table
            DB::insert('insert into password_resets (email, token) values (?, ?)', [$email, $token]);
      
            // Send email
            Mail::to($email)
                ->send(new PasswordReset($token));
            return redirect()->back()->with('success', 'Değişiklik talebin emailine gönderildi. Lütfen gelen email ile onaylama yap.');
        } else {
            return redirect()->back()->with('danger', 'Böyle bir mail bulunamadı.');
        }
    }

    public function getPasswordReset($token) {
        $record = DB::select('select * from password_resets where token = ?', [$token]);
        // get email from the record
        if(!$record) {
            return redirect()->route('login')->with('danger', 'Böyle bir istek bulunamadı.');
        }
        $email = $record[0]->email;
        $user = User::where('email', $email)->first();
        if(!$user) {
            redirect()->route('login')->with('danger', 'Böyle bir kullanıcı bulunamadı.');
        }    
        return view('auth.passwordReset')->with('token', $token);
    }

    public function postPasswordReset(Request $request, $token) {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);
        $record = DB::select('select * from password_resets where token = ?', [$token]);
        // get email from the record
        if(!$record) {
            return view('auth.signin')->with('danger', 'Böyle bir istek bulunamadı.');
        }
        $email = $record[0]->email;
        $user = User::where('email', $email)->first();
        if(!$user) {
            return view('auth.signin')->with('danger', 'Böyle bir kullanıcı bulunamadı.');
        }        
        $user->password = bcrypt($request->input('password'));
        $user->save();
        DB::delete('delete from password_resets where token = ?', [$token]);

        return redirect()->route('login')->with('success', 'Şifreniz başarılı bir şekilde değiştirildi. Şimdi yeni şifreniz ile giriş yapabilirsiniz.');
    
    }
}
