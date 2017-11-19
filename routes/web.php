<?php

/*******************HOME***********************/
  Route::get('/', 'HomeController@index')->name('home');
/*******************END OF HOME***********************/

/*******************FEEDBACK***********************/
  Route::get('/feedback', 'FeedbacksController@index');
  Route::post('/feedback/send', 'FeedbacksController@send')->middleware('guest');
  Route::post('/feedback/auth/send', 'FeedbacksController@sendAuth')->middleware('auth');

/*******************END OF FEEDBACK***********************/

/***********************AUTHENTICATION*********************/
  Route::get('/signup', [
      'uses' => '\App\Http\Controllers\AuthController@getSignup',
      'as' => 'auth.signup',
      'middleware' => ['guest'],
  ]);

  Route::post('/signup', [
      'uses' => '\App\Http\Controllers\AuthController@postSignup',
      'middleware' => ['guest'],
  ]);

  Route::get('/signin', [
    'uses' => '\App\Http\Controllers\AuthController@getSignin',
    'as' => 'login',
    'middleware' => ['guest'],
  ]);

  Route::post('/signin', [
      'uses' => '\App\Http\Controllers\AuthController@postSignin',
      'middleware' => ['guest'],
  ]);

  Route::get('/signout', [
      'uses' => '\App\Http\Controllers\AuthController@getSignOut',
      'as' => 'auth.signout',
  ]);

  Route::get('/password/forgotten', 'AuthController@getPasswordForgotten')->middleware('guest');
  Route::post('/password/forgotten', 'AuthController@postPasswordForgotten')->middleware('guest');
  Route::get('/password/reset/{token}', 'AuthController@getPasswordReset')->middleware('guest');
  Route::post('/password/reset/{token}', 'AuthController@postPasswordReset')->middleware('guest');
/***********************END OF AUTHENTICATION******************/

/********************SEARCH******************/
//Search Page
  Route::get('/search', 'SearchController@index');
// Make Search on Background
  Route::get('/searchengine', 'SearchController@getResults');
/********************END OF SEARCH******************/

/***************USER PROFILE******************/
  Route::get('/user/{username}', 'UserController@getProfile');

  // Profile edit
  Route::get('/profile/edit', 'UserController@getEdit')->name('profile.edit')->middleware('auth');
  Route::post('/profile/edit/{username}', 'UserController@postEdit')->middleware('auth');
  //Password edit
  Route::get('/profile/edit/password', 'UserController@getEditPass')->name('profile.password')->middleware('auth');
  Route::post('/profile/edit/password', 'UserController@postEditPass')->middleware('auth');

  //Changing User Avatar
  Route::post('/profile/upload/avatar', 'UserController@uploadAvatar')->middleware('auth');
  //Changing User Cover
  Route::post('/profile/upload/cover', 'UserController@uploadCover')->middleware('auth');

  Route::get('/user/info/{username}', 'UserController@userInfo')->middleware('auth');
  // Delete User Account
  Route::get('/account/delete', 'UserController@getDelete')->middleware('auth');
  Route::post('/account/{id}/delete', 'UserController@postDelete')->middleware('auth');

  // Verify user
  Route::get('/verify/{token}', 'AuthController@verifyUser');
/***************END OF USER PROFILE******************/


/***********************FRIENDS*********************/
  // Friends
  Route::get('/friends', [
    'uses' => '\App\Http\Controllers\FriendController@getIndex',
    'as' => 'friends.index',
    'middleware' => ['auth'],
  ]);

  //Adding Friend
  Route::post('/friends/add/{id}', 'FriendController@getAdd')->middleware('auth');
  //Accepting Friend
  Route::post('/friends/accept/{id}', 'FriendController@getAccept')->middleware('auth');
  //Rejecting Friend
  Route::post('/friends/reject/{id}', 'FriendController@getReject')->middleware('auth');
  //Deleting Friend
  Route::post('/friends/delete/{id}', 'FriendController@postDelete')->middleware('auth');
/***********************END OF FRIENDS*********************/


