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
    
})(jQuery);
