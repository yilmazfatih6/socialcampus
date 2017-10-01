
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('chat-messages', require('./components/Chat/ChatMessages.vue'));
Vue.component('chat-form', require('./components/Chat/ChatForm.vue'));
Vue.component('userblock', require('./components/Chat/Userblock.vue'));
Vue.component('users', require('./components/Inbox/Users.vue'));
Vue.component('inbox-user', require('./components/Inbox/Userblock.vue'));
Vue.component('clubblock', require('./components/Chat/ClubBlock.vue'));

// Personal Chat Vue Instance
if( $('#personal-chat').length !== 0 ) {
	const personalChat = new Vue({
	    el: '#personal-chat',

	    data: {
	        messages: []
	    },

	    /*
		* Everything typed in listen method happens on other user's screen
		* Not in sender's Screen
	    */
	    created() {
	        this.fetchMessages();
	        Echo.private('chat')
				.listen('MessageSent', (e) => {
				    this.messages.push({
						message: e.message.message,
						sender_id: e.message.sender_id,
						receiver_id: e.message.receiver_id
				    });
				});
	    },

	 	methods: {
	 		/**
	 		* Load messages from DB
	 		*/
	        fetchMessages() {
	            axios.get('/message/load/'+this.userId()).then(response => {
	                this.messages = response.data;
	            });
	        },

	        addMessage(message) {
	        	//Push Messages to sender's screen
	            this.messages.push(message);
	            // Send a ajax post request and persist messages to DB
	            axios.post('/message/send/'+this.userId(), message);
	        },

	        /**
	        * Getting user id from uri
	        */
	        userId() {
	    		// Get current path
	    		var curpath = window.location.pathname;
	    		// Split Path as Array
	    		var splitedPath = curpath.split('/');
	    		// Return 4rd array element which contains user id
	    		return splitedPath[3];
	    	}
	    }
	});
}

// Personal Chat Vue Instance
if( $('#club-chat').length !== 0 ) {
	const clubChat = new Vue({
		el: '#club-chat',

	    data: {
	        messages: []
	    },
	});
}

