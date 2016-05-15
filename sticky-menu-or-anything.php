<?php
/*
Plugin Name: Sticky Menu (or Anything!) on Scroll
Plugin URI: http://www.senff.com/plugins/sticky-anything-wp
Description: Pick any element on your page, and it will stick when it reaches the top of the page when you scroll down. Usually handy for navigation menus, but can be used for any (unique) element on your page.
Author: Mark Senff
Author URI: http://www.senff.com
Version: 1.3.1
*/

defined('ABSPATH') or die('INSERT COIN');


/**
 * === FUNCTIONS ========================================================================================
 */

/**
 * --- IF DATABASE VALUES ARE NOT SET AT ALL, ADD DEFAULT OPTIONS TO DATABASE ---------------------------
 */
if (!function_exists('sticky_anthing_default_options')) {
	function sticky_anthing_default_options() {
		$versionNum = '1.3.1';
		if (get_option('sticky_anything_options') === false) {
			$new_options['sa_version'] = $versionNum;
			$new_options['sa_element'] = '';
			$new_options['sa_topspace'] = '';
			$new_options['sa_adminbar'] = true;
			$new_options['sa_minscreenwidth'] = '';			
			$new_options['sa_maxscreenwidth'] = '';			
			$new_options['sa_zindex'] = '';
			$new_options['sa_dynamicmode'] = false;		
			$new_options['sa_debugmode'] = false;
			$new_options['sa_pushup'] = '';
			add_option('sticky_anything_options',$new_options);
		} 
	}
}

/**
 * --- IF DATABASE VALUES EXIST, CHECK IF NEWER OPTIONS EXIST ------------------------------------------
 * --- IF NOT, ADD THESE OPTIONS WITH DEFAULT VALUES ---------------------------------------------------
 * --- AND UPDATE VERSION NUMBER FOR SURE --------------------------------------------------------------
 */
if (!function_exists('sticky_anything_update')) {
	function sticky_anything_update() {
		$versionNum = '1.3.1';
		$existing_options = get_option('sticky_anything_options');

		if(!isset($existing_options['sa_minscreenwidth'])) {
			// Introduced in version 1.1
			$existing_options['sa_minscreenwidth'] = '';
			$existing_options['sa_maxscreenwidth'] = '';
		} 

		if(!isset($existing_options['sa_dynamicmode'])) {
			// Introduced in version 1.2
			$existing_options['sa_dynamicmode'] = false;
		} 

		if(!isset($existing_options['sa_pushup'])) {
			// Introduced in version 1.3
			$existing_options['sa_pushup'] = '';
			$existing_options['sa_adminbar'] = true;
		} 

		$existing_options['sa_version'] = $versionNum;
		update_option('sticky_anything_options',$existing_options);
	}
}


/**
 * --- LOAD MAIN .JS FILE AND CALL IT WITH PARAMETERS (BASED ON DATABASE VALUES) -----------------------
 */
if (!function_exists('load_sticky_anything')) {
    function load_sticky_anything() {

		$options = get_option('sticky_anything_options');
		$versionNum = $options['sa_version'];

		// Main jQuery plugin file 
	    	wp_register_script('stickyAnythingLib', plugins_url('/assets/js/jq-sticky-anything.min.js', __FILE__), array( 'jquery' ), $versionNum);
	    	wp_enqueue_script('stickyAnythingLib');

		$options = get_option('sticky_anything_options');

		// Set defaults for by-default-empty elements (because '' does not work with the JQ plugin) 
		if (!$options['sa_topspace']) {
			$options['sa_topspace'] = '0';
		}

		if (!$options['sa_minscreenwidth']) {
			$options['sa_minscreenwidth'] = '0';
		}

		if (!$options['sa_maxscreenwidth']) {
			$options['sa_maxscreenwidth'] = '999999';
		}

		// If empty, set to 1 - not to 0. Also, if set to "0", keep it at 0.
		if (strlen($options['sa_zindex']) == "0") {
			$options['sa_zindex'] = '1';
		}

		$script_vars = array(
		      'element' => $options['sa_element'],
		      'topspace' => $options['sa_topspace'],
		      'minscreenwidth' => $options['sa_minscreenwidth'],
		      'maxscreenwidth' => $options['sa_maxscreenwidth'],
		      'zindex' => $options['sa_zindex'],
		      'dynamicmode' => $options['sa_dynamicmode'],
		      'debugmode' => $options['sa_debugmode'],
		      'pushup' => $options['sa_pushup'],
		      'adminbar' => $options['sa_adminbar']
		);

		wp_enqueue_script('stickThis', plugins_url('/assets/js/stickThis.js', __FILE__), array( 'jquery' ), $versionNum, true);
		wp_localize_script( 'stickThis', 'sticky_anything_engage', $script_vars );

    }
}


