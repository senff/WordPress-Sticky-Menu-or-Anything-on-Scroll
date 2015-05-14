<h3>Plugin info</h3>

<?php 
	$options = get_option('sticky_anything_options');
	$version = $options['sa_version'];
?>

<div class="inner">

	<ul>
		<li><strong><?php _e('Author:','Sticky Anything plugin'); ?></strong> <a href="http://www.senff.com" target="_blank">Mark Senff</a></li>
		<li><strong><?php _e('Version:','Sticky Anything plugin'); ?></strong> <?php echo $version; ?></li>
		<li><strong><?php _e('Detailed Documentation:','Sticky Anything plugin'); ?></strong> <a href="http://www.senff.com/plugins/sticky-anything-wp" target="_blank">Senff.com</a></li>
		<li><strong><?php _e('Support Forum','Sticky Anything plugin'); ?></strong>: <a href="https://wordpress.org/support/plugin/sticky-menu-or-anything-on-scroll" target="_blank">WordPress.org</a></li>
		<li><strong><?php _e('Donate:','Sticky Anything plugin'); ?></strong> <a href="http://www.senff.com/donate" target="_blank">Paypal</a></li>
		<li><strong><?php _e('Non-WP version:','Sticky Anything plugin'); ?></strong> <a href="https://github.com/senff/Sticky-Anything" target="_blank">GitHub</a></li>
		<li><strong><?php _e('Twitter:','Sticky Anything plugin'); ?></strong> <a href="http://www.twitter.com/senff" target="_blank">@Senff</a></li>
	</ul>

</div>

<p><a href="https://wordpress.org/support/plugin/sticky-menu-or-anything-on-scroll" target="_blank"><strong><?php _e('Please Report Bugs','Sticky Anything plugin'); ?></strong></a></p>
