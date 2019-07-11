<?php
/* 
Plugin Name: Azad Popular Posts
Description: A very simple plugin
Plugin URi: gittechs.com/plugin/azad-popular-posts
Author: Md. Abul Kalam Azad
Author URI: gittechs.com/author
Author Email: webdevazad@gmail.com
Version: 0.0.0.1
Text Domain: azad-popular-posts
*/
defined('ABSPATH') || exit;

class Azad_Popular_Posts{
    public function __construct(){
        // add_action('plugins_loaded',array($this,'constants'),1);
        add_action('plugins_loaded',array($this,'azad_popular_posts_includes'),1);
        add_action('widgets_init',array($this,'azad_popular_posts_widget'),2);
        // add_action('admin_enqueue_scripts',array($this,'azad_admin_scripts'));
        // add_action('wp_enqueue_scripts',array($this,'azad_public_scripts'));
    }
    public function azad_popular_posts_includes(){
        require_once(plugin_dir_path(__FILE__).'/admin/class-azad-popular-posts-widget.php');
    }
    public function azad_popular_posts_widget(){
        register_widget('Azad_Popular_Posts_Widget');
    }
    public function init(){
        require_once(plugin_dir_path(__FILE__).'/inc/class-azad-popular-posts.php');
    }
    public function __destruct(){}
}
new Azad_Popular_Posts();

register_activation_hook('__FILE__',array('Azad_Popular_Posts_Activator','activate'));
register_activation_hook('__FILE__',array('Azad_Popular_Posts_Deactivator','deactivate'));