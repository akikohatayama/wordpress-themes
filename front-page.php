<?php get_header(); ?>
<!-- START .container -->
<div class="container clearfix">
	<!-- START .contents -->
	<div class="contents home-contents">
		<?php
			if(get_query_var('paged')){
				$paged = get_query_var('paged');
			}
			elseif(get_query_var('page')){
				$paged = get_query_var('page');
			}
			else{
				$paged = 1;
			}
		    $args = array('paged' => $paged, 'posts_per_page' => 4, 'orderby' => 'date');
		    $query = new WP_Query($args);
		?>
		<?php if( $query->have_posts() ) : ?>
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<article class="home-list">
					<a href="<?php the_permalink(); ?>">
						<?php
							$titleStyle = "style=''";
							if(has_post_thumbnail()){
								$imgURL = wp_get_attachment_image_src(get_post_thumbnail_id() , 'large');
								$titleStyle = "style='background-image:url(".$imgURL[0].");'";
							}
						?>
						<div class="list-img" <?php echo $titleStyle; ?>></div>
						<div class="home-list-contents">
							<span class="date">
								<!--公開日-->
								<time class="entry-date date" datetime="<?php echo get_the_date(); ?>">
									<i class="fas fa-pencil-alt"></i><?php echo get_the_date('Y年m月d日'); ?>
								</time>
								<!--更新日-->
								<time class="update date" datetime="<?php echo the_modified_date(); ?>">
									<i class="fas fa-sync-alt"></i><?php the_modified_date('Y年m月d日'); ?>
								</time>
							</span>
							<span class="cat">
								<?php 
								$category = get_the_category();
								$cat_name = $category[0]->name;
								echo $cat_name;
							 ?>
							 </span>
							<?php /* <h2><?php echo strip_tags(get_the_title()); ?></h2> */ ?>
							<?php
								if(mb_strlen($post->post_title, 'UTF-8') > 30){
									$title= mb_substr($post->post_title, 0, 30, 'UTF-8');
									echo '<h2>'.$title.'…</h2>';
								}else{
									echo '<h2>'.$post->post_title.'</h2>';
								}
							?>
						</div>
					</a>
				</article>
			<?php endwhile; ?>
			<?php if(function_exists('pagination')): ?>
				<?php pagination( $query->max_num_pages, $paged); ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
	<!-- END .contents -->
	<?php get_sidebar(); ?>
</div>
<!-- END .container -->
<?php get_footer(); ?>