<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Club;
use App\Page;
use App\Event;
use App\Message;
use App\Events\MessageSent;
use App\Events\ClubMessageSent;
use App\Events\EventMessageSent;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;

class MessageController extends Controller
{
    // Load Chat Page
    public function index()
    {
        // Get conversation if exists
        if (Auth::user()->conversations()) {
            $users = Auth::user()->conversations();
        } else {
            $users = null; //If not exists match users to null
        }

        $friends = Auth::user()->friends();

        return view('chat.index')->with('users', $users)
                                 ->with('friends', $friends);
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
    public function loadPersonalMessages($id)
    {
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if (!Auth::user()->isFriendsWithId($id)) {
            return ['status' => 'Something went wrong!'];
        }
        return Message::where('club_id', null)
                      ->where('page_id', null)
                      ->where('event_id', null)
                      ->where('sender_id', Auth::user()->id)
                      ->where('receiver_id', $id)
                      ->orWhere('sender_id', $id)
                      ->orWhere('receiver_id', Auth::user()->id)
                      ->get();
    }

    // Send a message
    public function sendPersonalMessage($id)
    {
        $user = Auth::user();
        // add new message to DB
        $message = Auth::user()->sentMessages()->create([
            'message' => request()->get('message'),
            'receiver_id' => $id,
        ]);

        broadcast(new MessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent!'];
    }


    // Get club chat page    
    public function clubChat($userId, $clubId)
    {
        $club = Club::find($clubId);
        $user = User::find($userId);
        return view('chat.club')->with('club', $club)
                                ->with('user', $user);
    }

    // Load Club Messages 
    public function loadClubMessages($userId, $clubId) {
        // Check if authenticated
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }

        // Return messages
        return Message::where('club_id', $clubId)
                      ->orWhere('sender_id', $userId)
                      ->orWhere('receiver_id', $userId)
                      ->get();
    }

    public function sendClubMessageAsUser($userId, $clubId) {
        // Find club 
        $club = Club::find(request()->get('club_id'));
        $user = User::find(request()->get('sender_id'));

        if (Auth::user()->id !== request()->get('sender_id')) {
            return ['status', 'Something went wrong!'];
        }

        // Persist message to DB
        $message = $user->sentMessages()->create([
            'message' => request()->get('message'),
            'sender_id' => request()->get('sender_id'),
            //'receiver_id' => 0
         ]);

        $message->club_id = request()->get('club_id');
        $message->save();


        broadcast(new ClubMessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent!'];
    }

    public function sendClubMessageAsClub($userId, $clubId) {
        $club = Club::find(request()->get('club_id'));
        $user = Auth::user();

        $message = $club->messages()->create([
            'message' => request()->get('message'),
            //  'sender_id' => request()->get('sender_id'),
            'receiver_id' => request()->get('receiver_id'),
        ]);        

        $message->sender_name = request()->get('sender_name');
        $message->save();

        broadcast(new ClubMessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent!'];
    }

    // Event chat page
    public function eventChat($userId, $eventId) {
        $user = User::find($userId);
        $event = Event::find($eventId);

        return view('chat.event')->with('user', $user)
                                 ->with('event', $event);
    }

    // Load Event Messages 
    public function loadEventMessages($userId, $eventId) {
        // Check if authenticated
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }

        // Return messages
        return Message::where('event_id', $eventId)
                      ->orWhere('sender_id', $userId)
                      ->orWhere('receiver_id', $userId)
                      ->get();
    }

    public function sendEventMessageAsUser($userId, $eventId) {
        // Find Event 
        $user = User::find(request()->get('sender_id'));

        if (Auth::user()->id !== request()->get('sender_id')) {
            return ['status', 'Something went wrong!'];
        }

        // Persist message to DB
        $message = $user->sentMessages()->create([
            'message' => request()->get('message'),
            'sender_id' => request()->get('sender_id'),
            //'receiver_id' => 0
         ]);

        $message->event_id = request()->get('event_id');
        $message->save();

        broadcast(new EventMessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent!'];
    }

    public function sendEventMessageAsEvent($userId, $eventId) {
        $event = Event::find(request()->get('event_id'));
        $user = Auth::user();

        $message = $event->messages()->create([
            'message' => request()->get('message'),
            //  'sender_id' => request()->get('sender_id'),
            'receiver_id' => request()->get('receiver_id'),
        ]);        

        $message->sender_name = request()->get('sender_name');
        $message->save();

        broadcast(new EventMessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent!'];
    }

}
