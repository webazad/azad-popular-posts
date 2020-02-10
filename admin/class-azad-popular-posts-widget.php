<?php
defined('ABSPATH') || exit;

class Azad_Popular_Posts_Widget extends WP_Widget{
    public function __construct(){
        parent::__construct(
            'azad_popular_posts',
            'Azad Popular Posts',
            array(
                'description'=>'Show your popular posts'
            )
        );
        add_action('wp_head',array($this, 'track_popular_post_views'));
    }
    public function track_popular_post_views(){
        if(is_single()){
            if(empty($post_id)){
                global $post;
                $post_id = $post->ID;
                $this->set_popular_post_views($post_id);      
            }
        }
    }
    public function set_popular_post_views($post_id){
        $count_key = 'views';
        $count = get_post_meta($post_id, $count_key, true);
        if($count == ''){
            delete_post_meta( $post_id, $count_key );
            add_post_meta( $post_id, $count_key, '1' );
        }else{
            $count++;
            update_post_meta( $post_id, $count_key, $count );
        }
    }
    public function form($instance){ 
        $defaults = array(
            'title'=>'Azad Popular Posts',
            'asdf'=>'asdf',
            'asdf'=>'asdf'
        );
        $instance = wp_parse_args((array)$instance,$defaults);
    ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Widget Title:</label>
            <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" class="widefat"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post_per_page'); ?>">Post Per Page:</label>
            <input type="text" id="<?php echo $this->get_field_id('post_per_page'); ?>" name="<?php echo $this->get_field_name('post_per_page'); ?>" value="<?php echo $instance['post_per_page']; ?>" class="widefat"/>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('dimage') ?>" name="<?php echo $this->get_field_name('dimage') ?>" value="1" <?php checked(1,$instance['dimage']); ?> class="widefat">
            <label for="<?php echo $this->get_field_id('dimage') ?>">Display Image:</label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('displayviews') ?>" name="<?php echo $this->get_field_name('displayviews') ?>" value="1" <?php checked(1, $instance['displayviews']); ?> class="widefat">
            <label for="<?php echo $this->get_field_id('displayviews') ?>">Display Views Count:</label>
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('dauthor') ?>" name="<?php echo $this->get_field_name('dauthor') ?>"value="1" <?php checked(1,$instance['dauthor']); ?> class="widefat">
            <label for="<?php echo $this->get_field_id('dauthor') ?>">Display Author :</label>
       </p>
    <?php    
    }
    public function update($new_instance,$old_instance){
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['displayviews'] = strip_tags($new_instance['displayviews']);
        return $new_instance;
    }
    public function widget($args, $instance){
        extract($args);
        
        if(isset($instance['title'])){
            $title = apply_filters('widget_title',$instance['title']);
        }else{
            $title = apply_filters('widget_title',$instance['title']);
        }

        if(isset($instance['post_per_page'])){
            $post_per_page = apply_filters('post_per_page',$instance['post_per_page']);
        }else{
            $post_per_page = apply_filters('post_per_page',$instance['post_per_page']);
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
            if($title){
                echo $before_title . $title . $after_title;
            }
            if($azad_posts->have_posts()) : ?>
                <div class="">
                    <ol>
                        <?php
                            while($azad_posts->have_posts()) : $azad_posts->the_post(); ?>
                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <?php endwhile; 
                        ?>
                    </ol>
                </div>
                <?php wp_reset_postdata(); 
            endif;
        echo $after_widget;
    }
}