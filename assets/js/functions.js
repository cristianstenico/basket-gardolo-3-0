(function ($) {

    var $body = $(document.body),
        $window = $(window),
        hero = $('.hero'),
        backgroundPosY,
        header = $('#masthead'),
        sidebar = $('#secondary'),
        searchSubmit = $('.search-submit'),
        resizeTimer;
    if (!hero.length) {
        header.addClass('with-background');
    }
    // Stick the #nav to the top of the window
    var navHomeY = header.outerHeight();
    var isFixed = false;
    var isWithBackground =false;
    if ($window.scrollTop() > navHomeY) {
        header.clone().appendTo('body').addClass('pinned')
        isFixed = true;
    }

    $window.scroll(function() {
        var scrollTop = $window.scrollTop();
        var shouldBeFixed = scrollTop > navHomeY;
        var shouldBeUnfixed = scrollTop < $('#masthead').outerHeight()
        if (scrollTop > ($window.height() - navHomeY) && !isWithBackground) {
            isWithBackground = true;
            $('.pinned').addClass('with-background');
        } else if (scrollTop <= navHomeY && isWithBackground) {
            isWithBackground = false;
            $('.pinned').removeClass('with-background');
        }
        if (shouldBeFixed && !isFixed) {
            header.clone().appendTo('body').addClass('pinned')
            isFixed = true;
        }
        else if (shouldBeUnfixed && isFixed)
        {
            $('.pinned').remove()
            isFixed = false;
        }
    });

    var img = new Image;
    img.src = hero.css('background-image').replace(/url\("|"\)$/ig, "");
    var imgRatio = img.height / img.width;
    calculateBackgroundPos();

    function calculateBackgroundPos() {
        var screenRatio = $window.height() / $window.width();
        var heroHeight = hero.height() - parseInt(hero.css('margin-Top'));
        var imgHeight = heroHeight;
        if (imgRatio > screenRatio) {
            imgHeight = $window.width() * imgRatio;
        }
        backgroundPosY = -(imgHeight - heroHeight) / 2;
        hero.css('backgroundPosition', '50% ' + (backgroundPosY + ($window.scrollTop() * 0.5)) + 'px');
    }

    // Make Featured image full-screen.
    function heroFullScreen() {
        var toolbarHeight, heroHeight, headerHeight, windowWidth, hentryInnerCalc;
        if (!hero.length) {
            return;
        }
        toolbarHeight = $body.is('.admin-bar') ? $('#wpadminbar').height() : 0;
        heroHeight = $window.height();
        headerHeight = header.outerHeight() + toolbarHeight;
        heroHeightNoHeader = heroHeight - headerHeight;
        windowWidth = $window.innerWidth();
        hentryInnerCalc = hero.find('.hentry-inner').height() + headerHeight;

        if ($window.height() < hentryInnerCalc) {
            heroHeight = hentryInnerCalc;
            heroHeightNoHeader = hentryInnerCalc - headerHeight;
        }

        if (windowWidth >= 768) {
            hero.css({
                'height': heroHeight + 'px',
                'margin-top': '-' + headerHeight + 'px',
                'padding-top': headerHeight + 'px',
            });
        } else if (windowWidth >= 540) {
            hero.css({
                'height': heroHeight + 'px',
                'margin-top': '-' + headerHeight + 'px',
                'padding-top': headerHeight + 'px',
            });
        } else {
            hero.css({
                'height': '',
                'margin-top': '-' + headerHeight + 'px',
                'padding-top': headerHeight + 'px',
            });
        }

        if (!sidebar.length) {
            return;
        }

        if (windowWidth >= 1056) {
            sidebar.css({
                'margin-top': heroHeightNoHeader + 'px'
            });
        } else {
            sidebar.removeAttr('style');
        }

    }

    function contentHeight() {
        var toolbarHeight = $body.is('.admin-bar') ? $('#wpadminbar').height() : 0,
            screenHeight = $window.height() - toolbarHeight,
            elementsHeight = header.outerHeight() + $('#colophon').outerHeight();

        $('#content').css({
            'min-height': screenHeight - elementsHeight + 'px'
        });
    }

    $window.scroll(function () {
        var height = $window.scrollTop();
        if (hero.height() - parseInt(hero.css('marginTop')) > height) {
            hero.css('backgroundPosition', '50% ' + (backgroundPosY + (height * 0.5)) + 'px');
        }
    });
    $window.load(function () {
        $('html').addClass('js');

        // Move Sharedaddy & Related Posts.
        var sharedaddy = $('.sd-sharing-enabled:not(#jp-post-flair), .sd-like.jetpack-likes-widget-wrapper, .sd-rating'),
            relatedPosts = $('#jp-relatedposts');
        if (sharedaddy.length) {
            sharedaddy.appendTo('.entry-footer');
        }
        if (relatedPosts.length) {
            $("#jp-post-flair").insertAfter('.entry-footer');
        }

        // Make sure tables don't overflow in Entry Content.
        $('.entry-content').find('table').each(function () {
            if ($(this).width() > $(this).parent().width()) {
                $(this).css('table-layout', 'fixed');
            }
        });

        // Remove box-shadow from linked images.
        $('.entry-content a, .comment-content a').each(function () {
            $(this).has('img').addClass('is-image');
        });

        $window.on('resize', function () {
            calculateBackgroundPos();
        });
    });

})(jQuery);
