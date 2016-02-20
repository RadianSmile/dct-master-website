<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php get_header( 'simple' ) ?>
<article class="main">
	<?php
		// $ary[ $term_num ][ user_id ]
		$display_array;
		
		
		
		// get all students
		$args = array(
			'role'		=>	'student',
			'meta_key'	=>	'student_id',
			'orderby'	=>	'meta_value',
			'order'		=>	'asc'
		);
		
		$students = get_users( $args );
		
		// put users in display array, in order to set the term_num
		foreach( $students as $index => $data ):
			$term_num = get_user_meta( $data->ID, 'term_num', true );
			
			if( empty( $display_array[ $term_num ] ) )
				$display_array[ $term_num ] = array();
			array_push( $display_array[ $term_num ], $data );
		endforeach;
		
		// sort array DESC, make newer student appear first
		krsort($display_array);
	?>
    
	<?php foreach( $display_array as $term => $user_array ): ?>
        <div class="term-spliter-text">第 <?=$term?> 屆</div>
        <div class="term-spliter-line"></div>
        
        <div class="term-container">
			<?php foreach( $user_array as $index => $data ): ?>
            <?php
                
                $attachment_id = get_user_meta( $data->ID, 'person_photo', true );
                $photo = wp_get_attachment_image_src( $attachment_id, 'medium' );
                $photoUrl = esc_attr( $photo[0] );
                
            ?>
            <div class="students-thumbnail" style="background-image: url(<?=$photoUrl?>);">
            <a href="<?=site_url().'/author/'.$data->user_login?>">
                <div class="user-info">
                    <?= $data->display_name ?><br />
                    <?= get_user_meta( $data->ID, 'person_title', true ) ?>
                </div>
            </a>
            </div>
            <?php endforeach; ?>
        </div>
	<?php endforeach ?>
</article>
<?php get_footer( 'simple' ) ?>