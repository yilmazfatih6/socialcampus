	
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

/*****INBOX*****/
//User
Vue.component('users', require('./components/Inbox/User/Users.vue'));
Vue.component('inbox-user', require('./components/Inbox/User/Userblock.vue'));
//Club
Vue.component('clubs', require('./components/Inbox/Club/Clubs.vue'));
Vue.component('inbox-club', require('./components/Inbox/Club/ClubBlock.vue'));
//Event
Vue.component('events', require('./components/Inbox/Event/Events.vue'));
Vue.component('inbox-event', require('./components/Inbox/Event/EventBlock.vue'));
//Page
Vue.component('pages', require('./components/Inbox/Page/Pages.vue'));
Vue.component('inbox-page', require('./components/Inbox/Page/PageBlock.vue'));

// User Chat
Vue.component('chat-messages', require('./components/Chat/User/ChatMessages.vue'));
Vue.component('chat-form', require('./components/Chat/User/ChatForm.vue'));
Vue.component('userblock', require('./components/Chat/User/Userblock.vue'));

// Club Chat
Vue.component('clubblock', require('./components/Chat/Club/ClubBlock.vue'));
Vue.component('club-messages', require('./components/Chat/Club/ClubMessages.vue'));
Vue.component('club-form', require('./components/Chat/Club/ClubForm.vue'));

// Event Chat
Vue.component('eventblock', require('./components/Chat/Event/EventBlock.vue'));
Vue.component('event-messages', require('./components/Chat/Event/EventMessages.vue'));
Vue.component('event-form', require('./components/Chat/Event/EventForm.vue'));

// Page Chat
Vue.component('pageblock', require('./components/Chat/Page/PageBlock.vue'));
Vue.component('page-messages', require('./components/Chat/Page/PageMessages.vue'));
Vue.component('page-form', require('./components/Chat/Page/PageForm.vue'));


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

	        addMessage(data) {
	        	//Push Messages to sender's screen
	            this.messages.push(data);
	            // Send a ajax post request and persist messages to DB
	            axios.post('/message/send/'+this.userId(), data);
	        },

	        /**
	        * Getting user id from uri
	        */
	        userId() {
	    		// Get current path
	    		var curPath = window.location.pathname;
	    		// Split Path as Array
	    		var splitedPath = curPath.split('/');
	    		// Return 4rd array element which contains user id
	    		return splitedPath[3];
	    	}
	    }
	});
}

/*********** CLUB CHAT VUE INSTANCE *************/
if( $('#club-chat').length !== 0 ) {
	const clubChat = new Vue({
		el: '#club-chat',
		created() {
			this.fetchMessages();
			Echo.private('club-chat')
				.listen('ClubMessageSent', (e) => {
				    this.messages.push({
						message: e.message.message,
						sender_id: e.message.sender_id,
						receiver_id: e.message.receiver_id,
						club_id: e.message.club_id,
						sender_name: e.message.sender_name,
				    });
				});
		},
	    data: {
	        messages: [],
	       	empty: false,
	    },
	    methods: {
	    	/*Fecth messages from DB*/
	    	fetchMessages() {
	    		var getUrl = '/message/'+this.userId()+'/load/club/'+this.clubId();
	    		axios.get(getUrl).then(response => {
	    			this.messages = response.data;
	    			if(response.data.length === 0) {
	    				this.empty = true;
	    			}
	    		});
	    	},
	    	// Persist messages to DB
	    	addMessageAsUser(data) {
	        	//Push Messages to sender's screen
	            this.messages.push(data);
	            // Send a ajax post request and persist messages to DB
	            var postUrl = '/message/'+this.userId()+'/send/club/'+this.clubId();
	            axios.post(postUrl, data);
	        },
	        addMessageAsClub(data) {
	        	//Push Messages to sender's screen
	            this.messages.push(data);
	            // Send a ajax post request and persist messages to DB
	            var postUrl = '/message/'+this.userId()+'/club/'+this.clubId()+'/send';
	            axios.post(postUrl, data);
	        },
	    	/*Get club id*/
	    	clubId() {
	    		var curPath = window.location.pathname;
	    		var splitedPath = curPath.split('/');
	    		return splitedPath[4];
	    	},
	    	/*Get auth user id*/
	    	userId() {
	    		var curPath = window.location.pathname;
	    		var splitedPath = curPath.split('/');
	    		return splitedPath[1];
	    	}
	    }
	});
}

/*********** EVENT CHAT VUE INSTANCE *************/
if( $('#event-chat').length !== 0 ) {
	const eventChat = new Vue({
		el: '#event-chat',
		created() {
			this.fetchMessages();
			Echo.private('event-chat')
				.listen('EventMessageSent', (e) => {
				    this.messages.push({
						message: e.message.message,
						sender_id: e.message.sender_id,
						receiver_id: e.message.receiver_id,
						event_id: e.message.event_id,
						sender_name: e.message.sender_name,
				    });
				});
		},
	    data: {
	        messages: [],
	       	empty: false,
	    },
	    methods: {
	    	/*Fecth messages from DB*/
	    	fetchMessages() {
	    		var getUrl = '/message/'+this.userId()+'/load/event/'+this.eventId();
	    		axios.get(getUrl).then(response => {
	    			this.messages = response.data;
	    			if(response.data.length === 0) {
	    				this.empty = true;
	    			}
	    		});
	    	},
	    	// Persist messages to DB
	    	addMessageAsUser(data) {
	        	//Push Messages to sender's screen
	            this.messages.push(data);
	            // Send a ajax post request and persist messages to DB
	            var postUrl = '/message/'+this.userId()+'/send/event/'+this.eventId();
	            axios.post(postUrl, data);
	        },
	        addMessageAsAdmin(data) {
	        	//Push Messages to sender's screen
	            this.messages.push(data);
	            // Send a ajax post request and persist messages to DB
	            var postUrl = '/message/'+this.userId()+'/event/'+this.eventId()+'/send';
	            axios.post(postUrl, data);
	        },
	    	/*Get event id*/
	    	eventId() {
	    		var curPath = window.location.pathname;
	    		var splitedPath = curPath.split('/');
	    		return splitedPath[4];
	    	},
	    	/*Get auth user id*/
	    	userId() {
	    		var curPath = window.location.pathname;
	    		var splitedPath = curPath.split('/');
	    		return splitedPath[1];
	    	}
	    }
	});
}

