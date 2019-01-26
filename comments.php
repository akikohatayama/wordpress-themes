<div class="comments">
    <?php 
    // コメントリストの表示
    if(have_comments()):
    ?>
        <ol class="commets-list">
            <?php wp_list_comments(); ?>
        </ol>
    <?php
    endif;
    
    echo comment_form();
    // コメントフォームここまで
    ?>
</div>