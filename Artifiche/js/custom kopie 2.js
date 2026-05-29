jQuery(document).ready(function() {

    // Check for open-filter parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('open-filter')) {
        openArtificheFilter();
    }

    jQuery('.bar').on('click', function(e) {
        e.preventDefault();
        jQuery('header').addClass('side-nav_active');
    });
    jQuery('.mobile-nav .icon-close').on('click', function(e) {
        e.preventDefault();
        jQuery('header').removeClass('side-nav_active');
    });
    // $('.count').hide();
    // $('.cart').on('click', function() {
    //     if ($(this).attr('data-click-state') == 1) {
    //         $(this).attr('data-click-state', 0);
    //         $(this).find('.count').fadeIn();
    //     } else {
    //         $(this).attr('data-click-state', 1);
    //         $(this).find('.count').fadeOut();
    //     }
    // });
    jQuery('.filter-fields').hide();

    // Function to open filter that can be called from anywhere
    window.openArtificheFilter = function() {
        var $filter = jQuery('#artifiche-filter');
        $filter.addClass('active');
        $filter.parent('.searchbox').addClass('filter-active');
        $filter.parents('form').find('.filter-fields').fadeIn('slow');
        
        // Scroll to the filter container
        jQuery('html, body').animate({
            scrollTop: jQuery('#artifiche-filter-container').offset().top
        }, 100);
    }

    // Handle links with class 'open-filter'
    jQuery('.open-filter').on('click', function(e) {
        e.preventDefault();
        openArtificheFilter();
    });

    jQuery('#artifiche-filter').on('click', function() {
        jQuery(this).toggleClass('active');
        jQuery(this).parent('.searchbox').toggleClass('filter-active');
        jQuery(this).parents('form').find('.filter-fields').fadeToggle('slow');
    });

    jQuery('.lang-switcher .js-wpml-ls-item-toggle').on('click', function() {
        jQuery(this).parent('li').toggleClass('lang-active');
        jQuery(this).parent('li').find('.js-wpml-ls-sub-menu').fadeToggle('slow');
    });

    if (!jQuery('.banner').length) {
        jQuery('main').addClass('no-banner');
    }



    jQuery(document).on('click touchstart', function(event) {
        if (jQuery(window).width() > 767) {
            if (!jQuery(event.target).closest(".bar,.mobile-nav").length) {
                jQuery("body").find("header").removeClass("side-nav_active");
                // jQuery("body").find('.chat-head').show();
            }
        }

    });
    jQuery(document).on('click touchstart', function(event) {
        if (jQuery(window).width() <= 767) {
            if (!jQuery(event.target).closest("#searchform,.header").length) {
                jQuery("body").find("header").removeClass("search-active");
                // jQuery("body").find("header .searchform input[type=text]").blur();
                // jQuery("body").find('.chat-head').show();
            }
        }
    });

    jQuery(window).scroll(function() {
        var sticky = jQuery('.header'),
            scroll = jQuery(window).scrollTop();

        if (scroll >= 40) {
            sticky.addClass('fixed');
        } else {
            sticky.removeClass('fixed');

        }
    });
    jQuery('.banner-carousel').slick({
        dots: false,
        // arrows: false,
        // infinite: false,
        speed: 300,
        fade: true,
        cssEase: 'linear',
        adaptiveHeight: true,
        // prevArrow:'.icon-forward',
        // draggable: false,
        // focusOnSelect: false,
        // slidesToShow: 1,
        // slidesToScroll: 1,
        responsive: [{
                breakpoint: 1024,
                settings: {}
            },
            {
                breakpoint: 767,
                settings: {
                    dots: true
                }
            },
            {
                breakpoint: 480,
                settings: {
                    dots: true
                }
            }
        ]
    });
    jQuery('.icon-forward').click(function() {
        jQuery('.banner-carousel').slick('slickPrev');
    });
    jQuery('.icon-backward').click(function() {
        jQuery('.banner-carousel').slick('slickNext');
    });
    if (jQuery(window).width() > 767) {
        if (jQuery('.js_select').length) {
            jQuery('.cat-filter .js_select option').each(function() {
                var val = jQuery(this).val();
                if (!val || val === '1') {
                    return;
                }
                if (val.indexOf('taxonomy=kollektionen') === -1 && val.indexOf('taxonomy=Kollektionen') === -1) {
                    return;
                }
                var match = val.match(/[?&]term=([^&]+)/);
                if (!match) {
                    return;
                }
                var slug = decodeURIComponent(match[1].replace(/\+/g, ' '));
                var path = '/kollektionen/' + slug + '/';
                if (window.location.pathname.indexOf('/en/') === 0) {
                    path = '/en/collections/' + slug + '/';
                }
                jQuery(this).val(window.location.origin + path);
            });
            jQuery(".js_select").each(function(index) {
                jQuery(this).select2({
                    allowClear: true,
                    width: '100%',
                    height: '60px',
                    language: 'de',
                    placeholder: 'wählen',
                    // containerCssClass: "custom-slect-wrap",
                    dropdownCssClass: "js_select2"
                });
            });

        }
    }

    if (jQuery(window).width() <= 767) {
        jQuery(".js_select").addClass('custom-select');
    }
    jQuery(window).on('resize', function() {
        var win = jQuery(this);
        if (win.width() > 812) {
            jQuery(".js_select").removeClass('custom-select');
        }
        if (win.width() <= 812) {
            jQuery(".js_select").addClass('custom-select');

        }
    });
    jQuery('.display-4-posters').each(function() {
        jQuery(this).find('.item-wrapper .general-poster').matchHeight({
            byRow: true
        });
    });
    jQuery('.display-3-posters').each(function() {
        jQuery(this).find('.item-wrapper .img-block').matchHeight({
            byRow: true
        });
    });
    // jQuery('.poster_grid').each(function() {
    //     jQuery(this).find('.poster-single .poster').matchHeight({
    //         byRow: false
    //     });
    // });
    // // get height of left summary and set right summary to the same on page load
    // var summaryLeftHeight = jQuery(".display-3-posters .general-poster").height();
    // jQuery(".display-3-posters .general-poster").css("height", summaryLeftHeight + "px");

    // // add this to make sure they have the same height on page resize 
    // jQuery(window).on("resize", function() {
    //     var summaryLeftHeight = jQuery(".display-3-posters .general-poster").height();
    //     jQuery(".display-3-posters .general-poster").css("height", summaryLeftHeight + "px");
    // });




    jQuery(window).on('load', function() {
        setTimeout(function() {
            jQuery('.preloader').fadeOut()
        }, 800);


    });
    jQuery(".poster-single .poster img").imagesLoaded(function() {
        // alert('loaded');
        jQuery('.poster_grid').each(function() {
            jQuery(this).find('.poster-single .poster').matchHeight({
                byRow: true
            });
        });
    });
    // alert("2");
    if (jQuery('.product-modal').length) {
        var imgLink = jQuery('.product-modal')
        var btn = imgLink.parents('.product-detail-wrap').find('.btn-link');
        var pcls_btn = jQuery(".pcls-btn").val();
        var pclr_code = jQuery(".pclr-code").val();
        var btnText = imgLink.parents('.product-detail-wrap').find('.btn-link').text();
        // console.log(btnText);
        var btnMarkup = jQuery("<div />").append(jQuery(".product-detail-wrap .btn-link").clone()).html();
        // console.log(btnMarkup);
        jQuery('.product-modal').magnificPopup({
            type: 'image',
            closeOnContentClick: false,
            closeBtnInside: false,
            closeOnBgClick: false,
            mainClass: 'mfp-with-zoom mfp-img-mobile image-zoom',
            closeMarkup: '<button class="mfp-close">'+ pcls_btn +'</button>',
            image: {
                markup: '<div class="mfp-figure">' +
                    '<div class="mfp-img"></div>' +
                    '<div class="mfp-top-bar">' +

                    ' ' + btnMarkup + ' ' +
                    '</div>' +
                    '<div class="picker-wrap">' +
                    '<h4>'+ pclr_code +'</h4><div class="color-picker"><input type="text" readonly id="colorpicker" data-inline="true" value="#fff"></div>' +
                    '</div>' +
                    '</div>', // Popup HTML markup. `.mfp-img` div will be replaced with img tag, `.mfp-close` by close button

                cursor: 'mfp-zoom-out-cur', // Class that adds zoom cursor, will be added to body. Set to null to disable zoom out cursor.

                titleSrc: 'title', // Attribute of the target element that contains caption for the slide.
                // Or the function that should return the title. For example:
                // titleSrc: function(item) {
                //   return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
                // }

                // verticalFit: true, // Fits image in area vertically

                // tError: '<a href="%url%">The image</a> could not be loaded.' // Error message
            },
            zoom: {
                enabled: true,
                duration: 500,
                easing: 'ease-in-out',
            },
            callbacks: {

                open: function() {
                    jQuery('#colorpicker').minicolors({
                        // inline:true,
                        position: 'top right',
                        // opacity:true,
                        // control:'wheel',
                        change: null,
                        defaultValue: '#fff',
                        change: null,
                    });

                    jQuery('#colorpicker').on('click touchstart', function() {
                        jQuery(this).blur();
                    })
                    jQuery('#colorpicker').on('input', function() {
                        var color = jQuery('#colorpicker').val();
                        // console.log(color);
                        jQuery('.mfp-bg').css('background-color', color);
                    });
                    jQuery('html').addClass("img-zoom-active");

                },
                close: function() {
                    // Will fire when popup is closed
                    jQuery('.mfp-bg').css('background-color', '#fff');
                    jQuery('html').removeClass("img-zoom-active");
                }
            }
        });
    }

    jQuery(function() {
        var logo = jQuery(".lrg-logo");
        jQuery(window).scroll(function() {
            var scroll = jQuery(window).scrollTop();

            if (scroll >= 110) {
                if (!logo.hasClass("sml-logo")) {
                    logo.hide();
                    logo.removeClass('lrg-logo').addClass("sml-logo").fadeIn("slow");
                }
            } else {
                if (!logo.hasClass("lrg-logo")) {
                    logo.hide();
                    logo.removeClass("sml-logo").addClass('lrg-logo').fadeIn("slow");
                }
            }

        });
    });
    if (jQuery('.product-detail-wrap').length) {
        jQuery('.product-detail-wrap').parents('body').addClass('custom-main');
        jQuery('.product-detail-wrap').parent('.blue-bg').next('.white-bg').addClass('pt-5')
    }

    jQuery('#searchform').on('click touchstart', function() {
        jQuery(this).parents('.header').addClass("search-active");
        // jQuery(this).find('input[type=text]').focus();
        // jQuery(this).find('input[type=text]').trigger('focus')
        // jQuery(this).find('input[type=text]').trigger('touchstart');
        // console.log("focused");
    });

    jQuery("#scroll-btn").click(function() {
        jQuery('html, body').animate({
            scrollTop: (jQuery(".detail-list").offset().top) - 400
        }, 2000);
    });
    if (jQuery(window).width() < 768) {
        jQuery('.footer_light .widget-title').on('click', function(e) {
            // e.preventDefault();
            // let jQuerythis = jQuery(this);

            if (jQuery(this).next('.textwidget').hasClass('show')) {
                jQuery(this).removeClass('active');
                jQuery(this).next('.textwidget').removeClass('show');
                jQuery(this).next('.textwidget').slideUp(350);
            } else {
                jQuery(this).addClass('active');
                jQuery(this).parent().find('.textwidget').removeClass('show');
                jQuery(this).parent().find('.textwidget').slideUp(350);
                jQuery(this).next('.textwidget').toggleClass('show');
                jQuery(this).next('.textwidget').slideToggle(350);
            }
        });
    }
    jQuery('.moreless-button').click(function() {
        jQuery(this).prev('.moretext').slideToggle();

        if (jQuery('html').is(':lang(en-us)')) {
            // alert('US lang detected');
            if (jQuery(this).text() == "more") {
                jQuery(this).parent('.mobile-only').find('.brief-txt .ellipsis').hide();
                jQuery(this).addClass('showless');
                jQuery(this).text("less");

            } else {
                jQuery(this).parent('.mobile-only').find('.brief-txt .ellipsis').show();
                jQuery(this).removeClass('showless');
                jQuery(this).text("more")
            }
        } else if (jQuery('html').is(':lang(de-DE)')) {
            if (jQuery(this).text() == "mehr") {
                jQuery(this).parent('.mobile-only').find('.brief-txt .ellipsis').hide();
                jQuery(this).addClass('showless');
                jQuery(this).text("weniger");

            } else {
                jQuery(this).parent('.mobile-only').find('.brief-txt .ellipsis').show();
                jQuery(this).removeClass('showless');
                jQuery(this).text("mehr")
            }
        }

    });
    jQuery(".detail-list li").each(function() {
        var tag = jQuery(this).find('.tag-list >span');
        console.log(tag.length);
        if (tag.length > 1) {
            tag.parents('li').addClass("remove-pd");
        } else {
            tag.parents('li').removeClass("remove-pd");
        }
    });

    jQuery(".enlarge-icon .image-link").on("click", (function(e) {
        e.preventDefault();

        jQuery('.product-modal').magnificPopup('open');

    }));
    jQuery('.mfp-close .icon-close').on("click", function() {
        jQuery('.product-modal').magnificPopup.close();
    });
    jQuery('.artifiche-form').find('.chk-label').parent('p').addClass('form-checkbox');
    // jQuery('body').addClass('mac-os');
    if (navigator.userAgent.indexOf('Mac') > 0)
        jQuery('body').addClass('Mac');
    if (navigator.userAgent.indexOf('Chrome') > 0)
        jQuery('body').addClass('chrome');

});
// jQuery(".about-left-content .desktop-only p").each(function() {
//     var readmoretxt = jQuery(".about-left-content .desktop-only p").text();

