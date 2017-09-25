<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Load Chat Page
    public function index()
    {
        $users = Auth::user()->conversations();
        return view('chat.index')->with('users', $users);
    }

    // Get personal chatpage
    public function personalChat($id)
    {
        // Preventing from user to chat with him/herself
        if ($id == Auth::user()->id) {
            return redirect()->back()->with('danger', 'Az önce kendi kendine konuşmaya mı kalıştın?');
        }
        // Get user array with that id
        $user = User::find($id);
        // Restrict users to talk each other if they are not friends
        if (!Auth::user()->isFriendsWith($user)) {
            return redirect()->back()->with('danger', 'Kullanıcı ile iletişime geçebilmen için arkadaş olman lazım!');
        }
        return view('chat.personal')->with('user', $user);
    }

    // Get Messages From DB
    public function loadMessages($id)
    {
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if (!Auth::user()->isFriendsWithId($id)) {
            return ['status' => 'Something went wrong!'];
        }
        return Message::where('sender_id', Auth::user()->id)
                      ->where('receiver_id', $id)
                      ->orWhere('sender_id', $id)
                      ->orWhere('receiver_id', Auth::user()->id)
                      ->get();
    }

    // Send a message
    public function sendMessage($id)
    {
        $user = Auth::user();
        // add new message to DB
        $message = Auth::user()->sentMessages()->create([
            'message' => request()->get('message')
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        // Write id to receiver_id column
        $message->receiver_id = $id;
        // Save changes
        $message->save();

        return ['status' => 'Message sent!'];
    }
}
