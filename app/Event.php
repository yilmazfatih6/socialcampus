<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date',
        'hour',
        'deadline',
        'attenders',
        'attender_limit',
        'price',
        'phone',
        'phone_alternative',
        'poster',
        'ended',
    ];

    protected $hidden = [

    ];

    public function clubs()
    {
        return $this->belongsTo('App\Club', 'club_id');
    }

    public function attenders()
    {
        return $this->belongsToMany('App\User', 'attenders', 'event_id', 'user_id');
    }

    public function confirm(User $user)
    {
        return $this->attenders()->where('user_id', $user->id)->first()->pivot->update(['confirmed' => true]);
    }

    public function makeAdmin(User $user)
    {
        return $this->attenders()->where('user_id', $user->id)->first()->pivot->update(['admin' => true]);
    }

    public function admins()
    {
        return $this->attenders()->where('admin', true)->get();
    }

    public function isDescLong() {
        if (strlen($this->description) > 150) {
            return true;
        } else {
            return false;
        }
    }

    public function shortenDescript()
    {
        if (strlen($this->description) > 150) {
            $this->description = substr($this->description, 0, 150);
            $this->description = substr($this->description, 0, strrpos($this->description, ' '));
            $this->description = substr($this->description, 0, strrpos($this->description, ' '));
            return $this->description;
        }
        return $this->description;
    }

    public function isFree()
    {
        return (bool) $this->where('price', null)->count();
    }

     /**
    *   Received and Sent Messages of Evemt
    */
    public function messages()
    {
        return $this->hasMany('App\Message', 'event_id');
    }

    // Checking if attender limit is reached 
    public function isAttenderLimitReached() {
        if ($this->attenders === $this->attender_limit) {
            return true;
        } else {
            return false;
        }
    }
}
