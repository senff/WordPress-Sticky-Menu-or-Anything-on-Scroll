=== Sticky Menu (or Anything!) on Scroll ===
Contributors: senff
Donate link: http://www.senff.com/donate
Tags: sticky header, sticky menu, sticky, header, menu
Plugin URI: http://www.senff.com/plugins/sticky-anything-wp
Requires at least: 3.6
Tested up to: 4.5
Stable tag: 1.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sticky Menu (Or Anything!) On Scroll will let you choose any element on your page that will be "sticky" at the top once you scroll down.

== Description ==

= Summary =

The Sticky Menu (Or Anything) On Scroll plugin for WordPress allows you to make any element on your pages "sticky" as soon as it hits the top of the page when you scroll down. Although this is commonly used to keep menus at the top of your page, the plugin allows you to make ANY element sticky (such as a Call To Action box, a logo, etc.)

A little bit of basic HTML/CSS knowledge is required. You just need to know how to pick the right selector for the element you want to make sticky, and you need to be sure it's a unique selector. Sometimes a simple selector like "nav", "#main-menu", ".menu-main-menu-1" is enough. Other times you will have to be more detailed and use a more specific selector such as "header > ul:first-child" or "nav.top .menu-header ul.main".

= Features =

* **Any element can stick**: although common use is for navigation menus, the plugin will let you pick any unique element with a name, class or ID to stick at the top of the page once you scroll past it. Use it for a sidebar, Call-to-action box, banner ad, etc.
* **Positioning from top**: optionally, you can add any amount of space between the sticky element and the top of the page, so that the element is not always stuck at the "ceiling" of the page.
* **Enable for certain screen sizes only**: optionally, you can set a minimum and/or maximum screen size where the stickiness should work. This can be handy if you have a responsive site and you don't want your element to be sticky on smaller screens, for example. 
* **Push-up element**: optionally, you can pick any other element lower on the page that will push the sticky element up again (for example a sidebar widget).
* **Admin Bar aware**: checks if the current user has an Admin Toolbar at the top of the page. If it has, the sticky element will not obscure it (or be obscured by it).
* **Z-index**: in case there are other elements on the page that obscure or peek through your sticky element, you can add a Z-index easily.
* **Dynamic Mode**: some issues that frequently appear in responsive themes have been address by adding a Dynamic Mode. See FAQ for details.
* **Debug Mode:** find out possible reasons why your element doesn't stick by switching on Debug Mode, and error messages will appear in your browser's console.


== Installation ==

1. Upload the "sticky-menu-or-anything" directory to your "wp-content/plugins" directory.
1. In your WordPress admin, go to PLUGINS and activate "Sticky Menu (or Anything!)"
1. Go to SETTINGS - STICKY MENU (OR ANYTHING!)
1. Pick the element you want to make sticky
1. Party!


== Frequently Asked Questions ==

= I selected a class/ID in the settings screen, but the element doesn't stick when I scroll down. Why not? =
Make sure that if you select the element by its classname, it is preceded by a dot (e.g. ".main-menu"), and if you select it by its ID, that it's preceded by a pound/hash/number sign (e.g. "#main-menu").  Also, make sure there is only ONE element on the page with the selector you're using. If there is none, or more than one element that matches your selector, nothing will happen.