//     if (readmoretxt.length > 100) {
//         jQuery(this).text(readmoretxt.substr(0, readmoretxt.lastIndexOf(' ', 97)) + '...');
//     }
// });

jQuery(".ajax_add_to_cart ").on("click", function(){
    jQuery(this).parents(".product-detail-wrap").addClass('artf-wishliat-width');
});

jQuery(document).ready(function ($) {
  $('.search-icon:not(".mobile-search-container .search-icon")').on('click', function () {
    $('.search-container').toggleClass('active');
    $('.search-bar input[type="search"]').focus();
  });
  
  // Add the 'mega-grid' class to the parent <ul> of 'li.menu-column'
  $('li.menu-column').parent('ul').addClass('mega-grid');
  
  // Wrap each mega-grid in a .mega-menu-wrapper if not already wrapped
  $('.menu-item-has-children > .sub-menu.mega-grid').each(function() {
    if (!$(this).parent().is('.mega-menu-wrapper')) {
      $(this).wrap('<div class="mega-menu-wrapper"></div>');
    }
  });
  
    $(".menu-mega-menu-container > ul > .menu-item-has-children").on("click", function (e) {
      // Prevent default only when clicking the parent, not the links inside
      if (!$(e.target).is("a")) {
          e.preventDefault();
      }
  
      // Close all other open sub-menus at the same level
      $(".menu-mega-menu-container > ul > .menu-item-has-children")
          .not(this)
          .removeClass("open")
          .find(".mega-menu-wrapper .sub-menu")
          .removeClass("open");
  
      // Toggle the 'open' class on the clicked menu item and its sub-menu
      $(this).toggleClass("open");
      $(this).find(".mega-menu-wrapper .sub-menu").toggleClass("open");
  });
  
  // Prevent clicks inside sub-menus from closing the menu
  $(".menu-mega-menu-container .sub-menu").on("click", function (e) {
      e.stopPropagation();
  });
  
  // Add click event to open submenus with 'activesub' class
  $(".menu-column > .sub-menu > .menu-item > a").on("click", function (e) {
      var $submenu = $(this).siblings(".sub-menu");
  
      if ($submenu.length) {
          e.preventDefault();  // Prevent navigation if there's a submenu
  
          // Close other open submenus on the same level
          $(this).closest(".sub-menu").find(".sub-menu").not($submenu).removeClass("activesub");
  
          // Toggle the 'activesub' class on the current submenu
          $submenu.toggleClass("activesub");
      }
  });


 
 $('.menu-container').click(function () {
     $(".menu-mega-menu-container, .mobile-lang-switcher, .mobile-search-container").toggleClass('active');
 });
 
 $('.mega-grid a[href]').on('click', function(e) {
     window.location = $(this).attr('href');
 });

  
});