/**
 * All puclic-facing Javascript code. Handles all functions needed for
 * showing and animating slide panels.
 *
 * @summary   All public-facing Javascript code for MojoPlug Slide Panel
 *
 * @link      http://mojoplug.com
 * @since     1.0.0
 * @since     1.0.1 Workaround for iPhone Safari bug
 * @since     1.1.0 Panel default visibility
 * @since     1.1.1 Fixed compatibility issue with Visual Composer
 */

(function ($) {
    'use strict';

    var leftTarget = mojospOptions.leftTarget;
    var $leftTarget = $(leftTarget);
    var leftOK = false;
    var rightTarget = mojospOptions.rightTarget;
    var $rightTarget = $(rightTarget);
    var rightOK = false;
    var $leftWrap = '';
    var $rightWrap = '';
    var $leftPanel = '';
    var $rightPanel = '';
    var $leftButton = '';
    var $rightButton = '';
    var leftIconOpen = mojospOptions.leftIconOpen;
    var leftIconClose = mojospOptions.leftIconClose;
    var showLeftButton = !!+mojospOptions.leftButtonShow; // !!+ converts string "0" and "1" to boolean false/true
    var rightIconOpen = mojospOptions.rightIconOpen;
    var rightIconClose = mojospOptions.rightIconClose;
    var showRightButton = !!+mojospOptions.rightButtonShow; // !!+ converts string "0" and "1" to boolean false/true
    var leftWidth= mojospOptions.leftWidth;
    var rightWidth = mojospOptions.rightWidth;

    /**
     * @summary Panel initialization. Launched once when page is ready.
     *
     * Handle all initialization routines for panels.
     *
     * @since 1.0.0
     * @access public
     */
    $(document).ready(function ($) {
        $('body').css('overflow-x', 'hidden');
        $leftWrap = $('#mojo-sp-left-wrap');
        $rightWrap = $('#mojo-sp-right-wrap');
        $leftPanel = $('#mojo-sp-left');
        $rightPanel = $('#mojo-sp-right');
        $leftButton = $('#mojo-sp-left-button');
        $rightButton = $('#mojo-sp-right-button');

        if (!showLeftButton)
            $leftButton.css('display', 'none');
        
        if (!showRightButton)
            $rightButton.css('display', 'none');
        
        // Does left panel exist?

        if (($leftPanel.length) && ($leftTarget.length))
        {
            $leftWrap.css('display', 'inline');
            initPanel('left', leftTarget, $leftWrap, $leftPanel, $leftButton, mojospOptions);
            leftOK = true;
            var element = document.getElementById('mojo-sp-left-button');
            if (!element.isVisible())
                alert('MojoPlug warning: This page contains element(s) blocking visibility of left Slide Panel. To fix the problem, find and remove overflow:hidden directive(s) from parent HTML element(s).')
        }
        
        // Does right panel exist?
        if (($rightPanel.length) && ($rightTarget.length))
        {
            $rightWrap.css('display', 'inline');
            initPanel('right', rightTarget, $rightWrap, $rightPanel, $rightButton, mojospOptions);
            rightOK = true;
            var element = document.getElementById('mojo-sp-right-button');
            if (!element.isVisible())
                alert('MojoPlug warning: This page contains element(s) blocking visibility of right Slide Panel. To fix the problem, find and remove overflow:hidden directive(s) from parent HTML element(s).')
        }
        
    });
    
    /**
     * @summary Initialize one panel.
     *
     * Initialize a panel. Called once when document is loaded.
     *
     * @since 1.0.0
     * @access private
     */
    function initPanel(side, target, $wrap, $panel, $button, options)
    {
        /* move the panel div to the end of the parent element */
        $wrap.appendTo(target);
        /* enable panel absolute positioning */
        $(target).css('position', 'relative');

        resetPanel(side);
        
        if (side === 'left')
        {
            setPanelZindex($wrap, $panel, target, options.leftZindex);
            
            // button
            $panel.css('background', options.leftBgColor);
            $('#mojo-sp-left-button > span').css('color', options.leftIconColor);
            $button.css('background', options.leftButtonBgColor);
            $button.hover(
                function() {
                    $button.css('left', '0px');
                    // There are cases where browser does not recognize hover-off event (e.g. mobile)
                    // Need to move the button back
                    setTimeout(function() {
                              $button.css('left', '-7px');
                            }, 1500);
                }, function() {
                    $button.css('left', '-7px');
            });
        }
        else
        {
            setPanelZindex($wrap, $panel, target, options.rightZindex);
            
            // button
            $panel.css('background', options.rightBgColor);
            $('#mojo-sp-right-button > span').css('color', options.rightIconColor);
            $button.css('background', options.rightButtonBgColor);
            $button.hover(
                function() {
                    $button.css('right', '0px');
                    // There are cases where browser does not recognize hover-off event (e.g. mobile)
                    // Need to move the button back
                    setTimeout(function() {
                              $button.css('right', '-7px');
                            }, 1500);
                }, function() {
                    $button.css('right', '-7px');
            });
        }
    }

    /**
     * @summary Set panel z-index value.
     *
     * Set panel z-index during initialization. Take a preset value or if
     * empty set a "best guess" values.
     *
     * @since 1.0.0
     * @access private
     */
    function setPanelZindex($wrap, $panel, target, setting)
    {
        if (target === 'body')
        {
            if (setting === '')
                // Body panel needs to be on top of everything. There may be e.g. adjacent elements, e.g. headers, with high z-index
                $wrap.css('z-index', '999999');
            else
                $wrap.css('z-index', setting);
        }
        else
        {
            if (setting === '')
                // Best guess, z-index 1 is in most cases enough to bring the panel top, but
                // keep it under possible fixed menubar with higher z-index
                $wrap.css('z-index', '1');
            else
                $wrap.css('z-index', setting);
            
            // Ensure parent is not blocking visibility
            $(target).css('overflow', 'visible');
        }
        
        // Panel needs to be on front of the tab button
        $panel.css('z-index', '1');
    }

    /**
     * @summary Tab button toggle events.
     *
     * Run this code when the #toggle-menu link has been tapped or clicked.
     *
     * @since 1.0.0
     * @access private
     */
    $('#mojosp-toggle-left, .mojosp-toggle-left, #mojo-sp-left-button').on('click', function (e) {
        e.preventDefault();

        if (leftOK)
            togglePanel($leftWrap, $leftPanel, $leftTarget, 'right', 'left');
        else
            alertNoElement();
    });
    
    $('#mojosp-toggle-right, .mojosp-toggle-right, #mojo-sp-right-button').on('click', function (e) {
        e.preventDefault();

        if (rightOK)
            togglePanel($rightWrap, $rightPanel, $rightTarget, 'left', 'right');
        else
            alertNoElement();
    });

    /**
     * @summary Error handling when target element is not avaiable.
     *
     * Run this if a user has clicked panel link but for some reason target element
     * is not available.
     *
     * @since 1.0.0
     * @access private
     */
    function alertNoElement()
    {
        alert('Oops, something went wrong. Please check in Wordpress Admin section that you have added minimum one widget in the panel (Appearance->Widgets) and in the Settings->MojoPlug Slide Panel that you have defined an existing Target Element.');
    }

    /**
     * @summary Toggle panel function.
     *
     * Whenever panel button or link is clicked this function is ran.
     *
     * @since 1.0.0
     * @access private
     */
    function togglePanel($wrap, $panel, $target, firstDir, secondDir)
    {
        var isLeftPanel = (secondDir === 'left');
        /* Cross browser support for CSS "transition end" event */
        var transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';

        /* When the toggle menu link is clicked, animation starts */

        $wrap.addClass('mojosp-animating');

        /***
         * Determine the direction of the animation and
         * add the correct direction class depending
         * on whether the menu was already visible.
         */
        if ($wrap.hasClass('mojosp-panel-visible')) {
            $wrap.addClass('mojosp-'+secondDir+'-to-'+secondDir);
        } else {
            $panel.css('display', 'block');
            $wrap.addClass('mojosp-'+secondDir+'-to-'+firstDir);
        }

        /***
         * When the animation (technically a CSS transition)
         * has finished, remove all mojosp-animating classes and
         * either add or remove the "mojosp-panel-visible" class 
         * depending whether it was visible or not previously.
         */
        $wrap.on(transitionEnd, function () {
            if ($wrap.hasClass('mojosp-panel-visible'))
            {
                // Panel just closed entirely
                if (isLeftPanel)
                {
                    $('#mojo-sp-left-button > span').addClass(leftIconOpen).removeClass(leftIconClose);
                    setPanelPosition('left', 'hidden');
                }
                else
                {
                    $('#mojo-sp-right-button > span').addClass(rightIconOpen).removeClass(rightIconClose);
                    setPanelPosition('right', 'hidden');
                }
            }
            else
            {
                // Panel just reached full width
                if (isLeftPanel)
                {
                    $('#mojo-sp-left-button > span').addClass(leftIconClose).removeClass(leftIconOpen);
                    setPanelPosition('left', 'visible');
                }
                else
                {
                    $('#mojo-sp-right-button > span').addClass(rightIconClose).removeClass(rightIconOpen);
                    setPanelPosition('right', 'visible');
                }
            }
            
            if (isLeftPanel)
            {
                $wrap
                    .removeClass('mojosp-animating mojosp-left-to-left mojosp-left-to-right')
                    .toggleClass('mojosp-panel-visible');
            }
            else
            {
                $wrap
                    .removeClass('mojosp-animating mojosp-right-to-left mojosp-right-to-right')
                    .toggleClass('mojosp-panel-visible');
            }
            
            $wrap.off(transitionEnd);
        });
    }
    
    /**
     * @summary Reset panel.
     *
     * Called when page is initialized or at the end of resize event.
     *
     * @since 1.0.0
     * @since 1.1.0 Panel default visibility
     * @access private
     */
    function resetPanel(side)
    {        
        var visibility = 'hidden';
        if ((side === 'left') && !!+mojospOptions.leftPanelShow)
        {
            visibility = 'visible';
        }
        else if ((side === 'right') && !!+mojospOptions.rightPanelShow)
        {
            visibility = 'visible';
        }
        
        setPanelWidth(side);
        setPanelPosition(side, visibility);
        
        // In case of windows resize, we need to remove and recreate the animiation <style>
        // Just in case the width of the screen is lower than predefined panel width
        if (side === 'left')
        {
            setLeftAnimCSS();
            if (visibility === 'hidden')
            {
                $('#mojo-sp-left-button > span').addClass(leftIconOpen).removeClass(leftIconClose);
            }
            else
            {
                $('#mojo-sp-left-button > span').addClass(leftIconClose).removeClass(leftIconOpen);
                $leftWrap.addClass('mojosp-panel-visible');
            }
        }
        else
        {
            setRightAnimCSS();
            if (visibility === 'hidden')
            {
                $('#mojo-sp-right-button > span').addClass(rightIconOpen).removeClass(rightIconClose);
            }
            else
            {
                $('#mojo-sp-right-button > span').addClass(rightIconClose).removeClass(rightIconOpen);
                $rightWrap.addClass('mojosp-panel-visible');
            }
        }

    }
    
    /**
     * @summary Set a panel position.
     *
     * The function calculates correct position and size of a panel.
     *
     * @since 1.0.0
     * @since 1.1.0 Panel default visibility
     * @access private
     */
    function setPanelPosition(side, pos)
    {
        if (side == 'left')
        {
            $('#mojo-sp-left').css('left', '-'+leftWidth+'px');
            if (pos === 'hidden')
            {
                var targetLeftMargin = $(leftTarget).offset().left;
                $leftWrap.css('left', (-targetLeftMargin).toString() + 'px');
                $leftPanel.css('display', 'none');
            }
            else
            {
                var targetLeftMargin = $(leftTarget).offset().left;
                $leftWrap.css('left', (-targetLeftMargin + leftWidth).toString() + 'px');
                $leftPanel.css('display', 'block');
            }
        }
        else
        {
            $('#mojo-sp-right').css('right', '-'+rightWidth+'px');
            if (pos === 'hidden')
            {
                var targetLeftMargin = $(rightTarget).offset().left;
                $rightWrap.css('right', (-($(window).width() - (targetLeftMargin + $(rightTarget).outerWidth()))).toString() + 'px');
                $rightPanel.css('display', 'none');
            }
            else
            {
                var targetLeftMargin = $(rightTarget).offset().left;
                $rightWrap.css('right', (-($(window).width() - (targetLeftMargin + $(rightTarget).outerWidth())) + rightWidth).toString() + 'px');
                $rightPanel.css('display', 'block');
            }
        }
    }
    
    /**
     * @summary Set panel width.
     *
     * Calculate panel width. Called during initialization and end of
     * windows resize.
     *
     * @since 1.0.0
     * @access private
     */
    function setPanelWidth(side)
    {
        var screenWidth = $('body').outerWidth();
        
        // Dynamic. If screen size is smaller than panel+button width, make panel smaller
        if (side === 'left')
        {
            leftWidth = parseInt(mojospOptions.leftWidth);
            
            if ((leftWidth + 57) > screenWidth)
                leftWidth = screenWidth - 57;

            $("#mojo-sp-left").css('width', leftWidth+'px');
        }
        else
        {
            rightWidth = parseInt(mojospOptions.rightWidth);
            
            if ((rightWidth + 57) > screenWidth)
                rightWidth = screenWidth - 57;

            $("#mojo-sp-right").css('width', rightWidth+'px');
        }
    }
    
    /**
     * @summary Set CSS needed for animation
     *
     * Set CSS <style> in DOM for the left panel. The style contains needed
     * animation transfroms.
     *
     * @since 1.0.0
     * @access private
     */
    function setLeftAnimCSS()
    {
        $('#mojosp-style-animation-left').remove();  // In case of window resize
        var styleStr = "<style id='mojosp-style-animation-left' type='text/css'>\n\
                        .mojosp-animating.mojosp-left-to-left {transform: translate3d( -"+leftWidth+"px, 0, 0 );\n\
                        -webkit-transform: translate3d( -"+leftWidth+"px, 0, 0 );}\n\
                        .mojosp-animating.mojosp-left-to-right {\n\
                        transform: translate3d( "+leftWidth+"px, 0, 0 );\n\
                        -webkit-transform: translate3d( "+leftWidth+"px, 0, 0 );}\n\
                        </style>";
        $("head").append(styleStr);
    }
    
    /**
     * @summary Set CSS needed for animation
     *
     * Set CSS <style> in DOM for the right panel. The style contains needed
     * animation transfroms.
     *
     * @since 1.0.0
     * @access private
     */
    function setRightAnimCSS()
    {
        $('#mojosp-style-animation-right').remove();  // In case of window resize
        var styleStr = "<style id='mojosp-style-animation-right' type='text/css'>\n\
                        .mojosp-animating.mojosp-right-to-left {transform: translate3d( -"+rightWidth+"px, 0, 0 );\n\
                        -webkit-transform: translate3d( -"+rightWidth+"px, 0, 0 );}\n\
                        .mojosp-animating.mojosp-right-to-right {\n\
                        transform: translate3d( "+rightWidth+"px, 0, 0 );\n\
                        -webkit-transform: translate3d( "+rightWidth+"px, 0, 0 );}\n\
                        </style>";
        $("head").append(styleStr);
    }

    /**
     * @summary Handle panel size and position in window resize event
     *
     * Handle panel resize in case of windows resize. Since there are no
     * native events for start and end of resize, we are using Timeout
     * functionality. We could resize panel continuosly, but this ensures
     * best possible performance.
     *
     * @since 1.0.0
     * @since 1.0.1 Workaround for iPhone Safari bug
     * @since 1.1.0 Panel default visibility
     * @access private
     */
    
    var resizeTimer;
    var resizeStarted = true;
    // Need to store window width because of iPhone Safari bug
    var windowWidth = $(window).width();
    $(window).resize(function () {

        // iPhone Safari bug handling
        if ($(window).width() == windowWidth)
            return;
        
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {

          // Resize ended
          resizeStarted = true;
          if (leftOK) resetPanel('left');
          if (rightOK) resetPanel('right');

        }, 250);
        
        // Reposition panels & buttons
        if (leftOK)
        {
            if (resizeStarted)
            {
                $('#mojo-sp-left-button > span').removeClass(leftIconClose).removeClass(leftIconOpen).addClass(leftIconOpen);
                $leftWrap.removeClass('mojosp-animating mojosp-left-to-left mojosp-left-to-right mojosp-panel-visible');
            }
            
            setPanelPosition('left', 'hidden');
        }
        
        if (rightOK)
        {
            if (resizeStarted)
            {
                $('#mojo-sp-right-button > span').removeClass(rightIconClose).removeClass(rightIconOpen).addClass(rightIconOpen);
                $rightWrap.removeClass('mojosp-animating mojosp-right-to-left mojosp-right-to-right mojosp-panel-visible');
            }
            setPanelPosition('right', 'hidden');
        }
        
        resizeStarted = false;
        windowWidth = $(window).width();
    });

})(jQuery);

