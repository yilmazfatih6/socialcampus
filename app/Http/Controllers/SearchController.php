<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Club;
use App\Page;
use App\Event;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }
    public function getResults(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Lütfen gerekli alanı doldurunuz!']);
            }
            return redirect()->back()->with('info', 'Lütfen aramak istediğiniz şeyi yazınız.');
        }

        $users = User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$query}%")->orWhere('username', 'LIKE', "%{$query}%")->get();
        $clubs = Club::where(DB::raw("CONCAT(name)"), 'LIKE', "%{$query}%")->orWhere('abbreviation', 'LIKE', "%{$query}%")->get();
        $pages = Page::where(DB::raw("CONCAT(name)"), 'LIKE', "%{$query}%")->orWhere('abbr', 'LIKE', "%{$query}%")->get();
        $events = Event::where(DB::raw("CONCAT(name)"), 'LIKE', "%{$query}%")->orWhere('description', 'LIKE', "%{$query}%")->get();

        if ($request->ajax()) {
            if ($request->input('restrict') == 'users') {
                return view('search.partials.results')->with('users', $users)->render();/*Only Users*/
            } elseif ($request->input('restrict') == 'clubs') {
                return view('search.partials.results')->with('clubs', $clubs)->render();/*Only Clubs*/
            } elseif ($request->input('restrict') == 'events') {
                return view('search.partials.results')->with('events', $events)->render();/*Only Events*/
            } elseif ($request->input('restrict') == 'pages') {
                return view('search.partials.results')->with('pages', $pages)->render();/*Only Pages*/
            } elseif ($request->input('restrict') == 'all') {
                return view('search.partials.results')->with('users', $users)
                                                                   ->with('clubs', $clubs)
                                                                   ->with('events', $events)
                                                                   ->with('pages', $pages)->render();/*All*/
            }
        }

        return view('search.index')->with('users', $users)
                                                ->with('clubs', $clubs)
                                                ->with('events', $events)
                                                ->with('pages', $pages)
                                                ->with('query', $query);
    }
}