/*********************************************************************
**			 		    	JQUERY                     				**
**********************************************************************/
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
/*Global Alert Variables*/
var alertSuccess = '<div id="popup-alert" class="alert alert-success alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b id="alert"></b></div>'
var alertDanger = '<div id="popup-alert" class="alert alert-danger alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b id="alert"></b></div>'
var alertWarning = '<div id="popup-alert" class="alert alert-warning alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><b id="alert"></b></div>'
/************** DOCUMENT READY PART *************/
$(document).ready(function(){

/************************ STATUS ************************************/
	// Text Area Expand
	$('body').on('keyup', 'textarea', function() {
		this.style.height = "1px";
		this.style.height = (this.scrollHeight)+"px";
	});

	// Extend Status
	$('body').on('click', '.extend-status', function() {
		var id = $(this).attr("data-status-id");
		$.ajax({
			method: "GET",
			url: "/status/extend/"+id,
			success: function(data){
				$("#status-body-"+id).html(data['status']);
			}
		});
	});
	// Shorten Status
	$('body').on('click', '#shorten-status', function() {
		var id = $(this).attr("data-status-id");
		$.ajax({
			method: "GET",
			url: "/status/shorten/"+id,
			success: function(data){
				$("#status-body-"+id).html(data['status']);
			}
		});
	});
	// Extend Event Description
	$('body').on('click', '.extend-desc', function() {
		var id = $(this).attr("data-event-id");
		$.ajax({
			method: "GET",
			url: "/event/"+id+"/extend/description",
			success: function(data){
				$("#description").html(data['description']);
			}
		});
	});
	// Shorten Event Description
	$('body').on('click', '.shorten-desc', function() {
		var id = $(this).attr("data-event-id");
		$.ajax({
			method: "GET",
			url: "/event/"+id+"/shorten/description",
			success: function(data){
				$("#description").html(data['description']);
			}
		});
	});
/************************ END OF EXTEND STATUS ************************************/

/************************ HOME ************************************/
	$( "#btn-hp-signin" ).slideDown(250, function() {
		$("#btn-hp-signin").css('display', 'block');
	});
	$( "#btn-hp-signup" ).slideDown(500, function() {
		$("#btn-hp-signup").css('display', 'block');
	});
	$( "#btn-hp-info" ).slideDown(750, function() {
		$("#btn-hp-info").css('display', 'block');
	});
	// Scroll To Clubs
	$("#btn-hp-info").click(function (){
                $('html, body').animate({
                    scrollTop: $("#hp-content").offset().top
                }, 500);
            });
	// Scroll To Signup
	$("#hp-scroll-to-signup").click(function (){
                $('html, body').animate({
                    scrollTop: $("#hp-signup").offset().top
                }, 500);
            });
	// Scroll To Signup
	$("#hp-scroll-to-top").click(function (){
                $('html, body').animate({
                    scrollTop: $("#hp-welcome").offset().top
                }, 500);
            });
/************************ END OF HOME ************************************/

/************************ AUTH ************************************/
	//Signin
	$("#signin-form").submit(function(event){
		event.preventDefault();
		$.ajax({
			method: "POST",
			url: "/signin",
			data: $("#signin-form").serialize(),
			dataType: "json",
		})
			.done(function(data){
				if( data['status'] == 0 )
				{
					$("#signin-alert").addClass("alert alert-danger");
					$("#signin-alert").text(data['message']);
					$("#username").val("");
					$("#password").val("");
				}
				else if( data['status'] == 1 )
				{
					$("#signin-alert").addClass("alert alert-danger");
					$("#signin-alert").text(data['message']);
					$("#password").val("");
				}
				else if( data['status'] == 2 )
				{
					window.location.replace('/');
				}
			});
	});
/************************ END OF AUTH ************************************/

/********************* FRIENDS ******************************/
	// Send Friendship
	$("#send-friendship").submit(function(event) {
		event.preventDefault();
		$.ajax({
			method: "POST",
			url: $(this).attr('action'),
			data: $(this).serialize(),
			dataType: "json",
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertSuccess);
				$("#alert").text(data['message']);
				$("#friendship-buttons-ul").load("/user/"+data['username']+" #friendship-buttons-li");
			}
		});
	});

	//Accept Friendship
	$('body').on('submit', '#accept-friendship', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			data: $(this).serialize(),
			dataType: "json",
			success: function(data){
				console.log(data.username);
				console.log(data['username']);
				/*Insert Alert*/
				$('#after').after(alertSuccess);
				$("#alert").text(data['message']);
				$("#friendship-buttons-ul").load("/user/"+data['username']+" #friendship-buttons-li");
			}
		});

	});

	//Reject Friendship
	$("#reject-friendship").submit(function(e){
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			data: $(this).serialize(),
			dataType: "json",
			success: function(data){
				/*Insert Alert*/
				$('#after').after(alertDanger);
				$("#alert").text(data['message']);
				$("#friendship-buttons-ul").load("/user/"+data['username']+" #friendship-buttons-li");
			}
		});

	});

	//Delete Friendship
	$("#delete-friendship").submit(function(event){

		event.preventDefault();
		$.ajax({
			method: "POST",
			url: $(this).attr("action"),
			data: $(this).serialize(),
			dataType: "json",
			success: function(data){
				/*Insert Alert*/
				$('#after').after(alertDanger);
				$("#alert").text(data['message']);
				$("#friendship-buttons-ul").load("/user/"+data['username']+" #friendship-buttons-li");
			}
		});

	});

	// Send Friendship Quick
	$('body').on('submit', '#send-friendship-quick', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				$('#after').after(alertSuccess);
				$('#alert').text(data['message']);
				$('#friendship-btn-wrapper-'+data['username']).load('/user/info/'+data['username']+' #friendship-btn-'+data['username']);
			}
		});
	});

	// Delete Friendship Quick
	$('body').on('submit', '#delete-friendship-quick', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				$('#after').after(alertDanger);
				$('#alert').text(data['message']);
				$('#friendship-btn-wrapper-'+data['username']).load('/user/info/'+data['username']+' #friendship-btn-'+data['username']);
			}
		});
	});

	// Accept Friendship Quick
	$('body').on('submit', '#accept-friendship-quick', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				$('#after').after(alertSuccess);
				$('#alert').text(data['message']);
				$('#friends-wrapper').load('/friends #friends');
			}
		});
	});

	// Reject Friendship Quick
		$('body').on('submit', '#reject-friendship-quick', function(e) {
		e.preventDefault();
		var notification = 0;
		notification = $(this).attr('data-notification-id');

		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertDanger);
				$('#alert').text(data['message']);
				$('#friends-wrapper').load('/friends #friends');
				$('#dropdownblock-'+notification).fadeOut();
			}

		});
	});
