<?php

// ウィジェットの設定
register_sidebar();

// ナビゲーションメニューの設定
add_theme_support( 'menu' );

// wpautop関数を無効
remove_filter( 'the_content', 'wpautop' );

// 404エラー
register_nav_menu( 'error-nav',  ' 404エラー時に表示するナビ ' );

// 固定ページで抜粋欄を表示する
add_post_type_support( 'page', 'excerpt' );

// アイキャッチ画像の有効化
add_theme_support( 'post-thumbnails' );

// 無効化・非表示
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head','rest_output_link_wp_head' );
remove_action( 'wp_head','wp_oembed_add_discovery_links' );
remove_action( 'wp_head','wp_oembed_add_host_js' );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

//---------------------------------------
//投稿一覧画面にカスタムフィールドの表示カラムを追加
//---------------------------------------
function my_posts_columns($columns){
    $new_columns = array();
    foreach ($columns as $name => $val){
    	if('categories' == $name){
            $new_columns['date'] = '日付';
        }
        if('tags' == $name){
            $new_columns['カウント'] = 'カウント';
        }
        $new_columns[ $name ] = $val;
    }
    return $new_columns;
}

add_filter( 'manage_posts_columns', 'my_posts_columns' );

function my_posts_custom_column($column, $post_id){
    switch($column){
        case 'カウント':
            $post_meta=get_post_meta($post_id,'post_views_count', true);
            if($post_meta){
				echo $post_meta;
            }else{
                echo '';
            }
            break;
    }
}
add_action( 'manage_posts_custom_column' , 'my_posts_custom_column', 10, 2 );


//---------------------------------------
//個別記事閲覧時にカウント
//---------------------------------------
function setPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//---------------------------------------
//検索条件が未入力時にsearch.phpにリダイレクト
//---------------------------------------
function set_redirect_template(){
    if(isset($_GET['s']) && empty($_GET['s'])){
        include(TEMPLATEPATH . '/search.php');
        exit();
    }
}
add_action('template_redirect', 'set_redirect_template');

//---------------------------------------
//キーワード ・ noindexの設定
//---------------------------------------
function add_seo_custom_fields() {
	$screen = array('page' , 'post');
	add_meta_box( 'seo_setting', 'SEO', 'seo_custom_fields', $screen );
}

function seo_custom_fields() {
	global $post;
	$meta_keywords = get_post_meta($post->ID,'meta_keywords',true);
	$noindex = get_post_meta($post->ID,'noindex',true);
	if($noindex==1){
		$noindex_check="checked";
	}else{
		$noindex_check= "/";
	}
	echo '<p>meta keywordを設定 半角カンマ区切りで入力<br />';
	echo '<input type="text" name="meta_keywords" value="'.esc_html($meta_keywords).'" size="80" /></p>';
	echo '<p>低品質コンテンツの場合はチェック<br>';
	echo '<input type="checkbox" name="noindex" value="1" ' . $noindex_check . '> noindex</p>';
}
 
function save_seo_custom_fields( $post_id ) {
	if(!empty($_POST['meta_keywords'])){
		update_post_meta($post_id, 'meta_keywords', $_POST['meta_keywords'] );
	}else{
		delete_post_meta($post_id, 'meta_keywords');
	}

	if(!empty($_POST['noindex'])){
		update_post_meta($post_id, 'noindex', $_POST['noindex'] );
	}else{
		delete_post_meta($post_id, 'noindex');
	}
}
add_action('admin_menu', 'add_seo_custom_fields');
add_action('save_post', 'save_seo_custom_fields');

//---------------------------------------
//コメントで使用できるタグや属性を無効化の設定
//---------------------------------------
function invalidate_comment_tags($comment_content) {
    if (get_comment_type() == 'comment') {
        $comment_content = htmlspecialchars($comment_content, ENT_QUOTES);
    }
    return $comment_content;
}
add_filter('comment_text', 'invalidate_comment_tags', 9);
add_filter('comment_text_rss', 'invalidate_comment_tags', 9);
add_filter('comment_excerpt', 'invalidate_comment_tags', 9);

//---------------------------------------
//コメント欄設定
//---------------------------------------
function my_comment_form_remove($arg) {
    $arg['url'] = '';
    $arg['email'] = '';
    return $arg;
}
add_filter('comment_form_default_fields', 'my_comment_form_remove');

