(function($) {
    "use strict";
    $(document).ready(function() {

        /*  [ Main Menu ]
        - - - - - - - - - - - - - - - - - - - - */
        $( '.main-menu .sub-menu' ).each(function() {
            $( this ).parent().addClass( 'has-child' ).find( '> a' ).append( '<span class="arrow"><i class="fa fa-angle-down"></i></span>' );
        });
        $( '.main-menu .arrow' ).on( 'click', function(e) {
            e.preventDefault();
            $( '.main-menu .arrow' ).not(this).parents( 'li' ).find( '> .sub-menu' ).slideUp( 'fast' );
            $( this ).parents( 'li' ).find( '> .sub-menu' ).slideToggle( 'fast' );
        });

        $( '.mobile-menu' ).on( 'click', function() {
            $( this ).parents( '.main-menu' ).toggleClass('open');
        });
        $( '.header-account-main .trigger-menu' ).on('click', function(event) {
            event.preventDefault();
            $( 'body' ).toggleClass('openNav_user');
        });
        
        $( '.trigger-menu' ).on('click', function(event) {
            event.preventDefault();
            $( 'body' ).toggleClass('openNav');
        });            

        /*  [ Responsive ]
        - - - - - - - - - - - - - - - - - - - - */
            function navMenu() {
                $( '.main-menu' ).each(function(index, el) {
                    var _this = $( this );
                    if( $( window ).width() > 992 ) {
                        _this.appendTo('.site-header');
                    }  else {
                        _this.appendTo('body');
                    }
                });
            }
            navMenu();
            $( window ).resize(function(event) {
                /* Act on the event */
                navMenu();
            });

            function navMenu() {
                $( '.main-menu' ).each(function(index, el) {
                    var _this = $( this );
                    if( $( window ).width() > 992 ) {
                        _this.appendTo('.site-header');
                    }  else {
                        _this.appendTo('.member-main');
                    }
                });
            }
            navMenu();
            $( window ).resize(function(event) {
                /* Act on the event */
                navMenu();
            });

        /*Search Form Header*/
        $('.search-button').on('click', function() {
            $('.menu-search').fadeToggle();
        });

        $('.top-list-item').wrapAll('<div class="top-blogs-list" />');
        $('.new-list-item').wrapAll('<div class="top-blogs-list" />');
        $('.widget-top').wrapAll('<div class="col-lg-9 col-md-12 col-sm-12 col-12" />');
        $('.widget-bottom').wrapAll('<div class="col-lg-3 col-md-0" />');
        $('#media_image-4').wrapAll('<div id="div_widget" />');

        /*Blogs slider*/
        $('.blogs-slider').owlCarousel({
            loop: true,
            autoplay: false,
            autoplaySpeed: 1000,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            items: 4,
            margin: 30,
            dots: false,
            nav: true,
            navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
            responsive: {
                0: {
                    items: 1,
                },
                400: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                }
            }
        });
        $('.blogs-slider').find('.owl-nav').removeClass('disabled');
        $('.blogs-slider').on('changed.owl.carousel', function(event) {
            $(this).find('.owl-nav').removeClass('disabled');
        });

        /* [ Close banner header ]
        ---------------------------------*/
        $('.banner-header .close').on('click', function() {
            $(this).parent().fadeOut();
        });

        /* [ Submenu account post ]
        ---------------------------------*/
        $( '.member-menu .sub-menu' ).each(function() {
            $( this ).parent().addClass( 'has-child' ).find( '> a' ).addClass('sub-link').append( '<span class="arrow"><i class="fa fa-angle-down"></i></span>' );
        });
        $( '.member-menu .sub-link' ).on( 'click', function(e) {
            e.preventDefault();
            $( '.member-menu .sub-link' ).not(this).parent().find( '> .sub-menu' ).slideUp( 'fast' );
            $( this ).parent().find( '> .sub-menu' ).slideToggle( 'fast' );
        });
        /* [ menu member popup ]
        ---------------------------------*/
        $('.member-title').on('click', function(e) {
            e.preventDefault();
            $('.member-bg').fadeToggle(0);
            $(this).parents('.header-right').find('.noti-detail').fadeOut(0);
            $(this).parents('.header-right').find('.noti-bg').fadeOut(0);
            $('.member-alert').fadeToggle(function() {
                $(this).focus();
            });
        });
        $('.member-bg').on('click', function() {
            $(this).fadeOut(0);
            $('.member-alert').fadeOut(0);
        });
        $('.notification-icon').on('click', function(e) {
            e.preventDefault();
            $('.noti-bg').fadeToggle(0);
            $(this).parents('.header-right').find('.member-alert').fadeOut(0);
            $(this).parents('.header-right').find('.member-bg').fadeOut(0);
            $('.noti-detail').fadeToggle(function() {
                $(this).focus();
            });
            $(this).find('span').remove();
            var current_user = $('input[name="current_user"]').val();
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: {
                    action: 'current_user',
                    cu: current_user,
                }
            });
        });
        $('.noti-bg').on('click', function() {
            $(this).fadeOut(0);
            $('.noti-detail').fadeOut(0);
        });

        /* [ Member edit ]
        ---------------------------------*/
        $('.field-input input').attr('disabled','disabled');
        $('.field-input input').addClass('no-border');
        $('.page-template-page-user .member-main-sidebar .custom-file-upload').hide();
        $('.page-template-page-user #wp-content-wrap').hide();
        
        $('.member-edit').on('click', function() {
            $(this).parent().find('input').fadeToggle(0);
            $(this).fadeOut(0);
            $(this).parents('.user-update').find('.field-input input').removeAttr('disabled');
            $(this).parents('.user-update').find('.field-input input').removeClass('no-border');
            $('.member-main-sidebar .custom-file-upload').show();
            $('.page-template-page-user #wp-content-wrap').show();
            $('.about-me').hide();
        });

        $('.input-update').on('click', function() {
            $(this).fadeOut(0);
        });

        /* [ Update Withdrawal ]
        ---------------------------------*/
        var typingTimer;                //timer identifier
        var doneTypingInterval = 100;  //time in ms, 5 second for example
        var $input = $('#withdraw_number');

        //on keyup, start the countdown
        $input.on('keyup', function () {
            clearTimeout(typingTimer);
            $input.parents( 'form' ).find( '.submit-money' ).prop('disabled', false);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        //on keydown, clear the countdown 
        $input.on('keydown', function () {
            $input.parents( 'form' ).find( '.submit-money' ).prop('disabled', false);
            clearTimeout(typingTimer);
        });
        function doneTyping () {
            var point = $input.val();
            var checkpoint = $('#checkpoint').text();
            if ( parseInt(checkpoint) <= parseInt(point) ) {
                alert('Xin lỗi! Số Point của bạn không đủ để thực hiện giao dịch.');
                $input.parents( 'form' ).find( '.submit-money' ).prop('disabled', true);
            } else {
                $input.parents( 'form' ).find( '.submit-money' ).prop('disabled', false);
            }
        }
        $('#withdraw_form').on('submit', function(e) {
            e.preventDefault();
            var withdraw_number = $(this).find('input[name="withdraw_number"]').val();
            var withdraw_content = $(this).find('textarea[name="withdraw_content"]').val();
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: {
                    action: 'withdrawal',
                    wn: withdraw_number,
                    wc: withdraw_content
                }
            }).done(function() {
                alert('Yêu cầu rút tiền thành công!');
                setTimeout(
                    function() {
                        window.location.reload();
                        $('#withdraw_form').each(function() {
                            this.reset()
                        });
                    }, 1);
            });
        });

        /* [ Sticky Sidebar ]
        ---------------------------------*/
        $(window).scroll(function(event) {
            if ($('.primary-sidebar').length > 0) {
                var thisSticky = $('.primary-sidebar .widget:last-child');
                var prevSticky = $('.primary-sidebar .widget:last-child').prev();
                var content = $('.site-content');
                var contentPos = content.offset().top + content.outerHeight() - $(thisSticky).height();
                /* Act on the event */
                var pos = ($(prevSticky).offset().top + 40 + $(prevSticky).outerHeight());
                if ($(window).scrollTop() >= pos) {
                    thisSticky.addClass('fixed');
                } else {
                    thisSticky.removeClass('fixed');
                };

                if ($(window).scrollTop() >= contentPos) {
                    thisSticky.addClass('end-fixed');
                } else {
                    thisSticky.removeClass('end-fixed');
                };
            };

            // Home sticky
            if ($('.kc-wp-sidebar').length > 0) {
                var hoemThisSticky = $('.kc-wp-sidebar .widget:last-child');
                var homePrevSticky = $('.kc-wp-sidebar .widget:last-child').prev();
                var homeContent = $('.home-site-content');
                var homeContentPos = homeContent.offset().top + homeContent.outerHeight() - $(hoemThisSticky).height();
                /* Act on the event */
                var homePos = ($(homePrevSticky).offset().top + 40 + $(homePrevSticky).outerHeight());
                if ($(window).scrollTop() >= homePos) {
                    hoemThisSticky.addClass('fixed');
                } else {
                    hoemThisSticky.removeClass('fixed');
                };

                if ($(window).scrollTop() >= homeContentPos) {
                    hoemThisSticky.addClass('end-fixed');
                } else {
                    hoemThisSticky.removeClass('end-fixed');
                };
            };

            // Sharing sticky
            if ($('.sharing').length > 0) {
                var sharingThisSticky = $('.sharing');
                var sharingPrevSticky = $('.content-left');
                var sharingContent = $('.content-main');
                var sharingContentPos = sharingContent.offset().top + sharingContent.height() - $(sharingThisSticky).height();
                /* Act on the event */
                var sharingPos = $(sharingPrevSticky).offset().top - 20;
                if ($(window).scrollTop() >= sharingPos) {
                    sharingThisSticky.addClass('fixed');
                } else {
                    sharingThisSticky.removeClass('fixed');
                };

                if ($(window).scrollTop() >= sharingContentPos) {
                    sharingThisSticky.addClass('end-fixed');
                } else {
                    sharingThisSticky.removeClass('end-fixed');
                };
            };
        });

        $( '.sharing .comment-count a' ).on('click', function(event) {
            event.preventDefault();
            var id = $( this ).attr( 'href' );
            $('html,body').animate({
                scrollTop: $(id).offset().top - 40
            }, 300);
        });

        /* [ Custom Animation ]
        ---------------------------------*/
        function threeusAnimation() {
            if ($('.animation3').length) {
                $('.animation3').each(function() {
                    var pos = $(this).offset().top - $(window).height();
                    var delay = 0;
                    delay = $(this).attr('data-delay');
                    if ($(window).scrollTop() >= pos) {
                        if ($(this).hasClass('intop')) {
                            $(this).addClass("outtop").delay(delay).queue(function() {
                                $(this).removeClass("intop").stop().dequeue();
                            });
                        } else if ($(this).hasClass('inleft')) {
                            $(this).addClass("outleft").delay(delay).queue(function() {
                                $(this).removeClass("inleft").stop().dequeue();
                            });
                        } else if ($(this).hasClass('inright')) {
                            $(this).addClass("outright").delay(delay).queue(function() {
                                $(this).removeClass("inright").stop().dequeue();
                            });
                        } else if ($(this).hasClass('inbottom')) {
                            $(this).addClass("outbottom").delay(delay).queue(function() {
                                $(this).removeClass("inbottom").stop().dequeue();
                            });
                        }
                    } else {
                        if ($(this).hasClass('outtop')) {
                            $(this).removeClass('outtop').addClass('intop');
                        } else if ($(this).hasClass('outleft')) {
                            $(this).removeClass('outleft').addClass('inleft');
                        } else if ($(this).hasClass('outright')) {
                            $(this).removeClass('outright').addClass('inright');
                        } else if ($(this).hasClass('outbottom')) {
                            $(this).removeClass('outbottom').addClass('inbottom');
                        }
                    }
                });
            }
        }
        $( window ).load(function() {
          threeusAnimation();
        });

        $(window).scroll(function() {
            threeusAnimation();
        });

        $(window).resize(function() {
            threeusAnimation();
        });

        /* [ Publish Post ]
        ---------------------------------*/     
        $('.add_tags').on('click',function(e){
            e.preventDefault();
            var tags = $('input[name="mp_tag"]').val();
            var str = tags.split(',');
            for (var i = 0; i < tags.split(',').length; i++) {
                $('.tag-selected').append('<span><i class="fa fa-times-circle" aria-hidden="true"></i><input type="text" name="tag[]" readonly value="' + str[i] + '" /></span>');
            }
            $('input[name="mp_tag"]').val("");
        });
        $('.tag-list span').on('click',function(e){
            e.preventDefault();
            var tags = $(this).text();
            $('.tag-selected').append('<span><i class="fa fa-times-circle" aria-hidden="true"></i><input type="text" name="tag[]" readonly value="' + tags + '" /></span>');
        });
        $(document).on('click','.tag-selected i',function(){
            $(this).parent().fadeOut();
        }); 

        /*  [ Account]
        - - - - - - - - - - - - - - - - - - - - */
        $('.menu_item_account').on( 'click',function(e) {
            e.preventDefault();
            $(this).parents('.site-main').find('.popup-bg').fadeIn();
            $(this).parents('.site-main').find('.popup-withdraw').fadeIn();
        });
        $('.popup-bg').on( 'click',function(e) {
            e.preventDefault();
            $(this).fadeOut();
            $(this).parent().find('.popup-withdraw').fadeOut();
        });

        /* custom live chat click */
        $( '.livechat a' ).each(function(index, el) {
            $( this ).attr( 'href', 'javascript:void(Tawk_API.toggle())' );
        });


        /*  [ Add Point ]
        - - - - - - - - - - - - - - - - - - - - */
        $('.publish-form input[name="mp_success"]').on( 'click' , function() {
            var mp_point = $(this).parents('.publish-form').find('input[name="mp_point"]').val();
            var mp_title = $(this).parents('.publish-form').find('input[name="mp_title"]').val();
            var mp_author = $(this).parents('.publish-form').find('input[name="mp_author"]').val();
            $.ajax({
                type: 'POST',
                url: ajaxUrl,
                data: {
                    action: 'addPoint',
                    mpp: mp_point,
                    mpt: mp_title,
                    mpa: mp_author,
                }
            });
        });

        var noti = $(".noti-detail li.read").length;
        if (noti > 0) {
            $('.notification-icon').append('<span>' + noti + '</span>');
        } else {
            $('.noti-detail').append('<span>Bạn không có thông báo mới!</span>');
        }

        $(document).on("change", "#mp-video", function(evt) {
          var $source = $('#video_preview');
          $source[0].src = URL.createObjectURL(this.files[0]);
          $source.parent()[0].load();
        });
 
        /*  [ Page loader]
        - - - - - - - - - - - - - - - - - - - - */
        $(window).load(function() {
          setTimeout(function() {
            $( 'body' ).addClass( 'loaded' );
            setTimeout(function () {
              $('#pageloader').fadeOut();
            }, 300);
          }, 200);
        });

        $('.single-post .content-right .entry-content img').each( function() {
            var img = $(this);
            var src = img.attr('src');
            if (!img.parent().attr('href')) {
                img.wrap( '<a href="'+ src +'" data-gall="gall1" class="venobox"></a>' );
            }
        });
        $('.venobox').venobox({
            framewidth: '600px',
        });
    });
})(jQuery);