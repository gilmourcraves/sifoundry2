
var utility = {
    getParameterByName: function(name) {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        var results = regex.exec(window.location.search);
        if(results == null)
            return "";
        else
            return decodeURIComponent(results[1].replace(/\+/g, " "));
    },

    isMobile: function(){
        if( /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            return 'true';
        }
    },

    getInternetExplorerVersion: function() {
        var rv = -1; // Return value assumes failure.
        if (navigator.appName == 'Microsoft Internet Explorer') {
            var ua = navigator.userAgent;
            var re = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
            if (re.exec(ua) != null)
                rv = parseFloat(RegExp.$1);
        }
        return rv;
    },

    setCookie: function (cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    },

    getCookie: function(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    },

    checkCookie: function (cname) {
        var cookie = utility.getCookie(cname);
        var result = false;

        if (cookie != "" && cookie != null) {
            result = true;
        }

        return result;

    },

    getExternalLink: function(url){
        var extLink = jQuery('#external-link-go');
        jQuery(extLink).attr('rel', url);
        var counter = 0;

        jQuery(extLink).click(function(){
            var rel = jQuery(this).attr('rel');
            //console.log(rel);
            if(counter == 0){
            window.open(rel);
            }
            counter++
        })
    }


};

var carouselMethods = {

    clientCarouselQuoteOn: function (o, $){

        $('.carousel-quote').each(function(){
            $(this).html('');
        });

        var clientCarousel = $('.client-carousel');
        var sourceElement = $('.quote-source');

        // reset
        clientCarousel.find('.carousel-cell').removeClass('active');
        $('.container-img').removeClass('muted');

        var thisIndex = $(o).index();

        var selected = $(o).closest('.carousel-cell');
        var carouselQuote = selected.find('.carousel-quote');
        var img = $(o).find('img');
        var quote = img.data('quote');
        var source = img.data('source');

        if (quote.length) {

            if(thisIndex == 1){
                carouselQuote.removeClass('bottom');
                selected.find('.container-img').eq(0).addClass('muted');

            } else {
                carouselQuote.addClass('bottom');
                selected.find('.container-img').eq(1).addClass('muted');
            }

            carouselQuote.html('<p>&#8220;' + quote + '&#8221;</p>' + '<span class="quote-source">' + source + '</span>').fadeIn('slow');

        } else {

            sourceElement.hide();
        }
    },

    clientCarouselQuoteOff: function(o, $){

        var clientCarousel = $('.client-carousel');

        clientCarousel.find('.carousel-cell').removeClass('active');

        var selected = $(o).closest('.carousel-cell');
        var carouselQuote = selected.find('.carousel-quote');

        $('.container-img').removeClass('muted');
        carouselQuote.html('');
    }

};