/************************ END OF FRIENDS ********************************/

/************************ EVENTS ********************************/
	// Attend to Event
	$('body').on('submit', '#attend-event', function(e) {
		event.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertSuccess);
				$("#alert").text(data['message']);
				/*Refreshing some sections*/
				$("#attender-num-wrap").load("/event/"+id+" #attender-num");
				/*reload attenders*/
				$("#attenders-wrapper").load("/event/"+id+" #attenders");
				/*Reload Event Buttons in Event Button Wrapper*/
				$("#ebw").load("/event/"+id+" #eb");
				$("#event-message").load("/event/"+id+" #message");
				$("#sharing-wrapper").load("/event/"+id+" #share");

			}
		});
	});
	// Quit Event
	$('body').on('submit', '#quit-event', function(e) {
		event.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertDanger);
				$("#alert").text(data['message']);
				/*Refreshing some sections*/
				$("#attender-num-wrap").load("/event/"+id+" #attender-num");
				/*reload attenders*/
				$("#attenders-wrapper").load("/event/"+id+" #attenders");
				/*Reload Event Buttons in Event Button Wrapper*/
				$("#ebw").load("/event/"+id+" #eb");
				$("#event-message").load("/event/"+id+" #message");
				$("#sharing-wrapper").load("/event/"+id+" #share");
			}
		});
	});
	// Attend to Event Quick
	$('body').on('submit', '#attend-event-quick', function(e) {
		event.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertSuccess);
				$("#alert").text(data['message']);
				/*Refreshing some sections*/
				$("#aw-"+id).load("/eventblock/"+id+" #attenders-"+id);
				$("#bw-"+id).load("/eventblock/"+id+" #buttons-"+id);
			}
		});
	});
	// Quit to Event Quick
	$('body').on('submit', '#quit-event-quick', function(e) {
		event.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertDanger);
				$("#alert").text(data['message']);
				/*Refreshing some sections*/
				$("#aw-"+id).load("/eventblock/"+id+" #attenders-"+id);
				$("#bw-"+id).load("/eventblock/"+id+" #buttons-"+id);
			}
		});
	});
	//Kick User from Event
	$('body').on('submit', '#event-kick-user', function(e) {
		event.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertDanger);
				$("#alert").text(data['message']);
				/*reload attenders*/
				$("#attenders-wrapper").load("/event/"+data['event_id']+" #attenders");
			}
		});
	});
	// Make User Event Admin
	$('body').on('submit', '#event-make-admin', function(e) {
		event.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertWarning);
				$("#alert").text(data['message']);
				/*reload attenders*/
				$("#attenders-wrapper").load("/event/"+data['event_id']+" #attenders");
				/*reload attenders*/
				$("#admins-wrapper").load("/event/"+data['event_id']+" #admins");
			}
		});
	});
/************************ END OF EVENTS ********************************/

/************************ PAGES ********************************/
	// Follow Page Quick
	$('body').on('submit' , '#follow-page-quick' , function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertSuccess);
				$('#alert').text(data['message']);
				$('#button-wrapper-'+id).load('/pages #button-'+id);
			}
		});
	});

		// Unfollow Page Quick
	$('body').on('submit', '#unfollow-page-quick', function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				/*Insert Alert*/
				$('#after').after(alertDanger);
				$('#alert').text(data['message']);
				$('#button-wrapper-'+id).load('/pages #button-'+id);
			}

		});
	});
/************************ END OF PAGES ********************************/

