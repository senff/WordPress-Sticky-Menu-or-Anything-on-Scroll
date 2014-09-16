<?php
/*
Plugin Name: Sticky Menu (or Anything!) on Scroll
Plugin URI: http://www.senff.com/plugins/sticky-anything-wp
Description: Pick any element on your page, and it will stick when it reaches the top of the page when you scroll down. Usually handy for navigation menus, but can be used for any (unique) element on your page.
Author: Mark Senff
Author URI: http://www.senff.com
Version: 1.0
*/

defined('ABSPATH') or die('Gorgonzola. Wow, BOB, wow.');


// === FUNCTIONS =========================================================================================================

if (!function_exists('sticky_anthing_default_options')) {
	function sticky_anthing_default_options() {
		$versionNum = '0.2';
		if (get_option('sticky_anything_options') === false) {
			$new_options['sa_version'] = $versionNum;
			$new_options['sa_element'] = '';
			$new_options['sa_topspace'] = '';
			$new_options['sa_zindex'] = '';
			$new_options['sa_debugmode'] = false;
			add_option('sticky_anything_options',$new_options);
		} else {
			$existing_options = get_option('sticky_anything_options');
			$existing_options['sa_version'] = $versionNum;
			update_option('sticky_anything_options',$existing_options);
		}
	}
}


if (!function_exists('load_sticky_anything')) {
    function load_sticky_anything() {

		// Main jQuery plugin file 
	    wp_register_script('stickyAnythingLib', plugins_url('/assets/js/jq-sticky-anything.min.js', __FILE__), array( 'jquery' ), '1.1');
	    wp_enqueue_script('stickyAnythingLib');

		$options = get_option('sticky_anything_options');

		// Set defaults when empty (because '' does not work with the JQ plugin) 

		if (!$options['sa_topspace']) {
			$options['sa_topspace'] = '0';
		}

		if (!$options['sa_zindex']) {
			$options['sa_zindex'] = '1';
		}

		$script_vars = array(
		      'element' => $options['sa_element'],
		      'topspace' => $options['sa_topspace'],
		      'zindex' => $options['sa_zindex'],
		      'debugmode' => $options['sa_debugmode']
		);

		wp_enqueue_script('stickThis', plugins_url('/assets/js/stickThis.js', __FILE__), array( 'jquery' ), '1.1', true);
		wp_localize_script( 'stickThis', 'sticky_anything_engage', $script_vars );

    }
}


if (!function_exists('sticky_anything_menu')) {
    function sticky_anything_menu() {
		add_options_page( 'Sticky Menu (or Anything!) Configuration', 'Sticky Menu (or Anything!)', 'manage_options', 'stickyanythingmenu', 'sticky_anything_config_page' );
    }
}


