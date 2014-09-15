=== Sticky Menu (or Anything!) on Scroll ===
Contributors: Mark Senff
Tags: plugin, sticky, menu, element, scroll
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Requires at least: 3.6
Tested up to: 4.0
Stable tag: 1.0


== Description ==
The Sticky Menu (Or Anything) On Scroll plugin for WordPress allows you to make any element on your pages "sticky" as soon as it hits the top of the page when you scroll down. Although this is commonly used to keep menus at the top of your page, the plugin allows you to make ANY element sticky (such as a Call To Action box, a logo, etc.)


**Features**

- any unique element with a name, class or ID can stick at the top of the page once you scroll past it
- optionally, add any amount of space so that the element is not stuck at the very top of the page
- optionally, add Z-index to element in case other elements obscure or peek through
- debug mode: find out possible reasons why your element doesn't stick


== Changelog ==

= 1.0 RELEASE =
* initial release (using v1.1 of the standalone jQuery plugin)


== Installation ==

- Upload the "sticky-menu-or-anything" directory to your "wp-content/plugins" directory.
- In your WordPress admin, go to PLUGINS and activate "Sticky Menu (or Anything!)"
- Pick the element you want to make sticky by configuring the plugin under SETTINGS - STICKY MENU (OR ANYTHING!)


== Frequently Asked Questions ==

Q: I selected a class/ID in the settings screen, but the element doesn't stick when I scroll downs. Why not?
A: Make sure that if you select the element by its classname, it is preceded by a dot (e.g. ".main-menu"), and if you select it by its ID, that it's preceded by a pound/hash/number sign (e.g. "#main-menu").  Also, make sure there is only ONE element on the page with the selector you're using. If there is none, or more than one element that matches your selector, nothing will happen.

Q: Still doesn't work, man.
A: Check the "Debug Mode" checkbox in the plugin's settings. Reload the page and you may see errors in your browser's console window.

Q: I'll need more help please!
A: The plugin's own page can be found at http://www.senff.com/plugins/sticky-anything-wp

Q: I remember you! Are you still involved with Def Leppard?
A: Nope. Still friends with some of them though.


For any other issues, please use the WordPress.org forum.

