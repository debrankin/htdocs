=== MojoPlug Slide Panel ===
Contributors: qumos
Donate link: http://mojoplug.com/
Tags: slide panel, sliding panel, slide sidebar, panel slider, off canvas, side panel, hidden, slideout, sliding widget
Requires at least: 4.0.0
Tested up to: 4.7
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lightweight, fast and smooth slide panel for your favorite widgets. Clean interface, customizable appearance, mobile friendly.

== Description ==

MojoPlug Slide Panel is a lightweight and easy-to-use plugin for adding left and/or right slide panels on your page. You can freely add one or more of your favorite widgets on a panel. The plugin is free.

Take a look at the Slide Panel in action: [DEMO](http://mojoplug.com/slide-panel)

= Fast and Smooth =
MojoPlug Slide Panel plays slide animation smoother than most of the similar tools out there. The difference becomes obvious especially with mobile devices.

= Customize =
The plugin has many customization options to make it perfect fit for your site. You can change background and text colors, opacity and vertical position of a tab button - amongst other things.

= How it works? =
After installing the plugin, a panel is activated by simply adding widgets on it in Appearance->Widgets area. You can modify the layout and some other things in Settings screen and style.css file.

Panel is attached to a 'body' tag by default and you will see a panel tab on top corner of every page on your site. You can attach the panel on settings to any other element. For example, you may prefer to see the panel only on the front page, next to your welcome section.

If you want to toggle the panel with your own button, that's possible too, and you can remove the side tab in Settings.

= Features =
* Smooth sliding in mobile devices too, thanks to hardware acceleration
* Toggle slide panel either with built-in tab button and/or your own button or link
* Customize background and text colors, opacity and tab button vertical location
* Make panel to appear on every page by attaching it to "body" tag
* Make panel to appear next to any other element (post, sidebar, row) by attaching it to an html element (ID, class or tag)

== Installation ==

1. Install MojoPlug Slide Panel via the plugin directory, or by uploading the files manually to your server.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Activate panel(s) in 'Appearance->Widgets' screen in WordPress. Drop minimum one widget on a panel to make it visible.

This should be enough to see the panel on your site. Read more about how to customize your panel here: [http://mojoplug.com/slide-panel](http://mojoplug.com/slide-panel)

== Frequently Asked Questions ==

= I have followed the instructions but I can't see the tab button or panel on the page. Why? =
A typical reason for this may be that some HTML elements on the page that are overlapping or hiding the button and panel.

If you understand HTML code, try to find elements with z-index or overflow:hidden CSS directives on the page. For example, if z-index value is very high for a sidebar, it may block the panel entirely.

You may solve these type of problems in various ways:
a) tuning MojoPlug Slide Panel z-index in settings to higher value
b) tuning your theme element's z-index to lower value and/or removing overflow:hidden
b) attaching panel to some other element in Settings
c) trying out with some other Wordpress theme

= I can see Slide Panel tab button, but when clicking it nothing happens. Why? =
See the first question. The most probable reason is that some other elements on your page are using higher z-index value than Slide Panel.

= Some other page elements are flowing on top of my panel. How can I fix it? =
See the first question. Other elements are probably having higher z-index value than the panel.

= How can I change panel's text color? =
Go to Plugins->Installed Plugins and press "edit" in MojoPlug Slide Panel section. Find the style.css and modify it to set headline and normal text colors.

= How can I change tab button's vertical position? =
Go to Plugins->Installed Plugins and press "edit" in MojoPlug Slide Panel section. Open the style.css and find the tab button section. Use "top" parameter to set button position.

== Screenshots ==

1. A client site with a demo Slide Panel.
2. A site with two open slide panels.
3. Slide Panel in action. Actual photo from Jolla phone's screen.
4. Slide Panel settings.

== Changelog ==

= 1.1.1 =
* Fixes compatibility issue with Visual Composer

= 1.1.0 =
* Allow to set default panel state, either Show or Hidden.
* Minor bugs fixed.

= 1.0.1 =
* Workaround for bug in iPhone Safari closing open panel when scrolling.

= 1.0.0 =
* The first version
