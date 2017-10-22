<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\Club;
use App\Event;
use App\User;
use App\Likeable;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AttendanceRequest;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Notification;

class EventController extends Controller
{
    //Events Home Page
    public function index()
    {
        $events = Event::orderBy('attenders', 'desc')->get();
        $ownedClubs = null; // Clubs with Admin privileges
        $ownedEvents = null; // Events with Admin privileges
        $joinedClubsEvents = null; // Events of Clubs which user is member of 
        $attendedEvents = null; // Attended events which user doesn't have admin privileges
        $otherEvents = null; // Events of Clubs which user is not member of 

        // Getting Clubs with admin privileges 
        if(Auth::check() && Auth::user()->isAdminAny()) {
            $ownedClubsBuffer = Auth::user()->clubs()->where('admin', true)->get();
            $ownedClubs = $ownedClubsBuffer->where('confirmed', true);
        }

        // Getting Events with admin privileges 
        if(Auth::check() && Auth::user()->isEventAdminAny()) {
            $ownedEvents = Auth::user()->events()->where('admin', true)->get();
        }

        // Attended Events
        if (Auth::check() && Auth::user()->isAttendingAny()) {
            $attendedEvents = Auth::user()->events()->where('confirmed', true)->where('admin', false)->get();
        }

        /*If User Is Member to any Club*/
        if (Auth::check() && Auth::user()->isMemberAny()) {

            // Collecting club ids of user's joined clubs
            $joinedClubs = Auth::user()->clubs()->get();
            $joinedClubsIds = $joinedClubs->map(function ($club) {
                return collect($club->toArray())->only('id')->all();
            });

            // Checking if users joined clubs has any events
            $hasJoinedClubHasAnyEvent = false;
            foreach ($joinedClubs as $club) {
                if ($club->hasEventsAny()) {
                    $hasJoinedClubHasAnyEvent = true;
                }
            }

            // Getting events of user's joined events if exists
            if($hasJoinedClubHasAnyEvent) {
                $joinedClubsEvents = Event::whereIn('club_id', $joinedClubsIds)->get();
            }

            if ($attendedEvents || $ownedEvents || $joinedClubsEvents) {
                /*Retrieving Other Events*/
                $ids2 = null;
                $j = 0;
                if($attendedEvents) {
                    foreach ($attendedEvents as $event) {
                        $ids2[$j] = $event->id;
                        $j++;
                    }
                }
                if($ownedEvents) {
                    foreach ($ownedEvents as $event) {
                        $ids2[$j] = $event->id;
                        $j++;
                    }
                }
                if($joinedClubsEvents) {
                    foreach ($joinedClubsEvents as $event) {
                        $ids2[$j] = $event->id;
                        $j++;
                    }
                }
                $otherEvents = Event::whereNotIn('id', $ids2)->get();
            }
        }

        return view('events.index')->with('events', $events)
                                   ->with('ownedClubs', $ownedClubs)
                                   ->with('ownedEvents', $ownedEvents)
                                   ->with('joinedClubsEvents', $joinedClubsEvents)
                                   ->with('attendedEvents', $attendedEvents)
                                   ->with('otherEvents', $otherEvents);
    }

    /*****************CREATE EVENT PAGE******************/
    public function getCreate($abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();

        if (!$club) {
            return redirect()->back()->with('danger', 'Üzgünüz böyle bir kulüp bulamadık.');
        }
        return view('events.create')->with('club', $club);
    }

