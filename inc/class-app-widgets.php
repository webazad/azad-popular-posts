<?php
defined( 'ABSPATH' ) || exit;

class App_Widget extends WP_Widget {

    protected $widget_slug = 'azad_popular_posts';

    public function __construct() {

        parent::__construct(
            $this->get_widget_slug(),
            __( 'Azad Popular Posts', $this->get_widget_slug() ),
            array(
                'classname' =>  $this->get_widget_slug().'-class',
                'description'   => __('A Simple plugin to show the posts as per the filter applied.',$this->get_widget_slug()),
            )
        );
        
        add_action( 'wp_head', array( $this, 'track_popular_post_views' ) );

        add_action('in_widget_form', array( __CLASS__, 'add_widget_option' ), 10, 3);
        add_filter('widget_update_callback', array( __CLASS__, 'update_widget_option' ), 10, 3);

    }

    public static function add_widget_option($widget, $return, $instance) {  
	
		if ( isset($instance['q2w3_fixed_widget']) ) $iqfw = $instance['q2w3_fixed_widget']; else $iqfw = 0;
		
		echo '<p>'.PHP_EOL;
    	
		echo '<input type="checkbox" name="'. $widget->get_field_name('q2w3_fixed_widget') .'" value="1" '. checked( $iqfw, 1, false ) .'/>'.PHP_EOL;
    	
		echo '<label for="'. $widget->get_field_id('q2w3_fixed_widget') .'">'. __('Fixed widget', 'q2w3-fixed-widget') .'</label>'.PHP_EOL;
	
		echo '</p>'.PHP_EOL;    

    }
    
    public static function update_widget_option($instance, $new_instance, $old_instance){
    
    	if ( isset($new_instance['q2w3_fixed_widget']) && $new_instance['q2w3_fixed_widget'] ) {
			
    		$instance['q2w3_fixed_widget'] = 1;
    
    	} else {
    	
    		$instance['q2w3_fixed_widget'] = false;
    	
    	}
    
    	return $instance;

	}

    public function get_widget_slug() {
		return $this->widget_slug;
    }

    public function track_popular_post_views() {
        if ( is_single() ) {
            if ( empty( $post_id ) ) {
                global $post;
                $post_id = $post->ID;
                $this->set_popular_post_views( $post_id );      
            }
        }
    }

    public function set_popular_post_views( $post_id ) {

        $count_key = 'views';
        $count = get_post_meta( $post_id, $count_key, true );
        if ( $count == '' ) {
            delete_post_meta( $post_id, $count_key );
            add_post_meta( $post_id, $count_key, '1' );
        } else {
            $count++;
            update_post_meta( $post_id, $count_key, $count );
        }

    }

    public function form ( $instance ) { 
        // $defaults = array(
        //     'title' => 'Azad Popular Posts',
        //     'asdf' => 'asdf',
        //     'asdf' => 'asdf'
        // );
        // $instance = wp_parse_args( ( array) $instance, $defaults );
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title:</label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'tcharacter' ); ?>">Select Title Characters:</label>
            <input type="number" id="<?php echo $this->get_field_id( 'tcharacter' ); ?>" name="<?php echo $this->get_field_name( 'tcharacter' ); ?>" value="<?php echo $instance['tcharacter']; ?>" class="widefat"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'twords' ); ?>">Select Title Words:</label>
            <input type="number" id="<?php echo $this->get_field_id( 'twords' ); ?>" name="<?php echo $this->get_field_name( 'twords' ); ?>" value="<?php echo $instance['twords']; ?>" class="widefat"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'post_per_page' ); ?>">Post Per Page:</label>
            <input type="number" id="<?php echo $this->get_field_id( 'post_per_page' ); ?>" name="<?php echo $this->get_field_name( 'post_per_page' ); ?>" value="<?php echo $instance['post_per_page']; ?>" class="widefat"/>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'dimage' ) ?>" name="<?php echo $this->get_field_name( 'dimage' ) ?>" value="1" <?php checked( 1, $instance['dimage']); ?> class="widefat">
            <label for="<?php echo $this->get_field_id( 'dimage' ) ?>">Display Thumbnail:</label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'displayviews' ) ?>" name="<?php echo $this->get_field_name( 'displayviews' ) ?>" value="1" <?php checked( 1, $instance['displayviews'] ); ?> class="widefat">
            <label for="<?php echo $this->get_field_id( 'displayviews' ) ?>">Display Views Count:</label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'ddate' ) ?>" name="<?php echo $this->get_field_name( 'ddate' ) ?>"value="1" <?php checked( 1, $instance['ddate'] ); ?> class="widefat">
            <label for="<?php echo $this->get_field_id( 'ddate' ) ?>">Display Date :</label>
       </p>
       <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'dauthor' ) ?>" name="<?php echo $this->get_field_name( 'dauthor' ) ?>"value="1" <?php checked( 1, $instance['dauthor'] ); ?> class="widefat">
            <label for="<?php echo $this->get_field_id( 'dauthor' ) ?>">Display Author :</label>
       </p>
       <p>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'sticky' ) ?>" name="<?php echo $this->get_field_name( 'sticky' ) ?>"value="1" <?php checked( 1, $instance['sticky'] ); ?> class="widefat">
            <label for="<?php echo $this->get_field_id( 'sticky' ) ?>">Is The Widget Sticky :</label>
       </p>
        <?php
    }

    // public function update( $new_instance, $old_instance ) {
    //     $instance = array();
    //     $instance['title'] = strip_tags( $new_instance['title'] );
    //     $instance['displayviews'] = strip_tags( $new_instance['displayviews'] );
    //     return $new_instance;
    // }

    public function widget( $args, $instance ) {

        extract( $args );

        if ( isset( $instance['title'] ) ) {
            $title = apply_filters( 'widget_title', $instance['title'] );
        } else {
            $title = apply_filters( 'widget_title', $instance['title'] );
        }

        if ( isset( $instance['post_per_page'] ) ) {
            $post_per_page = apply_filters( 'post_per_page', $instance['post_per_page'] );
        } else {
            $post_per_page = apply_filters( 'post_per_page', $instance['post_per_page'] );
        }

        $azad_posts = new WP_Query(
            array(
                'posts_per_page'        => $post_per_page,
                'post_type'             => 'post',
                'meta_key'              => 'views',
                'orderby'               => 'meta_value_num',
                'order'                 => 'DESC',
                'ignore_sticky_posts'   => true,
            )
        );

        echo $before_widget;

            if ( $title ) {
                echo $before_title . $title . $after_title;
            }

            if ( $azad_posts->have_posts() ) : ?>
                <div class="">
                    <ul class="">
                        <?php while( $azad_posts->have_posts() ) : $azad_posts->the_post(); ?>
                            <li>
                                <div class="">
                                    <a href="<?php the_permalink(); ?>"><?php echo esc_attr( get_post_time( 'm/j/y g:i A' ) ); ?></a>
                                    <a href="<?php the_permalink(); ?>"><?php //echo get_the_date( 'l, F j, Y' ); ?></a>
                                </div>
                                <div class="">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <?php
                wp_reset_postdata(); 
            endif;

        echo $after_widget;
    }
}