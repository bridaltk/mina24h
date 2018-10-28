(function($) {
	"use strict";
	$(document).ready(function() {
		$('.btn-handling').on( 'click' , function(e) {
            e.preventDefault();
            $(this).parents('.even').find('.popup-bg').fadeIn();
            $(this).parents('.even').find('.popup-handling').fadeIn();
        });
        $('.ph-cancel').on( 'click' , function(e) {
            e.preventDefault();
            $(this).parents('.even').find('.popup-bg').fadeOut();
            $(this).parents('.even').find('.popup-handling').fadeOut();
        });


        /* [ Update Withdrawal ]
        ---------------------------------*/
        $( '.handlingForm' ).on( 'submit', function(e) {
            e.preventDefault();
            var number_handling = $(this).find( 'input[name="number_handling"]' ).val();
            var login_name = $(this).find( 'input[name="login_name"]' ).val();
            var number_array = $(this).find( 'input[name="number_array"]' ).val();
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: {
                    action: 'handling',
                    nh: number_handling,
                    ln: login_name,
                    na: number_array,
                }
            }).done(function() {
              window.location.reload();
            });
        });

        /* [ Update Withdrawal ]
        ---------------------------------*/
        $( '.orderPost' ).on( 'change', function(e) {
            e.preventDefault();
            var date_start = $(this).find( 'input[name="date_start"]' ).val();
            var date_end = $(this).find( 'input[name="date_end"]' ).val();
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: {
                    action: 'orderDate',
                    ds: date_start,
                    de: date_end,
                }
            }).done(function() {
              window.location.reload();
            });
        });

        // Remove ACF Field in Register_form 
        $( '#registerform .acf-field, #registerform .acf-tab-wrap' ).each(function(index, el) {
            $( this ).remove();
        });
        $( '#registerform #acf-form-data' ).each(function(index, el) {
           $( this ).next().remove();
           $( this ).remove(); 
        });
	});
})(jQuery);