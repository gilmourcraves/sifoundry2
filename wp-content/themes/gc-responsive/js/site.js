
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

var animation = {
    triggerAnimation: function (revealClass, targetClass, offset, winHeight, $) {

        var trigger = $(window).scrollTop() + winHeight - offset;

        $(targetClass).each(function () {
            var elementOffset = $(this).offset().top;

            if (elementOffset < trigger) {

                $(this).addClass(revealClass.replace('.', ''));
            }
        });

    },

    numberCounter: function(o, $) {

        var delay = o.data('delay');
        var speed = o.data('speed');
        var extra = o.data('extra');

        if(extra === undefined){
            extra = '';
        }

        var numCountNum = o.data('total') -1;
        var numDisplay = '';

        setTimeout(
            function () {

                var numCountStart = 0;

                var numCounter = setInterval(function () {

                    if (numCountStart <= numCountNum) {
                        numDisplay = numCountStart + 1;
                        o.text(numDisplay);
                        numCountStart = numCountStart + 1;
                    } else {
                        o.text(numDisplay.toString() + extra + '+');
                        clearInterval(numCounter);
                    }

                }, speed);

            }, delay);
    },

    phoneImages: function(o, playAnimation, $) {

        var containerImages =  $(o).closest('section').find('.container-phone-animated');
        var animatedImg = containerImages.find('img.phone-animated');
        var animatedImgCount = animatedImg.length - 1;
        var i = 1; // start 1 higher so that the first image is only 3 seconds


        var animatedImgInterval = setInterval(function(){

            if(i > animatedImgCount) {
                i = 0;
            }

            animatedImg.eq(i-1).fadeOut();
            animatedImg.eq(i).fadeIn();

            i++;

        }, 3000);

        if(playAnimation == false){
            clearInterval(animatedImgInterval);
        }

    }
};