/***********************CLUB*********************/
  //Clubs
  Route::get('/clubs', 'ClubController@getIndex');

  //Creating Club Get Method
  Route::get('/club/create', [
      'uses' => '\App\Http\Controllers\ClubController@getCreate',
      'as' => 'clubs.create',
      'middleware' => ['auth'],
    ]);

  //Creating Club Post Method
  Route::post('/club/create', [
      'uses' => '\App\Http\Controllers\ClubController@postCreate',
      'middleware' => ['auth'],
  ]);

  //Getting Club Profile
  Route::get('/club/{abbreviation}', 'ClubController@getProfile')->name('clubs.profile');

  //Uploading Club Avatar and Cover
  Route::post('/club/{abbreviation}/upload/avatar', 'ClubController@uploadAvatar')->middleware('auth');
  Route::post('/club/{abbreviation}/upload/cover', 'ClubController@uploadCover')->middleware('auth');

  //Member Acception
  Route::post('/club/{abbreviation}/accept/{username}', 'ClubController@acceptMember')->middleware('auth');
  //Member Rejection
  Route::post('/club/{abbreviation}/reject/{username}', 'ClubController@rejectMember')->middleware('auth');
  //Member Kick
  Route::post('/club/{abbreviation}/kick/{username}', 'ClubController@kickMember')->middleware('auth');

  //Club Editing Infos
  Route::get('/club/{abbreviation}/edit', 'ClubController@getEdit')->middleware('auth');
  Route::post('/club/{abbreviation}/edit', 'ClubController@postEdit')->middleware('auth');

  //Club Changing password
  Route::get('/club/{abbreviation}/password', 'ClubController@getPassword')->middleware('auth');
  Route::post('/club/{abbreviation}/password', 'ClubController@postPassword')->middleware('auth');

  // Join to a Club
  Route::post('/club/add/{abbreviation}', 'ClubController@addClub')->name('club.add')->middleware('auth');

  //Quiting Club By User
  Route::post('/club/quit/{abbreviation}', 'ClubController@quitClub')->middleware('auth');

  //Sharing A Post On A Club
  Route::post('/club/post/{clubId}', 'ClubController@postStatus')->middleware('auth');

  Route::get('/club//status/{id}/delete', 'ClubController@postDelete');

  // Pagination Stuffs for Clubs Index
  Route::get('/requested_clubs', 'ClubController@requested');
  Route::get('/owned_clubs', 'ClubController@owned');
  Route::get('/joined_clubs', 'ClubController@joinedClubs');
  Route::get('/other_clubs', 'ClubController@otherClubs');
  Route::get('/all_clubs', 'ClubController@allClubs');

/***********************END OF CLUBS*********************/


/***********************EVENTS*********************/
  Route::get('/events', 'EventController@index')->name('events');
  Route::get('/event/create/{abbreviation}', 'EventController@getCreate')->middleware('auth');
  Route::post('/event/create/{abbreviation}', 'EventController@postCreate')->middleware('auth');
  // Attend To Event
  Route::post('/event/{id}/add', 'EventController@addEvent')->middleware('auth');
  // Quit Event
  Route::post('/event/{id}/quit', 'EventController@quitEvent')->middleware('auth');
  // Delete Event
  Route::post('/event/{id}/delete', 'EventController@delete')->middleware('auth');
  Route::post('/event/{eventId}/kick/{userId}', 'EventController@kickUser')->middleware('auth');
  Route::post('/event/{eventId}/make/admin/{userId}', 'EventController@makeAdmin')->middleware('auth');
  Route::get('/event/{id}', 'EventController@eventPage');
  //Admins & Attenders
  Route::get('/event/{id}/attenders', 'EventController@attenders')->middleware('auth');
  Route::get('/event/{id}/admins', 'EventController@admins')->middleware('auth');
  // Statuses
  Route::get('/event/{id}/statuses', 'EventController@statuses');
  Route::post('/event/{id}/post', 'EventController@postStatus')->middleware('auth');
  Route::get('/eventblock/{id}', 'EventController@eventblock')->middleware('auth');
  // Extend Description
  Route::get('/event/{id}/extend/description', 'EventController@extendDescript');
  // Shorten Description
  Route::get('/event/{id}/shorten/description', 'EventController@shortenDescript');
/***********************END OF EVENTS*********************/

/***********************STATUS*********************/
  //Statuses
  Route::post('/status', 'StatusController@postStatus')->name('status.post')->middleware('auth');
  //Showing Status
  Route::get('/status/{statusId}', 'StatusController@show');
  // Sharing Comment
  Route::post('/status/{statusId}/reply', 'StatusController@postReply')->name('status.reply')->middleware('auth');
  // Status or Comment Delete
  Route::post('/status/{id}/delete', 'StatusController@delete')->middleware('auth');
  // Like
  Route::post('/status/{statusId}/like', 'StatusController@like')->middleware('auth');
  // Dislike
  Route::post('/status/{statusId}/dislike', 'StatusController@dislike')->middleware('auth');
  // Extend Statuses
  Route::get('/status/extend/{id}', 'StatusController@extend');
  // Shorten Status
  Route::get('/status/shorten/{id}', 'StatusController@shorten');
  // Load Posting At Club
  Route::get('/posting/load/club/{id}', 'HomeController@clubPosting')->middleware('auth');
  Route::get('/posting/load/event/{id}', 'HomeController@eventPosting')->middleware('auth');
  Route::get('/posting/load/page/{id}', 'HomeController@pagePosting')->middleware('auth');

