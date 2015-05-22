<h2><?php _e('FAQ','Sticky Anything plugin'); ?>/<?php _e('Troubleshooting','Sticky Anything plugin'); ?></h2>

<p><strong><?php _e('Q: I selected a class/ID in the settings screen, but the element doesn\'t stick when I scroll down. Why not?','Sticky Anything plugin'); ?></strong>
<?php _e('Make sure that if you select the element by its classname, it is preceded by a dot (e.g. ".main-menu"), and if you select it by its ID, that it\'s preceded by a pound/hash/number sign (e.g. "#main-menu").  Also, make sure there is only ONE element on the page with the selector you\'re using. If there is none, or more than one element that matches your selector, nothing will happen.','Sticky Anything plugin'); ?></p>

<p><strong><?php _e('Q: I\'m having some issues on mobile (or other responsive themes).','Sticky Anything plugin'); ?></strong>
<?php _e('A number of people reported problems using a sticky element in a responsive theme - mostly situations involving a different menu (in both design and functionality) between desktop, tablet and mobile views. The \'Dynamic Mode\' solves some of these problems. Try it yourself and chances are that works for you as well (though it\'s not a setting that will magically solves any and all problems that may occur).','Sticky Anything plugin'); ?></p>

<p><strong><?php _e('Q: My menu sticks, but it doesn\'t open on the <a href="https://wordpress.org/themes/responsive" target="_blank">Responsive</a> theme when it\'s sticky.','Sticky Anything plugin'); ?></strong>
<?php _e('This is a known bug and I\'m looking into it. Haven\'t made much progress since last update though, I\'m sad to say.','Sticky Anything plugin'); ?></p>

<p><strong><?php _e('Q: I have another plugin called <a href="https://wordpress.org/plugins/easy-smooth-scroll-links/" target="_blank">Easy Smooth Scroll Links</a>, but once my menu becomes sticky, that one doesn\'t work anymore.','Sticky Anything plugin'); ?></strong>
<?php _e('This has been reported by various users, and it turns out that the coding methods of this plugin are simply not compatible with the coding of the Easy Smooth Scroll Links plugin. Unfortunately, there is no solution available for this issue.<br>There is an alternative workaround however. According to reports from users who had this issue, a plugin called <a href="https://wordpress.org/plugins/page-scroll-to-id/" target="_blank">Page Scroll To ID</a> is a worthy alternative to Easy Smooth Scroll Links and works with the Sticky Anything plugin.','Sticky Anything plugin'); ?></p>	

<p><strong><?php _e('Q: Users who are logged in to my site have a black Administrator Toolbar at the top of the screen, which would hide my sticky element when it\'s at the top of the screen. How can I fix that?','Sticky Anything plugin'); ?></strong>
<?php _e('Check the "Consider Administrator Toolbar" checkbox in the plugin\'s settings. With this setting on, your sticky element will be placed a little lower if there\'s an Administrator Toolbar present on the page.','Sticky Anything plugin'); ?></p>

<p><strong><?php _e('Q: Well it works, but once the element becomes sticky, it\'s not positioned properly at all.','Sticky Anything plugin'); ?></strong>
<?php _e('There are situations when this happens, especially when the original element has specific properties that are specifically used to manipulate its position. Things like negative margins, absolute positioning or left/top values on the original element can have undesired effects when the element becomes sticky. If possible, try to avoid that.','Sticky Anything plugin'); ?></p>

<p><strong><?php _e('Q: Still doesn\'t work. What could be wrong?','Sticky Anything plugin'); ?></strong>
<?php _e('Check the "Debug Mode" checkbox in the plugin\'s settings. Reload the page and you may see errors in your browser\'s console window. If you\'ve used a selector that returns zero elements on the page, OR more than one, it will be shown.','Sticky Anything plugin'); ?></p>

<p><strong><?php _e('Q: Is it possible to have multiple sticky elements?','Sticky Anything plugin'); ?></strong>
<?php _e('The current version only allows one sticky element. Having more than one may clutter up your page and confuse the user (imagine having a menu stuck at the top, and a banner stuck on the left, and another thing on the right, etc.). Having said that, this functionality may be added to a future version.','Sticky Anything plugin'); ?></p>

<p><strong><?php _e('Q: What is this Dynamic Mode thing exactly?','Sticky Anything plugin'); ?></strong>
<?php _e('To properly explain this, we\'ll need to go a little deeper in the plugin\'s functionality. So bear with me...','Sticky Anything plugin'); ?></p>
<p><?php _e('When an element becomes sticky at the top of the page (and keeps its place regardless of the scrolling), it\'s actually not the element itself you see, but a cloned copy of it (the original element is out of view and invisible).','Sticky Anything plugin'); ?></p>
<p><?php _e('The original element always stays where it originally is on the page, while the cloned element is always at the top of the browser viewport screen. However, you will never see them both at the same time; depending on your scroll position, it always just shows either one or the other.','Sticky Anything plugin'); ?></p>
<p><?php _e('In the original plugin version, the clone would be created right when you load the page. Then when you would scroll down, it would become visible (and stick at the top) while the original element would disappear.','Sticky Anything plugin'); ?></p>
<p><?php _e('However, some themes use some JavaScript to dynamically create elements (menus, mostly) for mobile sites. With this method, a menu doesn\'t exist in the HTML source code when you load the page, but is created on the fly some time after the page is fully loaded -- in many cases, these menus would just be generated ONLY when the screen is more (or less) than a certain specific width. With the original version of the plugin, the problem would be that the original element may not have been fully created upon page load, so the clone would also not be fully functional.','Sticky Anything plugin'); ?></p>
<p><?php _e('In Dynamic Mode, a clone of the element is not created on page load -- instead, it\'s created when the user scrolls and hits the "sticky" point. This ensures that the cloned element is an actual 1-on-1 copy of what the original element consists of at that specific point (and not at the "page is loaded" point, which may be different if the element was altered since).','Sticky Anything plugin'); ?></p>
<p><?php _e('Why don\'t we use Dynamic Mode all the time then? This has to do with the fact that other plugins initialize themselves on page load and may need the full markup (including the cloned element) at that point. In Dynamic Mode, there is no clone available yet on page load, so that could cause an issue.','Sticky Anything plugin'); ?></p>
<p><?php _e('Phew!','Sticky Anything plugin'); ?></p>

<p><strong><?php _e('Q: I\'ll need more help please!','Sticky Anything plugin'); ?></strong>
<?php _e('The plugin\'s own page can be found at <a href="http://www.senff.com/plugins/sticky-anything-wp" target="_blank">http://www.senff.com/plugins/sticky-anything-wp</a>. If that still doesn\'t help you solve your issue, please do NOT file a bug through the form on my website, but instead go to the plugin\'s support forum on <a href="https://wordpress.org/support/plugin/sticky-menu-or-anything-on-scroll" target="_blank">WordPress.org</a>.','Sticky Anything plugin'); ?></p>