jQuery(document).ready(function($) {

    var windowWidth = $(window).innerWidth();
    var windowHeight = $(window).innerHeight();

    var thePath = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

    if ($('#wpadminbar').length) {
        $('.container-section-nav').addClass('pusher-down');
    }

    // get rid of widows
/*    $('h1, h2, h3, h5, p').each(function() {
        $(this).html($(this).html().replace(/\s([^\s<]+)\s*$/,'&nbsp;$1'));
    });*/

     var dynamicH1 = utility.getParameterByName('header');

    if(dynamicH1 != ''){
        $('section:eq(0)').find('h1').text(dynamicH1);
    }

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


    $('.go-to-next-section').on('click', function(e){
        e.preventDefault();
        var nextSection = $(this).closest('section').next('section');

        $('html, body').stop().animate({
            scrollTop: nextSection.offset().top
        }, 900, 'easeInOutExpo');


    });

    $('.go-to-section').on('click', function(e){
        e.preventDefault();
        var sectionHash = $(this).data('hash');
        var sectionId = $('#' + sectionHash);

        $('html, body').stop().animate({
            scrollTop: sectionId.offset().top
        }, 900, 'easeInOutExpo');


    });

    // main menu

    if (windowWidth > 991) {
        var menuDropdown = $('#menu-main-menu > li > a');

        //menuDropdown.addClass('hvr-underline-from-right');

        var productsMain = $('.nav-products').find('.dropdown-toggle');

        productsMain.click(function(){
            window.location.href = '/products/approvesimple/';
        });

        //hover
        menuDropdown.hover(function () {

            var link = $(this);
            var parent = link.closest('.dropdown');
            var dropdown = $('.dropdown-menu');


            link.addClass('active');
            dropdown.addClass('active');
            parent.addClass('open');

            var isHovered = !!parent.
                filter(function () {
                    return $(this).is(":hover");
                }).length;

            parent.mouseleave(function () {
                link.removeClass('active');
                parent.removeClass('open');

            });

        }, function () {
            var link = $(this);
            var parent = link.closest('.dropdown');
            var hovered = $("#menu-main-menu").find(".dropdown-menu:hover").length;
            var hoveredItem = parent.find("a.dropdown-toggle:hover").length;
        });
    }

    if (windowWidth < 991) {

        var containerNav = $('.container-section-nav');
        var containerNavMenu = $('#gc-navbar-collapse');

        $('.navbar-toggle').on('click', function (e) {

            if (containerNavMenu.hasClass('container-nav-fixed')) {
                containerNav.removeClass('container-section-nav-fixed');
                containerNavMenu.removeClass('container-nav-fixed');
            } else {
                containerNav.addClass('container-section-nav-fixed');
                containerNavMenu.addClass('container-nav-fixed');
            }
        })

    }

    // init plugins

    AOS.init({
        easing: 'ease-in-out-sine',
        disable: 'mobile'
    });

    $('.parallax').parallaxBackground();

    $('map').imageMapResize();

    $('.open-video-modal').on('click', function(e){
        e.preventDefault();

        var videoModalId = $(this).data('modal');

        $('#' + videoModalId).modal({
            minHeight: 640,
            minWidth: 940,
            opacity: 90,
            overlayClose: true
        });
    });

    // blog tweaks for bootstrap

    $('.blog-content img').addClass('img-responsive');

    $('p.form-submit .submit').addClass('btn btn-default');

    // for hover of menu

    $('.dropdown-toggle').click(function (e) {
        if ($(document).width() > 768) {
            e.preventDefault();

            var url = $(this).attr('href');

            if (url !== '#') {

                window.location.href = url;
            }
        }
    });

    // presently only used on home page

    $('.list-scrollspy li a').on('click', function (e) {

        e.preventDefault();

        var theAnchor = $(this).attr('href');
        var theAnchorOffset = $(theAnchor).offset().top;


        $('html, body').stop().animate({
            scrollTop: theAnchorOffset
        }, 1100, 'easeInOutExpo', function () {
            window.location.hash = '';

        });
    });

    // back to top

    $('.scroll-to-top').click(function (e) {
        e.preventDefault();

        $('html, body').stop().animate({
            scrollTop: 0
        }, 1500, 'easeInOutExpo', function () {
            window.location.hash = '';
        });
    });

    /*about and solutions page*/

    var appearCounters = appear({
        elements: function elements(){
            return document.getElementsByClassName('container-counter-number');
        },
        appear: function appear(el){
            $('.counter-number').each(function () {
                animation.numberCounter($(this), $)
            });
        },
        bounds: 0,
        reappear: false
    });

    /* solutions page *******************************/

    /*TODO: Put methods into a singleton*/

    function showBuilding(o, $){
        var info = $(o).data('info');
        var left = $(o).data('left');
        var approvalImg = $(o).data('image');

        // resets
        $('.approval-info, .approval-category').hide();

        $('.' + info).fadeIn('slow');
        $('#' + approvalImg).fadeIn('slow');

        $('.line-indicator-img').animate({
            'left': left + '%'
        })
    }

    function runBuilding(o, stopIt,  $){

        if(stopIt == true) {
            $('#image-map-approvals').find('area').eq(0).click();
        } else {
            var counter = 0;
            var mapAreaLen = mapArea.length;
            var firstTime = true;

            var cycleBuildings = setInterval(function(){

                if(firstTime == true){
                    counter++;
                    firstTime = false;
                }

                $('#image-map-approvals').find('area').eq(counter).click();

                if(counter < mapAreaLen){
                    counter++;
                } else {
                    counter = 0;
                }

            }, 3000);

            mapArea.hover(function (e) {
                clearInterval(cycleBuildings);
            }, function () {});
        }

    }

    function showStreamlineItem(o, $){

        $('.streamline-item').find('img').animate({
            width : '75px'
        }, 30);

        var streamLineImg = $(o).find('img');

        streamLineImg.animate({
            width : '79px'
        }, 200);


        var info = $(o).data('info');
        var left = $(o).data('left');

        var thisInfo = $('#' + info);

        // resets
        $('.streamline-section').not(thisInfo).hide();

        if((thisInfo).is(':hidden') == true){
            thisInfo.fadeIn('slow');
        }

        $('.indicator-streamline').animate({
            'left': left + '%'
        })
    }

    var mapArea = $('#image-map-approvals').find('area');

    var appearApprovalBuildings = appear({
        elements: function elements(){
            return document.getElementsByClassName('container-approval-img');
        },
        appear: function appear(el){
            runBuilding(el, false, $);
        },
        // function to run when an element is in view
        disappear: function disappear(el){
            runBuilding(el, true, $);
        },
        bounds: 0,
        reappear: false
    });

    mapArea.click(function(e){
        e.preventDefault();
        showBuilding($(this), $)
    });

    mapArea.hover(function (e) {
        showBuilding($(this), $)

    }, function () {});

    var streamlineItem = $('.container-streamline-items').find('.streamline-item');

    streamlineItem.hover(function (e) {
        showStreamlineItem($(this), $)

    }, function () {});

    streamlineItem.click(function (e) {
        showStreamlineItem($(this), $)
    });

    var appearStreamline = appear({
        elements: function elements(){
            return document.getElementsByClassName('container-streamline-items');
        },
        appear: function appear(el){

            if(sectionToClick.length > 0) {

            } else {
                var counter = 0;
                var streamlineItemLen = streamlineItem.length -1;

                if(windowWidth > 992) {

                    var cycleStreamline = setInterval(function(){

                        $('.container-streamline-items').find('.streamline-item').eq(counter).click();

                        if(counter < streamlineItemLen){
                            counter++;
                        } else {
                            counter = 0;
                        }

                    }, 5000);

                    streamlineItem.hover(function (e) {
                        clearInterval(cycleStreamline);
                    }, function () {});
                }
            }

        },
        // function to run when an element is in view
        disappear: function disappear(el){
            $('.container-streamline-items').find('.streamline-item').eq(0).click();
        },
        bounds: 0,
        reappear: false
    });

    var owlVideos = $('#owl-carousel-videos');

    if(owlVideos.length == 1) {

        owlVideos.owlCarousel({
            items: 2,
            lazyLoad:false,
            loop:true,
            autoplay: false,
            dots: false,
            dotsEach: false,
            nav: true,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            autoplayTimeout: 1000,
            smartSpeed: 1000,
            margin: 60,
            responsive:{
                0:{
                    items:1
                },
                940:{
                    items:2

                }
            }
        });
    }

    // Load form
    MktoForms2.loadForm("//app-ab21.marketo.com", "740-CGV-889", 1050, function (form) {
        // Listen for the validate event
        form.onValidate(function () {
            // Get the values
            var vals = form.vals();
            // Check your condition
            if (vals.Email === "") {
                // Prevent form submission
                form.submittable(false);
                // Show error message, pointed at Email element
                var emailElem = form.getFormElem().find("#Email");
                form.showErrorMessage("Please provide an email address.", emailElem);
            }
            else if (!isEmailGood(vals.Email)) {
                form.submitable(false);
                var emailElem = form.getFormElem().find("#Email");
                form.showErrorMessage("Must be Business email.", emailElem);
            }
            else if (vals.Email !== "" && vals.Company === "") {
                // Prevent form submission
                form.submittable(false);
                // Show error message, pointed at Company element
                var companyElem = form.getFormElem().find("#Company");
                form.showErrorMessage("Please provide a company name.", companyElem);
            }
            else {
                // Enable submission for those who met the criteria
                form.submittable(true);
            }
        });
    });

    function isEmailGood(email) {
        // Please include the email domains you would like to block in this list
        var invalidDomains = ["@gmail.", "@yahoo.", "@hotmail.", "@live.", "@aol.", "@outlook.", "@sbcglobal.net", "@comcast.net", "@cox.net", "@quickbase.com"];

        for (var i = 0; i < invalidDomains.length; i++) {
            var domain = invalidDomains[i];
            if (email.indexOf(domain) != -1) {
                return false;
            }
        }
        return true;
    }

});