/**
 * Author: Jason Farrell
 * Author URI: http://useallfive.com/
 *
 * Description: Checks if a DOM element is truly visible.
 * Package URL: https://github.com/UseAllFive/true-visibility
 */
Element.prototype.isVisible = function() {

    'use strict';

    /**
     * Checks if a DOM element is visible. Takes into
     * consideration its parents and overflow.
     *
     * @param (el)      the DOM element to check if is visible
     *
     * These params are optional that are sent in recursively,
     * you typically won't use these:
     *
     * @param (t)       Top corner position number
     * @param (r)       Right corner position number
     * @param (b)       Bottom corner position number
     * @param (l)       Left corner position number
     * @param (w)       Element width number
     * @param (h)       Element height number
     */
    function _isVisible(el, t, r, b, l, w, h) {
        var p = el.parentNode,
                VISIBLE_PADDING = 2;

        if ( !_elementInDocument(el) ) {
            return false;
        }

        //-- Return true for document node
        if ( 9 === p.nodeType ) {
            return true;
        }

        //-- Return false if our element is invisible
        if (
             '0' === _getStyle(el, 'opacity') ||
             'none' === _getStyle(el, 'display') ||
             'hidden' === _getStyle(el, 'visibility')
        ) {
            return false;
        }

        if (
            'undefined' === typeof(t) ||
            'undefined' === typeof(r) ||
            'undefined' === typeof(b) ||
            'undefined' === typeof(l) ||
            'undefined' === typeof(w) ||
            'undefined' === typeof(h)
        ) {
            t = el.offsetTop;
            l = el.offsetLeft;
            b = t + el.offsetHeight;
            r = l + el.offsetWidth;
            w = el.offsetWidth;
            h = el.offsetHeight;
        }
        //-- If we have a parent, let's continue:
        if ( p ) {
            //-- Check if the parent can hide its children.
            if ( ('hidden' === _getStyle(p, 'overflow') || 'scroll' === _getStyle(p, 'overflow')) ) {
                //-- Only check if the offset is different for the parent
                if (
                    //-- If the target element is to the right of the parent elm
                    l + VISIBLE_PADDING > p.offsetWidth + p.scrollLeft ||
                    //-- If the target element is to the left of the parent elm
                    l + w - VISIBLE_PADDING < p.scrollLeft ||
                    //-- If the target element is under the parent elm
                    t + VISIBLE_PADDING > p.offsetHeight + p.scrollTop ||
                    //-- If the target element is above the parent elm
                    t + h - VISIBLE_PADDING < p.scrollTop
                ) {
                    //-- Our target element is out of bounds:
                    return false;
                }
            }
            //-- Add the offset parent's left/top coords to our element's offset:
            if ( el.offsetParent === p ) {
                l += p.offsetLeft;
                t += p.offsetTop;
            }
            //-- Let's recursively check upwards:
            return _isVisible(p, t, r, b, l, w, h);
        }
        return true;
    }

    //-- Cross browser method to get style properties:
    function _getStyle(el, property) {
        if ( window.getComputedStyle ) {
            return document.defaultView.getComputedStyle(el,null)[property];
        }
        if ( el.currentStyle ) {
            return el.currentStyle[property];
        }
    }

    function _elementInDocument(element) {
        while (element = element.parentNode) {
            if (element == document) {
                    return true;
            }
        }
        return false;
    }

    return _isVisible(this);

};