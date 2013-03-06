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

/* =====================================================
    Router 
======================================================= */

(function ($) {

    var methods = {
        init: function (options) {
            return this.each(function() {
                $(this).data( $.extend({
                    "routes": {
                        boletim: function() {
                            $.ajax({
                                type:   'GET',
                                url:    url + '/_getBoletim.php',
                                success: function (r) {
                                    $("#meio").html(r);
                                }
                            });
                        },
                        default: function (argument) {
                            $.ajax({
                                type:   'GET',
                                url:    url + '/_getDefault.php',
                                success: function (r) {
                                    $("#meio").html(r);
                                }
                            });
                        }
                    }
                }, options) );
                methods.route.apply(this);
                addHashChange( $.proxy( methods.route, this ) );
            });
        },
        route: function (argument) {
            var hash = window.location.hash;
            if(hash != '') {
                hash = hash.replace( /(#[\/]*)([\w\d]+)([\/]*)/g, "$2");
                var f = $(this).data('routes')[ $.fn.basename( hash ) ];
                typeof f === "function" ? f() : $(this).data('routes')['default']()
            }
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

// Author: Tony Pinheiro
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
                window.location = window.location.href;
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

    $("#hFormLogin").login();


    /* ============================================== */
    /* Set Height for Vertical Rhythm of images
    /* ============================================ */
    $(".attachment-excerpt-thumb, .imgAnchor img").adjustVRhythm();
    $(".attachment-excerpt-thumb, .imgAnchor img").live('load', function(){
        $(this).adjustVRhythm();
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
                    var outpout = Mustache.render( template, r );
                    $('#uInfo').html(outpout);
                }
            })
            
        } else {
            $('#uInfo').html( Mustache.render( $("#t_uInfo").html(), JSON.parse($.cookie('uInfo')) ) );
        }
    }

    ajax();
});
