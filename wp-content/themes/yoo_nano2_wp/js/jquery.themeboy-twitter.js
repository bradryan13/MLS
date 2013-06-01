// ThemeBoy Twitter Stream
function timeago(time_value) {	
	var values = time_value.split(" ");
	time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	var parsed_date = Date.parse(time_value);
	var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	delta = delta + (relative_to.getTimezoneOffset() * 60);
	var r = '';
	if (delta < 60) {
			r = 'a minute ago';
	} else if(delta < 120) {
			r = 'couple of minutes ago';
	} else if(delta < (45*60)) {
			r = (parseInt(delta / 60)).toString() + ' minutes ago';
	} else if(delta < (90*60)) {
			r = 'an hour ago';
	} else if(delta < (24*60*60)) {
			r = '' + (parseInt(delta / 3600)).toString() + ' hours ago';
	} else if(delta < (48*60*60)) {
			r = '1 day ago';
	} else {
			r = (parseInt(delta / 86400)).toString() + ' days ago';
	}
	return r;
};
String.prototype.hashify = function() {
		return this.replace(/#([A-Za-z0-9\/\.]*)/g, function(m) {
				return '<a target="_blank" href="http://twitter.com/search?q=' + m.replace('#','') + '">' + m + "</a>";
		});
};
String.prototype.linkify = function(){
		return this.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&\?\/.=]+/, function(m) {
				return '<a target="_blank" href="' + m + '">' + m + "</a>";
		});
};
String.prototype.atify = function() {
		return this.replace(/@[\w]+/g, function(m) {
				return '<a target="_blank" href="http://www.twitter.com/' + m.replace('@','') + '">' + m + "</a>";
		});
};
(function($){
	$.fn.twitter = function(options) {
		
		var defaults = {
			limit: 10,
			display_avatar: true
		};
		var options = $.extend(defaults, options);
		
		username = options.username;
		
		var self = this;
		
		$.getJSON('http://api.twitter.com/1/statuses/user_timeline.json?callback=?&include_rts=1&count=' + options.limit + '&screen_name=' + username,
		function(obj) {
			self.find('.loading').remove();
			self.append(
				'<div class="profile">' +
				(options.display_avatar ? ('<img class="profile_image" src="' + obj[0].user.profile_image_url + '" />') : '') +
				'<div class="username ellipsis"><a href="http://twitter.com/intent/user?&user_id=' + obj[0].user.id + '">' + obj[0].user.name + '</a></div>' +
				'<div class="follow"><a href="http://twitter.com/intent/user?user_id=' + obj[0].user.id + '">follow</a></div>' +
				'</div>'
			);
			if (options.limit > 0) {
				self.append('<ul class="tweets">');
				var count = 0;
				$.each(obj, function(index, value) {
					count++;
					$(self).find('ul.tweets').append(
						'<li class="tweet ' + (count % 2 == 0 ? 'even' : 'odd') + (count >= options.limit ? ' last' : '') + '">' +
						'<p class="text">' + value.text.linkify().atify().hashify() + '</p>' +
						'<ul class="intents">' +
						'<li><a href="http://twitter.com/' + username + '/status/' + value.id_str + '" target="_blank">' + timeago(value.created_at) + '</a></li>' +
						'<li><a href="http://twitter.com/intent/tweet?in_reply_to=' + value.id_str + '">Reply</a></li>' +
						'<li><a href="http://twitter.com/intent/retweet?tweet_id=' + value.id_str + '">Retweet</a></li>' +
						'<li class="last"><a href="http://twitter.com/intent/favorite?tweet_id=' + value.id_str + '">Favorite</a></li>' +
						'</ul>' +
						'</li>' +
						"\n");
				});
				self.append('</ul>');
			}
		});
	};
})(jQuery);