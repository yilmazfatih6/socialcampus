<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $fillable = [
        'name',
        'abbreviation',
        'description',
        'club_type',
        'fb_url',
        'twitter_url',
        'insta_url',
        'password',
        'confirmed',
    ];

    protected $hidden = [
        'password',
    ];

    public function members()
    {
        return $this->belongsToMany('App\User', 'members', 'club_id', 'user_id');
    }

    public function admins()
    {
        return $this->members()->where('admin', true)->get();
    }

    public function isAdmin(User $user)
    {
        return (bool) $this->members()->where('user_id', $user->id)
                                      ->where('admin', 1)->count();
    }

    public function isMember(User $user)
    {
        return (bool) $this->members()->where('user_id', $user->id)
                                      ->where('accepted', true)
                                      ->where('admin',false)->count();
    }

    public function hasRequest(User $user)
    {
        return (bool) $this->members()->where('user_id', $user->id)
                               ->where('accepted', false)
                               ->count();
    }

    public function acceptMember(User $user)
    {
        return $this->members()->where('user_id', $user->id)->first()->pivot->update(['accepted' => true]);
    }

    public function makeAdmin(User $user)
    {
        return $this->members()->where('user_id', $user->id)->first()->pivot->update(['admin' => true]);
    }

    public function statuses()
    {
        return $this->hasMany('App\Status', 'club_id');
    }

    public function events()
    {
        return $this->hasMany('App\Event', 'club_id');
    }

    public function hasEventsAny() {
        return $this->events()->count();
    }

    public function confirm()
    {
        return $this->update(['confirmed' => true]);
    }

    /**
    *   Received and Sent Messages of Club
    */
    public function messages()
    {
        return $this->hasMany('App\Message', 'club_id');
    }

}