/***********************END OF STATUS*********************/

/***********************PAGES*********************/
  Route::get('/pages', 'PageController@index');
  Route::get('/page/create', 'PageController@getCreate')->middleware('auth');
  Route::post('/page/create', 'PageController@postCreate')->middleware('auth');
  Route::get('/page/{abbr}', 'PageController@getProfile');
  // Posting A Status
  Route::post('page/{abbr}/post', 'PageController@postStatus')->middleware('auth');
  Route::post('/page/{abbr}/follow', 'PageController@followPage')->middleware('auth');
  Route::post('/page/{abbr}/unfollow', 'PageController@unfollowPage')->middleware('auth');
  // Upload Avatar & Cover
  Route::post('/page/{abbr}/upload/avatar', 'PageController@uploadAvatar')->middleware('auth');
  Route::post('/page/{abbr}/upload/cover', 'PageController@uploadCover')->middleware('auth');
  // Edit Page Info
  Route::get('/page/{abbr}/edit', 'PageController@getEdit')->middleware('auth');
  Route::post('/page/{abbr}/edit', 'PageController@postEdit')->middleware('auth');

/***********************END OF PAGES*********************/

/***********************NOTIFICATIONS*********************/
  Route::get('/notifications', 'NotificationController@index');
  Route::get('/markAsRead/{id}', 'NotificationController@markAsRead');
  Route::get('/markAsReadAll', 'NotificationController@markAsReadAll');
/***********************END OF NOTIFICATIONS*********************/

/*********************** LORD *********************/
  Route::get('/lord', 'LordController@index')->middleware('auth', 'lord');
  Route::get('/lord/apply', 'LordController@apply')->name('lord.apply')->middleware('auth');
  Route::post('/lord/confirm/{abbreviation}', 'LordController@confirm')->middleware('auth', 'lord');
  Route::post('/lord/reject/{abbreviation}', 'LordController@reject')->middleware('auth', 'lord');
/*********************** END OF LORD *********************/

/*********************** CHAT *********************/
  Route::get('/chat', 'MessageController@index')->middleware('auth');
  // Get personal chat page
  Route::get('/chat/personal/{id}', 'MessageController@personalChat')->middleware('auth');
  // Get Messages from DB
  Route::get('/message/load/{id}', 'MessageController@loadPersonalMessages')->middleware('auth');
  // Send a Message
  Route::post('/message/send/{id}', 'MessageController@sendPersonalMessage')->middleware('auth');

  // Club Chat Page
  Route::get('/chat/{userId}/club/{clubId}', 'MessageController@clubChat')->middleware('auth');
  // Get messages of chat between some user and some club
  Route::get('/message/{userId}/load/club/{clubId}', 'MessageController@loadClubMessages')->middleware('auth');
  // Send message as user
  Route::post('/message/{userId}/send/club/{clubId}', 'MessageController@sendClubMessageAsUser')->middleware('auth');
  // Send message as club
  Route::post('/message/{userId}/club/{clubId}/send', 'MessageController@sendClubMessageAsClub')->middleware('auth');

  // Event Chat Page
  Route::get('/chat/{userId}/event/{eventId}', 'MessageController@eventChat')->middleware('auth');
  // Get messages of chat between some user and some event
  Route::get('/message/{userId}/load/event/{eventId}', 'MessageController@loadEventMessages')->middleware('auth');
  // Send message as user
  Route::post('/message/{userId}/send/event/{eventId}', 'MessageController@sendEventMessageAsUser')->middleware('auth');
  // Send message as event
  Route::post('/message/{userId}/event/{eventId}/send', 'MessageController@sendEventMessageAsEvent')->middleware('auth');

  // Pages Chat Page
  Route::get('/chat/{userId}/page/{pageId}', 'MessageController@pageChat')->middleware('auth');
  // Get messages of chat between some user and some event
  Route::get('/message/{userId}/load/page/{pageId}', 'MessageController@loadPageMessages')->middleware('auth');
  // Send message as user
  Route::post('/message/{userId}/send/page/{pageId}', 'MessageController@sendPageMessageAsUser')->middleware('auth');
  // Send message as event
  Route::post('/message/{userId}/page/{pageId}/send', 'MessageController@sendPageMessageAsPage')->middleware('auth');

/*********************** END OF CHAT *********************/

/*********************** MAIL *********************/
//....
/*********************** END OF MAIL *********************/