= I'm having some issues on mobile (or other responsive themes). = 
A number of people reported problems using a sticky element in a responsive theme - mostly situations involving a different menu (in both design and functionality) between desktop, tablet and mobile views. The newly-introduced 'Dynamic Mode' solves some of these problems. Try it yourself and chances are that works for you as well (though it's not a setting that will magically solves any and all problems that may occur).

= My menu sticks, but it doesn't open on the Responsive Theme when it's sticky. =
This is a known bug, and an incompatibility with the theme. I'm still looking into it. For the time being, it would be better to turn off stickiness for the mobile menu (set "Do not stick element when screen smaller than:" to 651 pixels).

= I have another plugin called Easy Smooth Scroll Links, but once my menu becomes sticky, that one doesn't work anymore. =
This has been reported by various users, and it turns out that the coding methods of this plugin are simply not compatible with the coding of the Easy Smooth Scroll Links plugin. Unfortunately, there is no solution available for this issue.
There is an alternative workaround however. According to reports from users who had this issue, a plugin called "Page Scroll To ID" (available in the WordPress.org plugin repo) is a worthy alternative to Easy Smooth Scroll Links and works with the Sticky Anything plugin.

= Users who are logged in to my site have a black Administrator Toolbar at the top of the screen, which would hide my sticky element when it's at the top of the screen. How can I fix that? =
Check the "Consider Administrator Toolbar" checkbox in the plugin's settings. With this setting on, your sticky element will be placed a little lower if there's an Administrator Toolbar present on the page.

= Well it works, but once the element becomes sticky, it's not positioned properly at all. =
There are situations when this happens, especially when the original element has specific properties that are specifically used to manipulate its position. Things like negative margins, absolute positioning or left/top values on the original element can have undesired effects when the element becomes sticky. If possible, try to avoid that.

= Still doesn't work. What could be wrong? =
Check the "Debug Mode" checkbox in the plugin's settings. Reload the page and you may see errors in your browser's console window. If you've used a selector that returns zero elements on the page, OR more than one, it will be shown.

= Is it possible to have multiple sticky elements? =
The current version only allows one sticky element. Having more than one may clutter up your page and confuse the user (imagine having a menu stuck at the top, and a banner stuck on the left, and another thing on the right, etc.). Having said that, this functionality may be added to a future version.

= What is this Dynamic Mode thing exactly? =
To properly explain this, we'll need to go a little deeper in the plugin's functionality. So bear with me...

When an element becomes sticky at the top of the page (and keeps its place regardless of the scrolling), it's actually not the element itself you see, but a cloned copy of it (the original element is out of view and invisible). 

The original element always stays where it originally is on the page, while the cloned element is always at the top of the browser viewport screen. However, you will never see them both at the same time; depending on your scroll position, it always just shows either one or the other.

In the original plugin version, the clone would be created right when you load the page. Then when you would scroll down, it would become visible (and stick at the top) while the original element would disappear.

However, some themes use some JavaScript to dynamically create elements (menus, mostly) for mobile sites. With this method, a menu doesn't exist in the HTML source code when you load the page, but is created on the fly some time after the page is fully loaded -- in many cases, these menus would just be generated ONLY when the screen is more (or less) than a certain specific width. With the original version of the plugin, the problem would be that the original element may not have been fully created upon page load, so the clone would also not be fully functional.

In Dynamic Mode, a clone of the element is not created on page load -- instead, it's created when the user scrolls and hits the "sticky" point. This ensures that the cloned element is an actual 1-on-1 copy of what the original element consists of at that specific point (and not at the "page is loaded" point, which may be different if the element was altered since).

Why don't we use Dynamic Mode all the time then? This has to do with the fact that other plugins initialize themselves on page load and may need the full markup (including the cloned element) at that point. In Dynamic Mode, there is no clone available yet on page load, so that could cause an issue.

Phew!

= I'll need more help please! = 
The plugin's own page can be found [here](http://www.senff.com/plugins/sticky-anything-wp). If that still doesn't help you solve your issue, please do NOT file a bug through the form on my website, but instead go to the plugin's [WordPress.org support forum](https://wordpress.org/support/plugin/sticky-menu-or-anything-on-scroll).



== Screenshots ==

1. Settings screen


== Changelog ==

= 1.3.1 =
* Minor bug fix for push-up element

= 1.3 =
* Added functionality to move sticky element down in case there is an Administrator Toolbar at the top of the page
* Added functionality to push sticky element up by another element lower down the page

= 1.2.4 =
* Fixed small bug related to version number

= 1.2.3 =
* Bug with Dynamic Mode select box/label fixed
* Bug with Z-index fixed (thanks @aguseo for reporting)
* All text in plugin fully translatable
* Added FAQ tab to settings screen
* Added infobox to settings screen
* Added a few comments to source code

= 1.2 =
* Dynamic Mode added (addressing problems with dynamically created menus -- see Frequently Asked Questions above for details)

= 1.1.4 =
* Ready for WordPress 4.1 (and TwentyFifteen)
* Fixes issue when element has padding in percentages

= 1.1.3 =
* Fixes width calculation bug introduced in previous version (sorry about that), box sizing now supported

= 1.1.2 =
* Fixes element width calculation bug

= 1.1.1 =
* Fixes viewport calculation bug

= 1.1 =
* Added functionality for optional minimum/maximum screen size

= 1.0 =
* Initial release (using v1.1 of the standalone jQuery plugin)


== Upgrade Notice ==

= 1.3.1 =
* Minor bug fix for push-up element

= 1.3 =
* BY POPULAR DEMAND: functionalities added related to Administrator Toolbar and element that can push sticky element up

= 1.2.4 =
* Minor bugfix

= 1.2.3 =
* Bugfixes, improvements and translation-ready

= 1.2 =
* Dynamic Mode added

= 1.1.4 =
* Bugfixes, ready for WordPress 4.1 (and TwentyFifteen)

= 1.1.3 =
* Bugfix for new bug introduced in 1.1.2

= 1.1.2 =
* Bugfixes

= 1.1.1 =
* Bugfixes

= 1.1 =
* Added functionality (minimum and/or maximum screen size)

= 1.0 =
* Initial release of the plugin
