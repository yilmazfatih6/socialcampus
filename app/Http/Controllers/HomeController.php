<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\User;
use App\Page;
use App\Club;
use App\Event;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $statuses = Status::notReply()->where(function ($query) {
                return $query->where('user_id', Auth::user()->id)
                             ->orWhereIn('user_id', Auth::user()->friends()->pluck('id'))
                             ->whereNull('page_id')
                             ->whereNull('club_id');
            })
            ->orWhereIn('page_id', Auth::user()->pages()->pluck('page_id'))
            ->orWhereIn('club_id', Auth::user()->clubs()->pluck('club_id'))
            ->orWhereIn('event_id', Auth::user()->events()->pluck('event_id'))
            ->orderBy('created_at', 'desc')->paginate(4);

            if ($request->ajax()) {
                return view('statuses.load')->with('statuses', $statuses)->render();
            }

            $clubs = Auth::user()->clubs()->get();
            $events = Auth::user()->events()->get();
            $pages = Auth::user()->pages()->where('admin', true)->get();
            return view('home.timeline')->with('statuses', $statuses)
                                        ->with('clubs', $clubs)
                                        ->with('events', $events)
                                        ->with('pages', $pages);
        }

        return view('home.index');
    }

    // Changing Timeline Posting
    public function clubPosting($id)
    {
        $club = Club::where('id', $id)->first();
        return view('clubs.header.partials.posting')->with('club', $club)->render();
    }
    public function eventPosting($id)
    {
        $event = Event::where('id', $id)->first();
        return view('events.partials.posting')->with('event', $event)->render();
    }
    public function pagePosting($id)
    {
        $page = Page::where('id', $id)->first();
        return view('pages.header.partials.posting')->with('page', $page)->render();
    }

    public function foo(Request $request) {
        $this->validate($request, [
            'image' => 'image',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            $request->file('image')->storeAs('public/', $filename);
            Image::make($image)->fit(500, 500)->save(storage_path('/app/public/min/'.$filename));
        }

        return redirect()->back()->with('success', "that's the spirit!");
    }
}
