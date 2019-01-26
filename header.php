<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head prefix="og: http://ogp.me/ns#">
<?php if(is_tag() || is_date() || is_search() || is_404()) : ?><meta name="robots" content="noindex"/><?php endif; ?>
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">
<meta property="og:locale" content="ja_JP">
<?php if( is_single() || is_page() ): ?>
<?php if(get_post_meta(get_the_ID(),'noindex',true)){ echo'<meta name="robots" content="noindex"/>';}; ?>
<meta property="og:type" content="article">
<meta property="og:title" content="<?php the_title(); ?>">
<meta property="og:url" content="<?php the_permalink(); ?>">
<?php if(is_front_page() && is_paged()): ?>
<meta property="og:description" content="<?php echo "ページ ".get_query_var('page')." | ".strip_tags( get_the_excerpt() ); ?>" />
<?php else: ?>
<meta property="og:description" content="<?php echo strip_tags( get_the_excerpt() ); ?>">
<?php endif; ?>
<?php if( has_post_thumbnail() ): ?>
<?php $postthumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
<meta property="og:image" content="<?php echo $postthumb[0]; ?>">
<?php endif; ?>
<?php else: ?>
<meta property="og:type" content="website">
<meta property="og:title" content="<?php bloginfo( 'name' ); ?>">
<?php
$http = is_ssl() ? 'https' . '://' : 'http' . '://';
$url = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
?>
<meta property="og:url" content="<?php echo $url; ?>">
<meta property="og:description" content="<?php bloginfo( 'description' ) ?>">
<!-- <meta property="og:image" content=""> -->
<?php endif; ?>
<?php $customfield = get_post_meta($post->ID, 'meta_keywords', true); ?>
<?php if( empty($customfield) ): ?>
<?php if( has_tag() ): ?>
<?php $tags = get_the_tags(); $kwds = array(); foreach($tags as $tag){ $kwds[] = $tag->name; } ?>
<meta name="keywords" content="<?php echo implode( ',',$kwds ); ?>">
<?php endif; ?>
<?php else: ?>
<?php if( !is_category() ): ?>
<meta name="keywords" content="<?php echo esc_attr( $post->meta_keywords ); ?>">
<?php endif; ?>
<?php endif; ?>
<?php if( is_category() ): ?>
<?php if( is_category('music') ): ?>
<meta name="keywords" content="チッタボ,ちったぼ,音楽">
<?php if( isset($_GET["page"]) &&  $_GET["page"] > 0 ): ?>
<meta name="description" content="<?php echo "ページ ".$_GET["page"]." | 音楽に関する記事の一覧を表示しています。"; ?>" />
<?php else: ?>
<meta name="description" content="音楽に関する記事の一覧を表示しています。">
<?php endif; ?>
<?php endif; ?>
<?php if( is_category('life') ): ?>
<meta name="keywords" content="チッタボ,ちったぼ,暮らし">
<?php if( isset($_GET["page"]) &&  $_GET["page"] > 0 ): ?>
<meta name="description" content="<?php echo "ページ ".$_GET["page"]." | 暮らしに関する記事の一覧を表示しています。"; ?>" />
<?php else: ?>
<meta name="description" content="暮らしに関する記事の一覧を表示しています。">
<?php endif; ?>
<?php endif; ?>
<?php if( is_category('programming') ): ?>
<meta name="keywords" content="チッタボ,ちったぼ,プログラミング">
<?php if( isset($_GET["page"]) &&  $_GET["page"] > 0 ): ?>
<meta name="description" content="<?php echo "ページ ".$_GET["page"]." | プログラミングに関する記事の一覧を表示しています。"; ?>" />
<?php else: ?>
<meta name="description" content="プログラミングに関する記事の一覧を表示しています。">
<?php endif; ?>
<?php endif; ?>
<?php if( is_category('beauty') ): ?>
<meta name="keywords" content="チッタボ,ちったぼ,ビューティー">
<?php if( isset($_GET["page"]) &&  $_GET["page"] > 0 ): ?>
<meta name="description" content="<?php echo "ページ ".$_GET["page"]." | ビューティーに関する記事の一覧を表示しています。"; ?>" />
<?php else: ?>
<meta name="description" content="ビューティーに関する記事の一覧を表示しています。">
<?php endif; ?>
<?php endif; ?>
<?php if( is_category('other') ): ?>
<meta name="keywords" content="チッタボ,ちったぼ,その他">
<?php if( isset($_GET["page"]) &&  $_GET["page"] > 0 ): ?>
<meta name="description" content="<?php echo "ページ ".$_GET["page"]." | その他に関する記事の一覧を表示しています。"; ?>" />
<?php else: ?>
<meta name="description" content="その他に関する記事の一覧を表示しています。">
<?php endif; ?>
<?php endif; ?>
<?php else: ?>
<?php if(is_front_page() && is_paged()): ?>
<meta name="description" content="<?php echo "ページ ".get_query_var('page')." | ".strip_tags( get_the_excerpt() ); ?>" />
<?php else: ?>
<meta name="description" content="<?php echo strip_tags( get_the_excerpt() ); ?>" />
<?php endif; ?>
<?php endif; ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/reset.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css?date=20190108">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="apple-touch-icon" href="<?php bloginfo( 'template_url' ) ?>/webclipicon.png" />
<link rel="shortcut icon" href="<?php bloginfo( 'template_url' ) ?>/webclipicon.ico" />
<?php wp_enqueue_script('jquery'); ?>
<?php wp_head(); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" async charset='UTF-8'></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/jquery.js" async charset='UTF-8'></script>
<!-- START GoogleAnalytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-xxxxxxx-x', 'auto');
ga('send', 'pageview');
</script>
</head>
<body>
	<header>
		<div class="header">
			<!-- logo -->
			<div class='site-title'>
				<h1>
					<a href="https://chittaboo.com">
						<img src="https://chittaboo.com/blog/wp-content/uploads/logo.png" alt="チッタボ" title="チッタボ" />
					</a>
				</h1>
			</div>
			<button type="button" id="navbutton" class="navbutton">
				<span class="m-bar hmb-1"></span>
				<span class="m-bar hmb-2"></span>
				<span class="m-bar hmb-3"></span>
		    </button>
			<!-- navigationbar -->
			<nav class="nav"><?php wp_nav_menu(array('menu' => 'navimenu')); ?></nav>
		</div>
	<?php wp_head(); ?>
	</header>
