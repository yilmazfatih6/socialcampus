<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
          'body',
          'event_id',
      ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function club()
    {
        return $this->belongsTo('App\Club', 'club_id');
    }

    public function page()
    {
        return $this->belongsTo('App\Page', 'page_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Event', 'event_id');
    }

    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopePagePost($query)
    {
        return $query->whereNotNull('page_id');
    }

    public function replies()
    {
        return $this->hasMany('App\Status', 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Likeable', 'likeable');
    }

    public function shortened()
    {
        if (strlen($this->body) > 250) {
            $this->body = substr($this->body, 0, 250);
            $this->body = substr($this->body, 0, strrpos($this->body, ' '));
            $this->body = substr($this->body, 0, strrpos($this->body, ' '));
            $this->body = $this->body.'<a class="link extend-status color-blue" data-status-id="'.$this->id.'">  <i class="fa fa-chevron-down" aria-hidden="true"></i> Genişlet</a>';
            return $this->body;
        }
        return $this->body;
    }
}
