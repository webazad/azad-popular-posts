<?php
 // add script

 function most_popular_plugn_style(){
 	wp_enqueue_style('style', plugins_url( 'style/style.css', dirname(__FILE__) ) );
 }
 add_action('wp_enqueue_scripts','most_popular_plugn_style');
