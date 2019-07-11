<?php
defined('ABSPATH') || exit;

class Azad_Popular_Posts_Widget extends WP_Widget{
    public function __construct(){
        parent::__construct(
            'azad_popular_posts',
            'Azad Popular Posts',
            array(
                'description'=>'asdf'
            )
        );
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
<?php    }
    public function update($new_instance,$old_instance){
        $instance = array();
            $instance['title'] = strip_tags($new_instance['title']);
            $instance['displayviews'] = strip_tags($new_instance['displayviews']);
            return $instance;
    }
    public function widget($args, $instance){
        extract($args);
        
        $azad_posts = new WP_Query(
            array(
                //'posts_per_page' => 5,
                'post_type' => 'post',
                // 'meta_key' => 12,
                // 'orderby' => 12,
                // 'order' => 12,
                // 'ignore_sticky_posts' => true,
            )
        );

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
            

        echo $before_widget;
        if($title){
            echo $before_title . $title . $after_title;
            //echo $count;
        }
        if($azad_posts->have_posts()) :
            while($azad_posts->have_posts()) : $azad_posts->the_post(); ?>
                <div class="">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php echo $count; ?>
                </div>
        <?php    endwhile;
            wp_reset_postdata();
        endif;
        echo $after_widget;
    }
}