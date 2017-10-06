<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name',
        'abbr',
        'description',
        'genre',
        'fb_url',
        'twitter_url',
        'insta_url',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'page_id', 'user_id');
    }

    public function admins()
    {
        return $this->followers()->where('admin', true)->get();
    }

    public function makeAdmin(User $user)
    {
    	return $this->followers()->where('user_id', $user->id)->first()->pivot->update(['admin' => true]);
    }

    public function makeCreator(User $user)
    {
        return $this->followers()->where('user_id', $user->id)->first()->pivot->update(['creator' => true]);
    }

    public function statuses()
    {
        return $this->hasMany('App\Status', 'page_id');
    }

    public function isAdmin(User $user)
    {
        return (bool) $this->followers()->where('user_id', $user->id)
                                        ->where('admin', true)
                                        ->count();
    }

    public function isFollowing(User $user)
    {
        return (bool) $this->followers()->where('user_id', $user->id)
                                        ->where('admin', false)->count();
    }

    /**
    *   Received and Sent Messages of Club
    */
    public function messages()
    {
        return $this->hasMany('App\Message', 'page_id');
    }
}