if (!function_exists('sticky_anything_config_page')) {
	function sticky_anything_config_page() {
	// Retrieve plugin configuration options from database
	$sticky_anything_options = get_option( 'sticky_anything_options' );
	?>

	<div id="sticky-anything-settings-general" class="wrap">
		<h2>Sticky Menu (or Anything!) Settings</h2>

		<p>Pick any element on your page, and it will stick when it reaches the top of the page when you scroll down. Usually handy for navigation menus, but can be used for any (unique) element on your page.</p>

		<?php 

			$warnings = false;

			if ( isset( $_GET['message'] )) { 
				if ($_GET['message'] == '1') {
					echo '<div id="message" class="fade updated"><p><strong>Settings Updated</strong></p></div>';
				}
			} 
			
			if ( isset( $_GET['message'] )) { 
				if ($sticky_anything_options['sa_element'] == '') {
					$warnings = true;  
				}
			}

			if ( (!is_numeric($sticky_anything_options['sa_topspace'])) && ($sticky_anything_options['sa_topspace'] != '')) {
				// Top space is not empty and has bad value
				$warnings = true;
			}

			if ((!is_numeric($sticky_anything_options['sa_zindex'])) && ($sticky_anything_options['sa_zindex'] != '')) {
				// Z-index is not empty and has bad value
				$warnings = true;
			}


			// IF THERE ARE ERRORS, SHOW THEM
			if ( $warnings == true ) { 
				echo '<div id="message" class="error"><p><strong>Please review the current settings:</strong></p>';
				echo '<ul style="list-style-type:disc; margin:0 0 20px 24px;">';

				if ($sticky_anything_options['sa_element'] == '') {
					echo '<li><strong>ELEMENT</strong> is a required field. If you do not want anything sticky, consider disabling the plugin.</li>';
				} 

				if ( (!is_numeric($sticky_anything_options['sa_topspace'])) && ($sticky_anything_options['sa_topspace'] != '')) {
					echo '<li><strong>TOP POSITION</strong> has to be a number (do not include "px" or "pixels", or any other characters).</li>';
				}

				if ((!is_numeric($sticky_anything_options['sa_zindex'])) && ($sticky_anything_options['sa_zindex'] != '')) {
					echo '<li><strong>Z-INDEX</strong> has to be a number (do not include any other characters).</li>';
				}

				echo '</ul></div>';
			} 			

		?>



		<table class="widefat"><tr><td>

		<form method="post" action="admin-post.php">

			<input type="hidden" name="action" value="save_sticky_anything_options" />
			<!-- Adding security through hidden referrer field -->
			<?php wp_nonce_field( 'sticky_anything' ); ?>

			<table class="form-table">

				<tr>
					<th scope="row">Sticky Element: <span class="required">*</span> <a href="#" title="The element that needs to be sticky once you scroll. This can be your menu, or any other element like a sidebar, ad banner, etc. Make sure this is a unique identifier." class="help">?</a></th>
					<td>
						<input type="text" id="sa_element" name="sa_element" value="<?php 
							if ($sticky_anything_options['sa_element'] != '#NO-ELEMENT') {
								echo esc_html( $sticky_anything_options['sa_element'] ); 
							}
						?>"/> (e.g. #main-navigation, .main-menu-1, header nav, etc.) 
					</td>
				</tr>


				<tr>
					<th scope="row">Space between top of page and sticky element: (optional) <a href="#" title="If you don't want the element to be sticky at the very top of the page, but a little lower, add the number of pixels that should be between your element and the 'ceiling' of the page." class="help">?</a></th>
					<td>
						<input type="number" id="sa_topspace" name="sa_topspace" value="<?php echo esc_html( $sticky_anything_options['sa_topspace'] ); ?>" style="width:80px;" /> pixels
					</td>
				</tr>

				<tr>
					<th scope="row">Z-index: (optional) <a href="#" title="If there are other elements on the page that obscure/overlap the sticky element, adding a Z-index might help. If you have no idea what that means, try entering 99999." class="help">?</a></th>
					<td>
						<input type="number" id="sa_zindex" name="sa_zindex" value="<?php echo esc_html( $sticky_anything_options['sa_zindex'] ); ?>" style="width:80px;" />
					</td>
				</tr>

				<tr>
					<th scope="row">Debug mode: <a href="#" title="When Debug Mode is on, error messages will be shown in your browser's console when the element you selected either doesn't exist, or when there are more elements on the page with your chosen selector." class="help">?</a></th>
					<td>
						<input type="checkbox" id="sa_debugmode" name="sa_debugmode" <?php if ($sticky_anything_options['sa_debugmode']  ) echo ' checked="checked" ';?> />
						<label for="sa_debugmode"><strong>Log plugin errors in browser console</strong></label>
						<p class="description">Do NOT check this option in production environments.</p>
					</td>
				</tr>

			</table>

			<input type="submit" value="SAVE SETTINGS" class="button-primary"/>

			<p></p>
		</form>

		</td></tr></table>

		<hr>

		<p><a href="http://www.senff.com/plugins/sticky-anything-wp" target="_blank">Sticky Menu (or Anything!) on Scroll</a> version 1.0 by <a href="http://www.senff.com" target="_blank">Senff</a> &nbsp;/&nbsp; <a href="http://www.senff.com/contact" target="_blank">Please Report Bugs</a> &nbsp;/&nbsp; Follow on Twitter: <a href="http://www.twitter.com/senff" target="_blank">@Senff</a> &nbsp;/&nbsp; <a href="http://www.senff.com/plugins/sticky-anything-wp" target="_blank">Detailed documentation</a> &nbsp;/&nbsp; <a href="http://www.senff.com/plugins/sticky-anything" target="_blank">Non-WP jQuery plugin</a></p>

	</div>

	<?php
	}
}


if (!function_exists('sticky_anything_admin_init')) {
	function sticky_anything_admin_init() {
		add_action( 'admin_post_save_sticky_anything_options', 'process_sticky_anything_options' );
	}
}


if (!function_exists('process_sticky_anything_options')) {
	function process_sticky_anything_options() {

		if ( !current_user_can( 'manage_options' ))
			wp_die( 'Not allowed');

		check_admin_referer('sticky_anything');
		$options = get_option('sticky_anything_options');

		foreach ( array('sa_element') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			} 
		}

		foreach ( array('sa_topspace') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_zindex') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_debugmode') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = true;
			} else {
				$options[$option_name] = false;
			}
		}

		update_option( 'sticky_anything_options', $options );	
 		wp_redirect( add_query_arg(
 			array('page' => 'stickyanythingmenu', 'message' => '1'),
 			admin_url( 'options-general.php' ) 
 			)
 		);	

		exit;
	}
}





// === HOOKS AND ACTIONS ==================================================================================

register_activation_hook( __FILE__, 'sticky_anthing_default_options' );
add_action('wp_enqueue_scripts', 'load_sticky_anything');
add_action('admin_menu', 'sticky_anything_menu');
add_action('admin_init', 'sticky_anything_admin_init' );


