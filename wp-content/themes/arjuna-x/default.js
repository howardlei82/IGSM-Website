
SRS = {
	addLoadEvent: function(f) {
		var oo = window.onload; 
		if (typeof window.onload != 'function') { 
			window.onload = f; 
		} else { 
			window.onload = function() { 
				if (oo) oo(); 
				f(); 
			} 
		} 
	},
	search: {
		d: null,
		init: function() {
			var s = document.getElementById('searchQuery');
			SRS.search.d = s.value;
			s.onfocus = function() {
				if (this.value == SRS.search.d) {
					this.value = '';
					this.className = this.className.replace(new RegExp(" searchQueryIA\\b"), "");
				}
			};
			s.onblur = function() {
				if (this.value == '') {
					this.value = SRS.search.d;
					this.className += " searchQueryIA";
				}
			}
		}
	},
	comment: {
		d: {},
		init: function() {
			//Inject the default WordPress moveForm function with advanced customization.
			if (typeof addComment != 'undefined') {
				addComment._moveForm = addComment.moveForm;
				addComment.moveForm = function(commId, parentId, respondId, postId) {
					var c = this.I('cancel-comment-reply-link');
					var r = this.I(respondId);
					if(!new RegExp('\\bcommentReplyActive\\b').test(r.className))
						r.className+=" commentReplyActive";
					var r = addComment._moveForm(commId, parentId, respondId, postId);
					c._onclick = c.onclick;
					c.onclick = function() {
						var respond = addComment.I(addComment.respondId);
						respond.className = respond.className.replace(new RegExp(" commentReplyActive\\b"), "");
						return this._onclick();
					}
					return r;
				}
			}
			
			//Activate form functionality
			var els = [
				{ID: 'replyName', defaultID: 'replyNameDefault'},
				{ID: 'replyEmail', defaultID: 'replyEmailDefault'},
				{ID: 'replyURL', defaultID: 'replyURLDefault'},
				{ID: 'comment', defaultID: 'replyMsgDefault'}
			];
			for (var i=0; i<els.length; i++) {
				var e = jQuery('#' + els[i].ID);
				if (e.length) {
					e.attr('_defaultValue', jQuery('#'+els[i].defaultID).val());
					e.focus(function() {
						if (jQuery(this).val() == jQuery(this).attr('_defaultValue'))
							jQuery(this).val('').removeClass('inputIA');
					});
					e.blur(function() {
						if (jQuery(this).val() == '')
							jQuery(this).val(jQuery(this).attr('_defaultValue')).addClass('inputIA');
					});
				}
			}
			if(document.reply) {
				jQuery('#commentform').submit(function() {
					var els = [
						{ID: 'replyName', defaultID: 'replyNameDefault'},
						{ID: 'replyEmail', defaultID: 'replyEmailDefault'},
						{ID: 'replyURL', defaultID: 'replyURLDefault'},
						{ID: 'comment', defaultID: 'replyMsgDefault'}
					];
					for (var i=0; i<els.length; i++) {
						var e = jQuery('#' + els[i].ID);
						if (e.length) {
							if (e.val() == jQuery(e).attr('_defaultValue'))
								e.val('');
						}
					}
				});
				return true;
			}
			
		}
		
	},
	
	setOpacity: function (o, op) {
		if (typeof o.style.opacity != 'undefined')
			o.style.opacity = (op==1)?(0.9999999):(op);
		else if (typeof o.style.MozOpacity != 'undefined')
			o.style.MozOpacity = (op==1)?(0.9999999):(op);
		else if (typeof o.style.KhtmlOpacity != 'undefined')
			o.style.KhtmlOpacity = op;
		else if (typeof o.filters == 'object')
			o.style.filter = 'alpha(opacity='+(op*100)+')';
	}
};

