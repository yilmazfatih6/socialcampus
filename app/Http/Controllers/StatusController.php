<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Status;
use App\Likeable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StatusController extends Controller
{
    public function postStatus(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'image' => 'image',
            'video' => 'file',
        ]);

        if ($request->hasFile('image') && $request->hasFile('video')) {
            return redirect()->back()->with('warning', 'Üzgünüz şuan için sadece bir medya içeriği paylaşabilirsin :(');
        }

        Auth::user()->statuses()->create([
            'body' => $request->input('status'),
        ]);

        //Posting Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'_'.Auth::user()->username.'.'.$image->getClientOriginalExtension();
            $request->file('image')->storeAs('/public/statuses/images/', $filename);
            $status = Auth::user()->statuses()->orderBy('created_at', 'desc')->first();
            $status->image = $filename;
            $status->save();
        }

        //Posting Video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = time().'_'.Auth::user()->username.'.'.$video->getClientOriginalExtension();
            $request->file('video')->storeAs('/public/statuses/videos/', $filename);
            $status = Auth::user()->statuses()->orderBy('created_at', 'desc')->first();
            $status->video = $filename;
            $status->save();
        }

        return redirect()->route('home')->with('success', 'Başarılı bir şekilde paylaşıldı.');
    }

    //Reply to a Status
    public function postReply(Request $request, $statusId)
    {
        // Check whether textarea is empty or not
        if ($request->ajax()) {
            if (empty($request->input('reply-'.$statusId))) {
                return response()->json(['message' => 'Lütfen bir şeyler yazın.']);
            }
        } else {
            $this->validate($request, [
                    "reply-".$statusId => 'required|max:1000',
                ], [
                    'required' => 'Yorum yapmak için bu alanı doldurmanız gerekli.',
                ]);
        }

        $status = Status::notReply()->find($statusId);
        $body = $request->input("reply-{$statusId}");

        // Checking whether status exists
        if (!$status) {
            if ($request->ajax()) {
                return redirect()->route('home')->with('danger', 'Böyle bir paylaşım bulunamadı.');
            } else {
                return response()->json(['message' => 'Böyle bir paylaşım bulunamadı.']);
            }
        }
        // Checking whether of not user is a member of club
        if ($status->club_id && !Auth::user()->isMemberWithId($status->club_id)) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Yorum yapabilmek için kulübe üye olmanız gerekli.']);
            } else {
                return redirect()->back()->with('danger', 'Yorum yapabilmek için kulübe üye olmanız gerekli.');
            }
        }
        // Checking whether of not user is attending to event
        if ($status->event_id && !Auth::user()->isAttendingWithId($status->event_id)) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Yorum yapabilmek için etkinliğe katılıyor olmanız gerekli.']);
            } else {
                return redirect()->back()->with('danger', 'Yorum yapabilmek için etkinliğe katılıyor olmanız gerekli.');
            }
        }
        // Checking if users are friends
        if (!$status->club_id && !$status->event_id && !$status->page_id) {
            if (!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id) {
                if ($request->ajax()) {
                    return redirect()->route('home')->with('danger', 'Bu kullanıcı ile arkadaş değilsiniz');
                } else {
                    return response()->json(['message' => 'Bu kullanıcı ile arkadaş değilsiniz']);
                }
            }
        }

        $reply = Status::create([ 'body' => $body ])->user()->associate(Auth::user());
        $status->replies()->save($reply);
        if ($request->ajax()) {
            return response()->json(['id' => $status->id]);
        } else {
            return redirect()->back()->with('success', 'Yorumunuz paylaşıldı.');
        }
    }

    //Delete a Status
    public function delete(Request $request, $id)
    {
        $status = Status::where('id', $id)->first();
        $status->delete();

        //Deleting Image if exist
        if ($status->image !== null) {
            Storage::delete('/public/statuses/'.$status->image);
        }

        //Deleting Video if exists
        if ($status->video !== null) {
            Storage::delete('/public/statuses/'.$status->video);
        }

        if ($request->ajax()) {
            return response()->json(['id' => $status->id,
                                     'message' => 'Silindi.',
                                     'duration' => 3000,
                                    ]);
        }

        return redirect()->back()->with('danger', 'Silindi.');
    }

    //Like a Status
    public function like(Request $request, $id)
    {
        $status = Status::find($id);

        if ($request->ajax()) {
            if (!$status) {
                return response()->json(['message' => 'Böyle bir gönderi yok :/']);
            }
            if (Auth::user()->hasLikedStatus($status)) {
                return response()->json(['message' => 'Bir paylaşımı yalnız bir kere beğenebilirsiniz.']);
            }
        } else {
            if (!$status) {
                return redirect()->back('home')->with('danger', 'Gönderi bulunamadı.');
            }
            if (Auth::user()->hasLikedStatus($status)) {
                return redirect()->back()->with('danger', 'Bir paylaşımı yalnız bir kere beğenebilirsiniz.');
            }
        }

        $like = $status->likes()->create([]);
        Auth::user()->likes()->save($like);

        if ($request->ajax()) {
            return response()->json(['id' => $status->id]);
        }

        return redirect()->back()->with('success', 'Gönderi beğenildi.');
    }

    // Dislike a Status
    public function dislike(Request $request, $id)
    {
        $status = Status::find($id);

        if ($request->ajax()) {
            if (!$status) {
                return response()->json(['message' => 'Böyle bir gönderi yok :/']);
            }
            if (!Auth::user()->hasLikedStatus($status)) {
                return response()->json(['message' => 'Hayda hata verdik malız galiba :/']);
            }
        } else {
            if (!$status) {
                return redirect()->back('home')->with('danger', 'Gönderi bulunamadı.');
            }
            if (!Auth::user()->hasLikedStatus($status)) {
                return redirect()->back()->with('danger', 'Hayda hata verdik malız galiba :/');
            }
        }

        $status->likes()->where('likeable_id', $status->id)
                                ->where('user_id', Auth::user()->id)->delete();

        if ($request->ajax()) {
            return response()->json(['id' => $status->id]);
        }

        return redirect()->back()->with('success', 'Beğeni geri alındı.');
    }

    // Show a Status
    public function show($id)
    {
        $status = Status::where('id', $id)->first();
        $user = User::where('id', $status->user_id)->first();

        return view('statuses.status')->with('user', $user)
                                      ->with('status', $status);
    }

    // Extend Status
    public function extend($id)
    {
        $status = Status::where('id', $id)->first()->body;
        $link = '<a id="shorten-status-'.$id.'" class="link shorten-status color-blue" data-status-id="'.$id.'">  <i class="fa fa-chevron-up" aria-hidden="true"></i> Daralt</a>';
        return response()->json([ 'status' => $status,
                                  'link' => $link
                                ]);
    }

    // Shorten Status
    public function shorten($id)
    {
        $status = Status::where('id', $id)->first();
        $status = $status->shortened();
        $link = '<a id="extend-status-'.$id.'" class="link extend-status color-blue" data-status-id="'.$id.'"> <i class="fa fa-chevron-down" aria-hidden="true"></i> Genişlet</a>';
        return response()->json([ 'status' => $status,
                                  'link' => $link
                                ]);
    }
}