/************************ CLUBS ********************************/
	// Accept Member
	$('body').on('submit', '#club-accept-member', function(e) {
		e.preventDefault();

		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				$('#after').after(alertSuccess);
				$('#alert').text(data.message);
				$('#userblock-'+data.id).fadeOut();
			},
		});
	});

	// Reject Member
	$('body').on('submit', '#club-reject-member', function(e) {
		e.preventDefault();

		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				$('#after').after(alertDanger);
				$('#alert').text(data.message);
				$('#userblock-'+data.id).fadeOut();
			},
		});
	});

	// Kick Member
	$('body').on('submit', '#club-kick-user', function(e) {
		e.preventDefault();

		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: "json",
			success: function(data) {
				$('#after').after(alertDanger);
				$('#alert').text(data['message']);
				$('#userblock-'+data['id']).fadeOut();
			},
		});
	});

	// Join To A Club
	$('body').on('submit', '#join-club', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				$('#after').after(alertSuccess);
				$('#alert').text(data['message']);
				$('#membership-buttons-ul').load('/club/'+data['abbr']+' #membership-buttons-div');
			},
		});
	});

	// Quit A Club
	$('body').on('submit', '#quit-club', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				$('#after').after(alertDanger);
				$('#alert').text(data['message']);
				$('#membership-buttons-ul').load('/club/'+data['abbr']+' #membership-buttons-div');
			},
		});
	});

	// Join To A Club Quick
	$('body').on('submit', '#join-club-quick', function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				$('#after').after(alertSuccess);
				$('#alert').text(data['message']);
				$('#button-wrapper-'+id).load('/clubs #button-'+id);
			},
		});
	});

	// Quit From A Club Quick
	$('body').on('submit', '#quit-club-quick', function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				$('#after').after(alertDanger);
				$('#alert').text(data['message']);
				$('#button-wrapper-'+id).load('/clubs #button-'+id);
			},
		});
	});
/************************ END OF CLUBS ********************************/

/************************ NOTIFICATIONS ********************************/
	/* Mark As Read*/
		$('body').on('click', '#mark-as-read', function() {
		var id = $(this).attr('data-id');
		$.ajax({
			url: '/markAsRead/'+id,
			method: 'get',
			dataType: 'json',
		});
	});

		/* Mark As Read All*/
		$('body').on('click', '#mark-as-read-all', function(e) {
			e.preventDefault();
			$.ajax({
				url: '/markAsReadAll',
				method: 'get',
				dataType: 'json',
				success: function(data) {
					$('nav').load('/clubs nav .container-fluid');
			}
		});
	});
/************************ END OF NOTIFICATIONS ********************************/

/************************ LORD ********************************/
	// Confirm Clubs
	$('body').on('submit', '#lord-confirm-club', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			dataType: 'json',
			success: function(data) {
				$('#after').after(alertSuccess);
				$('#alert').text(data['message']);
				$('#club-requests-wrapper').load('/sks #club-requests');
				$('#active-clubs-wrapper').load('/sks #active-clubs');
			}
		});
	});

	// Reject Clubs
	$('body').on('submit', '#lord-reject-club', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			dataType: 'json',
			success: function(data) {
				$('#after').after(alertDanger);
				$('#alert').text(data['message']);
				$('#club-requests-wrapper').load('/sks #club-requests');
				$('#active-clubs-wrapper').load('/sks #active-clubs');
			}
		});
	});
/************************ END OF LORD ********************************/