menus = {
	effect: 'none',
	duration: 300,
	
	cache: [],
	active: null,
	
	enable: function() {
		if(jQuery(document.body).hasClass('menusNoJS'))
			return;
			
		//this.totalFrames = Math.ceil(this.fps * (this.duration/1000));
		//this.interval = 1000 / this.fps;
		
		this.enableWithoutAnimation();
		//this.enableMenus2();
	},
	
	enableWithoutAnimation: function() {
		jQuery('#headerMenu1 > li, #headerMenu2 > li')
		.each(function() {
			this._timer = null;
			this._ref = menus.cache.length;
			this._cache = [];
			menus.cache.push(this);
			
			jQuery('> ul > li', this)
			.each(function() {
				this._timer = null;
				var p = jQuery(this).parent().parent()[0];
				this._ref = p._cache.length;
				p._cache.push(this);
			})
			.mouseenter(function() {
				var e = jQuery(this).parent().parent()[0];
				if(e._active)
					jQuery(obj._cache[i]).removeClass('jHover');
				menus.closeAll(jQuery(this).parent().parent()[0]);
				if(this._timer)
					clearTimeout(this._timer);
				jQuery('> a', this).addClass('active');
				jQuery(this).addClass('jHover');
			})
			.mouseleave(function() {
				jQuery('> a', this).removeClass('active');
				this._timer = setTimeout('jQuery(menus.cache['+this._ref+']).removeClass("jHover");', 500);
			});
			
			
		})
		.mouseenter(function() {
			menus.closeAll();
			if(this._timer)
				clearTimeout(this._timer);
			jQuery('> a', this).addClass('active');
			jQuery(this).addClass('jHover');
		})
		.mouseleave(function() {
			jQuery('> a', this).removeClass('active');
			this._timer = setTimeout('jQuery(menus.cache['+this._ref+']).removeClass("jHover");', 500);
		});
		
		
	},
	
	closeAll: function(obj) {
		if(obj) {
			//sub menus
			for(var i=0; i<obj._cache.length; i++)
				jQuery(obj._cache[i]).removeClass('jHover');
			return;
		}
		for(var i=0; i<menus.cache.length; i++)
			jQuery(menus.cache[i]).removeClass('jHover');
	},
	
	// Currently not working properly all versions of Internet Explorer (nested overflow issue?)
	enableWithAnimation: function() {
		jQuery('#headerMenu1 > li, #headerMenu2 > li').each(function() {
			var m = jQuery('> .children', this);
			if(!m[0]) return;
			
			if(menus.effect == 'slide') {
				//get height
				m.css('opacity', 0).show();
				var h = m[0].clientHeight;
				
				//go to second dropdown
				jQuery('> li > ul.children', m).each(function() {
					var m = jQuery(this);
					m.css('opacity', 0).show();
					var w = m[0].clientWidth;
					m.hide().css('opacity', '');
					m[0]._targetWidth = w;
					
					//set initial width to 0
					m.css('width', 0);
				});
				
				m.hide().css('opacity', '');
				m[0]._targetHeight = h;
				
				//set initial height to 0
				m.css('height', 0);
			} else if(menus.effect == 'fade') {
				//set initial opacity to 0
				m.css('opacity', 0);
				
				//go to second dropdown
				jQuery('> li > ul.children', m).each(function() {
					//set initial opacity to 0
					jQuery(this).css('opacity', 0);
				});
			}
		});
		
		
		jQuery('#headerMenu1 > li, #headerMenu2 > li')
		.mouseenter(function() {
			jQuery('> a', this).addClass('active');
			var m = jQuery('> .children', this);
			m.stop().show();
			if(menus.effect == 'slide') {
				var h = m[0]._targetHeight;
				m.animate({
					height: h+'px'
				}, {
					duration: menus.duration
				});
			} else if(menus.effect == 'fade') {
				m.animate({
					opacity: 1
				}, {
					duration: menus.duration
				});
			}
		})
		.mouseleave(function() {
			jQuery('> a', this).removeClass('active');
			var m = jQuery('> .children', this);
			m.stop().show();
			if(menus.effect == 'slide') {
				m.animate({
					height: 0
				}, {
					duration: menus.duration,
					complete: function () {
						jQuery(this).hide();
					}
				});
			} else if(menus.effect == 'fade') {
				m.animate({
					opacity: 0
				}, {
					duration: menus.duration,
					complete: function () {
						jQuery(this).hide();
					}
				});
			}
		});
		
		jQuery('#headerMenu1 > li > ul > li, #headerMenu2 > li > ul > li')
		.mouseenter(function() {
			jQuery('> a', this).addClass('active');
			var m = jQuery('> .children', this);
			m.stop().show();
			if(menus.effect == 'slide') {
				w.animate({
					width: m[0]._targetWidth
				}, {
					duration: menus.duration
				});
			} else if(menus.effect == 'fade') {
				m.animate({
					opacity: 1
				}, {
					duration: menus.duration
				});
			}
		})
		.mouseleave(function() {
			jQuery('> a', this).removeClass('active');
			var m = jQuery('> .children', this);
			m.stop();
			if(menus.effect == 'slide') {
				m.animate({
					width: 0
				}, {
					duration: menus.duration,
					complete: function () {
						jQuery(this).hide();
					}
				});
			} else if(menus.effect == 'fade') {
				m.animate({
					opacity: 0
				}, {
					duration: menus.duration,
					complete: function () {
						jQuery(this).hide();
					}
				});
			}
		});
	}
};

jQuery(function() {
	
	menus.enable();
	SRS.search.init();
	SRS.comment.init();
	
	jQuery('#rss-extended')
	.mouseenter(function() {
		jQuery(this).addClass('active');
	})
	.mouseleave(function() {
		jQuery(this).removeClass('active');
	});
	
	if(document.location.hash == '#_trackbacks') {
		jQuery('#arjuna_trackbacks').show();
		jQuery('#arjuna_comments').hide();
		jQuery('#arjuna_commentTabs a.comments').removeClass('active');
		jQuery('#arjuna_commentTabs a.trackbacks').addClass('active');
	}
	
	jQuery('#arjuna_commentTabs a').click(function() {
		jQuery(this).blur();
		if(jQuery(this).hasClass('comments')) {
			jQuery('#arjuna_trackbacks').hide();
			jQuery('#arjuna_comments').show();
			jQuery(this).addClass('active');
			jQuery('#arjuna_commentTabs a.trackbacks').removeClass('active');
		} else if(jQuery(this).hasClass('trackbacks')) {
			jQuery('#arjuna_comments').hide();
			jQuery('#arjuna_trackbacks').show();
			jQuery(this).addClass('active');
			jQuery('#arjuna_commentTabs a.comments').removeClass('active');
		}
	});
	
	//image resizing
	jQuery('#contentArea div.postContent div.wp-caption').each(function() {
		if(jQuery('#contentArea div.postContent').width() < jQuery(this).outerWidth()) {
			var w = jQuery(this).outerWidth();
			var h = jQuery(this).outerHeight();
			var r = jQuery('#contentArea div.postContent').width() / w;
			jQuery(this).css('width', w * r);
			jQuery('img', this).css('width', w * r).css('height', h * r);
		}
	});
	
});
