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
			<li>
				<?php
					if( $cat ) {
						$catdata = get_category( $cat );
						if( $catdata->parent ) {
							echo get_category_parents( $catdata->parent, true, '</li><li>' );
						}
					} 
				?>
				<a><?php single_term_title(); ?></a>
			</li>
		</ol>
	</div>
	<div class="contents cat-contents">
		<?php 
			$cat_o = get_queried_object();
			$cat_name = $cat_o->name;
			$cat_count = $cat_o->count;

			if(get_query_var('paged')){
				$paged = get_query_var('paged');
			}
			elseif(get_query_var('page')){
				$paged = get_query_var('page');
			}
			else{
				$paged = 1;
			}

			$arg = array('paged' => $paged, 
						'post_type' => 'post', 
						'posts_per_page' => 4,
						'orderby' => 'date',
						'order' => 'DESC',
						'category__in' => $cat_o->term_id
					);
			$posts = get_posts($arg);
			$query = new WP_Query($arg);
		 ?>
		<h1>「<?php echo $cat_name; ?>」の記事一覧　全<?php echo $cat_count ?>件</h1>
		<?php if( $posts ): ?>
			<?php foreach ( $posts as $post ) : setup_postdata( $post ); ?>
				<article class="cat-list">
					<a href="<?php the_permalink(); ?>">
						<?php
							$titleStyle = "style=''";
							if(has_post_thumbnail()){
								$imgURL = wp_get_attachment_url(get_post_thumbnail_id());
								$titleStyle = "style='background-image:url(".$imgURL.");'";
							}
						?>
						<div class="list-img" <?php echo $titleStyle; ?>></div>
						<div class="text">
							<?php
								if(mb_strlen($post->post_title, 'UTF-8') > 30){
									$title= mb_substr($post->post_title, 0, 30, 'UTF-8');
									echo '<h2>'.$title.'…</h2>';
								}else{
									echo '<h2>'.$post->post_title.'</h2>';
								}
							?>
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
							<p>
								<?php
									if(mb_strlen($post->post_content, 'UTF-8') > 90){
										$content= mb_substr(strip_tags($post->post_content), 0, 90, 'UTF-8');
										echo $content.'…';
									}else{
										echo strip_tags($post->post_content);
									}
								?>
							</p>
						</div>
					</a>
				</article>
			<?php endforeach; ?>
			<?php if(function_exists('category_pagination')): ?>
				<?php category_pagination($query->max_num_pages, $query->query_vars["paged"]); ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
	<!-- END .contents -->
	<?php get_sidebar(); ?>
</div>
<!-- END .container -->
<?php get_footer(); ?>