/**
 * --- ADD LINK TO SETTINGS PAGE TO SIDEBAR ------------------------------------------------------------
 */
if (!function_exists('sticky_anything_menu')) {
    function sticky_anything_menu() {
		add_options_page( 'Sticky Menu (or Anything!) Configuration', 'Sticky Menu (or Anything!)', 'manage_options', 'stickyanythingmenu', 'sticky_anything_config_page' );
    }
}


/**
 * --- ADD LINK TO SETTINGS PAGE TO PLUGIN ------------------------------------------------------------
 */
if (!function_exists('sticky_anything_settings_link')) {
function sticky_anything_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=stickyanythingmenu">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
}


/**
 * --- THE WHOLE ADMIN SETTINGS PAGE -------------------------------------------------------------------
 */
if (!function_exists('sticky_anything_config_page')) {
	function sticky_anything_config_page() {
	// Retrieve plugin configuration options from database
	$sticky_anything_options = get_option( 'sticky_anything_options' );
	?>

	<div id="sticky-anything-settings-general" class="wrap">
		<h2><?php _e('Sticky Menu (or Anything!) Settings','Sticky Anything plugin'); ?></h2>

		<p><?php _e('Pick any element on your page, and it will stick when it reaches the top of the page when you scroll down. Usually handy for navigation menus, but can be used for any (unique) element on your page.','Sticky Anything plugin'); ?></p>

		<div class="main-content">

			<h2 class="nav-tab-wrapper">	
				<a class="nav-tab" href="#main"><?php _e('Settings','Sticky Anything plugin'); ?></a>
				<a class="nav-tab" href="#faq"><?php _e('FAQ/Troubleshooting','Sticky Anything plugin'); ?></a>
			</h2>

			<br>

			<?php 

				$warnings = false;

				if ( isset( $_GET['message'] )) { 
					if ($_GET['message'] == '1') {
						echo '<div id="message" class="fade updated"><p><strong>'.__('Settings Updated.','Sticky Anything plugin').'</strong></p></div>';
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

				if ( (!is_numeric($sticky_anything_options['sa_minscreenwidth'])) && ($sticky_anything_options['sa_minscreenwidth'] != '')) {
					// Minimum width is not empty and has bad value
					$warnings = true;
				}

				if ( (!is_numeric($sticky_anything_options['sa_maxscreenwidth'])) && ($sticky_anything_options['sa_maxscreenwidth'] != '')) {
					// Maximum width is not empty and has bad value
					$warnings = true;
				}

				if ( ($sticky_anything_options['sa_minscreenwidth'] != '') && ($sticky_anything_options['sa_maxscreenwidth'] != '') && ( ($sticky_anything_options['sa_minscreenwidth']) >= ($sticky_anything_options['sa_maxscreenwidth']) ) ) {
					// Minimum width is larger than the maximum width
					$warnings = true;
				}

				if ((!is_numeric($sticky_anything_options['sa_zindex'])) && ($sticky_anything_options['sa_zindex'] != '')) {
					// Z-index is not empty and has bad value
					$warnings = true;
				}

				// IF THERE ARE ERRORS, SHOW THEM
				if ( $warnings == true ) { 
					echo '<div id="message" class="error"><p><strong>'.__('Please review the current settings:','Sticky Anything plugin').'</strong></p>';
					echo '<ul style="list-style-type:disc; margin:0 0 20px 24px;">';

					if ($sticky_anything_options['sa_element'] == '') {
						echo '<li>'.__('ELEMENT is a required field. If you do not want anything sticky, consider disabling the plugin.','Sticky Anything plugin').'</li>';
					} 

					if ( (!is_numeric($sticky_anything_options['sa_topspace'])) && ($sticky_anything_options['sa_topspace'] != '')) {
						echo '<li>'.__('TOP POSITION has to be a number (do not include "px" or "pixels", or any other characters).','Sticky Anything plugin').'</li>';
					}

					if ( (!is_numeric($sticky_anything_options['sa_minscreenwidth'])) && ($sticky_anything_options['sa_minscreenwidth'] != '')) {
						echo '<li>'.__('MINIMUM SCREEN WIDTH has to be a number (do not include "px" or "pixels", or any other characters).','Sticky Anything plugin').'</li>';
					}

					if ( (!is_numeric($sticky_anything_options['sa_maxscreenwidth'])) && ($sticky_anything_options['sa_maxscreenwidth'] != '')) {
						echo '<li>'.__('MAXIMUM SCREEN WIDTH has to be a number (do not include "px" or "pixels", or any other characters).','Sticky Anything plugin').'</li>';
					}

					if ( ($sticky_anything_options['sa_minscreenwidth'] != '') && ($sticky_anything_options['sa_maxscreenwidth'] != '') && ( ($sticky_anything_options['sa_minscreenwidth']) >= ($sticky_anything_options['sa_maxscreenwidth']) ) ) {
						echo '<li>'.__('MAXIMUM screen width has to have a larger value than the MINIMUM screen width.','Sticky Anything plugin').'</li>';
					}

					if ((!is_numeric($sticky_anything_options['sa_zindex'])) && ($sticky_anything_options['sa_zindex'] != '')) {
						echo '<li>'.__('Z-INDEX has to be a number (do not include any other characters).','Sticky Anything plugin').'</li>';
					}

					echo '</ul></div>';
				} 			

			?>
		
			<div class="tabs-content">

				<div id="sticky-main">

					<form method="post" action="admin-post.php">

						<input type="hidden" name="action" value="save_sticky_anything_options" />
						<!-- Adding security through hidden referrer field -->
						<?php wp_nonce_field( 'sticky_anything' ); ?>

						<table class="form-table">

							<tr>
								<th scope="row"><?php _e('Sticky Element:','Sticky Anything plugin'); ?> <span class="required">*</span> <a href="#" title="<?php _e('The element that needs to be sticky once you scroll. This can be your menu, or any other element like a sidebar, ad banner, etc. Make sure this is a unique identifier.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="text" id="sa_element" name="sa_element" value="<?php 
										if ($sticky_anything_options['sa_element'] != '#NO-ELEMENT') {
											echo esc_html( $sticky_anything_options['sa_element'] ); 
										}
									?>"/> <em><?php _e('(choose ONE element, e.g. #main-navigation, OR .main-menu-1, OR header nav, etc.)','Sticky Anything plugin'); ?></em>
								</td>
							</tr>


							<tr>
								<th scope="row"><?php _e('Space between top of page and sticky element: (optional)','Sticky Anything plugin'); ?> <a href="#" title="<?php _e('If you don\'t want the element to be sticky at the very top of the page, but a little lower, add the number of pixels that should be between your element and the \'ceiling\' of the page.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="number" id="sa_topspace" name="sa_topspace" value="<?php echo esc_html( $sticky_anything_options['sa_topspace'] ); ?>" style="width:80px;" /> pixels
								</td>
							</tr>

							<tr class="new-feature">
								<th scope="row"><span class="new"><?php _e('NEW!','Sticky Anything plugin'); ?></span> <?php _e('Check for Admin Toolbar:','Sticky Anything plugin'); ?> <a href="#" title="<?php _e('If the sticky element gets obscured by the Administrator Toolbar for logged in users (or vice versa), check this box.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="checkbox" id="sa_adminbar" name="sa_adminbar" <?php if ($sticky_anything_options['sa_adminbar']  ) echo ' checked="checked" ';?> />
									<label for="sa_adminbar"><strong><?php _e('Move the sticky element down a little if there is an Administrator Toolbar at the top (for logged in users).','Sticky Anything plugin'); ?></strong></label>
								</td>
							</tr>

							<tr>
								<th scope="row"><?php _e('Do not stick element when screen smaller than: (optional)','Sticky Anything plugin'); ?> <a href="#" title="<?php _e('Sometimes you do not want your element to be sticky when your screen is small (responsive menus, etc). If you enter a value here, your menu will not be sticky when your screen width is smaller than his value.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="number" id="sa_minscreenwidth" name="sa_minscreenwidth" value="<?php echo esc_html( $sticky_anything_options['sa_minscreenwidth'] ); ?>" style="width:80px;" /> pixels
								</td>
							</tr>

							<tr>
								<th scope="row"><?php _e('Do not stick element when screen larger than: (optional)','Sticky Anything plugin'); ?> <a href="#" title="<?php _e('Sometimes you do not want your element to be sticky when your screen is large (responsive menus, etc). If you enter a value here, your menu will not be sticky when your screen width is wider than this value.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="number" id="sa_maxscreenwidth" name="sa_maxscreenwidth" value="<?php echo esc_html( $sticky_anything_options['sa_maxscreenwidth'] ); ?>" style="width:80px;" /> pixels
								</td>
							</tr>

							<tr>
								<th scope="row"><?php _e('Z-index: (optional)','Sticky Anything plugin'); ?> <a href="#" title="<?php _e('If there are other elements on the page that obscure/overlap the sticky element, adding a Z-index might help. If you have no idea what that means, try entering 99999.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="number" id="sa_zindex" name="sa_zindex" value="<?php echo esc_html( $sticky_anything_options['sa_zindex'] ); ?>" style="width:80px;" />
								</td>
							</tr>

							<tr class="new-feature">
								<th scope="row"><span class="new"><?php _e('NEW!','Sticky Anything plugin'); ?></span> <?php _e('Push-up element (optional):','Sticky Anything plugin'); ?> <a href="#" title="<?php _e('If you want your sticky element to be \'pushed up\' again by another element lower on the page, enter it here. Make sure this is a unique identifier.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="text" id="sa_pushup" name="sa_pushup" value="<?php 
										if ($sticky_anything_options['sa_pushup'] != '#NO-ELEMENT') {
											echo esc_html( $sticky_anything_options['sa_pushup'] ); 
										}
									?>"/> <em><?php _e('(choose ONE element, e.g. #footer, OR .widget-bottom, etc.)','Sticky Anything plugin'); ?></em>
								</td>
							</tr>

							<tr>
								<th scope="row"><?php _e('Dynamic mode:','Sticky Anything plugin'); ?> <a href="#" title="<?php _e('When Dynamic Mode is OFF, a cloned element will be created upon page load. If this mode is ON, a cloned element will be created every time your scrolled position hits the \'sticky\' point.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="checkbox" id="sa_dynamicmode" name="sa_dynamicmode" <?php if ($sticky_anything_options['sa_dynamicmode']  ) echo ' checked="checked" ';?> />
									<label for="sa_dynamicmode"><strong><?php _e('If the plugin doesn\'t work in your theme (often the case with responsive themes), try it in Dynamic Mode.','Sticky Anything plugin'); ?></strong></label>
									<p class="description"><?php _e('NOTE: this is not a \'Magic Checkbox\' that fixes all problems. It simply solves some issues that frequently appear with some responsive themes, but doesn\'t necessarily work in ALL situations.','Sticky Anything plugin'); ?></p>
								</td>
							</tr>

							<tr>
								<th scope="row"><?php _e('Debug mode:','Sticky Anything plugin'); ?> <a href="#" title="<?php _e('When Debug Mode is on, error messages will be shown in your browser\'s console when the element you selected either doesn\'t exist, or when there are more elements on the page with your chosen selector.','Sticky Anything plugin'); ?>" class="help">?</a></th>
								<td>
									<input type="checkbox" id="sa_debugmode" name="sa_debugmode" <?php if ($sticky_anything_options['sa_debugmode']  ) echo ' checked="checked" ';?> />
									<label for="sa_debugmode"><strong><?php _e('Log plugin errors in browser console','Sticky Anything plugin'); ?></strong></label>
									<p class="description"><?php _e('Do NOT check this option in production environments.','Sticky Anything plugin'); ?></p>
								</td>
							</tr>

						</table>

						<input type="submit" value="<?php _e('SAVE SETTINGS','Sticky Anything plugin'); ?>" class="button-primary"/>

						<p>&nbsp;</p>
					</form>


				</div>

				<div id="sticky-faq">
					<?php include 'assets/faq.php'; ?>
				</div>

			</div>

		</div>

		<div class="main-sidebar">	
			<?php include 'assets/plugin-info.php'; ?>
		</div>

	</div>

	<?php
	}
}


if (!function_exists('sticky_anything_admin_init')) {
	function sticky_anything_admin_init() {
		add_action( 'admin_post_save_sticky_anything_options', 'process_sticky_anything_options' );
	}
}

/**
 * --- PROCESS THE SETTINGS FORM AFTER SUBMITTING ------------------------------------------------------
 */
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

		foreach ( array('sa_minscreenwidth') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_maxscreenwidth') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_zindex') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			}
		}

		foreach ( array('sa_pushup') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = sanitize_text_field( $_POST[$option_name] );
			} 
		}

		foreach ( array('sa_adminbar') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = true;
			} else {
				$options[$option_name] = false;
			}
		}

		foreach ( array('sa_dynamicmode') as $option_name ) {
			if ( isset( $_POST[$option_name] ) ) {
				$options[$option_name] = true;
			} else {
				$options[$option_name] = false;
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


/**
 * --- ADD THE .CSS AND .JS TO ADMIN MENU --------------------------------------------------------------
 */
if (!function_exists('sticky_anything_styles')) {
	function sticky_anything_styles($hook) {
		if ($hook != 'settings_page_stickyanythingmenu') {
			return;
		}

		wp_register_script('stickyAnythingAdminScript', plugins_url('/assets/js/sticky-anything-admin.js', __FILE__), array( 'jquery' ), '1.0');
		wp_enqueue_script('stickyAnythingAdminScript');

		wp_register_style('stickyAnythingAdminStyle', plugins_url('/assets/css/sticky-anything-admin.css', __FILE__) );
	    wp_enqueue_style('stickyAnythingAdminStyle');		
	}
}


/**
 * === HOOKS AND ACTIONS AND FILTERS AND SUCH ==========================================================
 */

$plugin = plugin_basename(__FILE__); 

register_activation_hook( __FILE__, 'sticky_anthing_default_options' );
add_action('init','sticky_anything_update',1);
add_action('wp_enqueue_scripts', 'load_sticky_anything');
add_action('admin_menu', 'sticky_anything_menu');
add_action('admin_init', 'sticky_anything_admin_init' );
add_action('admin_enqueue_scripts', 'sticky_anything_styles' );
add_filter("plugin_action_links_$plugin", 'sticky_anything_settings_link' );
