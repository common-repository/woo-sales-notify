<?php
/*************************
	* Plugin Name: Sales Notify for WooCommerce
	* Plugin URI: https://studio.envato.com/users/alisaleem252
	* Description: This is an Extension to WooCommerce Plugin, It will promote your recent Sales and Notify Visitors about it.
	* Version: 1.0.0
	* Author: alisaleem252
	* Author URI: https://studio.envato.com/users/alisaleem252
	* Text Domain: woo-sales-notify
*
 _ |. _ _ | _  _  _ _ '~)L~'~)
(_|||_\(_||(/_(/_| | | /__) /_
                              
*************************/
if ( ! defined( 'ABSPATH' ) ) exit;


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	function wooboaster_settings_link($links) { 
	  $settings_link = '<a href="admin.php?page=wooboast-scheule-event">Settings</a>'; 
	  array_unshift($links, $settings_link); 
	  return $links; 
	}
	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'wooboaster_settings_link' );
	
	/*Hook Some Action during Activation */
	register_activation_hook( __FILE__, 'wooboaster_activation' );  //activation hook for Schedule hook
	function wooboaster_activation() {
		$schedule = get_option('schedulevalue');
		wp_schedule_event( time(), $schedule, 'prefix_'.$schedule.'_event_hook' );
		create_wooboaster();
		add_option('enable_wooboaster','yes');
	} //close function
	
	
	define('WOOBOASTERPATH', dirname(__FILE__) );
	// First Check if WooCommerce Is Active
	
	require_once(WOOBOASTERPATH.'/inc/filejson.php');
	require_once(WOOBOASTERPATH.'/init.php');
}
else {
	function wooboaster_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'WooCommerce Sales Notify is an Extension to WooCommerce, You need to Activate that first!', 'woo-sales-notify' ); ?></p>
    </div>
    <?php
}
	add_action( 'admin_notices', 'wooboaster_admin_notice' );	
}
?>