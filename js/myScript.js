/* =====================================================
	Adjust vertical rhythm of images 
======================================================= */

(function ($) {

	var methods = {
		init: function (options) {
			return this.each(function() {
				$(this).data( $.extend({
					'vHeight': 22
				}, options) );
				methods.adjust.apply(this);
				$(window).bind('resize', $.proxy( methods.adjust, this ));
			});
		},
		reset: function() {
			var _this = $( this );
			_this.css({
				height: 'auto',
				width: 'auto'
			});
		},
		adjust: function() {
			methods.reset.apply( this );
			var _this = $( this );
			var s = _this.data();
			var oldH = _this.height();
			var ratio = _this.width() / oldH;
			var newH = ( (_this.height()/s.vHeight) >> 0 ) * s.vHeight;
			var newW = Math.round( newH * ratio );
			_this.height( newH );
			_this.width( newW );
		}
	};

	$.fn.adjustVRhythm = function(method) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
		}    
	};

})(jQuery);


/* ===================================================== */
/* Router */
/* =====================================================*/

(function ($) {

	var methods = {
		init: function (options) {
			return this.each(function() {
				$(this).data( $.extend({
					"routes": {
						"default": methods.get
					}
				}, options) );
				methods.route.apply(this);
				addHashChange( $.proxy( methods.route, this ) );
				$("#mainNav a").click( 
					$.proxy( function (e) {
						var url = $(e.target).prop('href');
						$('#meio').children().css('opacity','0.3');
						//methods.route.apply(this, [url]);
					}, this));
			});
		},
		route: function (url) {
			/* if is a normal page, return false */
			var href = window.location.href;
			var patHash = /\/#/g;
			if(!patHash.test(href))
				return false;

			var pattern = /^#[\/]*([\w\d-]+)[\/]*([\w\d-]*)[\/]*/g;
			if(typeof url === 'undefined' || typeof url === 'object') {
				var hash = window.location.hash.replace( pattern, "$1");
				var slug = window.location.hash.replace( pattern, "$2");
			} else {
				var hash = $.fn.basename(url).replace( pattern, "$1");
				var slug = window.location.hash.replace( pattern, "$2");
			}
			hash = hash === '' || hash === '#/' ? 'default' : hash;
			var f = $(this).data('routes')[ $.fn.basename( hash ) ];
			typeof f === "function" ? f(hash, slug) : $(this).data('routes')['default'](hash, slug)
		},
		html: function ( html ) {
			var m = $('#meio').children();
			m.css({
				opacity: 0,
				position: 'relative',
				top: '0px',
				left: '-15px'
			}).html( html ).stop().animate({
				opacity: 1,
				top: 0,
				left: 0
			}, 100);
		},
		get: function ( hash, slug ) {
			if(hash == 'post')
				loadScript(url+'/../../../wp-includes/js/comment-reply.min.js', {id:'comment-reply'});

			$('body').addClass('wait');
			$('#meio').children().css('opacity','0.3');
			$.ajax({
				type:   'GET',
				url:    url + '/_get-' + hash + '.php',
				data: 	{ _s: session, slug: slug },
				cache: 	false,
				success: function (r) {
					methods.render.apply($("#meio"), [r] );
				},
				error: function (r) {
					$.ajax({
						type:   'GET',
						url:    url + '/_get-default.php',
						cache: 	false,
						data: 	session,
						success: $.proxy( methods.render, $("#meio"), response ),
						error: function (r) {
							console.log('route error');
						}
					});
				}
			});
		},
		render: function ( html ) {
			$('body').removeClass('wait');
			methods.html( html );
			$(".attachment-excerpt-thumb, .imgAnchor img").imagesLoaded({
				done: function ( $images ) {
					$images.adjustVRhythm();
				}
			});
		}
	};

	$.fn.route = function(method) {
		if ( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
		}    
	};

})(jQuery);

$(window).route();

/* ===================================================== */
/* Login */
/* =====================================================*/
(function($) {

	var methods = {
		init : function(options) {

			var defaults = $.extend({
				request : null,
				erro : '.msgErro',
				msg : '.msg',
				textMsg : 'Entrando ...',
				textErro : 'Login invรกlido. Tente novamente xD',
				loader : '.loader'
			}, options);

			return this.each(function() {
				var $this = $(this);
				$this.data(defaults);
				$this.submit(function() {
					$this.find('.loader').css('display', 'inline');
					$this.find('.popup').fadeIn(200).find($this.data('msg')).text($this.data('textMsg'));
					$this.find('.popup ' + $this.data('erro')).text('');
					return methods.send.apply(this);
				});
			});

		},
		send : function() {
			$this = $(this);
			$.ajax({
				type : 'POST',
				url : $this.attr('action'),
				data : $this.serialize(),
				dataType : 'json',
				context : this
			}).done(function(r) {
				methods.success.apply(this, [r]);
			});

			return false;
		},
		success : function(r) {
			$this = $(this);
			if (!r.login) {
				$this.find('.popup .msgErro').text(r.message);
				$this.find('.popup .msg').text('');
				$this.find('.loader').css('display', 'none');
				setTimeout(function() {
					$this.find('.popup').fadeOut(200);
				}, 1500);
			} else {
				$this.find('.popup .msg').text('Redirecionando ...');
				window.location = window.location.href + "#/";
			}
		},
		error : function() {

		}
	};

	// LOGIN
	$.fn.login = function(method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if ( typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.jPopup');
		}
	};

})(jQuery);

$(document).ready(function() {

	$('a').click(function(){
		var anchor = $(this);
		var href = anchor.prop('href');
		var comment = anchor.attr('class');
		
		var patt = /#/g;
		if(patt.test(href))
			return

		patt = /commentLink/g;
		if(patt.test(comment))
			return

		var rel = /lightbox/g;
		if(rel.test(anchor.attr('rel')))
			return

		$('body').addClass('wait');
	});

	$("#hFormLogin").login();


	/* ============================================== */
	/* Set Height for Vertical Rhythm of images
	/* ============================================ */
	$(".attachment-excerpt-thumb, .imgAnchor img, .aThumb img").imagesLoaded({
		done: function ( $images ) {
			$images.adjustVRhythm();
		}
	});

	function ajax() {

		if(!$.cookie('uInfo')) {
			$('#uInfo').html('<tr><td>loading...</td></tr>');
			var data = session;
			$.ajax({
				type:       'GET',
				url:        url + '/_getHeader.php',
				cache:      false,
				data:       data, 
				dataType:   'json',
				success: function (r) {
					$.cookie('uInfo', JSON.stringify(r), { expires: 1, path: '/' });
					var template = $("#t_uInfo").html();
					var output = Mustache.render( template, r );
					$('#uInfo').html(output);
					alert($("#uInfo").html());
				}
			})
			
		} else {
			$('#uInfo').html( Mustache.render( $("#t_uInfo").html(), JSON.parse($.cookie('uInfo')) ) );
		}
	}

	ajax();
});
