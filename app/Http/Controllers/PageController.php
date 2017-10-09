<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Page;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Notifications\FollowRequest;
use Illuminate\Support\Facades\Notification;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::get();

        if (Auth::check()) {
            if (Auth::user()->pages()->count()) {
                /*Creating an Array That Contains Id Values of the Pages that User DOESN'T FOLLOWING*/
                $pageIds;
                $i = 0;
                foreach (Auth::user()->pages()->get() as $page) {
                    $pageIds[$i] = $page->id;
                    $i++;
                }

                $otherPages = Page::whereNotIn('id', $pageIds)->get();
                return view('pages.index')->with('pages', $pages)->with('otherPages', $otherPages);
            }
        }
        return view('pages.index')->with('pages', $pages);
    }

    /***********************GET PROFILE OF A PAGE************************/
    public function getProfile(Request $request, $abbr)
    {
        $page = Page::where('abbr', $abbr)->first();
        $statuses = Status::where('page_id', $page->id)->orderBy('created_at', 'desc')->paginate(2);
        $followers = $page->followers()->get();

        if ($request->ajax()) {
            return view('statuses.load')->with('page', $page)
                                        ->with('statuses', $statuses)
                                        ->with('followers', $followers);
        }
        return view('pages.profile')->with('page', $page)
                                    ->with('statuses', $statuses)
                                    ->with('followers', $followers);
    }

    /***********************CREATING A NEW PAGE***********************/
    public function getCreate()
    {
        return view('pages.create');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
          'name' => 'required|max:200',
          'abbr' => 'required|unique:pages|alpha_dash|max:50'
        ]);

        Auth::user()->pages()->create([
          'name' => $request->input('name'),
          'abbr' => $request->input('abbr'),
          'description' => $request->input('description'),
          'genre' => $request->input('genre'),
          'fb_url' => $request->input('fb_url'),
          'twitter_url' => $request->input('twitter_url'),
          'insta_url' => $request->input('insta_url'),
        ]);

        $page = Page::where('abbr', $request->input('abbr'))->first();
        $page->makeAdmin(Auth::user());
        $page->makeCreator(Auth::user());
        $page->save();

        return redirect()->action('PageController@getProfile', ['abbr'=>$request->input('abbr')])->with('Yepyeni sayfanız oluşturuldu.');
    }

    /***********************POSTING A STATUS ON A PAGE**********************/
    public function postStatus(Request $request, $abbr)
    {
        $this->validate($request, [
          'image' => 'image',
          'video' => 'file',
        ]);

        if ($request->hasFile('image') && $request->hasFile('video')) {
            return redirect()->back()->with('warning', 'Üzgünüz şuan için sadece bir medya içeriği paylaşabilirsin :(');
        }

        if (!$request->has('post') && !$request->has('image') && !$request->has('video')) {
            return redirect()->back()->with('danger', 'Paylaşım yapmak için bir şeyler yazmalısın.');
        }

        Auth::user()->statuses()->create([
            'body' => $request->input('post'),
        ]);

        $page = Page::where('abbr', $abbr)->first();
        $status = Auth::user()->statuses()->orderBy('created_at', 'desc')->first();
        $status->page_id = $page->id;

        //Posting Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'event_'.time().'_'.Auth::user()->username.'_'.$page->abbr.'.'.$image->getClientOriginalExtension();
            $request->file('image')->storeAs('/public/statuses/images/', $filename);
            $status->image = $filename;
            $status->save();
        }

        //Posting Video
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $filename = 'event_'.time().'_'.Auth::user()->username.'_'.$page->abbr.'.'.$video->getClientOriginalExtension();
            $request->file('video')->storeAs('/public/statuses/videos/', $filename);
            $status = Auth::user()->statuses()->orderBy('created_at', 'desc')->first();
            $status->video = $filename;
            $status->save();
        }

        $status->save();
        return redirect()->back()->with('success', 'Başarılı bir şekilde paylaşıldı.');
    }

    /*************************FOLLOWING A PAGE***************************/
    public function followPage(Request $request, $abbr)
    {
        $page = Page::where('abbr', $abbr)->first();
        $admins = $page->admins();

        Auth::user()->followPage($page);

        Notification::send($admins, new FollowRequest(Auth::user(), $page));

        if ($request->ajax()) {
            return response()->json(['message' => 'Sayfa takip edildi.',
                                     'bio' => view('pages.header.partials.bio')->with('page', $page)->render(),
                                    ]);
        }

        return redirect()->back()->with('Başarılı bir şekilde takip edildi.');
    }
    /*************************UNFOLLOWING A PAGE***************************/
    public function unfollowPage(Request $request, $abbr)
    {
        $page = Page::where('abbr', $abbr)->first();
        Auth::user()->unfollowPage($page);

        if ($request->ajax()) {
            return response()->json(['message' => 'Sayfayı takip etmeyi bıraktın.',
                                     'bio' => view('pages.header.partials.bio')->with('page', $page)->render(),
                                    ]);
        }

        return redirect()->back()->with('Bu sayfayı takip etmeyi bıraktın.');
    }

    /***********************UPLOADING AVATAR TO PAGE**********************/
    public function uploadAvatar(Request $request, $abbr)
    {
        if ($request->hasFile('avatar')) {
            $page = Page::where('abbr', $abbr)->first();
            if ($page->avatar !== 'default.png') {
                Storage::delete('/public/avatars/'.$page->avatar);
            }
            $avatar = $request->file('avatar');
            $filename = 'page_'.time().'_'.$page->abbr.'.'.$avatar->getClientOriginalExtension();
            // Store file at specific path 
            $avatar->storeAs('/public/avatars/', $filename);
            $page->avatar = $filename;
            $page->save();
        }
        return redirect()->back()->with('success', 'Sayfa profil fotoğrafı başarılı bir şekilde değiştirildi.')
                                 ->withInput(['tab'=>'admin']);
    }

    /***********************UPLOADING COVER TO PAGE**********************/
    public function uploadCover(Request $request, $abbr)
    {
        $page = Page::where('abbr', $abbr)->first();
        if ($request->hasFile('cover')) {
            if ($page->cover !== 'default.jpg') {
                Storage::delete('/public/covers/'.$page->cover);
            }
            $cover = $request->file('cover');
            $filename = 'page_'.time().'_'.$page->abbr.'.'.$cover->getClientOriginalExtension();
            // Store file at specific path 
            $cover->storeAs('/public/covers/', $filename);
            $page->cover = $filename;
            $page->save();
        }
        return redirect()->back()->with('success', 'Sayfa kapak fotoğrafı başarılı bir şekilde değiştirildi.')
                                 ->withInput(['tab'=>'admin']);
    }

    /***********************EDITING PAGE INFORMATIONS***********************/
    public function getEdit($abbr)
    {
        $page = Page::where('abbr', $abbr)->first();
        return view('pages.edit')->with('page', $page);
    }

    public function postEdit(Request $request, $abbr)
    {
        $page = Page::where('abbr', $abbr)->first();

        $this->validate($request, [
          'name' => 'required|max:200',//array isimleri formlardaki name değerleri ile eşleşmelidir.
          'abbr' => ['required', Rule::unique('pages')->ignore($page->id), 'alpha_dash', 'max:50'],
        ]);

        if (!Auth::user()->isPageAdmin($page)) {
            return redirect()->back()->with('danger', 'Yetkisiz girişim.');
        }

        $page->update([
          'name' => $request->input('name'),
          'abbr' => $request->input('abbr'),
          'description' => $request->input('description'),
          'genre' => $request->input('genre'),
          'fb_url' => $request->input('fb_url'),
          'twitter_url' => $request->input('twitter_url'),
          'insta_url' => $request->input('insta_url'),
        ]);

        return redirect()->action('PageController@getEdit', ['abbr' => $page->abbr])->with('success', 'Bilgiler güncellendi.');;
    }
}
