<?php 
function set_popular_post_widget_views_count($postID) {
	$count_key = 'views';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '1');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
		
	}
}

/*
 * track post views
 */
function track_popular_post_views ($post_id) {
	if ( is_single() ){
	if ( empty ( $post_id) ) {
		global $post;
		$post_id = $post->ID;
		set_popular_post_widget_views_count($post_id);
	}
}
	
}
add_action( 'wp_head', 'track_popular_post_views');