<?php

namespace App\Http\Controllers;

use Auth;
use App\Club;
use Illuminate\Http\Request;
use App\Notifications\ClubAcceptance;
use Illuminate\Support\Facades\Notification;

class LordController extends Controller
{
    // Get Index Page
    public function index()
    {
        $clubRequests = Club::where('confirmed', false)->get();
        $confirmedClubs =  Club::where('confirmed', true)->get();
        return view('lord.index')->with('clubRequests', $clubRequests)
                                 ->with('confirmedClubs', $confirmedClubs);
    }

    // Apply Page
    public function apply()
    {
        if (Auth::user()->lord) {
            return redirect()->action('LordController@index');
        }
        return view('lord.apply');
    }

    // Confirm Clubs
    public function confirm(Request $request, $abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        $club->confirm();
        Notification::send($club->admins(), new ClubAcceptance($club));

        if ($request->ajax()) {
            return response()->json(['message' => $club->name.' isimli kulüp onaylandı.']);
        }

        return redirect()->back()->with('success', $club->name.' isimli kulüp onaylandı.');
    }

    // Reject Clubs
    public function reject(Request $request, $abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();

        $club->delete();

        if ($request->ajax()) {
            return response()->json(['message' => $club->name.' isimli kulüp reddedildi.']);
        }

        return redirect()->back()->with('success', $club->name.' isimli kulüp reddedildi.');
    }
}
