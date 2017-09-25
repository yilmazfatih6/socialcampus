<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'video',
        'image',
    ];

    // Accesing user from message
    // Connect to User Model, match id of User Model with sender_id of Message Model
    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'sender_id');
    }
}
