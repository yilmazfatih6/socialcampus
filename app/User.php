<?php

namespace App;

use Auth;
use App\Club;
use App\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'department',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /************************   NAME METHODS   *********************************/
    public function getName()
    {
        if ($this->first_name && $this->last_name) {
            return "{$this->first_name} {$this->last_name}";
        }

        if ($this->first_name) {
            return $this->first_name;
        }
    }

    public function getNameOrUsername()
    {
        return $this->getName() ?: $this->username;
    }
    public function getFirstNameOrUsername()
    {
        return $this->first_name ?: $this->username;
    }
    /************************  END OF NAME METHODS   *********************************/


    /************************   STATUSES   *********************************/
    public function statuses()
    {
        return $this->hasMany('App\Status', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany('App\Likeable', 'user_id');
    }

    public function dislikes()
    {
        return $this->hasMany('App\Likeable', 'user_id');
    }
    /************************   END OF STATUSES   *********************************/


    /************************   EVENTS   *********************************/

    public function events()
    {
        return $this->belongsToMany('App\Event', 'attenders', 'user_id', 'event_id');
    }
    public function addEvent(Event $event)
    {
        return $this->events()->attach($event->id);
    }

    public function quitEvent(Event $event)
    {
        return $this->events()->detach($event->id);
    }

    public function attendedEvent()
    {
        return $this->events()->wherePivot('confirmed', true)->get();
    }

    public function isAttending(Event $event)
    {
        return (bool) $this->events()->where('event_id', $event->id)->count();
    }

    public function isAttendingWithId($id)
    {
        return (bool) $this->events()->where('event_id', $id)->count();
    }

    public function isAttendingAny()
    {
        return (bool) $this->events()->count();
    }

    public function canAttend(Event $event)
    {
        $club = Club::where('id', $event->club_id)->first();
        if ( $this->isMember($club) && $event->attenders !== $event->attender_limit) {
            return (bool) true;
        } else {
            return (bool) false;
        }
    }

    public function isConfirmed(Event $event)
    {
        return (bool) $this->events()->where('event_id', $event->id)
                                     ->where('confirmed', true)->count();
    }

    public function isEventAdmin(Event $event)
    {
        return (bool) $this->events()->where('event_id', $event->id)
                                     ->where('admin', true)->count();
    }

    public function isEventAdminAny()
    {
        return (bool) $this->events()->where('admin', true)->count();
    }

    public function waitingToBeConfirmed(Event $event)
    {
        return (bool) $this->events()->where('event_id', $event->id)
                                     ->where('confirmed', false)->count();
    }

    public function attendingFree(Event $event)
    {
        if (Auth::user()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = 0;
        }

        return (bool) $this->events()->where('user_id', $user_id)
                                     ->where('event_id', $event->id)
                                     ->where('confirmed', null)->count();
    }

    public function ownedEvents() {
        return $this->events()->where('admin', true)->get();
    }

    public function notOwnedEvents() {
        return $this->events()->where('admin', false)->where('confirmed', true)->get();
    }

    /************************   END OF EVENTS   *********************************/


    /************************   CLUBS  *********************************/
    public function clubs()
    {
        return $this->belongsToMany('App\Club', 'members', 'user_id', 'club_id');
    }

    public function addClub(Club $club)
    {
        return $this->clubs()->attach($club->id);
    }

    public function quitClub(Club $club)
    {
        return $this->clubs()->detach($club->id);
    }

    public function acceptedClubs()
    {
        return $this->clubs()->wherePivot('accepted', true)->get();
    }

    public function isAdmin(Club $club)
    {
        return (bool) $this->clubs()->where('club_id', $club->id)->where('admin', true)->count();
    }

    public function isAdminAny()
    {
        $clubs = $this->clubs()->where('admin', true)->get();
        return (bool) $clubs->where('confirmed', true)->count();
    }

    public function isMemberAny()
    {
        return (bool) $this->clubs()->where('user_id', Auth::user()->id)
                                              ->where('accepted', true)
                                              ->where('admin', false)->count();
    }

    public function isMember(Club $club)
    {
        return (bool) $this->acceptedClubs()->where('id', $club->id)->count();
    }

    public function isMemberWithId($id)
    {
        return (bool) $this->acceptedClubs()->where('id', $id)->count();
    }

    public function requestedClubs()
    {
        return $this->clubs()->wherePivot('accepted', false)->get();
    }

    public function isRequestedClub(Club $club)
    {
        return (bool) $this->requestedClubs()->where('id', $club->id)->count();
    }

    public function isRequestedAnyClub()
    {
        return (bool) $this->requestedClubs()->count();
    }

    public function ownedClubs() {
        return $this->clubs()->where('admin', true)->get();
    }

    public function notOwnedClubs() {
        return $this->clubs()->where('admin', false)->get();
    }

    /*************************  END OF CLUBS  *****************************/

    /************************     FRIENDS     **************************/
    public function friendOfMine()
    {
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }

    public function friends()
    {
        return $this->friendOfMine()->wherePivot('accepted', true)->get()->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    public function friendRequests()
    {
        return $this->friendOfMine()->wherePivot('accepted', false)->get();
    }

    public function friendRequestPending()
    {
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function hasFriendRequestReceivedId($id)
    {
        return (bool) $this->friendRequests()->where('id', $id)->count();
    }

    public function addFriend(User $user)
    {
        return $this->friendOf()->attach($user->id);
    }

    public function rejectFriend(User $user)
    {
        return $this->friendRequests()->detach($user->id);
    }

    public function deleteFriend(User $user)
    {
        $this->friendOf()->detach($user->id);
        $this->friendOfMine()->detach($user->id);
    }

    public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
            'accepted' => true,
        ]);
    }

    public function isFriendsWith(User $user)
    {
        return (bool) $this->friends()->where('id', $user->id)->count();
    }

    public function isFriendsWithId($id)
    {
        return (bool) $this->friends()->where('id', $id)->count();
    }

    public function hasLikedStatus(Status $status)
    {
        return (bool) $status->likes->where('user_id', $this->id)->count();
    }
    /************************  END OF FRIENDS   **************************/


    /************************   PAGES    ***************************/
    public function pages()
    {
        return $this->belongsToMany('App\Page', 'followers', 'user_id', 'page_id');
    }

    public function isPageAdmin(Page $page)
    {
        return (bool) $this->pages()->where('page_id', $page->id)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('admin', true)->count();
    }

    public function isFollowingPage(Page $page)
    {
        return (bool) $this->pages()->where('page_id', $page->id)->count();
    }

    public function isFollowingPageWithId($id)
    {
        return (bool) $this->pages()->where('page_id', $id)->count();
    }

    public function followPage(Page $page)
    {
        return $this->pages()->attach($page->id);
    }

    public function unfollowPage(Page $page)
    {
        return $this->pages()->detach($page->id);
    }

    public function isPageAdminAny()
    {
        return (bool) $this->pages()->where('user_id', Auth::user()->id)
                                    ->where('admin', true)->count();
    }

    public function isFollowingAny()
    {
        return (bool) $this->pages()->where('user_id', Auth::user()->id)
                                    ->where('admin', false)->count();
    }

    public function ownedPages() {
        return $this->pages()->where('admin', true)->get();
    }

    public function notOwnedPages() {
        return $this->pages()->where('admin', false)->get();
    }
    /*********************     END OF PAGES     ************************/

    /*********************    LORD     ************************/

    public function isLord()
    {
        return (bool) $this->lord;
    }

    public function makeLord()
    {
        return $this->pivot->update(['lord' => true]);
    }

    /*********************     END OF LORD     ************************/

    /*********************    MESSAGES     ************************/
    // Access to Messages
    // Connect to Message Model, match receiver_id of Message Model with id of User Model
    public function receivedMessages()
    {
        return $this->hasMany('App\Message', 'receiver_id');
    }
    // Connect to Message Model, match sender_id of Message Model with id of User Model
    public function sentMessages()
    {
        return $this->hasMany('App\Message', 'sender_id');
    }

    // Personal messages
    public function messages()
    {
        return Message::where('club_id', null)
                      ->where('event_id', null)
                      ->where('page_id', null)
                      ->where('sender_id', Auth::user()->id)
                      ->orWhere('receiver_id', Auth::user()->id)->get();
    }

    /**
    * Gets lastly chatted users (Ugly code af :/)
    */
    public function conversations()
    {
        $usersId = null;
        $index = 0;
        $same = false;
        foreach (Auth::user()->messages() as $message) {
            if($message->receiver_id === Auth::user()->id)
            {
                if ($index !== 0) {
                    foreach ($usersId as $id) {
                        if($message->sender_id === $id) {
                            $same = true;
                            break;
                        }
                    }
                }
                if ($same === true) {
                    $index++;
                    $same = false;
                    continue;
                } else {
                    $usersId[$index] = $message->sender_id;
                }
            } elseif ($message->sender_id === Auth::user()->id) {
                if ($index !== 0) {
                    foreach ($usersId as $id) {
                        if($message->receiver_id === $id) {
                            $same = true;
                            break;
                        }
                    }
                }
                if ($same === true) {
                    $index++;
                    $same = false;
                    continue;
                } else {
                    $usersId[$index] = $message->receiver_id;
                }
            }
            $index++;
        }

        // Return null if there is no user
        if ($usersId === null) {
            return null;
        }

        $users = User::whereIn('id', $usersId)->get();
        return $users;
    }

    /**
    *   CLUB CONVERSATIONS
    */
    public function clubConversations() {
        // Getting ids of owned club
        if ($this->ownedClubs()) {
            $ids = $this->ownedClubs()->map(function ($club) {
                return collect($club->toArray())->only('id')->all();
            });
        } else {
            $ids = 0;
        }
        
        // Get club messages
        $messages = Message::whereIn('club_id', $ids)
                           ->orWhere('sender_id', $this->id)
                           ->orWhere('receiver_id', $this->id)
                           ->get();

        //Below section creates and array which holds club id values of the user's messages
        // Values are held as unique. Therefore there are not any same club id value in the array.
        if (count($messages)) {
            // Get club ids of club messages
            $messageClubIds = null; // This will be array which holds club ids of messages
            $index = 0; // index value for foreach
            foreach ($messages as $message) {
                $same = false; // checking 
                if (isset($messageClubIds)) {
                    foreach ($messageClubIds as $id) {
                        if ($message->club_id == $id) {
                            $same = true;
                            break;
                        }
                    }
                }
                if (!$same) {
                    $messageClubIds[$index] = $message->club_id;
                }
                $index++;
            }
        } else {
            return null;
        }
        return Club::whereIn('id', $messageClubIds)->get();
    }

    /**
    *   EVENT CONVERSATIONS
    */
    public function eventConversations() {
        // Getting ids of owned event
        if ($this->ownedEvents()) {
            $ids = $this->ownedEvents()->map(function ($event) {
                return collect($event->toArray())->only('id')->all();
            });
        } else {
            $ids = 0;
        }
        
        // Get club messages
        $messages = Message::whereIn('event_id', $ids)
                           ->where('club_id', null)
                           ->where('page_id', null)
                           ->orWhere('sender_id', $this->id)
                           ->orWhere('receiver_id', $this->id)
                           ->get();

        //Below section creates and array which holds event id values of the user's messages
        // Values are held as unique. Therefore there are not any same event id value in the array.
        if (count($messages)) {
            // Get event ids of event messages
            $messageEventIds = null; // This will be array which holds event ids of messages
            $index = 0; // index value for foreach
            foreach ($messages as $message) {
                $same = false; // checking 
                if (isset($messageEventIds)) {
                    foreach ($messageEventIds as $id) {
                        if ($message->event_id == $id) {
                            $same = true;
                            break;
                        }
                    }
                }
                if (!$same) {
                    $messageEventIds[$index] = $message->event_id;
                }
                $index++;
            }
        } else {
            return null;
        }
        return Event::whereIn('id', $messageEventIds)->get();
    }

    /**
    *   PAGE CONVERSATIONS
    */
    public function pageConversations() {
        // Getting ids of owned event
        if ($this->ownedPages()) {
            $ids = $this->ownedPages()->map(function ($page) {
                return collect($page->toArray())->only('id')->all();
            });
        } else {
            $ids = 0;
        }
        
        // Get club messages
        $messages = Message::whereIn('page_id', $ids)
                           ->where('club_id', null)
                           ->where('event_id', null)
                           ->orWhere('sender_id', $this->id)
                           ->orWhere('receiver_id', $this->id)
                           ->get();

        //Below section creates and array which holds page id values of the user's messages
        // Values are held as unique. Therefore there are not any same page id value in the array.
        if (count($messages)) {
            // Get page ids of page messages
            $messagePageIds = null; // This will be array which holds page ids of messages
            $index = 0; // index value for foreach
            foreach ($messages as $message) {
                $same = false; // checking 
                if (isset($messagePageIds)) {
                    foreach ($messagePageIds as $id) {
                        if ($message->page_id == $id) {
                            $same = true;
                            break;
                        }
                    }
                }
                if (!$same) {
                    $messagePageIds[$index] = $message->page_id;
                }
                $index++;
            }
        } else {
            return null;
        }
        return Page::whereIn('id', $messagePageIds)->get();
    }

    /*********************     END OF MESSAGES     ************************/

    /************************   FEEDBACKS   *********************************/
    public function feedbacks() {
        return $this->hasMany('App\Feedback', 'user_id');
    }
    /************************  END OF  FEEDBACKS   *********************************/

}
