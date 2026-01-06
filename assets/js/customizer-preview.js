/**
 * Theme Customizer Live Preview
 * 
 * @package FectionWP_Pro
 */

(function($) {
    'use strict';
    
    // Base font size live preview
    wp.customize('fwp_base_font_size', function(value) {
        value.bind(function(newval) {
            $('body').css('font-size', newval + 'px');
        });
    });
    
    // ==========================================================================
    // HERO SECTION LIVE PREVIEW
    // ==========================================================================
    
    // Hero Title
    wp.customize('fwp_hero_title', function(value) {
        value.bind(function(newval) {
            $('.fwp-hero__title').html(newval);
        });
    });
    
    // Hero Subtitle
    wp.customize('fwp_hero_subtitle', function(value) {
        value.bind(function(newval) {
            if (newval) {
                if ($('.fwp-hero__subtitle').length) {
                    $('.fwp-hero__subtitle').html(newval).show();
                } else {
                    $('.fwp-hero__title').before('<p class="fwp-hero__subtitle lead fw-semibold mb-2">' + newval + '</p>');
                }
            } else {
                $('.fwp-hero__subtitle').hide();
            }
        });
    });
    
    // Hero Description
    wp.customize('fwp_hero_description', function(value) {
        value.bind(function(newval) {
            $('.fwp-hero__description').html(newval);
        });
    });
    
    // Hero Button 1 Text
    wp.customize('fwp_hero_btn1_text', function(value) {
        value.bind(function(newval) {
            var btn = $('.fwp-hero__buttons a:first-child');
            if (newval) {
                btn.text(newval).show();
            } else {
                btn.hide();
            }
        });
    });
    
    // Hero Button 1 URL
    wp.customize('fwp_hero_btn1_url', function(value) {
        value.bind(function(newval) {
            $('.fwp-hero__buttons a:first-child').attr('href', newval);
        });
    });
    
    // Hero Button 1 Style
    wp.customize('fwp_hero_btn1_style', function(value) {
        value.bind(function(newval) {
            var btn = $('.fwp-hero__buttons a:first-child');
            btn.attr('class', 'btn btn-' + newval + ' btn-lg');
        });
    });
    
    // Hero Button 2 Text
    wp.customize('fwp_hero_btn2_text', function(value) {
        value.bind(function(newval) {
            var btn = $('.fwp-hero__buttons a:last-child');
            if (newval) {
                btn.text(newval).show();
            } else {
                btn.hide();
            }
        });
    });
    
    // Hero Button 2 URL
    wp.customize('fwp_hero_btn2_url', function(value) {
        value.bind(function(newval) {
            $('.fwp-hero__buttons a:last-child').attr('href', newval);
        });
    });
    
    // Hero Button 2 Style
    wp.customize('fwp_hero_btn2_style', function(value) {
        value.bind(function(newval) {
            var btn = $('.fwp-hero__buttons a:last-child');
            btn.attr('class', 'btn btn-' + newval + ' btn-lg');
        });
    });
    
    // Hero Background Color
    wp.customize('fwp_hero_bg_color', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.fwp-hero').css('background-color', newval);
            } else {
                $('.fwp-hero').css('background-color', '');
            }
        });
    });
    
    // Hero Text Color
    wp.customize('fwp_hero_text_color', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.fwp-hero').css('color', newval);
            } else {
                $('.fwp-hero').css('color', '');
            }
        });
    });
    
    // Hero Height
    wp.customize('fwp_hero_height', function(value) {
        value.bind(function(newval) {
            $('.fwp-hero')
                .removeClass('fwp-hero--small fwp-hero--medium fwp-hero--large fwp-hero--full fwp-hero--auto')
                .addClass('fwp-hero--' + newval);
        });
    });
    
    // Hero Layout
    wp.customize('fwp_hero_layout', function(value) {
        value.bind(function(newval) {
            $('.fwp-hero')
                .removeClass('fwp-hero--centered fwp-hero--left fwp-hero--split-left fwp-hero--split-right')
                .addClass('fwp-hero--' + newval);
        });
    });
    
    // Hero Overlay Opacity
    wp.customize('fwp_hero_overlay_opacity', function(value) {
        value.bind(function(newval) {
            $('.fwp-hero__overlay').css('opacity', newval / 100);
        });
    });
    
    // ==========================================================================
    // SITE TITLE / LOGO STYLING LIVE PREVIEW
    // ==========================================================================
    
    var $brandElements = $('.navbar-brand, .navbar-brand a, .site-title');
    
    // Font Size
    wp.customize('fwp_site_title_font_size', function(value) {
        value.bind(function(newval) {
            $brandElements.css('font-size', newval + 'px');
        });
    });
    
    // Font Weight
    wp.customize('fwp_site_title_font_weight', function(value) {
        value.bind(function(newval) {
            $brandElements.css('font-weight', newval);
        });
    });
    
    // Text Transform
    wp.customize('fwp_site_title_text_transform', function(value) {
        value.bind(function(newval) {
            $brandElements.css('text-transform', newval);
        });
    });
    
    // Letter Spacing
    wp.customize('fwp_site_title_letter_spacing', function(value) {
        value.bind(function(newval) {
            $brandElements.css('letter-spacing', newval + 'px');
        });
    });
    
    // Text Color
    wp.customize('fwp_site_title_color', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $brandElements.css('color', newval);
            } else {
                $brandElements.css('color', '');
            }
        });
    });
    
    // Hover Color
    wp.customize('fwp_site_title_hover_color', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('<style id="fwp-title-hover">.navbar-brand:hover,.navbar-brand a:hover{color:' + newval + ' !important;}</style>').appendTo('head');
                $('#fwp-title-hover').remove();
                $('<style id="fwp-title-hover">.navbar-brand:hover,.navbar-brand a:hover{color:' + newval + ' !important;}</style>').appendTo('head');
            } else {
                $('#fwp-title-hover').remove();
            }
        });
    });
    
    // Background Color
    wp.customize('fwp_site_title_bg_color', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $brandElements.css('background-color', newval);
            } else {
                $brandElements.css('background-color', '');
            }
        });
    });
    
    // Padding
    wp.customize('fwp_site_title_padding', function(value) {
        value.bind(function(newval) {
            if (newval > 0) {
                $brandElements.css('padding', newval + 'px ' + (newval * 1.5) + 'px');
            } else {
                $brandElements.css('padding', '');
            }
        });
    });
    
    // Border Radius
    wp.customize('fwp_site_title_border_radius', function(value) {
        value.bind(function(newval) {
            if (newval > 0) {
                $brandElements.css('border-radius', newval + 'px');
            } else {
                $brandElements.css('border-radius', '');
            }
        });
    });
    
    // Text Shadow
    wp.customize('fwp_site_title_text_shadow', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $brandElements.css('text-shadow', '2px 2px 4px rgba(0,0,0,0.3)');
            } else {
                $brandElements.css('text-shadow', '');
            }
        });
    });
    
    // Mobile Size
    wp.customize('fwp_site_title_mobile_size', function(value) {
        value.bind(function(newval) {
            $('#fwp-title-mobile').remove();
            if (newval > 0) {
                $('<style id="fwp-title-mobile">@media (max-width:767px){.navbar-brand,.navbar-brand a,.site-title{font-size:' + newval + 'px;}}</style>').appendTo('head');
            }
        });
    });
    
    // Tagline Font Size
    wp.customize('fwp_tagline_font_size', function(value) {
        value.bind(function(newval) {
            $('.site-tagline').css('font-size', newval + 'px');
        });
    });
    
})(jQuery);
