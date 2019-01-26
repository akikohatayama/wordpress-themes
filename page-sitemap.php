<?php
/*
Template Name: サイトマップ
Template Post Type: page
*/
?>
<?php get_header(); ?>
<!-- START .container -->
<div class="container clearfix">
  <div id="breadcrumb" class="bread">
    <ol>
      <li>
        <a href="<?php echo home_url(); ?>">
          <i class="fa fa-home"></i><span>TOP</span>
        </a>
      </li>
      <?php
        $page_obj = get_queried_object();
        if($page_obj->post_parent != 0){
          $page_ancestors = array_reverse( $post->ancestors );
          foreach ($page_ancestors as $page_ancestor) {
            echo '<li><a href="',esc_url(get_permalink($page_ancestor)),'">',esc_html(get_the_title($page_ancestor)),'</a></li>'.PHP_EOL;
          }
        }
      ?>
      <li><a><?php the_title(); ?></a></li>
    </ol>
  </div>
	<?php if(have_posts()): while(have_posts()):the_post(); ?>
		<!-- START .contents -->
		<div class="contents">
			<?php if(is_front_page()) : ?>
        	<?php else : ?>
            	<h1 id="page_title"><?php the_title(); ?></h1>
        	<?php endif ?>
        <div class="site-map">
        <p><a href="<?php echo home_url(); ?>">TOPページ</a></p>
        <?php
          $args=array('orderby' => 'name', 'order' => 'ASC');
          $categories=get_categories($args);
          foreach($categories as $category) {
            echo '<h2><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '"' . '>' . $category->name.'</a></h2>';
        ?>
          <ul>
            <?php
              global $post;
              $myposts = get_posts('numberposts=100&category=' . $category->term_id);
              foreach($myposts as $post) : setup_postdata($post);
            ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endforeach; ?>
          </ul>
        <?php }; ?>
        <h2>他のページ</h2>
        <ul>
          <?php wp_list_pages('title_li='); ?>
        </ul>
      </div>
		</div>
		<!-- END .contents -->
	<?php endwhile; endif; ?>
	<?php get_sidebar(); ?>
</div>
<!-- END .container -->
<?php get_footer(); ?>