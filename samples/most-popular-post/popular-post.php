<?php
/**
* plugin name: most popular post widget
* Plugin URI:https://web.facebook.com/quazi.sazzad.7
* Version: 2.2
*  description: This is a simple widget plugin to show most popular posts of your WordPress website based on views.
* Author: Quazi Sazzad
* Author URI: https://web.facebook.com/quazi.sazzad.7
* Tested up to: 5.2.2
* Layers Plugin: True
* Layers Required Version: 1.0
* Version: 2.0
*License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * License: GPL2
 * Copyright 2016  quazi sazzad  (email : qsazzad21@gmail.com, skype:quazisazzad)
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
**/
?>
<?php

if(!defined('ABSPATH')){
	exit;
}


require_once(plugin_dir_path(__FILE__).'/includes/popular-post-script.php');
require_once(plugin_dir_path(__FILE__).'/includes/popular-post_widget.php');
require_once(plugin_dir_path(__FILE__).'/includes/views_posts.php');

function popular_post_widget_register(){
	register_widget('most_popular_post_widget');
}
add_action('widgets_init','popular_post_widget_register');

/*add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'customize_link_p' );
function customize_link_p( $links ) {
   $links[] = '<a href="https://bit.ly/2LwYJRm">SpeedUp Website</a>';
   return $links;
}*/

add_image_size( 'mpp', 80, 60, true );