/*********** PAGE CHAT VUE INSTANCE *************/
if( $('#page-chat').length !== 0 ) {
	const pageChat = new Vue({
		el: '#page-chat',
		created() {
			this.fetchMessages();
			Echo.private('page-chat')
				.listen('PageMessageSent', (e) => {
				    this.messages.push({
						message: e.message.message,
						sender_id: e.message.sender_id,
						receiver_id: e.message.receiver_id,
						page_id: e.message.page_id,
						sender_name: e.message.sender_name,
				    });
				});
		},
	    data: {
	        messages: [],
	       	empty: false,
	    },
	    methods: {
	    	/*Fecth messages from DB*/
	    	fetchMessages() {
	    		var getUrl = '/message/'+this.userId()+'/load/page/'+this.pageId();
	    		axios.get(getUrl).then(response => {
	    			this.messages = response.data;
	    			if(response.data.length === 0) {
	    				this.empty = true;
	    			}
	    		});
	    	},
	    	// Persist messages to DB
	    	addMessageAsUser(data) {
	        	//Push Messages to sender's screen
	            this.messages.push(data);
	            // Send a ajax post request and persist messages to DB
	            var postUrl = '/message/'+this.userId()+'/send/page/'+this.pageId();
	            axios.post(postUrl, data);
	        },
	        addMessageAsPage(data) {
	        	//Push Messages to sender's screen
	            this.messages.push(data);
	            // Send a ajax post request and persist messages to DB
	            var postUrl = '/message/'+this.userId()+'/page/'+this.pageId()+'/send';
	            axios.post(postUrl, data);
	        },
	    	/*Get page id*/
	    	pageId() {
	    		var curPath = window.location.pathname;
	    		var splitedPath = curPath.split('/');
	    		return splitedPath[4];
	    	},
	    	/*Get auth user id*/
	    	userId() {
	    		var curPath = window.location.pathname;
	    		var splitedPath = curPath.split('/');
	    		return splitedPath[1];
	    	}
	    }
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
	$(".send-friendship").submit(function(event) {
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
				// Reload bio navbar
				$(".user-bio").html(data.bio);
			}
		});
	});

	//Accept Friendship
	$('body').on('submit', '.accept-friendship', function(e) {
		e.preventDefault();
		$.ajax({
			method: $(this).attr('method'),
			url: $(this).attr('action'),
			data: $(this).serialize(),
			dataType: "json",
			success: function(data){
				/*Insert Alert*/
				$('#after').after(alertSuccess);
				$("#alert").text(data['message']);
				// Reload bio navbar
				$(".user-bio").html(data.bio);
			}
		});

	});

	//Reject Friendship
	$(".reject-friendship").submit(function(e){
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
				// Reload bio navbar
				$(".user-bio").html(data.bio);
			}
		});

	});

	//Delete Friendship
	$(".delete-friendship").submit(function(event){
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
				// Reload bio navbar
				$(".user-bio").html(data.bio);
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
				// Reload userblock buttons
				$('#friendship-btn-wrapper-'+data['username']).load('/user/info/'+data['username']+' #friendship-btn-'+data['username']);
				// Reload friends index page
				$('#friends-wrapper').load('/friends #friends');
				$('#dropdownblock-'+notification).fadeOut();
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
				// Reload userblock buttons
				$('#friendship-btn-wrapper-'+data['username']).load('/user/info/'+data['username']+' #friendship-btn-'+data['username']);
				// Reload friends index page
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
				/*reload attenders on index page*/
				$("#attenders-wrapper").load("/event/"+id+" #attenders");
				/*reload sharing on index page*/
				$("#sharing-wrapper").load("/event/"+id+" #share");
				// reload info section
				$('.event-info').html(data.info);

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
				/*reload attenders on index page*/
				$("#attenders-wrapper").load("/event/"+id+" #attenders");
				/*reload sharing on index page*/
				$("#sharing-wrapper").load("/event/"+id+" #share");
				// reload info section
				$('.event-info').html(data.info);
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
				$(".event-thumbnail-"+id).html(data.thumbnail);
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
				$(".event-thumbnail-"+id).html(data.thumbnail);
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

	// Follow page
	$('body').on('submit', '#follow-page', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				$('#after').after(alertSuccess);
				$('#alert').text(data['message']);
				$('.page-bio').html(data.bio);
			},
		});
	});


	// Unfollow page
	$('body').on('submit', '#unfollow-page', function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			method: $(this).attr('method'),
			dataType: 'json',
			success: function(data) {
				$('#after').after(alertDanger);
				$('#alert').text(data['message']);
				$('.page-bio').html(data.bio);
			},
		});
	});

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
				$('#membership-buttons').html(data.bio);
				$('#membership-buttons-xs').html(data.header);
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
				$('#membership-buttons').html(data.bio);
				$('#membership-buttons-xs').html(data.header);
				$('#quit').modal('toggle');	
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
					$('#main-nav').load('/clubs nav .container-fluid');
					//$('.navigation').load(data.nav);
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

