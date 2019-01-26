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
				<?php if( has_category() ): ?>
					<?php $postcat=get_the_category(); echo get_category_parents( $postcat[0],true, '</li><li>' ); ?>
				<?php endif; ?>
				<a>
					<?php the_title(); ?>
				</a>
		    </li>
		</ol>
	</div>
	<?php if(have_posts()): while(have_posts()):the_post(); ?>
		<!-- START .contents -->
		<div class="contents">
			<article>
				<h1>
					<?php the_title(); ?>
				</h1>
				<p class="category"><i class="fas fa-tags"></i><?php the_category(', '); ?></p>
				<!--公開日-->
				<time class="entry-date date" datetime="<?php echo get_the_date(); ?>">
					<i class="fas fa-pencil-alt"></i><?php echo get_the_date('Y年m月d日'); ?>
				</time>
				<!--更新日-->
				<time class="update date" datetime="<?php echo the_modified_date(); ?>">
					<i class="fas fa-sync-alt"></i><?php the_modified_date('Y年m月d日'); ?>
				</time>
				<p class="thumb">
					<?php the_post_thumbnail('medium'); ?>
				</p>
				<?php the_content(); ?>
				<!--前の記事・次の記事 -->
				<?php 
					//前の記事を取得
					$prevPost = get_adjacent_post(true, '', true);
					$prevThumbnail = get_the_post_thumbnail($prevPost->ID, array(80,80));
					$prevPostTitle = get_the_title($prevPost->ID);
					if(mb_strlen($prevPostTitle, 'UTF-8') > 14){
						$prevPostTitle = mb_substr($prevPostTitle, 0, 14, 'UTF-8').'…';
					}
							
					//次の記事を取得
					$nextPost = get_adjacent_post(true, '', false);
					$nextThumbnail = get_the_post_thumbnail($nextPost->ID, array(80,80));
					$nextPostTitle = get_the_title($nextPost->ID);
					if(mb_strlen($nextPostTitle, 'UTF-8') > 14){
						$nextPostTitle = mb_substr($nextPostTitle, 0, 14, 'UTF-8').'…';
					}
					
					//前の記事か次の記事のどちらかが存在しているとき
					if($prevPost || $nextPost){
					    echo '<div class="prev-next-link">';
					    previous_post_link('%link', '<p class="prev-next-label"><i class="fas fa-angle-double-left"></i> 前の記事</p><div class="thumb-pic">'.$prevThumbnail.'<p>'.$prevPostTitle.'</p></div>', true);

					    next_post_link('%link', '<p class="prev-next-label">次の記事 <i class="fas fa-angle-double-right"></i></p><div class="thumb-pic">'.$nextThumbnail.'<p>'.$nextPostTitle.'</p></div>', true);
					    echo '</div>';
					}
				?>
				<?php get_template_part( 'sns' ); ?>
			</article>
			<div class="advertisement">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- adsense_contents_bottom -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:336px;height:280px"
				     data-ad-client="ca-pub-4630528553310878"
				     data-ad-slot="2530040827"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
			<?php 
				$args = array('category_name' => $postcat[0]->slug, 'posts_per_page' => 4, 'orderby' => 'rand', 'post__not_in' => array(get_the_ID()));
				$query = new WP_Query($args);
			?>
			<?php if( $query->have_posts() ) : ?>
				<aside class="related-post">
					<h4>「<?php the_category(', '); ?>」の記事</h4>
					<ul>
						<?php while ($query->have_posts()) : $query->the_post(); ?>
							<li>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail('thumbnail'); ?>
									<?php
										if(mb_strlen($post->post_title, 'UTF-8') > 34){
											$title= mb_substr($post->post_title, 0, 34, 'UTF-8');
											echo '<div class="text bold">'.$title.'…</div>';
										}else{
											echo '<div class="text bold">'.$post->post_title.'</div>';
										}
									?>
									</span>
								</a>
							</li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</ul>
				</aside>
			<?php endif; ?>
		</div>
		<!-- END .contents -->
	<?php endwhile; endif; ?>
	<?php get_sidebar(); ?>
	<!-- 記事閲覧カウント -->
	<?php setPostViews(get_the_ID()); ?>
</div>
<!-- END .container -->
<?php get_footer(); ?>