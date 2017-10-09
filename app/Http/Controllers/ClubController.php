<?php

namespace App\Http\Controllers;

use Auth;
use Image;
use App\Club;
use App\Status;
use App\Event;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Notifications\MemberAcceptance;
use App\Notifications\MembershipRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class ClubController extends Controller
{
    public function getIndex()
    {
        $clubs = Club::where('confirmed', true)->orderBy('name', 'asc')->paginate(1);
        $clubs->withPath('/all_clubs');
        if (Auth::check()) {
            $requestedClubs = Auth::user()->clubs()->where('accepted', false)->paginate(1);
            $requestedClubs->withPath('/requested_clubs');
            $ownedClubs = Auth::user()->clubs()->where('admin', true)->paginate(1);
            $ownedClubs->withPath('/owned_clubs');
            $joinedClubs = Auth::user()->clubs()->where('accepted', true)->paginate(1);
            $joinedClubs->withPath('/joined_clubs');
            if (Auth::user()->clubs()->count()) {
                /*Creating an Array That Contains Id Values of the Clubs that User DOESN'T FOLLOWING*/
                $clubIds;
                $i = 0;
                foreach (Auth::user()->clubs()->get() as $club) {
                    $clubIds[$i] = $club->id;
                    $i++;
                }

                $otherClubs = Club::whereNotIn('id', $clubIds)->paginate(1);
                $otherClubs->withPath('/other_clubs');

                return view('clubs.index')->with('clubs', $clubs)
                                            ->with('ownedClubs', $ownedClubs)
                                            ->with('requestedClubs', $requestedClubs)
                                            ->with('joinedClubs', $joinedClubs)
                                            ->with('otherClubs', $otherClubs);
            }
        }
        return view('clubs.index')->with('clubs', $clubs);
    }

    /***********************CREATING A NEW CLUB***********************/
    public function getCreate()
    {
        return view('clubs.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
          'name' => 'required|max:200',//array isimleri formlardaki name değerleri ile eşleşmelidir.
          'abbreviation' => 'required|unique:clubs|alpha_dash|max:50',
          'club_type' => 'required',
        ]);

        Club::create([
          'name' => $request->input('name'),
          'abbreviation' => $request->input('abbreviation'),
          'description' => $request->input('description'),
          'club_type' => $request->input('club_type'),
          'fb_url' => $request->input('fb_url'),
          'twitter_url' => $request->input('twitter_url'),
          'insta_url' => $request->input('insta_url'),
        ]);

        $club = Club::where('abbreviation', $request->input('abbreviation'))->first();
        $user = Auth::user();
        $user->addClub($club);
        $club->acceptMember($user);
        $club->makeAdmin($user);

        return redirect()->route('home')->with('success', 'Talebiniz site yöneticilerine bildirildi. Kulübünüz onaylandıktan sonra size bildirilecektir.');
    }

    /***********************GET THE PROFILE OF CLUB***********************/
    public function getProfile(Request $request, $abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        $statuses = Status::where('club_id', $club->id)->orderBy('created_at', 'desc')->paginate(2);
        $members = $club->members()->where('accepted', true)->get();
        $admins = $club->members()->where('admin', 1)->get();
        $requests = $club->members()->where('accepted', 0)->get();
        $events = Event::where('club_id', $club->id)->orderBy('created_at', 'desc')->get();


        if ($club->confirmed) {
            if ($request->ajax()) {
                return view('statuses.load')->with('club', $club)
                            ->with('statuses', $statuses)
                            ->with('members', $members)
                            ->with('admins', $admins)
                            ->with('requests', $requests)
                            ->with('events', $events)->render();
            }

            return view('clubs.profile')->with('club', $club)
                            ->with('statuses', $statuses)
                            ->with('members', $members)
                            ->with('admins', $admins)
                            ->with('requests', $requests)
                            ->with('events', $events);
        } else {
            return redirect()->back()->with('danger', 'Ulaşmaya çalıştığınız kulüp henüz onaylanmamıştır.');
        }
    }

    /***********************JOIN TO A CLUB***********************/
    public function addClub(Request $request, $abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        $admins = $club->admins();

        // Add user to club
        Auth::user()->addClub($club);

        // Send notifications to club admins
        Notification::send($admins, new MembershipRequest(Auth::user(), $club));    

        if ($request->ajax()) {
            return response()->json(['message' => 'Kulübe katılım isteği gönderildi.',
                                     'abbr' => $club->abbreviation,
                                     'bio' => view('clubs.partials.load.navButtons')->with('club', $club)->render(),
                                     'header' => view('clubs.partials.load.headerButtons')->with('club', $club)->render(),
                                    ]);
        }

        return redirect()->route('clubs.profile', ['abbreviation' => $club->abbreviation])->with('success', 'İstek gönderildi.');
    }

    /***********************QUITING A CLUB***********************/
    public function quitClub(Request $request, $abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        Auth::user()->quitClub($club);

        if ($request->ajax()) {
            return response()->json(['message' => 'Kulüpten ayrıldınız.',
                                     'abbr' => $club->abbreviation,
                                     'bio' => view('clubs.partials.load.navButtons')->with('club', $club)->render(),
                                     'header' => view('clubs.partials.load.headerButtons')->with('club', $club)->render(),
                                    ]);
        }

        return redirect()->route('clubs.profile', ['abbreviation' => $club->abbreviation])->with('danger', 'Kulüpten Ayrıldın');
    }

    /***********************POSTING A STATUS ON A CLUB**********************/
    public function postStatus(Request $request, $clubId)
    {
        $this->validate($request, [
          'post' => 'max:1000',
          'image' => 'image',
          'video' => 'file',
        ]);

        // Checking whether of not user is a member of club
        if (!Auth::user()->isMemberWithId($clubId)) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Paylaşım yapabilmek için kulübe üye olmanız gerekli.']);
            } else {
                return redirect()->back()->with('danger', 'Paylaşım yapabilmek için kulübe üye olmanız gerekli.');
            }
        }

        if ($request->hasFile('image') && $request->hasFile('video')) {
            return redirect()->back()->with('warning', 'Üzgünüz şuan için sadece bir medya içeriği paylaşabilirsin :(');
        }

        Auth::user()->statuses()->create([
            'body' => $request->input('post-'.$clubId),
        ]);

        $status = Auth::user()->statuses()->orderBy('created_at', 'desc')->first();

        $status->club_id = $clubId;

        $status->save();

        $club = Club::where('id', $clubId)->first();

        //Posting Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename =
            time().'_'.Auth::user()->username.'_'.$club->abbreviation.'.'.$image->getClientOriginalExtension();
            $request->file('image')->storeAs('/public/statuses/images/', $filename);
            $status->image = $filename;
            $status->save();
        }

        //Posting Video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename =
            time().'_'.Auth::user()->username.'_'.$club->abbreviation.'.'.$video->getClientOriginalExtension();
            $request->file('video')->storeAs('/public/statuses/videos/', $filename);
            $status = Auth::user()->statuses()->orderBy('created_at', 'desc')->first();
            $status->video = $filename;
            $status->save();
        }

        return redirect()->back()->with('success', 'Başarılı bir şekilde paylaşıldı.');
    }

    /***********************ACCEPTING A USER TO CLUB**********************/
    public function acceptMember(Request $request, $abbreviation, $username)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        $user = User::where('username', $username)->first();
        $club->acceptMember($user);
        $user->notify(new MemberAcceptance($club));
        if ($request->ajax()) {
            return response()->json(['message' => 'Kullanıcı kulübe kabul edildi.',
                                     'id' => $user->id,
                                    ]);
        }

        return redirect()->back()->with('info', 'Üye talebi kabul edildi.');
    }

    /***********************REJECTING A USER'S REQUEST**********************/
    public function rejectMember(Request $request, $abbreviation, $username)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        $user = User::where('username', $username)->first();

        $user->quitClub($club);

        if ($request->ajax()) {
            return response()->json(['message' => 'Kullanıcının katılım talebi reddedildi.',
                                                'id' => $user->id,
                                              ]);
        }

        return redirect()->back()->with('info', 'Üye talebi reddedildi.');
    }

    /***********************KICK A USER**********************/
    public function kickMember(Request $request, $abbreviation, $username)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        $user = User::where('username', $username)->first();

        $user->quitClub($club);

        if ($request->ajax()) {
            return response()->json(['id' => $user->id,
                                     'message' => 'Üye kulüpten atıldı.',
                                    ]);
        }
        return redirect()->back()->with('info', 'Üye kulüpten atıldı.');
    }

    /***********************EDITING CLUB INFORMATIONS***********************/
    public function getEdit($abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        return view('clubs.edit')->with('club', $club);
    }

    public function postEdit(Request $request, $abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();

        $this->validate($request, [
          'name' => 'required|max:200',//array isimleri formlardaki name değerleri ile eşleşmelidir.
          'abbreviation' => ['required', Rule::unique('clubs')->ignore($club->id), 'alpha_dash', 'max:50'],
          'club_type' => 'required',
        ]);

        if (!Auth::user()->isAdmin($club)) {
            return redirect()->back()->with('danger', 'Yetkisiz deneme.');
        }

        $club->update([
          'name' => $request->input('name'),
          'abbreviation' => $request->input('abbreviation'),
          'description' => $request->input('description'),
          'club_type' => $request->input('club_type'),
          'fb_url' => $request->input('fb_url'),
          'twitter_url' => $request->input('twitter_url'),
          'insta_url' => $request->input('insta_url'),
        ]);
        return redirect()->action('ClubController@getEdit', ['abbreviation' => $club->abbreviation])->with('success', 'Bilgiler güncellendi.');
    }

    /***********************UPLOADING AVATAR TO CLUB**********************/
    public function uploadAvatar(Request $request, $abbreviation)
    {
        if ($request->hasFile('avatar')) {
            $club = Club::where('abbreviation', $abbreviation)->first();
            if ($club->avatar !== 'default.png') {
                Storage::delete('/public/avatars/'.$club->avatar);
            }
            $avatar = $request->file('avatar');
            $filename = 'club_'.time().'_'.$club->abbreviation.'.'.$avatar->getClientOriginalExtension();
            // Store file at specific path 
            $avatar->storeAs('/public/avatars/', $filename);
            $club->avatar = $filename;
            $club->save();
        }
        return redirect()->back()->with('success', 'Kulüp profil fotoğrafı başarılı bir şekilde değiştirildi.')
                                           ->withInput(['tab'=>'admin']);
    }

    /***********************UPLOADING COVER TO CLUB**********************/
    public function uploadCover(Request $request, $abbreviation)
    {
        $club = Club::where('abbreviation', $abbreviation)->first();
        if ($request->hasFile('cover')) {
            if ($club->cover !== 'default.jpg') {
                Storage::delete('/public/covers/'.$club->cover);
            }
            $cover = $request->file('cover');
            $filename = 'club_'.time().'_'.$club->abbreviation.'.'.$cover->getClientOriginalExtension();
            // Store file at specific path 
            $cover->storeAs('/public/covers/', $filename);
            $club->cover = $filename;
            $club->save();
        }
        return redirect()->back()->with('success', 'Kulüp kapak fotoğrafı başarılı bir şekilde değiştirildi.')
                                           ->withInput(['tab'=>'admin']);
    }

    /***********************PAGINATION REQUESTED CLUBS**********************/
    public function requested(Request $request)
    {
        $requestedClubs = Auth::user()->clubs()->where('accepted', false)->paginate(1);
        $requestedClubs->withPath('/requested_clubs');
        if ($request->ajax()) {
            return view('clubs.partials.pagination.requestedClubs')->with('requestedClubs', $requestedClubs)->render();
        }
        return redirect()->back('info', 'Tarayıcının javascipt özelliğini aktifleştirmende yarar var :D');
    }
    /***********************PAGINATION OWNED CLUBS**********************/
    public function owned(Request $request)
    {
        $ownedClubs = Auth::user()->clubs()->where('admin', true)->paginate(1);
        $ownedClubs->withPath('/owned_clubs');
        if ($request->ajax()) {
            return view('clubs.partials.pagination.ownedClubs')->with('ownedClubs', $ownedClubs)->render();
        }
        return redirect()->back('info', 'Tarayıcının javascipt özelliğini aktifleştirmende yarar var :D');
    }
    /***********************PAGINATION JOINED CLUBS**********************/
    public function joinedClubs(Request $request)
    {
        $joinedClubs = Auth::user()->clubs()->where('accepted', true)->paginate(1);
        $joinedClubs->withPath('/joined_clubs');
        if ($request->ajax()) {
            return view('clubs.partials.pagination.joinedClubs')->with('joinedClubs', $joinedClubs)->render();
        }
        return redirect()->back('info', 'Tarayıcının javascipt özelliğini aktifleştirmende yarar var :D');
    }
    /***********************PAGINATION OTHER CLUBS**********************/
    public function otherClubs(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->clubs()->count()) {
                /*Creating an Array That Contains Id Values of the Clubs that User DOESN'T FOLLOWING*/
                $clubIds;
                $i = 0;
                foreach (Auth::user()->clubs()->get() as $club) {
                    $clubIds[$i] = $club->id;
                    $i++;
                }

                $otherClubs = Club::whereNotIn('id', $clubIds)->paginate(1);
                $otherClubs->withPath('/other_clubs');

                if ($request->ajax()) {
                    return view('clubs.partials.pagination.OtherClubs')->with('otherClubs', $otherClubs)->render();
                }
                return redirect()->back('info', 'Tarayıcının javascipt özelliğini aktifleştirmende yarar var :D');
            }
        }
        return redirect()->back('danger', 'Bunun için giriş yapmanız gerekli!');
    }
    /***********************PAGINATION ALL CLUBS**********************/
    public function allClubs(Request $request)
    {
        $clubs = Club::where('confirmed', true)->orderBy('name', 'asc')->paginate(1);
        $clubs->withPath('/all_clubs');
        if ($request->ajax()) {
            return view('clubs.partials.pagination.clubs')->with('clubs', $clubs)->render();
        }
        return redirect()->back('info', 'Tarayıcının javascipt özelliğini aktifleştirmende yarar var :D');
    }
}
