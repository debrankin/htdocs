/**
 * All admin-facing Javascript code
 *
 * @summary   All admin-facing Javascript code for MojoPlug Slide Panel
 *
 * @link      http://mojoplug.com
 * @since     1.0.0
 */

(function ($) {
    'use strict';

    /**
     * @summary   Add Color Picker to all inputs that have 'color-field' class
     * 
     * Attach standard Wordpress Color Picker to all fields with color-field
     * class
     * 
     * @since     1.0.0
     */
    $(function () {
        $('.color-field').wpColorPicker();
    });

})(jQuery);