/************************ STATUSES ********************************/
	// Make Comment
	 $('body').on('submit', '#make-comment', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			data: $(this).serialize(),
			dataType: 'json',
			success: function(data){
					if( data.message ) {
						$('#after').after(alertDanger);
						$('#alert').text(data.message);
					}
					var myUrl = "/status/"+data['id'];
					var tag = "#status-"+data['id'];
					$(tag).load(myUrl+" #sc-"+data['id'])
				}
		});
	});

	 // Like Status
	 $('body').on('submit', '.like-status', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			dataType: 'json',
			success: function(data){
				if(data['message'])
				{
					$('#after').after(alertDanger);
					$('#alert').text(data['message']);
				}
				var url = "/status/"+data['id'];
				$("#sf-"+data['id']).load(url+" #sf-ul-"+data['id']);
			}
		});
	});

	  // Dislike Status
	 $('body').on('submit', '.dislike-status', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			dataType: 'json',
			success: function(data){
				if(data['message'])
				{
					$('#after').after(alertDanger);
					$('#alert').text(data['message']);
				}
				var url = "/status/"+data['id'];
				$("#sf-"+data['id']).load(url+" #sf-ul-"+data['id']);
			}
		});
	});

	 // Delete Status
	 $('body').on('submit', '.delete-status', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			dataType: 'json',
			success: function(data){
				$('#status-'+data['id']).fadeOut();
				if(data.message) {
					$('#after').after(alertDanger);
					$('#alert').text(data['message']);
					$('#popup-alert').fadeOut(data.duration);
				}
			}
		});
	});

  	// Delete Reply
	 $('body').on('submit', '.delete-reply', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			dataType: 'json',
			success: function(data){
				$('#reply-'+data['id']).fadeOut();
				$('#after').after(alertDanger);
				$('#alert').text(data.message);
				$('#popup-alert').fadeOut(data.duration);
			}
		});
	});
/************************ END OF STATUSES ********************************/

/************************ TABS ********************************/
	// Tabs
		$('#tabs a').click(function(e) {
			e.preventDefault();
			$(this).tab('show');
		});

		// store the currently selected tab in the hash value
		$("ul.nav-pills > li > a").on("shown.bs.tab", function(e) {
			var id = $(e.target).attr("href").substr(1);
			window.location.hash = id;
		});

		// on load of the page: switch to the currently selected tab
		var hash = window.location.hash;
		$('#tabs a[href="' + hash + '"]').tab('show');
	// End of Tabs
/************************ END OF TABS ********************************/

/************************ SEARCH ********************************/
	// Auto Search on Typing
	$('body').on('keyup', '#search-page-form', function(e) {
		$(this).submit();
	});
	// Auto Search on Restrict Change
	$('body').on('click', 'input[name="restrict"]', function(e) {
		$("#search-page-form").submit();
	});
	//Search Steps
	$('body').on('submit', '#search-page-form', function(e) {
		e.preventDefault();
		// Push Query to Browser History
		history.pushState(null, null, "/searchengine?"+$(this).serialize());
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			data: $(this).serialize(),
		}).done(function(data) {
			$('#results').html(data);
		}).fail(function () {
			 /*Insert Alert*/
			$('#after').after(alertDanger);
			$("#alert").text("Üzgünüz bir hata oluştu.");
		});
	});
/************************ END OF SEARCH ********************************/

/************************ PAGINATION ********************************/
	// Pagination
	$(function() {
		$('body').on('click', '.pagination a', function(e) {
			e.preventDefault();

			var url = $(this).attr('href');

			getData(url);

			//Code for users to bookmark this page
			//window.history.pushState("", "", url);
		});

		function getData(url) {
			$.ajax({
				url : url
			}).done(function (data) {
				if( url.indexOf("admins") >= 0 ) {
					$('.admins').html(data);
				} else if( url.indexOf("attenders") >= 0 ) {
					$('.attenders').html(data);
				} else if( url.indexOf("requested_clubs") >= 0 ) {
					$('section.requested').html(data);
				} else if( url.indexOf("owned_clubs") >= 0 ) {
					$('section.owned').html(data);
				} else if( url.indexOf("other_clubs") >= 0 ) {
					$('section.otherClubs').html(data);
				} else if( url.indexOf("joined_clubs") >= 0 ) {
					$('section.joinedClubs').html(data);
				} else if( url.indexOf("all_clubs") >= 0 ) {
					$('section.allClubs').html(data);
				} else {
					$('.results').html(data);
				}

			}).fail(function () {
				 /*Insert Alert*/
				$('#after').after(alertDanger);
				$("#alert").text("Üzgünüz bir hata oluştu.");
			});
		}
	});
/************************ END OF PAGINATION ********************************/

