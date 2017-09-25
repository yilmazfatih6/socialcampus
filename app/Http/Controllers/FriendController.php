<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\FriendshipRequest;

class FriendController extends Controller
{
    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $requests= Auth::user()->friendRequests();

        return view('friends.index')->with('friends', $friends)
                                                ->with('requests', $requests);
    }

    public function getAdd(Request $request, $id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return redirect()->route('home')->with('danger', 'Böyle bir kullanıcı bulunamadı.');
        }

        if (Auth::user()->id === $user->id) {
            return redirect()->route('home');
        }

        if (Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())) {
            return redirect()->back()->with('info', 'Arkadaşlık isteğinizin kabul edilmesi bekleniyor.');
        }

        if (Auth::user()->isFriendsWith($user)) {
            return redirect()->back()->with('info', 'Bu kullanıcı ile zaten arkadaşsınız.');
        }

        Auth::user()->addFriend($user);

        $user->notify(new FriendshipRequest(Auth::user()));

        if ($request->ajax()) {
            return response()->json(['message' => 'İstek gönderildi.',
                                                   'username' => $user->username,
                                                ]);
        }

        return redirect()->back()->with('success', 'Arkadaşlık isteği gönderildi.');
    }

    public function getAccept($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('danger', 'Böyle bir kullanıcı bulunamadı.');
        }

        if (!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->back()->with('info', 'Üzgünüz bir sorun oluştu.');
        }

        Auth::user()->acceptFriendRequest($user);

        return response()->json(['message' => 'Arkadaşlık isteği kabul edildi.',
                                 'username' => $user->username,
                                ]);
    }

    public function getReject($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->back()->with('danger', 'Böyle bir kullanıcı bulunamadı.');
        } elseif (!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->back()->with('info', 'Üzgünüz bir sorun oluştu.');
        } else {
            Auth::user()->deleteFriend($user);
            return response()->json(['message' => 'Arkadaşlık isteği reddedildi.',
                                                   'username' => $user->username,
                                                ]);
        }
    }

    public function postDelete(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if (!Auth::user()->isFriendsWith($user)) {
            return redirect()->back()->with('info', 'Bazı şeyler ters gitti. Özür dilerim :(');
        }

        Auth::user()->deleteFriend($user);

        return response()->json(['message' => 'Arkadaşlıktan çıkarıldı.',
                                              'username' => $user->username
                                            ]);
    }
}
