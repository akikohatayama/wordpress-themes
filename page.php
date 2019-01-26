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
			<?php the_content(); ?>	
		</div>
		<!-- END .contents -->
	<?php endwhile; endif; ?>
	<?php get_sidebar(); ?>
</div>
<!-- END .container -->
<?php get_footer(); ?>