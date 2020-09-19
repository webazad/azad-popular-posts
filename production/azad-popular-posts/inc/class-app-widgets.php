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
                'description'   => __('A Simple plugin to show the posts as per the filter applied.', $this->get_widget_slug() ),
            )
        );
        
        add_action( 'wp_head', array( $this, 'track_popular_post_views' ) );

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
            <input type="checkbox" id="<?php echo $this->get_field_id( 'fimage' ) ?>" name="<?php echo $this->get_field_name( 'fimage' ) ?>" value="1" <?php checked( 1, $instance['fimage']); ?> class="widefat">
            <label for="<?php echo $this->get_field_id( 'fimage' ) ?>">Display Thumbnail:</label>
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
            <input type="checkbox" id="<?php echo $this->get_field_id( 'fixed' ) ?>" name="<?php echo $this->get_field_name( 'fixed' ) ?>"value="1" <?php checked( 1, $instance['fixed'] ); ?> />
            <label for="<?php echo $this->get_field_id( 'fixed' ) ?>">Fixed Widget :</label>
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
		
		if ( isset( $instance['twords'] ) ) {
            $twords = apply_filters( 'post_per_page', $instance['twords'] );
        } else {
            $twords = apply_filters( 'post_per_page', $instance['twords'] );
        }
		
		if ( isset( $instance['tcharacter'] ) ) {
            $tcharacter = apply_filters( 'post_per_page', $instance['tcharacter'] );
        } else {
            $tcharacter = apply_filters( 'post_per_page', $instance['tcharacter'] );
        }
		
		if ( isset( $instance['tcharacter'] ) ) {
            $tcharacter = apply_filters( 'post_per_page', $instance['tcharacter'] );
        } else {
            $tcharacter = apply_filters( 'post_per_page', $instance['tcharacter'] );
        }
		
		if ( isset( $instance['fimage'] ) ) {
            $fimage = apply_filters( 'post_per_page', $instance['fimage'] );
        } else {
            $fimage = apply_filters( 'post_per_page', $instance['fimage'] );
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
			
			echo '<div class="azad-popular-posts">';
				if ( $title ) {
					echo $before_title . $title . $after_title;
				}

				if ( $azad_posts->have_posts() ) : ?>
					
						<ul class="">
							<?php while( $azad_posts->have_posts() ) : $azad_posts->the_post(); ?>
								<li style="<?php echo ( $fimage ) ? 'grid-template-columns: 1fr 3fr;' : ''; ?>">
									<div class="app-date">
										<a href="<?php the_permalink(); ?>"><?php //echo wp_date( 'l, F j, Y' ); 
										//echo esc_attr( get_the_time( 'g:i A' ) ); ?></a>
										<a href="<?php the_permalink(); ?>"><?php //echo get_the_date( 'F j, Y' ); ?></a>
										<a href="<?php the_permalink(); ?>"><?php echo ( $fimage ) ? the_post_thumbnail( 'thumbnail' ) : ''; ?></a>
									</div>
									<div class="app-title">
										<a href="<?php the_permalink(); ?>"  alt="<?php esc_attr( the_title_attribute() ); ?>">
											<?php echo ( $twords ) ? wp_trim_words( get_the_title(), $twords, '...' ) : get_the_title(); ?>
											<?php //echo ( $tcharacter ) ? substr( get_the_title(), 0, 5 ) : get_the_title(); ?>
										</a>
									</div>
								</li>
							<?php endwhile; ?>
						</ul>
					
					<?php
					wp_reset_postdata(); 
				endif;
			echo '</div>';
			
        echo $after_widget;
    }
}