function change_comment_email_notes($defaults) {
    $defaults['title_reply'] = 'コメントはこちらからお気軽にどうぞ';
    $defaults['comment_notes_before'] = '<p class="comment-notes">
    <span id="email-notes">コメントはサイト管理者が確認するまで表示されませんのでしばらくお待ちください。<br>
    また、他の読者の方にも有益だと判断した場合掲載いたしますのでご了承くださいませ。<br>
    </span></p>';
    
    return $defaults;
}
add_filter('comment_form_defaults', 'change_comment_email_notes');

function move_comment_field_to_bottom($fields) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}
add_filter('comment_form_fields', 'move_comment_field_to_bottom');

//---------------------------------------
//contact form 7 プラグインをお問い合わせページ以外で読み込まない設定
//---------------------------------------
function my_contact_enqueue_scripts(){
wp_deregister_script('contact-form-7');
wp_deregister_style('contact-form-7');
if (is_page('contact')) {
    if (function_exists( 'wpcf7_enqueue_scripts')) {
        wpcf7_enqueue_scripts();
    }
    if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
    wpcf7_enqueue_styles();
    }
}
}
add_action( 'wp_enqueue_scripts', 'my_contact_enqueue_scripts');

//---------------------------------------
//<pre><code を使っているときだけhighlightタグを読み込む設定
//---------------------------------------
function load_higlight_js() {

    global $post;
    if( false !== strpos( $post->post_content, '<pre><code' ) ){
        echo '<link rel="stylesheet" href="https://chittaboo.com/blog/wp-content/themes/chittaboo/highlight.css">';
        echo '<script src="https://chittaboo.com/blog/wp-content/themes/chittaboo/highlight.pack.js"></script>';
        echo '<script>hljs.initHighlightingOnLoad();</script>';
    }
}
add_action( 'wp_footer', 'load_higlight_js');

