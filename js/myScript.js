// Author: Tony Pinheiro

(function($) {

    var methods = {
        init : function(options) {

            var defaults = $.extend({
                request : null,
                erro : '.msgErro',
                msg : '.msg',
                textMsg : 'Entrando ...',
                textErro : 'Login inválido. Tente novamente xD',
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
            //alert($(this).attr('action'));
            $.ajax({
                type : 'POST',
                url : $this.attr('action'),
                data : $this.serialize(),
                dataType : 'html',
                context : this
            }).done(function(r) {
                methods.success(r, $this);
            });

            return false;
        },
        success : function(r, form) {
            $this = form;
            if (!r) {
                //alert('Login Incorreto');
                $this.find('.popup .msgErro').text('Login incorreto, tente novamente');
                $this.find('.popup .msg').text('');
                $this.find('.loader').css('display', 'none');
                setTimeout(function() {
                    $this.find('.popup').fadeOut(200);
                }, 1500);
            } else {
                $this.find('.popup .msg').text('Redirecionando ...');
                window.location = 'Sistema/Aluno2/';
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

});