/********************************* INPUT FILES ********************************/
	$('#file-name-avatar').click(function() {
		$('#select-file-avatar').show();
		$('#select-file-avatar').change(function() {
			if( $('#select-file-avatar').val() == '' ) {
				var filename = "Fotoğraf Seç";
			} else {
				var filename = $('#select-file-avatar').val().split('\\').pop();
			}
			$('#file-name-avatar').text(filename);
	   	});
	});
	$('#file-name-cover').click(function() {
		$('#select-file-cover').show();
		$('#select-file-cover').change(function() {
			if( $('#select-file-cover').val() == '' ) {
				var filename = "Fotoğraf Seç";
			} else {
				var filename = $('#select-file-cover').val().split('\\').pop();
			}
			$('#file-name-cover').text(filename);
	   	});
	});
	$('.posting-image').click(function() {
		$('.posting-select-image').show();
		$('.posting-select-image').change(function() {
			if( $('.posting-select-image').val() == '' ) {
				var filename = "Fotoğraf Seç";
			} else {
				var filename = $('.posting-select-image').val().split('\\').pop();
			}
			$('.selected-file-name').html('<i class="fa fa-check color-green" aria-hidden="true"></i> '+filename);
	   	});
	});
	$('.posting-video').click(function() {
		$('.posting-select-video').show();
		$('.posting-select-video').change(function() {
			if( $('.posting-select-video').val() == '' ) {
				var filename = "Fotoğraf Seç";
			} else {
				var filename = $('.posting-select-video').val().split('\\').pop();
			}
			$('.selected-file-name').html('<i class="fa fa-check color-green" aria-hidden="true"></i> '+filename);
	   	});
	});
	// General File Input Name Shower
	$('.file-select').click(function() {
		$('.file-input').show();
		$('.file-input').change(function() {
			if( $('.file-input').val() == '' ) {
				var filename = "Fotoğraf Seç";
			} else {
				var filename = $('.file-input').val().split('\\').pop();
			}
			$('.file-name').html('<i class="fa fa-check color-green" aria-hidden="true"></i> '+filename);
	   	});
	});
/********************************* END OF INPUT FILES *********************************/

/********************************* ACCORDION COLLAPSE *********************************/
	$('.share-at-clubs').click(function() {
		$('#my-events').collapse('hide');
		$('#my-pages').collapse('hide');
	});
	$('.share-at-events').click(function() {
		$('#my-clubs').collapse('hide');
		$('#my-pages').collapse('hide');
	});
	$('.share-at-pages').click(function() {
		$('#my-clubs').collapse('hide');
		$('#my-events').collapse('hide');
	});
/********************************* END OF ACCORDION COLLAPSE *********************************/
/********************************* CHANGING TIMELINE POSTING *********************************/
	// Load Club Posting
	$('.share-at-club-media').click(function(){
		$.ajax({
			url: '/posting/load/club/'+$(this).attr('data-id'),
			method: 'get',
		}).done(function(data){
			$('section.posting').html(data);
			$('#share-at').modal('hide');
			$('.share-at-name').text('Kulüp');
		}).fail(function(){
			alert("Hoaydaa hata verdik galiba malız... :(");
		});
	});
	// Load Event Posting
	$('.share-at-event-media').click(function(){
		console.log("seether");
		$.ajax({
			url: '/posting/load/event/'+$(this).attr('data-id'),
			method: 'get',
		}).done(function(data){
			$('section.posting').html(data);
			$('#share-at').modal('hide');
			$('.share-at-name').text('Etkinlik');
		}).fail(function(){
			alert("Hoaydaa hata verdik galiba malız... :(");
		});
	});
	// Load Page Posting
	$('.share-at-page-media').click(function(){
		console.log("seether");
		$.ajax({
			url: '/posting/load/page/'+$(this).attr('data-id'),
			method: 'get',
		}).done(function(data){
			$('section.posting').html(data);
			$('#share-at').modal('hide');
			$('.share-at-name').text('Sayfa');
		}).fail(function(){
			alert("Hoaydaa hata verdik galiba malız... :(");
		});
	});
/************* END OF CHANGING TIMELINE POSTING **************/
});

