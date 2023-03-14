(function($) {
    "use strict";
    // Document ready function 


    /*-------------------------------------
    Booking dates and time
    -------------------------------------*/
    var datePicker = $('.rt-date');
    if (datePicker.length) {
        datePicker.datetimepicker({
            format: 'Y-m-d',
            timepicker: false
        });
    }

    var timePicker = $('.rt-time');
    if (timePicker.length) {
        timePicker.datetimepicker({
            format: 'H:i',
            datepicker: false
        });
    }

    /*---------------------------------------
    On Click Section Switch
    --------------------------------------- */
    $('[data-type="section-switch"]').on('click', function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            if (target.length > 0) {

                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });

    /*-------------------------------------
    On Scroll 
    -------------------------------------*/
    $(window).on('scroll', function() {
        imageFunction();

        // Menu Sticky Header 1
        if ($(window).scrollTop() > 150) {
            $('#header_1').addClass('menu-sticky');
        } else {
            $('#header_1').removeClass('menu-sticky');
        }

        // Menu Sticky Header 2
        if ($(window).scrollTop() > 175) {
            $('#header_2').addClass('menu-sticky');
        } else {
            $('#header_2').removeClass('menu-sticky');
        }

        // Menu Sticky Header 3
        if ($(window).scrollTop() > 95) {
            $('#header_3').addClass('menu-sticky');
        } else {
            $('#header_3').removeClass('menu-sticky');
        }

        // Back Top Button
        if ($(window).scrollTop() > 700) {
            $('.scrollUp').addClass('back-top');
        } else {
            $('.scrollUp').removeClass('back-top');
        }
    });

    /*-------------------------------------
    On click loadmore functionality 
    -------------------------------------*/
    $('.loadmore').on('click', 'a', function(e) {
        e.preventDefault();
        var _this = $(this),
            _count = parseInt(_this.parent('.loadmore').data("count"), 10) || 1,
            _parent = _this.parents('.menu-list-wrapper'),
            _target = _parent.find('.menu-list'),
            _set = _target.find('.menu-item.hidden').slice(0, _count);
        if (_set.length) {
            _set.animate({
                opacity: 0
            });
            _set.promise().done(function() {
                _set.removeClass('hidden');
                _set.show().animate({
                    opacity: 1
                }, 1000);
            });
        } else {
            _this.text('No more item to display');
        }
        return false;
    });


    /*-------------------------------------
    Section background image 
    -------------------------------------*/
    imageFunction();

    function imageFunction() {

        // Section static background image
        $('[data-bg-image]').each(function() {
            var img = $(this).data('bg-image');
            $(this).css({
                backgroundImage: 'url(' + img + ')',
            });
        });
    }

    $(window).on('scroll', function() {
        imageFunction();
    });

    /*-------------------------------------
    Header area apace 
    -------------------------------------*/
    headerNsliderResize();

    function headerNsliderResize() {
        var Hhw = $('.header-height-wrap'),
            wWidth = $(window).width(),
            Hhwslider = Hhw.parents('#wrapper').find("#header-area-space"),
            mHeight = Hhw.outerHeight();
        if (wWidth < 992) {
            mHeight = $('body > .mean-bar').outerHeight();
            // $("#downFromTop").css("margin-top", mHeight + 'px');
        }
        Hhwslider.css("margin-top", mHeight + 'px');
    }

    // Price range filter
    var priceSlider = document.getElementById('price-range-filter');
    if (priceSlider) {
        noUiSlider.create(priceSlider, {
            start: [10000, 35000],
            connect: true,
            range: {
                'min': 0,
                'max': 100000
            },
            format: wNumb({
                decimals: 0
            }),
        });
        var marginMin = document.getElementById('price-range-min'),
            marginMax = document.getElementById('price-range-max');
        priceSlider.noUiSlider.on('update', function(values, handle) {
            if (handle) {
                marginMax.innerHTML = "$" + values[handle];
            } else {
                marginMin.innerHTML = "$" + values[handle];
            }
        });
    }

    /*---------------------------------------
    Hoverdir Initialization
    --------------------------------------- */
    $('.multi-side-hover').each(function() {
        $(this).hoverdir({
            hoverDelay: 5,
        });
    });

    /*-------------------------------------
    Quantity Holder
    -------------------------------------*/
    $('#quantity-holder, #quantity-holder2').on('click', '.quantity-plus', function() {

        var $holder = $(this).parents('.quantity-holder');
        var $target = $holder.find('input.quantity-input');
        var $quantity = parseInt($target.val(), 10);
        if ($.isNumeric($quantity) && $quantity > 0) {
            $quantity = $quantity + 1;
            $target.val($quantity);
        } else {
            $target.val($quantity);
        }

    }).on('click', '.quantity-minus', function() {

        var $holder = $(this).parents('.quantity-holder');
        var $target = $holder.find('input.quantity-input');
        var $quantity = parseInt($target.val(), 10);
        if ($.isNumeric($quantity) && $quantity >= 2) {
            $quantity = $quantity - 1;
            $target.val($quantity);
        } else {
            $target.val(1);
        }

    });

    /*-------------------------------------
    MeanMenu activation code
    --------------------------------------*/
    $('nav#dropdown').meanmenu({
        siteLogo: "<div class='mobile-menu-nav-back'><a class='logo-mobile' href='home'><img src='assets/img/proxy/5-12.png' alt='Proxydoc' height='100' width='100'  class='img-fluid'/></a></div>"
    });

    /*-------------------------------------
    // jquery zoom activation code
    -------------------------------------*/
    var ecomZoom = $('.ex1');
    if (ecomZoom.length) {
        $('.ex1').zoom();
    }

    /*-------------------------------------
    Circle Bars - Knob
    -------------------------------------*/
    if (typeof($.fn.knob) != 'undefined') {
        $('.knob.knob-nopercent').each(function() {
            var $this = $(this),
                knobVal = $this.attr('data-rel');
            $this.knob({
                'draw': function() {}
            });
            $this.appear(function() {
                $({
                    value: 0
                }).animate({
                    value: knobVal
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $this.val(Math.ceil(this.value)).trigger('change');
                    }
                });
            }, {
                accX: 0,
                accY: -150
            });
        });
    }

    /*-------------------------------------
    Counter
    -------------------------------------*/
    var counterContainer = $('.counter');
    if (counterContainer.length) {
        counterContainer.counterUp({
            delay: 50,
            time: 5000
        });
    }

    /*-------------------------------------
     Accordion
     -------------------------------------*/
    var accordion = $('#accordion');
    accordion.on('show.bs.collapse', function(e) {
        $(e.target).prev('.panel-heading').addClass('active');
    }).on('hide.bs.collapse', function(e) {
        $(e.target).prev('.panel-heading').removeClass('active');
    });

    $('.panel-heading a', accordion).on('click', function(e) {
        if ($(this).parents('.panel').children('.panel-collapse').hasClass('show')) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    /*-------------------------------------
    Contact Form initiating
    -------------------------------------*/
    var contactForm = $('#contact-form');
    if (contactForm.length) {
        contactForm.validator().on('submit', function(e) {
            var $this = $(this),
                $target = contactForm.find('.form-response');
            if (e.isDefaultPrevented()) {
                $target.html("<div class='alert alert-danger'><p>Please select all required field.</p></div>");
            } else {
                $.ajax({
                    url: "vendor/php/form-process.php",
                    type: "POST",
                    data: contactForm.serialize(),
                    beforeSend: function() {
                        $target.html("<div class='alert alert-info'><p>Loading ...</p></div>");
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        console.log(res);
                        if (res.success) {
                            $this[0].reset();
                            $target.html("<div class='alert alert-success'><p>Message has been sent successfully.</p></div>");
                        } else {
                            if (res.message.length) {
                                var messages = null;
                                res.message.forEach(function(message) {
                                    messages += "<p>" + message + "</p>";
                                });
                                $target.html("<div class='alert alert-success'><p>" + messages + "</p></div>");
                            }
                        }
                    },
                    error: function() {
                        $target.html("<div class='alert alert-success'><p>Error !!!</p></div>");
                    }
                });
                return false;
            }
        });
    }


    /*-------------------------------------
     Select2 activation code
     -------------------------------------*/
    if ($('select.select2').length) {
        $('select.select2').select2({
            theme: 'classic',
            dropdownAutoWidth: true,
            width: '100%'
        });
    }

    /* ---------------------------------------
    Parallax
    --------------------------------------- */
    if ($('.parallaxie').length) {
        $(".parallaxie").parallaxie({
            speed: 0.5,
            offset: 0,
        });
    }

    /*-------------------------------------
     Google Map
    -------------------------------------*/
    if ($('#googleMap').length) {
        var initialize = function() {
            var mapOptions = {
                zoom: 15,
                scrollwheel: false,
                center: new google.maps.LatLng(-37.81618, 144.95692),
                styles: [{
                    stylers: [{
                        saturation: -100
                    }]
                }]
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
            var marker = new google.maps.Marker({
                position: map.getCenter(),
                animation: google.maps.Animation.BOUNCE,
                icon: 'img/map-marker.png',
                map: map
            });
        }
        // Add the map initialize function to the window load function
        google.maps.event.addDomListener(window, "load", initialize);
    }

    /*-------------------------------------
    Carousel slider initiation
    -------------------------------------*/
    $('.rc-carousel').each(function() {
        var carousel = $(this),
            loop = carousel.data('loop'),
            items = carousel.data('items'),
            margin = carousel.data('margin'),
            stagePadding = carousel.data('stage-padding'),
            autoplay = carousel.data('autoplay'),
            autoplayTimeout = carousel.data('autoplay-timeout'),
            smartSpeed = carousel.data('smart-speed'),
            dots = carousel.data('dots'),
            nav = carousel.data('nav'),
            navSpeed = carousel.data('nav-speed'),
            rXsmall = carousel.data('r-x-small'),
            rXsmallNav = carousel.data('r-x-small-nav'),
            rXsmallDots = carousel.data('r-x-small-dots'),
            rXmedium = carousel.data('r-x-medium'),
            rXmediumNav = carousel.data('r-x-medium-nav'),
            rXmediumDots = carousel.data('r-x-medium-dots'),
            rSmall = carousel.data('r-small'),
            rSmallNav = carousel.data('r-small-nav'),
            rSmallDots = carousel.data('r-small-dots'),
            rMedium = carousel.data('r-medium'),
            rMediumNav = carousel.data('r-medium-nav'),
            rMediumDots = carousel.data('r-medium-dots'),
            rLarge = carousel.data('r-large'),
            rLargeNav = carousel.data('r-large-nav'),
            rLargeDots = carousel.data('r-large-dots'),
            rExtraLarge = carousel.data('r-extra-large'),
            rExtraLargeNav = carousel.data('r-extra-large-nav'),
            rExtraLargeDots = carousel.data('r-extra-large-dots'),
            center = carousel.data('center'),
            custom_nav = carousel.data('custom-nav') || '';
        carousel.owlCarousel({
            loop: (loop ? true : false),
            items: (items ? items : 4),
            lazyLoad: true,
            margin: (margin ? margin : 0),
            autoplay: (autoplay ? true : false),
            autoplayTimeout: (autoplayTimeout ? autoplayTimeout : 1000),
            smartSpeed: (smartSpeed ? smartSpeed : 250),
            dots: (dots ? true : false),
            nav: (nav ? true : false),
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            navSpeed: (navSpeed ? true : false),
            center: (center ? true : false),
            responsiveClass: true,
            responsive: {
                0: {
                    items: (rXsmall ? rXsmall : 1),
                    nav: (rXsmallNav ? true : false),
                    dots: (rXsmallDots ? true : false)
                },
                576: {
                    items: (rXmedium ? rXmedium : 2),
                    nav: (rXmediumNav ? true : false),
                    dots: (rXmediumDots ? true : false)
                },
                768: {
                    items: (rSmall ? rSmall : 3),
                    nav: (rSmallNav ? true : false),
                    dots: (rSmallDots ? true : false)
                },
                992: {
                    items: (rMedium ? rMedium : 4),
                    nav: (rMediumNav ? true : false),
                    dots: (rMediumDots ? true : false)
                },
                1200: {
                    items: (rLarge ? rLarge : 5),
                    nav: (rLargeNav ? true : false),
                    dots: (rLargeDots ? true : false)
                },
                1400: {
                    items: (rExtraLarge ? rExtraLarge : 6),
                    nav: (rExtraLargeNav ? true : false),
                    dots: (rExtraLargeDots ? true : false)
                }
            }
        });
        var owl = carousel.data('owlCarousel');


        if (custom_nav) {
            var nav = $(custom_nav),
                nav_next = $('.rt-next', nav),
                nav_prev = $('.rt-prev', nav);

            nav_next.on('click', function(e) {
                e.preventDefault();
                owl.next();
                return false;
            });

            nav_prev.on('click', function(e) {
                e.preventDefault();
                owl.prev();
                return false;
            });
        }
    });

    /*-------------------------------------
    Window load function
    -------------------------------------*/
    $(window).on('load', function() {

        //Slick Carousel 
        var SlickCarousel = $('#slick-carousel-wrap');
        if (SlickCarousel.length) {
            SlickCarousel.find('.carousel-content').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                autoplay: false,
                asNavFor: '.carousel-nav',
                prevArrow: '<span class="slick-prev slick-navigation"><i class="fa fa-angle-left" aria-hidden="true"></i></span>',
                nextArrow: '<span class="slick-next slick-navigation"><i class="fa fa-angle-right" aria-hidden="true"></i></span>'
            });
            SlickCarousel.find('.carousel-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: '.carousel-content',
                dots: false,
                arrows: true,
                prevArrow: true,
                nextArrow: true,
                centerMode: true,
                centerPadding: '0px',
                focusOnSelect: true,
                responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 479,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }]
            });
        }

        var SlickCarousel = $('#slick-carousel-wrap2');
        if (SlickCarousel.length) {
            SlickCarousel.find('.carousel-content').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                autoplay: false,
                asNavFor: '.carousel-nav',
                prevArrow: '<span class="slick-custom-prev slick-navigation"><i class="fas fa-chevron-left"></i></span>',
                nextArrow: '<span class="slick-custom-next slick-navigation"><i class="fas fa-chevron-right"></i></span>'
            });
            SlickCarousel.find('.carousel-nav').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.carousel-content',
                dots: false,
                arrows: true,
                prevArrow: true,
                nextArrow: true,
                centerMode: true,
                centerPadding: '0px',
                focusOnSelect: true,
                responsive: [{
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 479,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }]
            });
        }

        // Onepage Nav on meanmenu
        var onePageNav = $('#navOnePage');
        if (onePageNav.length) {
            $('#navOnePage').onePageNav({
                scrollOffset: 80,
                end: function() {
                    $('.meanclose').trigger('click');
                }
            });
        }

        // Countdown activation code
        var eventCounter = $('#countdown');
        if (eventCounter.length) {
            eventCounter.countdown('2019/08/21', function(e) {
                $(this).html(e.strftime("<div class='countdown-section'><h2>%D</h2> <h3>day%!D</h3> </div><div class='countdown-section'><h2>%H</h2> <h3>Hour%!H</h3> </div><div class='countdown-section'><h2>%M</h2> <h3>Minutes</h3> </div><div class='countdown-section'><h2>%S</h2> <h3>Second</h3> </div>"))

            });
        }

        // Popup
        var yPopup = $(".popup-youtube");
        if (yPopup.length) {
            yPopup.magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
            });
        }

        // Single Popup
        if ($('.popup-zoom-single').length) {
            $('.popup-zoom-single').magnificPopup({
                type: 'image'
            });
        }

        // Gallery Popup
        if ($('.zoom-gallery').length) {
            $('.zoom-gallery').each(function() {
                $(this).magnificPopup({
                    delegate: 'a.popup-zoom',
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
            });
        }

        // Masonry
        var galleryIsoContainer = $('#no-equal-gallery');
        if (galleryIsoContainer.length) {
            // var blogGallerIso = galleryIsoContainer.imagesLoaded(function() {
            //     blogGallerIso.isotope({
            //         itemSelector: '.no-equal-item',
            //         masonry: {
            //             columnWidth: '.no-equal-item'
            //         }
            //     });
            // });
        }

        // Page Preloader
        $('#preloader').fadeOut('slow', function() {
            $(this).remove();
        });

        // Isotope initialization
        var $container = $('.isotope-wrap');
        if ($container.length > 0) {
            $container.find('.isotope-classes-tab').on('click', 'a', function() {
                var $this = $(this);
                $this.parent('.isotope-classes-tab').find('a').removeClass('current');
                $this.addClass('current');
                var selector = $this.attr('data-filter');
                $('.featuredContainer', $container).isotope({
                    filter: selector,
                    transitionDuration: '1s',
                    hiddenStyle: {
                        opacity: 0,
                        transform: 'scale(0.001)',
                    },
                    visibleStyle: {
                        transform: 'scale(1)',
                        opacity: 1
                    }
                });
                return false;
            });
        }

        // Bar Chart 
        if (typeof Chart !== 'undefined') {

            var $cart = ['bar-chart-1', 'bar-chart-2'];
            $cart.map(function(chart_id) {
                var item = $("#" + chart_id);
                if (item.length) {

                    new Chart(document.getElementById(chart_id), {
                        type: 'bar',
                        data: {
                            labels: item.data('labels').split(','),
                            datasets: [{
                                label: "Total value",
                                backgroundColor: item.data('colors').split(','),
                                data: item.data('data').split(',')
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true
                            }
                        }
                    });
                }
            });
        }
    });

    /*-------------------------------------
    Jquery Serch Box
    -------------------------------------*/
    $(document).on('click', '#top-search-form .search-button', function(e) {
        e.preventDefault();
        var targrt = $(this).prev('input.search-input');
        targrt.animate({
            width: ["toggle", "swing"],
            height: ["toggle", "swing"],
            opacity: "toggle"
        }, 500, "linear");
        return false;
    });

    /*-------------------------------------
     Wow js Active
    -------------------------------------*/
    new WOW().init();


    /*-------------------------------------
     Window onLoad and onResize event trigger
     -------------------------------------*/
    $(window).on('load resize', function() {
        var wHeight = $(window).height(),
            mLogoH = $('a.logo-mobile-menu').outerHeight();
        wHeight = wHeight - 50;
        $('.mean-nav > ul').css('height', wHeight + 'px');
        headerNsliderResize();

        //Auto equal height
        equalHeight();
    });

    /*-------------------------------------
     Jquery Stiky Menu at window Load
     -------------------------------------*/
    $(window).on('scroll', function() {
        var s = $('#sticker'),
            w = $('body'),
            h = s.outerHeight(),
            windowpos = $(window).scrollTop(),
            windowWidth = $(window).width(),
            h2 = s.parent('#header-two'),
            h1 = s.parent('#header-one'),
            h1H = h1.find('.header-top-bar').outerHeight(),
            topBar = s.prev('.header-top-bar'),
            tempMenu;
        if (windowWidth > 991) {
            w.css('padding-top', '');
            var topBarH, mBottom = 0;
            if (h2.length) {
                topBarH = h = 1;
                mBottom = 0;
            } else if (h1.length) {
                topBarH = topBar.outerHeight();
                if (windowpos <= topBarH) {
                    if (h1.hasClass('header-fixed')) {
                        h1.css('top', '-' + windowpos + 'px');
                    }
                }
            }
            if (windowpos >= topBarH) {
                if (h1.length || h2.length) {
                    s.addClass('stick');
                }
                if (h1.length) {
                    if (h1.hasClass('header-fixed')) {
                        h1.css('top', '-' + topBarH + 'px');
                    } else {
                        w.css('padding-top', h + 'px');
                    }
                }
            } else {
                s.removeClass('stick');
                if (h1.length) {
                    w.css('padding-top', 0);
                }
            }
        }
    });


    /*-------------------------------------
    Auto equal height for product listing
    -------------------------------------*/
    function equalHeight() {
        var imgH = 0,
            boxH = 0,
            wWidth = $(window).width(),
            allH;
        $('.equal-height-wrap .item-img,.equal-height-wrap .item-content').height('auto');
        if (wWidth > 991) {
            $('.equal-height-wrap').each(function() {
                var self = $(this);
                var TempImgH = self.find('.item-img').height();
                imgH = TempImgH > imgH ? TempImgH : imgH;
                var TempBoxH = self.find('.item-content').outerHeight();
                boxH = TempBoxH > boxH ? TempBoxH : boxH;
            });
            allH = imgH;
            allH = boxH > imgH ? boxH : imgH;
            $('.equal-height-wrap .item-img,.equal-height-wrap .item-content').height(allH + "px");
        }
    }

})(jQuery);