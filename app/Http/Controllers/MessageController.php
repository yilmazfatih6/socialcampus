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
use App\Events\PageMessageSent;
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

        // Get club conversation if exists
        if (Auth::user()->clubConversations()) {
            $clubs = Auth::user()->clubConversations();
        } else {
            $clubs = null; //If not exists match users to null
        }

        // Get event conversation if exists
        if (Auth::user()->eventConversations()) {
            $events = Auth::user()->eventConversations();
        } else {
            $events = null; //If not exists match users to null
        }

        // Get page conversation if exists
        if (Auth::user()->pageConversations()) {
            $pages = Auth::user()->pageConversations();
        } else {
            $pages = null; //If not exists match users to null
        }

        $friends = Auth::user()->friends();
        
        return view('chat.index')->with('users', $users)
                                 ->with('clubs', $clubs)
                                 ->with('events', $events)
                                 ->with('pages', $pages)
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
        // Makin some validations
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if ($id == Auth::user()->id) {
            return ['status' => "Kendi kendine mi konuşmaya çalışıyorsun :("];
        }
        if (!Auth::user()->isFriendsWithId($id)) {
            return ['status' => "Bu kullanıcı ile konuşmak için arkadaş olmanız gerekli!"];
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
        // Makin some validations
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if ($id == Auth::user()->id) {
            return ['status' => "Kendi kendine mi konuşmaya çalışıyorsun :("];
        }
        if (!Auth::user()->isFriendsWithId($id)) {
            return ['status' => "Bu kullanıcı ile konuşmak için arkadaş olmanız gerekli!"];
        }

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

        // Makin some validations
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if (Auth::user()->isAdmin($club)) {
            if(Auth::user()->id === $userId) {
                return ['status' => "Bu kulübün yöneticisisin!"];
            }
        }
        
        return view('chat.club')->with('club', $club)
                                ->with('user', $user);
    }

    // Load Club Messages 
    public function loadClubMessages($userId, $clubId) {
        
        $club = Club::find($clubId);

        // Makin some validations
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if (Auth::user()->isAdmin($club)) {
            if(Auth::user()->id === $userId) {
                return ['status' => "Bu kulübün yöneticisisin!"];
            }
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

        // Makin some validations
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if (Auth::user()->id !== request()->get('sender_id')) {
            return ['status', 'Something went wrong!'];
        }
        if (Auth::user()->isAdmin($club)) {
            if(Auth::user()->id === $userId) {
                return ['status' => "Bu kulübün yöneticisisin!"];
            }
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

        // Makin some validations
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if (!Auth::user()->isAdmin($club)) {
            return ['status' => "Bu kulübün yöneticisi değilsin!"];
        }
        if (Auth::user()->isAdmin($club)) {
            if(Auth::user()->id === $userId) {
                return ['status' => "Bu kulübün yöneticisisin!"];
            }
        }

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

        // Makin some validations
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if(Auth::user()->isEventAdmin($event) && Auth::user()->id === $userId) {
            return ['status' => 'You are admin!'];
        }

        return view('chat.event')->with('user', $user)
                                 ->with('event', $event);
    }

    // Load Event Messages 
    public function loadEventMessages($userId, $eventId) {
        // Check if authenticated
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if(Auth::user()->isEventAdmin($event) && Auth::user()->id === $userId) {
            return ['status' => 'You are admin!'];
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
        if(Auth::user()->isEventAdmin($event) && Auth::user()->id === $userId) {
            return ['status' => 'You are admin!'];
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
        if(!Auth::check()) {
            return ['status' => 'Authentication problem!']
        }
        if(Auth::user()->isEventAdmin($event) && Auth::user()->id === $userId) {
            return ['status' => 'You are admin!'];
        }
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

    public function pageChat($userId, $pageId) {
        $user = User::find($userId);
        $page = Page::find($pageId);
        if(!Auth::check()) {
            return ['status' => 'Authentication problem!']
        }
        if(Auth::user()->isPageAdmin($page) && Auth::user()->id === $userId) {
            return ['status' => 'You are admin!'];
        }
        return view('chat.page')->with('user', $user)
                                ->with('page', $page);
    }

    // Load Page Messages 
    public function loadPageMessages($userId, $pageId) {
        // Check if authenticated
        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if(Auth::user()->isPageAdmin($page) && Auth::user()->id === $userId) {
            return ['status' => 'You are admin!'];
        }

        // Return messages
        return Message::where('page_id', $pageId)
                      ->orWhere('sender_id', $userId)
                      ->orWhere('receiver_id', $userId)
                      ->get();
    }

    public function sendPageMessageAsUser($userId, $pageId) {
        // Find Page 
        $user = User::find(request()->get('sender_id'));

        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if(Auth::user()->isPageAdmin($page) && Auth::user()->id === $userId) {
            return ['status' => 'You are admin!'];
        }
        if (Auth::user()->id !== request()->get('sender_id')) {
            return ['status', 'Something went wrong!'];
        }

        // Persist message to DB
        $message = $user->sentMessages()->create([
            'message' => request()->get('message'),
            'sender_id' => request()->get('sender_id'),
            //'receiver_id' => 0
         ]);

        $message->page_id = request()->get('page_id');
        $message->save();

        broadcast(new PageMessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent!'];
    }

    public function sendPageMessageAsPage($userId, $pageId) {
        $page = Page::find(request()->get('page_id'));
        $user = Auth::user();

        if (!Auth::check()) {
            return ['status' => 'Failed!'];
        }
        if(Auth::user()->isPageAdmin($page) && Auth::user()->id === $userId) {
            return ['status' => 'You are admin!'];
        }

        $message = $page->messages()->create([
            'message' => request()->get('message'),
            //  'sender_id' => request()->get('sender_id'),
            'receiver_id' => request()->get('receiver_id'),
        ]);        

        $message->sender_name = request()->get('sender_name');
        $message->save();

        broadcast(new PageMessageSent($user, $message))->toOthers();

        return ['status' => 'Message sent!'];
    }


}