//----------------------------------------
// titleタグ
//----------------------------------------
function theme_slug_setup() {
   add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_slug_setup');

//セパレータ
function title_separator($sep) {
    $sep = '|';
    return $sep;
}
add_filter('document_title_separator', 'title_separator');

//----------------------------------------
// インスタグラム埋め込み
//----------------------------------------
function get_instagram(){

    $option = [
        //文字列として返すかどうか
        CURLOPT_RETURNTRANSFER => true,
        // タイムアウト時間
        CURLOPT_TIMEOUT        => 3,
    ];

    $myAccessToken = 'xxxxx.xxxxxxxxxx.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    //表示件数
    $count = 4;
    $url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$myAccessToken."&count=".$count;

    $ch = curl_init($url);
    curl_setopt_array($ch, $option);

    $json    = curl_exec($ch);
    $info    = curl_getinfo($ch);
    $errorNo = curl_errno($ch);

    if ($errorNo !== CURLE_OK) {
        // 詳しくエラーハンドリングしたい場合はerrorNoで確認
        // タイムアウトの場合はCURLE_OPERATION_TIMEDOUT
        return [];
    }

    // 200以外のステータスコードは失敗とみなし空配列を返す
    if ($info['http_code'] !== 200) {
        return [];
    }

    //取ってきた内容を読み込んで、取得した件数分まわす
    $obj = json_decode($json);
    foreach($obj->data as $key => $data){

        if(($key % 2) == 0){
            print('<div class="insta_left_item">');
        }else{
            print('<div class="insta_right_item">');

        }
        print('<div class="insta_thumb_wrap">');
        print('<div class="insta_thumb">');
        printf('<a href="%s" target="_blank">',$data->link);
        printf('<img src="%s" alt="">',$data->images->low_resolution->url);
        print('</a>');
        print('</div>');
        print('</div>');
        print('<div class="insta_comment">');
        print('<span class="date">');
        $datetime = date("Y-m-d", $data->created_time );
        $posted_date = date("Y年m月d日", $data->created_time );
        print('<time class="date" datetime="');
        printf($datetime);
        print('"><i class="fas fa-camera"></i>');
        printf($posted_date);
        print('</time>');
        print('</span>');
        if(mb_strlen($data->caption->text, 'UTF-8') > 25){
            $caption_text= mb_substr($data->caption->text, 0, 25, 'UTF-8');
            echo '<p class="caption-text">'.$caption_text.'…</p>';
        }else{
            echo '<p class="caption-text">'.$data->caption->text.'</p>';
        }
        print('</div>');
        print('</div>');
    };
}

//----------------------------------------
// ページネーション出力
// $paged : 現在のページ
// $pages : 全ページ数
// $range : 左右に何ページ表示するか
// $show_only : 1ページしかない時に表示するかどうか
//----------------------------------------
function pagination( $pages, $paged, $range = 1, $show_only = false ) {
    $showitems = ($range * 2)+1;
    //float型で渡ってくるので明示的にint型へ
    $pages = ( int ) $pages;
    //get_query_var('page')をそのまま投げても大丈夫なように
    $paged = $paged ?: 1;

    if ( $show_only && $pages === 1 ) {
        // １ページのみで表示設定が true の時
        echo '<div class="pagination"><span class="current pager">1</span></div>';
        return;
    }

    // １ページのみで表示設定もないとき
    if ( $pages === 1 ) {
        return;
    }

    if ( 1 !== $pages ) {
        echo '<div class="pagination">';
        echo '<p class="inner">';
        echo '<span class="page-of">Page'.$paged.'/'.$pages.'</span>';
        if ( $paged > $range + 1 ) {
            echo '<a class="m-prev" href="'.get_pagenum_link(1).'"><i class="fas fa-angle-double-left"></i></a>';
        }
        if ( $paged > 1 ) {
            echo '<a class="pn-prev" href="'.get_pagenum_link( $paged - 1 ).'"><i class="fas fa-angle-left"> 前へ</i></a>';
        }

        for ( $i = 1; $i <= $pages; $i++ ) {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                // $paged +- $range 以内であればページ番号を出力
                if ( $paged === $i ) {
                    echo '<span class="current">', $i ,'</span>';
                } else {
                    echo '<a href="'.get_pagenum_link( $i ).'" class="pn-numbers">'.$i.'</a>';
                }
            }
        }
        if ( $paged < $pages ) {
            echo '<a class="pn-next" href="'.get_pagenum_link( $paged + 1 ).'">次へ <i class="fas fa-angle-right"></i></a>';
        }
        if ( $paged + $range < $pages ) {
            echo '<a class="m-next" href="'.get_pagenum_link( $pages ).'"><i class="fas fa-angle-double-right"></i></a>';
        }
        echo '</p></div>'."\n";
    }
}
//----------------------------------------
// カテゴリーページネーション出力
// $paged : 現在のページ
// $pages : 全ページ数
// $range : 左右に何ページ表示するか
// $show_only : 1ページしかない時に表示するかどうか
//----------------------------------------
function category_pagination( $pages, $paged, $range = 1, $show_only = false ) {
    $showitems = ($range * 2)+1;
    //float型で渡ってくるので明示的にint型へ
    $pages = ( int ) $pages;
    //get_query_var('page')をそのまま投げても大丈夫なように
    $paged = $paged ?: 1;

    if ( $show_only && $pages === 1 ) {
        // １ページのみで表示設定が true の時
        echo '<div class="pagination"><span class="current pager">1</span></div>';
        return;
    }

    // １ページのみで表示設定もないとき
    if ( $pages === 1 ) {
        return;
    }

    if ( 1 !== $pages ) {
        echo '<div class="pagination">';
        echo '<p class="inner">';
        echo '<span class="page-of">Page'.$paged.'/'.$pages.'</span>';
        $url = 'https://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

        if(strpos($url,'?page=') === false){
            $url = preg_replace('/\/$/', '?page=', $url);
        }else{
            $url = preg_replace('/\?page=./', '?page=', $url);
        }

        if ( $paged > $range + 1 ) {
            echo '<a class="m-prev" href="'.$url.'1"><i class="fas fa-angle-double-left"></i></a>';
        }
        if ( $paged > 1 ) {
            $paged_number = $paged - 1;
            $link = $url.$paged_number;
            echo '<a class="pn-prev" href="'.$link.'"><i class="fas fa-angle-left"> 前へ</i></a>';
        }

        for ( $i = 1; $i <= $pages; $i++ ) {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
                // $paged +- $range 以内であればページ番号を出力
                if ( $paged === $i ) {
                    echo '<span class="current">', $i ,'</span>';
                } else {
                    echo '<a href="'.$url.$i.'" class="pn-numbers">'.$i.'</a>';
                }
            }
        }
        if ( $paged < $pages ) {
            $paged_number = $paged + 1;
            $link = $url.$paged_number;
            echo '<a class="pn-next" href="'.$link.'">次へ <i class="fas fa-angle-right"></i></a>';
        }
        if ( $paged + $range < $pages ) {
            echo '<a class="m-next" href="'.$url.$pages.'"><i class="fas fa-angle-double-right"></i></a>';
        }
        echo '</p></div>'."\n";
    }
}
//----------------------------------------
// 記事内アドセンス
//----------------------------------------
function show_adsense_contents() {
    return '<div class="advertisement"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block; text-align:center;"
     data-ad-layout="in-article"
     data-ad-format="fluid"
     data-ad-client="xx-xxx-xxxxxxxxxxxx"
     data-ad-slot="xxxxxxxxx"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script></div>';
}

