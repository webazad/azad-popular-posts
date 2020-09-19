<?php
/* 
Plugin Name: Azad Popular Posts
Description: A very simple plugin
Plugin URI: gittechs.com/plugin/azad-popular-posts
Author: Md. Abul Kalam Azad
Author URI: gittechs.com/author
Author Email: webdevazad@gmail.com
Version: 1.0.0
Text Domain: azad-popular-posts
*/

defined( 'ABSPATH' ) || exit;

require_once ( ABSPATH . 'wp-admin/includes/plugin.php' );

$plugin_data = get_plugin_data( __FILE__ );

define( 'APP_NAME', $plugin_data['Name'] );
define( 'APP_VERSION', $plugin_data['Version'] );
define( 'APP_TEXTDOMAIN', $plugin_data['TextDomain'] );
define( 'APP_PATH', plugin_dir_path( __FILE__ ) );
define( 'APP_URL', plugin_dir_url( __FILE__ ) );
define( 'APP_BASENAME', plugin_basename( __FILE__ ) );
define( 'APP_FILE', basename( __FILE__ ) );
define( 'APP_DEBUG', FALSE );
//define( 'APP_URL', plugins_url( '', __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function activate_app() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-app-activator.php';
    //AppActivator::activate();
}
register_activation_hook( __FILE__, 'activate_app' );

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_app() {
	require_once plugin_dir_path( __FILE__ ) . 'inc/class-app-deactivator.php';
    //AppDeactivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_app' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'inc/class-app.php';

/**
 * Begins execution of the plugin.
 */
function run_app() {

	$plugin = new App();
	$plugin->run();

}
run_app();


//add_action( 'init', 'asdf' );
// function asdf() {
//     wp_redirect( admin_url( "?page=nextgen-gallery" ) );
// }