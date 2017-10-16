<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function getProfile(Request $request, $username)
    {
        $user = User::where('username', $username)->first();
        $statuses = $user->statuses()->where('event_id', null)
                                     ->where('page_id', null)
                                     ->orderBy('created_at', 'desc')
                                     ->notReply()
                                     ->paginate(5);
        $friends = $user->friends();
        $clubs = $user->acceptedClubs();
        if (!$user) {
            abort(404);
        }

        if ($request->ajax()) {
            return view('statuses.load')->with('user', $user)->with('statuses', $statuses)->render();
        }

        if (Auth::user()) {
            return view('users.index')->with('user', $user)
                                                    ->with('friends', $friends)
                                                    ->with('statuses', $statuses)
                                                    ->with('authUserIsFriend', Auth::user()->isFriendsWith($user))
                                                    ->with('clubs', $clubs);
        } else {
            return view('users.index')->with('user', $user)->with('friends', $friends)
                                                           ->with('clubs', $clubs)
                                                           ->with('statuses', $statuses);
        }
    }

    public function getEdit()
    {
        return view('users.edit');
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
            'email' =>  ['required', Rule::unique('users')->ignore(Auth::user()->id),'max:200', 'email'],
            'username' => ['required', Rule::unique('users')->ignore(Auth::user()->id), 'alpha_dash','max:50'],
            'password' => 'required',
            'first_name' => 'required|max:50',
            'last_name' => 'required|alpha|max:50',
        ]);

        if (!Auth::attempt([ 'username' => Auth::user()->username, 'password' => $request->input('password') ])) {
            return redirect()->back()->with('info', 'Şifreniz yanlış.');
        }

        Auth::user()->update([
            'email'=> $request->input('email'),
            'username' => $request->input('username'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'department' => $request->input('department'),
        ]);

        return redirect()->route('profile.edit')->with('info', 'Profiliniz başarılı bir şekilde güncellenmiştir.');
    }

    public function getEditPass()
    {
        return view('users.editPassword');
    }

    public function postEditPass(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            // 'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);

        // if(!Auth::attempt($request->only(['current_password']))) {
        //     return redirect()->back()->with('info', 'Geçerli şifreniz eşleşmiyor..');
        // }

        Auth::user()->update([
            'password'=> bcrypt($request->input('password')),
        ]);

        return redirect()->back()->with('info', 'Şifreniz başarılı bir şekilde değiştirilmiştir.');
    }

    //Uploading Avatar
    public function uploadAvatar(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $user = Auth::user();

            if ($user->avatar !== 'default.png') {
                Storage::delete('/public/avatars/'.$user->avatar);
            }

            $avatar = $request->file('avatar');
            // Give a specific name
            $filename = 'user_'.time().'_'.$user->username.'.'.$avatar->getClientOriginalExtension();
            // Store file at specific path 
            Image::make($avatar)->fit(500, 500)->save(storage_path('app/public/avatars/'.$filename));
            $user->avatar = $filename;
            $user->save();
            if ($request->ajax()) {
                return response()->json(['message' => 'Profile fotoğrafı değiştirildi.']);
            } else {
                return redirect()->back()->with('success', 'Profil fotoğrafı başarılı bir şekilde değiştirildi.');
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['message' => 'Lütfen bir dosya seçiniz.']);
            } else {
                return redirect()->back()->with('danger', 'Lütfen bir dosya seçiniz.');
            }
        }
    }

    //Uploading Avatar
    public function uploadCover(Request $request)
    {
        if ($request->hasFile('cover')) {
            $user = Auth::user();
            if ($user->cover !== 'default.jpg') {
                Storage::delete('/public/covers/'.$user->cover);
            }
            $cover = $request->file('cover');
            $filename = 'user_'.time().'_'.$user->username.'.'.$cover->getClientOriginalExtension();
            $cover->storeAs('/public/covers/', $filename);
            $user->cover = $filename;
            $user->save();
        }

        return redirect()->back()->with('success', 'Kapak fotoğrafı başarılı bir şekilde değiştirildi.');
    }

    // User info
    public function userInfo($username)
    {
        $user = User::where('username', $username)->first();
        return view('users.userinfo')->with('user', $user);
    }
}
