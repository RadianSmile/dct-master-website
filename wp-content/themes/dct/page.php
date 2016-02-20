<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php get_header() ?>
<?php

    // 預設抓取現在頁面的 post
    $thePost = get_post();
    
    $thumbnail_id = get_post_meta( $thePost->ID, '_thumbnail_id', true );
    $imageUrl = wp_get_attachment_url( $thumbnail_id );

?>
<div id="pageMainView" class="mainView top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pos">
                    <h1><?=$thePost->post_title?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom GF">
        <div></div>
        <div></div>
    </div>
</div>
<!-- /mainView -->




<div class="container">
    <?= apply_filters( 'the_content', $thePost->post_content ) ?>
</div>
<?php if( $imageUrl != "" ): ?>
    <script>
        $('#pageMainView').backgroundUrl = '<?=$imageUrl?>';
    </script>
<?php endif ?>
<?php get_footer() ?>