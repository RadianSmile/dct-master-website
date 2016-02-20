<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php get_header() ?>
<div class="mainView top">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="pos">
          <h1>STUDENTS</h1>
          <p>政治大學數位內容碩士學位學程</p>
          <p>學生</p>
        </div>
      </div>
    </div>
  </div>
  <div class="bottom GF">
    <div></div>
    <div></div>
  </div>
</div>
<!-- main view -->


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
<div class="container">
  <div class="row">
    <div class="col-sm-12 ">
    
      <div class="divTitle">
        <?=$term?>th <span></span>
      </div>

    <?php foreach( $user_array as $index => $data ):
    
                
        $attachment_id = get_user_meta( $data->ID, 'person_photo', true );
        $photo = wp_get_attachment_image_src( $attachment_id, 'thumbnail', true );
        $photoUrl = esc_attr( $photo[0] );

        if( $attachment_id == null )
        	$photoUrl = get_template_directory_uri() . '/img/WhosWho.png';
               
    ?>
    <div class="col-md-3 listuser text-center">
    	<a href="<?= site_url().'/author/'.$data->user_login ?>">
    		<img src="<?= $photoUrl ?>" alt="<?= $data->display_name ?>" class="img-circle" />
    		<h4> <?= $data->display_name ?> </h4>
    		<p> <?= get_user_meta( $data->ID, 'person_title', true ) ?> </p>
    	</a>
    </div>
    <?php endforeach; ?>
      
      
    </div>
  </div>
</div>
<hr>
<?php endforeach; ?>
<script>
$('body').attr('id', 'students');
$('li.students').attr('class', 'active students');
</script>
<?php get_footer() ?>