jQuery(document).ready(function($) {

    var windowWidth = $(window).innerWidth();
    var windowHeight = $(window).innerHeight();

    var thePath = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

    var mainNav = $('.container-section-nav');

    if ($('#wpadminbar').length) {
        mainNav.addClass('pusher-down');
    }

    // get rid of widows
/*    $('h1, h2, h3, h5, p').each(function() {
        $(this).html($(this).html().replace(/\s([^\s<]+)\s*$/,'&nbsp;$1'));
    });*/

     var dynamicH1 = utility.getParameterByName('header');


    // scroll thingy

    // to top right away
    var targetHash =  window.location.hash;
    var sectionToClick = utility.getParameterByName('section');

    if ( targetHash ) scroll(0,0);
    // void some browsers issue
    setTimeout( function() { scroll(0,0); }, 1);


    if ( targetHash ) {
        var anchorHref = targetHash;

        setTimeout(function () {
            $('html, body').stop().animate({
                scrollTop: jQuery(anchorHref).offset().top
            }, 1000, 'easeInOutExpo');
        }, 1500);

        if((sectionToClick.length) && (windowWidth > 992)) {

            setTimeout(function () {
                $('#' + sectionToClick).click();
            }, 2500);

        }
    }

    // from original prototype

    $('body.home').find('.logo').addClass('logo-white');

    var heroVideo = $('#hero-video');
    var heroVideoHeight = heroVideo.height();

    var headerMenu = mainNav;
    var header = $('header');
    var logo = $('.logo');
    var headerMenuTop = headerMenu.offset();

    if(headerMenuTop.top > (heroVideoHeight - 90)){
        headerMenu.addClass('add-background');
    } else {
        headerMenu.removeClass('add-background');
        logo.addClass('logo-white');
    }

    window.addEventListener("scroll", function(event) {
        var top = this.scrollY, left = this.scrollX;

        if(top > (heroVideoHeight - 90)){
            headerMenu.addClass('add-background');
            logo.removeClass('logo-white');
        } else {
            headerMenu.removeClass('add-background');
            logo.addClass('logo-white');
        }
    }, false);


    $('div.body-wrapper').imagesLoaded(function () {

        setTimeout(function(){
            $('#page-loader').fadeOut('slow', function () {

                $('div.body-wrapper').animate({opacity: 1});

            });
        }, 500);
    });

    // ticker

    $('.sif-ticker').width($('.sif-01').width());

    // client carousel
    var clientCarousel = $('.client-carousel');

    clientCarousel.flickity({
        cellAlign: 'left',
        contain: true,
        pageDots: false,
        pauseAutoPlayOnHover: true,
        initialIndex: 0,

        on: {
            ready: function () {

                var clientCarouselVisible = false;

                var carouselCell = $('.carousel-cell');

                var firstElement = carouselCell.eq(0).find('.container-img');

                $(window).scroll(function(){
                    if(clientCarousel.visible() && clientCarouselVisible == false){

                        var carouselCell = $('.client-carousel .carousel-cell');

                        var numSlides = carouselCell.length;

                        setTimeout(function(){

                            carouselMethods.clientCarouselQuoteOn(firstElement, $);

                            // loop through cells
                            var moveSlides = setInterval(function(){

                                clientCarousel.flickity( 'next', false, false );

                                var selectedSlide = clientCarousel.find('.carousel-cell.is-selected');

                                var index = selectedSlide.index();

                                // reset
                                clientCarousel.find('.carousel-cell').removeClass('active');
                                $('.container-img').removeClass('muted');

                                var lastElement = carouselCell.eq(index - 1).find('.container-img');

                                carouselMethods.clientCarouselQuoteOff(lastElement, $);

                                var i = 0;

                                var thisElement = carouselCell.eq(index).find('.container-img');

                                thisElement.each(function(){

                                    carouselMethods.clientCarouselQuoteOff(firstElement, $);

                                    var img = $(this).find('img');
                                    var quote = img.data('quote');

                                    if(quote.length > 1){

                                        thisElement = carouselCell.eq(index).find('.container-img').eq(i);

                                        setTimeout(function(){
                                            carouselMethods.clientCarouselQuoteOn(thisElement, $);
                                        }, 1000);

                                        return false;
                                    }

                                    i++;

                                });


                                if(index == (numSlides - 1)){

                                    clientCarousel.flickity( 'select', 0, false, false );

                                    carouselMethods.clientCarouselQuoteOn(firstElement, $);
                                }

                            }, 3500);

                            clientCarousel.on( 'click', function() {

                                clearInterval(moveSlides);

                            });

                            $('.flickity-prev-next-button.previous').on( 'click', function() {

                                clearInterval(moveSlides);
                            });

                            $('.flickity-prev-next-button.next').on( 'click', function() {

                                clearInterval(moveSlides);
                            });

                        }, 1500);


                        clientCarouselVisible = true;
                    }
                });


                $('.container-img').hover(function () {

                    carouselMethods.clientCarouselQuoteOn(this, $);

                }, function(){

                    carouselMethods.clientCarouselQuoteOff(this, $);

                });


            }
        }
    });

    // engineered carousel
    var engineeredCarousel = $('.engineered-carousel');

    engineeredCarousel.flickity({
        cellAlign: 'left',
        contain: true,
        pageDots: false,
        prevNextButtons: true,
        /*      autoPlay: 4000,*/
        pauseAutoPlayOnHover: true,

        on: {
            ready: function () {

                var engineeredCarouselVisible = false;

                $(window).scroll(function(){
                    if(engineeredCarousel.visible() && engineeredCarouselVisible == false){

                        engineeredCarousel.flickity('playPlayer');

                        clientCarouselVisible = true;
                    }
                });


            }
        }

    });

    $('#container-connecting-mobile').find('a').on('click', function(e){
        e.preventDefault();

        var theContent = $(this).closest('li').find('div');

        theContent.slideToggle();

    });

    /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */

    if(innerWidth < 993){
        particlesJS.load('container-connecting', '/wp-content/themes/gc-responsive/js/vendor/particles.js/particlesjs-config.json', function() {
            console.log('callback - particles.js config loaded');
        });
    }




});