    /*****************PERSIST EVENT TO DB******************/
    public function postCreate(Request $request, $abbreviation)
    {
        $this->validate($request, [
          'name' => 'required|max:25',
          'description' => 'required',
          'date' => 'required|date',
          'hour' => 'required',
          'attender_limit' => 'integer|nullable',
          'price' => 'integer|nullable',
          'contact' => 'integer|nullable',
          'contact_2' => 'integer|nullable',
          'poster' => 'image',
        ]);
        ///////////////////////////////////////////////////////////////
        if (strtotime($request->input('date')) < time()) {
            return redirect()->back()->withInput($request->except('date'), $request->except('date'))
                                     ->with('danger', 'Etkinlik tarihi bugünden önce gerçekleşemez!');
        }
        ///////////////////////////
        if (strtotime($request->input('deadline')) > strtotime($request->input('date'))) {
            return redirect()->back()->withInput($request->except('deadline'))
                                     ->with('danger', 'Son katılım tarihi etkinlik tarihinden sonra olamaz!');
        }

        $club = Club::where('abbreviation', $abbreviation)->first();

        $club->events()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'date' => $request->input('date'),
            'hour' => $request->input('hour'),
        ]);

        $event = Event::orderBy('created_at', 'desc')->first();

        //Add Attender Limit if exits
        if ($request->has('deadline')) {
            $event->deadline = $request->input('deadline');
        }

        //Add Attender Limit if exits
        if ($request->has('attender_limit')) {
            $event->attender_limit = $request->input('attender_limit');
        }
        //Add Price if exits
        if ($request->has('price')) {
            $event->price = $request->input('price');
        }
        //Add Phone if exits
        if ($request->has('contact')) {
            $event->phone = $request->input('contact');
        }
        //Add alternative Phone if exits
        if ($request->has('contact_2')) {
            $event->phone_alternative = $request->input('contact_2');
        }
        //Poster
        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');
            $filename = time().'_'.$club->abbreviation.'.'.$poster->getClientOriginalExtension();
            $request->file('poster')->storeAs('public/events/posters/', $filename);
            Image::make($poster)->fit(500, 500)->save(storage_path('/app/public/events/posters/min/'.$filename));
            $event->poster = $filename;
            $event->save();
        }
        Auth::user()->addEvent($event);
        $event->confirm(Auth::user());
        $event->makeAdmin(Auth::user());
        $event->attenders++;
        $event->save();
        return redirect()->action('EventController@eventPage', ['id' => $event->id])->with('success', 'Etkinlik oluşturuldu.');
    }

    // Attending to an event
    public function addEvent(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        $admins = $event->attenders()->where('admin', true)->get();
        // If users requested to attend to event for the second time return this
        if (Auth::user()->isAttending($event)) {
            if($request->ajax()) {
                return response()->json(['danger' => 'Bir etkinliğe birden fazla kere katılamazsınız.']);
            } else {
                return redirect()->back()->with('danger', 'Bir etkinliğe birden fazla kere katılamazsınız.');
            }
        } 
        // Checking if attender limit has been reached
        if ($event->attenders === $event->attender_limit) {
            if($request->ajax()) {
                return response()->json(['danger' => 'Üzgünüz etkinlik katılımcı limitine ulaşmış.']);
            } else {
                return redirect()->back()->with('danger', 'Üzgünüz etkinlik katılımcı limitine ulaşmış.');
            }
        }

        Auth::user()->addEvent($event);
        Notification::send($admins, new AttendanceRequest(Auth::user(), $event));
        $event->attenders++;
        $event->save();
        // If attend is free return this
        if ($event->price===null || $event->price===0) {
            $event->confirm(Auth::user());
            $event->save();
            return response()->json(['message' => 'Etkinliğe katıldınız.',
                                     'thumbnail' => view('events.partials.blocks.eventblock')->with('event', $event)->render(),
                                     'info' => view('events.partials.info')->with('event', $event)->render(),
                                    ]);
        }

        // If attend is NOT free return this
        return response()->json(['message' => 'Katılım isteği gönderildi. Lütfen ödeme için etkinlik sahibi ile görüşün.',
                                 'thumbnail' => view('events.partials.blocks.eventblock')->with('event', $event)->render(),
                                 'info' => view('events.partials.info')->with('event', $event)->render(),
                                ]);
    }

    public function quitEvent($id)
    {
        $event = Event::where('id', $id)->first();
        Auth::user()->quitEvent($event);
        $event->attenders--;
        $event->save();
        return response()->json(['message' => 'Etkinlikten çıkış yapıldı.',
                                 'thumbnail' => view('events.partials.blocks.eventblock')->with('event', $event)->render(),
                                 'info' => view('events.partials.info')->with('event', $event)->render(),
                                ]);
    }

    public function kickUser($eventId, $userId)
    {
        $event = Event::where('id', $eventId)->first();
        $user = User::where('id', $userId)->first();
        $user->quitEvent($event);
        $event->attenders--;
        $event->save();

        return response()->json(['message' => 'Kullanıcı etkinlikten çıkartıldı.',
                                 'event_id' => $event->id,
                                ]);
    }

    public function makeAdmin($eventId, $userId)
    {
        $event = Event::where('id', $eventId)->first();
        $user = User::where('id', $userId)->first();
        $event->makeAdmin($user);

        return response()->json(['message' => 'Kullanıcıya organizatör yetkileri verildi.',
                                 'event_id' => $event->id,
                                ]);
    }

    //Getting Event Home Page
    public function eventPage($id)
    {
        $event = Event::where('id', $id)->first();
        $club_id = $event->club_id;
        $club = Club::where('id', $club_id)->first();

        $statuses = Status::where('event_id', $id)->orderBy('created_at', 'desc')->paginate(2);
        $statuses->withPath('/event/'.$event->id.'/statuses');

        $attenders = $event->attenders()->paginate(1);
        $attenders->withPath('/event/'.$event->id.'/attenders');

        $admins = $event->attenders()->where('admin', true)->paginate(1);
        $admins->withPath('/event/'.$event->id.'/admins');

        return view('events.event')->with('event', $event)
                                   ->with('club', $club)
                                   ->with('statuses', $statuses)
                                   ->with('admins', $admins)
                                   ->with('attenders', $attenders);
    }

    // Pagination Action For Admins of Attenders
    public function attenders(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        $attenders = $event->attenders()->paginate(1);
        $attenders->withPath('/event/'.$event->id.'/attenders');

        if ($request->ajax()) {
            return view('events.partials.pagination.attenders')->with('event', $event)->with('attenders', $attenders)->render();
        }

        return view('events.attenders')->with('attenders', $attenders)->with('event', $event);
    }

    // Pagination Action For Admins of Event
    public function admins(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        $admins = $event->attenders()->where('admin', true)->paginate(1);
        $admins->withPath('/event/'.$event->id.'/admins');

        if ($request->ajax()) {
            return view('events.partials.pagination.admins')->with('event', $event)->with('admins', $admins)->render();
        }

        return view('events.admins')->with('event', $event)->with('admins', $admins);
    }

    // Pagination Action For Statuses of Event
    public function statuses(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        $statuses = Status::where('event_id', $id)->orderBy('created_at', 'desc')->paginate(2);
        $statuses->withPath('/event/'.$event->id.'/statuses');

        if ($request->ajax()) {
            return view('statuses.load')->with('statuses', $statuses)->render();
        }
    }

    //Posting Status on Event Page
    public function postStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required',
            'image' => 'image',
            'video' => 'file',
        ]);

        // Checking whether of not user is attending to event
        if (!Auth::user()->isAttendingWithId($id)) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Yorum yapabilmek için etkinliğe katılıyor olmanız gerekli.']);
            } else {
                return redirect()->back()->with('danger', 'Yorum yapabilmek için etkinliğe katılıyor olmanız gerekli.');
            }
        }

        if ($request->hasFile('image') && $request->hasFile('video')) {
            return redirect()->back()->with('warning', 'Üzgünüz şuan için sadece bir medya içeriği paylaşabilirsin :(');
        }

        Auth::user()->statuses()->create([
            'body' => $request->input('status'),
        ]);

        $status = Auth::user()->statuses()->orderBy('created_at', 'desc')->first();
        $status->event_id = $id;

        //Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'event_'.time().'_'.$id.'.'.$image->getClientOriginalExtension();
            $request->file('image')->storeAs('public/statuses/images', $filename);
            $status->image = $filename;
        }

        //Video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = 'event_'.time().'_'.$id.'.'.$video->getClientOriginalExtension();
            $request->file('video')->storeAs('public/statuses/videos', $filename);
            $status->video = $filename;
        }

        $status->save();
        return redirect()->back()->with('success', 'Paylaşıldı!');
    }

    public function eventblock($id)
    {
        $event = Event::where('id', $id)->first();
        return view('events.info')->with('event', $event);
    }

    // Extend Status
    public function extendDescript($id)
    {
        $event = Event::where('id', $id)->first();
        $link = '<a class="link shorten-desc" data-event-id="'.$id.'">  <i class="fa fa-chevron-up" aria-hidden="true"></i> Daralt</a>';
        return response()->json([ 'description' => $event->description,
                                  'link' => $link
                                ]);
    }

    // Shorten Status
    public function shortenDescript($id)
    {
        $event = Event::where('id', $id)->first();
        $description = $event->shortenDescript();
        $link = '<a class="link extend-desc" data-event-id="'.$id.'">  <i class="fa fa-chevron-up" aria-hidden="true"></i> Daralt</a>';
        return response()->json([ 'description' => $description,
                                  'link' => $link
                                ]);
    }
}