add_shortcode('adcontents', 'show_adsense_contents');

//----------------------------------------
//jQuery Migrate プラグインだけ外す方法
//----------------------------------------
function dequeue_jquery_migrate( $scripts){
    if(!is_admin()){    
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
    }
}
add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );

//----------------------------------------
//前の記事・次の記事
//----------------------------------------
function next_post_link_attributes($output) {
    return str_replace('<a href=', '<a class="next-link" href=', $output);
}
add_filter('next_post_link', 'next_post_link_attributes');

function prev_post_link_attributes($output) {
    return str_replace('<a href=', '<a class="prev-link" href=', $output);
}
add_filter('previous_post_link', 'prev_post_link_attributes');

//----------------------------------------
// 内部リンクをショートコードでブログカード化 http://nelog.jp/get_the_custom_excerpt
//----------------------------------------
function get_the_custom_excerpt($content, $length) {
    //デフォルトの長さを指定する
    $length = ($length ? $length : 70);
    //ショートコード削除
    $content =  strip_shortcodes($content);
    //タグの除去
    $content =  strip_tags($content);
    //特殊文字の削除（今回はスペースのみ）
    $content =  str_replace("&nbsp;","",$content);
    return $content;
}
 
//----------------------------------------
//内部リンクをはてなカード風にするショートコード
//----------------------------------------
function nlink_scode($atts) {
    extract(shortcode_atts(array(
        'url'=>"",
        'title'=>"",
        'excerpt'=>""
    ),$atts));

    //URLから投稿IDを取得
    $id = url_to_postid($url);
    $post = get_post($id);
    //カテゴリー
    $category = get_the_category($id);
    $cat_name = $category[0]->cat_name;
    //投稿日
    $post_date = mysql2date('Y年m月d日', $post->post_date);
    //更新日
    $post_modified = mysql2date('Y年m月d日', $post->post_modified);
    //内容
    $content = $post->post_content;
    if(mb_strlen($content, 'UTF-8') > 90){
        $content = mb_substr(strip_tags($content), 0, 90, 'UTF-8').'…';
    }else{
        $content = strip_tags($content);
    }
    //画像サイズの幅
    $img_width ="90";
    //画像サイズの高さ
    $img_height = "90";
    //タイトルを取得
    if(empty($title)){
        $title = esc_html(get_the_title($id));
    }
 
    //アイキャッチ画像を取得 
    if(has_post_thumbnail($id)) {
        $img = wp_get_attachment_image_src(get_post_thumbnail_id($id),array($img_width,$img_height));
        $img_tag = "<img src='" . $img[0] . "' alt='{$title}' width=" . $img[1] . " height=" . $img[2] . " />";
    }

    $site_url = get_bloginfo('url');
    $site_title = get_bloginfo( 'name' );
    $site_description = get_bloginfo( 'description' );

    $nlink .='
<div class="blog-card">
    <a href="'. $url .'">
        <div class="blog-card-thumbnail">'. $img_tag .'</div>
        <div class="blog-card-content">
            <div class="blog-card-title">'. $title .' </div>
            <span class="date">
                <time class="entry-date date" datetime="'.$post_date.'"><i class="fas fa-pencil-alt"></i>'.$post_date.'</time>
                <time class="update date" datetime="'.$post_modified.'"><i class="fas fa-sync-alt"></i>'.$post_modified.'</time>
            </span>
            <span class="cat">'.$cat_name.'</span>
            <p>'.$content.'</p>
        </div>
        <div class="clear"></div>
    </a>
</div>';
    return $nlink;
}  
 
add_shortcode("nlink", "nlink_scode");
?>
