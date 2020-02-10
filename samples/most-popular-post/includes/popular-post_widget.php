<?php 

class most_popular_post_widget extends WP_Widget{
  public function __construct(){
    parent:: __construct('most_popular_post_widget', 'Popular Post Widget',array(
          'description'=> 'Shown your most viwes post'
      ));
  }

 public function widget($args,$instance){
  
      $title=$instance['title'];
      $post_per_page=$instance['post_per_page'];
      $displayviews=$instance['displayviews'];
      $cmtcount=$instance['cmtcount'];
      $dauthor=$instance['dauthor'];
      $dimage=$instance['dimage'];
      $viewby=$instance['viewby'];


      if ( $viewby == 'mostview' ){
        $meta_key = "views";
        $orderby = "meta_value_num";

      }else{

        $meta_key = "";
        $orderby = "comment_count";

      }

      $plr_posts = new WP_Query( array(
      "posts_per_page" => $post_per_page,
      "post_type" => "post",
      "meta_key" => $meta_key,
      'orderby' => $orderby,
      "order" => "DESC",
      "ignore_sticky_posts" => true,
    ) );

      echo $args['before_widget'];
      echo $args['before_title'];
      echo $title;
        echo $args['after_title'];
  if ( $plr_posts->have_posts() ) {
       while ( $plr_posts->have_posts() ) :$plr_posts-> the_post();
        $count = get_post_meta(get_the_id(),'views', true);

        $count  = ( $count == null ? '0' : $count );

        $view = ( $count > 1 ? ' Views' : ' View' );



        ?>
        <div class="mpp-single-latest-post"><!-- single lates post item start-->
                <div class="media"><!-- media  -->
                      <?php if( $dimage == 1 ) : ?>
                        <?php if( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'mpp' ); ?>
                        <?php endif; ?>
                      <?php endif; ?>
                        <div class="media-body"><!-- media body-->
                            <a href="<?php the_permalink( ); ?>">
                              <h5 class="mt-0"><?php the_title(); ?></h5>
                            </a>
                            <?php if( $displayviews == 1 ) : ?>
                             <span class="meta-time"><i class="fa fa-eye "></i> <?php echo $count .$view; ?></span>
                             <?php endif;
                              ?>
                              
                             <?php if( $dauthor == 1 ) : ?>
                               <span class="meta-time"><i class="fa fa-user "></i> <?php the_author(); ?></span>
                             <?php endif; ?>
                            <?php if( $cmtcount == 1 ) : ?>
                               <span class="meta-time"><i class="fa fa-comment "></i> <?php comments_number(); ?></span>
                          <?php endif; ?>
                        </div><!-- /.media body -->
                    </div><!-- /.media -->
                </div><!-- single lates post item start-->

      <?php endwhile;
    } else {
      echo 'Click or visit a post of your website to show it as popular post';
    }
      echo $args['after_widget'];

  }

 public function form($instance){

    if(isset($instance['title'])){
      $title = $instance['title'];
    }else{
     $title = 'Most Popular Post';
    }  

    if(isset($instance['post_per_page'])){
      $post_per_page = $instance['post_per_page'];
    }else{
     $post_per_page = 5;
    }  
 
  if(isset($instance['displayviews'])){
      $displayviews = $instance['displayviews'];
    }else{
     $displayviews = 1;
    }
    if(isset($instance['cmtcount'])){
      $cmtcount = $instance['cmtcount'];
    }else{
     $cmtcount = 0;
    } 

    if(isset($instance['dauthor'])){
      $dauthor = $instance['dauthor'];
    }else{
     $dauthor = 0;
    }     

    if(isset($instance['dimage'])){
      $dimage = $instance['dimage'];
    }else{
     $dimage = 0;
    }  
   
    if(isset($instance['viewby'])){
      $viewby = $instance['viewby'];
    }else{
     $viewby = 'mostcomment';
    }  

    ?>
       <p>
        <label for="<?php echo $this->get_field_id('title') ?>">Widget Title:</label>
        <input type="text" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>"
        value="<?php echo esc_attr ($title); ?>" class="widefat">
       </p>

    <p>
        <label for="<?php echo $this->get_field_id('post_per_page') ?>">Posts Per Page:</label>
        <input type="text" id="<?php echo $this->get_field_id('post_per_page') ?>" name="<?php echo $this->get_field_name('post_per_page') ?>"
        value="<?php echo esc_attr ($post_per_page); ?>" class="widefat">
       </p>

       <p>
       <input type="checkbox" id="<?php echo $this->get_field_id('dimage') ?>" name="<?php echo $this->get_field_name('dimage') ?>"
        value="1" <?php checked($dimage,1); ?> class="widefat">
        <label for="<?php echo $this->get_field_id('dimage') ?>">Display Image:</label>
        </p>

       <p>
       <input type="checkbox" id="<?php echo $this->get_field_id('displayviews') ?>" name="<?php echo $this->get_field_name('displayviews') ?>"
        value="1" <?php checked($displayviews,1); ?> class="widefat">
        <label for="<?php echo $this->get_field_id('displayviews') ?>">Display Views Count:</label>
        </p>


      <p>
          <input type="checkbox" id="<?php echo $this->get_field_id('dauthor') ?>" name="<?php echo $this->get_field_name('dauthor') ?>"value="1" <?php checked($dauthor,1); ?> class="widefat">
        <label for="<?php echo $this->get_field_id('dauthor') ?>">Display Author :</label>
       </p>
 
       <p>
        <input type="checkbox" id="<?php echo $this->get_field_id('cmtcount') ?>" name="<?php echo $this->get_field_name('cmtcount') ?>"
        value="1" <?php checked($cmtcount,1); ?> class="widefat">
        <label for="<?php echo $this->get_field_id('cmtcount') ?>">Display Comment Count :</label>
        </p>     

        <p>
          <label for="<?php echo $this->get_field_id('viewby') ?>">View By:</label><br/>
          <select id="<?php echo $this->get_field_id('viewby') ?>"  name="<?php echo $this->get_field_name('viewby') ?>" >
            <option <?php echo (  $viewby == 'mostview' ? 'selected' : '' ); ?> value="mostview">Most Viewed Post</option>
            <option <?php echo (  $viewby == 'mostcomment' ? 'selected' : '' ); ?> value="mostcomment">Most Commented post</option>
          </select>
        </p>
  

    <?php
  }

     public function update($new_instance, $old_instance){
      $instance = array();
      $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
      $instance['post_per_page'] = (!empty($new_instance['post_per_page'])) ? strip_tags($new_instance['post_per_page']) : '';
      $instance['displayviews'] = (!empty($new_instance['displayviews'])) ? strip_tags($new_instance['displayviews']) : '';
      $instance['cmtcount'] = (!empty($new_instance['cmtcount'])) ? strip_tags($new_instance['cmtcount']) : '';
      $instance['dauthor'] = (!empty($new_instance['dauthor'])) ? strip_tags($new_instance['dauthor']) : '';
      $instance['dimage'] = (!empty($new_instance['dimage'])) ? strip_tags($new_instance['dimage']) : '';
      $instance['viewby'] = (!empty($new_instance['viewby'])) ? strip_tags($new_instance['viewby']) : '';
      
      return $instance;
   }


}