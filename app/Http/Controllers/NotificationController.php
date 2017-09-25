<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications.index');
    }

    public function markAsRead($id)
    {
        if (!Auth::check()) {
            return redirect()->back();
        }
        Auth::user()->unreadNotifications->where('id', $id)->markAsRead();
        return response()->json(['status' => 'OK']);
    }

    public function markAsReadAll()
    {
        if (!Auth::check()) {
            return redirect()->back();
        }

        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'OK']);
    }
}
