jQuery(function($){
	//ナビゲーションメニュー
	$('#navbutton').click(function() {
		$('.nav').slideToggle();
	});


	$('#navbutton').on('click', function() {
		$(this).toggleClass('active');
	});

	//戻るボタン
	var pageTop = $('.page_top');
    pageTop.hide();
    $(window).scroll(function() {
        if ($(this).scrollTop() > 800){
            pageTop.fadeIn();
        } else {
            pageTop.fadeOut();
        }
    });
    pageTop.click(function() {
        $('body, html').animate({scrollTop:0}, 500, 'swing');
        return false;
    });

});