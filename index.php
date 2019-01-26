<?php get_header(); ?>
<!-- START .container -->
<div class="container clearfix">
	<?php if(have_posts()): while(have_posts()):the_post(); ?>
		<!-- START .contents -->
		<div class="contents">
			<h2>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>
			<!--公開日-->
			<time class="entry-date date" datetime="<?php echo get_the_date(); ?>">
				<i class="fas fa-pencil-alt"></i><?php echo get_the_date('Y年m月d日'); ?>
			</time>
			<!--更新日-->
			<time class="update date" datetime="<?php echo the_modified_date(); ?>">
				<i class="fas fa-sync-alt"></i><?php the_modified_date('Y年m月d日'); ?>
			</time>
			<p>
				<?php the_category(', '); ?>
			</p>
			<?php the_content(); ?>
		</div>
		<!-- END .contents -->
	<?php endwhile; endif; ?>
	<?php get_sidebar(); ?>
</div>
<!-- END .container -->
<?php get_footer(); ?>