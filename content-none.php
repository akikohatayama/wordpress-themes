<div class="content-none">
	<?php if(is_404()){
		// 404ページのとき
		$site_name = get_bloginfo('name');
		echo 'いつも',$site_name,'をご覧いただきありがとうございます。<br>
					アクセスされたページは削除またはURLが変更されています。<br>
					<br>
					これからもよりよいサイトになるよう精進させていただきますのでよろしくお願いいたします。';
	}elseif(is_search()){
		// 検索結果ページのとき
		$site_name = get_bloginfo('name');
		$search_name = get_search_query();
		echo 'いつも', $site_name, 'をご覧いただきありがとうございます。<br>
				「',$search_name,'」で検索しましたがページが見つかりませんでした。<br>
				<br>
				これからもよりよいサイトになるよう精進させていただきますのでよろしくお願いいたします。';
	} ?>
</div>