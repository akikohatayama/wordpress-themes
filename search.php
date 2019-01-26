<?php get_header(); ?>
<!-- START .container -->
<div class="container clearfix">
	<div class="contents">
		<?php if (isset($_GET['s']) && empty($_GET['s'])) { ?>
		    <p>
		    	いつも<?php echo get_bloginfo('name'); ?>をご覧いただきありがとうございます。<br>
		    	検索条件の入力がありませんでした。<br>
		    </p>
		<?php } else { ?>
		    <?php if(have_posts()): ?>
		        <?php while(have_posts()): the_post(); ?>
		            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		            <?php the_excerpt(); ?>
		        <?php endwhile; ?>
		    <?php else : ?>
		        <p>
		        	いつも<?php echo get_bloginfo('name'); ?>をご覧いただきありがとうございます。<br>
		        	検索条件にヒットした記事がありませんでした。<br>
		        	<br>
		        	これからもよりよいサイトになるよう精進させていただきますのでよろしくお願いいたします。
		    	</p>
		    <?php endif; ?>
		<?php } ?>
	</div>
	<!-- END .contents -->
	<?php get_sidebar(); ?>
</div>
<!-- END .container -->
<?php get_footer(); ?>



