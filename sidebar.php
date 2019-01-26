<!-- START .sidebar -->
<aside class="sidebar">
	<?php /* <div class="advertisement sidebar-wrapper">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- adsense-side1 -->
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="xx-xxx-xxxxxxxxx"
		     data-ad-slot="xxxxxxxxxxxx"
		     data-ad-format="auto"
		     data-full-width-responsive="true"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div> */ ?>
	<div class="new-posts sidebar-wrapper">
		<h4>
			<i class="fas fa-heart"></i>よく読まれている記事
		</h4>
		<aside class="side-posts">
			<?php setPostViews( get_the_ID() ); ?>
			<?php
			    $args = array(
			    	'meta_key' => 'post_views_count',
			    	'orderby' => 'meta_value_num',
			    	'post__not_in' => array(get_the_ID()),
			    	'posts_per_page' => 4,
			    	'order' => 'DESC'
			    );
			    $query = new WP_Query($args);
			?>
			<?php if( $query->have_posts() ) : ?>
				<ul>
					<?php while ($query->have_posts()) : $query->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('thumbnail'); ?>
								<div class="side-posts-contents">
									<?php
										if(mb_strlen($post->post_title, 'UTF-8') > 34){
											$title= mb_substr($post->post_title, 0, 34, 'UTF-8');
											echo '<h2>'.$title.'…</h2>';
										}else{
											echo '<h2>'.$post->post_title.'</h2>';
										}
									?>
									<span class="cat">
										<?php 
										$category = get_the_category();
										$cat_name = $category[0]->name;
										echo $cat_name;
									 ?>
									 </span>
								</div>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</aside>
	</div>
	<div class="new-posts sidebar-wrapper">
		<?php test(); ?>
	</div>
	<div class="widget_info sidebar-wrapper">
		<h4>
			<i class="far fa-bell"></i>チッタからのお知らせ
		</h4>
		<aside class="side-info-list">
			<ul>
				<li>
					<time class="entry-date">2019年1月3日</time>
					<p>
						地味に難しかったカテゴリー一覧のページネーションが完成しました。<br>
						ブログ機能が出来上がったので、じゃんじゃん記事を書いていきます！
					</p>
				</li>
            	<li>
					<time class="entry-date">2019年1月2日</time>
					<a href="https://chittaboo.com/m-chan-tomato/">
						<p>Ｍちゃんのトマト仲間を募集しています</p>
					</a>
				</li>
			</ul>
		</aside>
	</div>
	<div id="profile" class="sidebar-wrapper">
		<h4>
			<i class="fas fa-address-card"></i>このブログを書いている人
		</h4>
		<div class="profile-img"><img src="<?php bloginfo( 'template_url' ) ?>/profile.jpg"/></div>
		<div class="profile-name"><p>チッタ</p></div>
		<div class="profile-sns">
			<p>
				<a href="https://www.instagram.com/akikohatayama/" target="_blank">
					<i class="fab fa-instagram"></i>
				</a>
				<a href="https://www.facebook.com/akiko.hatayama.75" target="_blank">
					<i class="fab fa-facebook"></i>
				</a>
				<a href="https://soundcloud.com/user-724664291" target="_blank">
					<i class="fab fa-soundcloud"></i>
				</a>
				<a href="https://www.youtube.com/channel/UCUinSOVyn_OTVScGGyZCAKg" target="_blank">
					<i class="fab fa-youtube"></i>
				</a>
			</p>
		</div>
		<p>
			主婦プログラマをしながら作曲活動をしている私が興味を持ったことや好きなことなどを掲載しています。
		</p>
		<div id="more-profile">
			<a href="https://chittaboo.com/more-profile/">詳しいプロフィールはこちら</a>
		</div>
	</div>
	<div class="sidebar-wrapper">
		<h4>
			<i class="fab fa-instagram"></i>インスタグラム
		</h4>
		<div class="insta">
            <div class="insta_wrap">
                <div class="insta_container">
                <?php get_instagram(); ?>
                </div>
            </div>
        </div>
	</div>
	<div class="advertisement sidebar-wrapper">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- adsense-side2 -->
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-4630528553310878"
		     data-ad-slot="9772859189"
		     data-ad-format="auto"
		     data-full-width-responsive="true"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>
	<div class="new-posts sidebar-wrapper">
		<h4>
			<i class="fas fa-edit"></i>新着記事
		</h4>
		<aside class="side-posts">
			<?php
			    $args = array('posts_per_page' => 4, 'orderby' => 'date');
			    $query = new WP_Query($args);
			?>
			<?php if( $query->have_posts() ) : ?>
				<ul>
					<?php while ($query->have_posts()) : $query->the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail('thumbnail'); ?>
								<div class="side-posts-contents">
									<?php
										if(mb_strlen($post->post_title, 'UTF-8') > 34){
											$title= mb_substr($post->post_title, 0, 34, 'UTF-8');
											echo '<h2>'.$title.'…</h2>';
										}else{
											echo '<h2>'.$post->post_title.'</h2>';
										}
									?>
									<span class="cat">
										<?php 
										$category = get_the_category();
										$cat_name = $category[0]->name;
										echo $cat_name;
									 ?>
									 </span>
								</div>
							</a>
						</li>	
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</aside>
	</div>
	<div id="search-form" class="sidebar-wrapper">
		<?php get_search_form(); ?>
	</div>
</aside>
<!-- END .sidebar -->