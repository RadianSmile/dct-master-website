<?php
	
	// prevent hacking
	defined('ABSPATH') or die("No Hackers Sorry !");
	
	
	// add student and teacher role
	// need edited, only call one time in life time
	$permission = array(
		'read' => true,
		'edit_posts' => true,
		'edit_published_posts' => true,
		'delete_posts' => true,
		'delete_published_posts' => true,
		'publish_posts' => true,
		'upload_files' => true
	);
	
	remove_role( 'student' );
	remove_role( 'professor' );
	add_role( 'student', '學生', $permission );
	add_role( 'professor', '教授', $permission );
	
	
	// display custom fields when editing profile
	add_action( 'show_user_profile', 'dctweb_extra_profile_fields' );
	add_action( 'edit_user_profile', 'dctweb_extra_profile_fields' );
	
	// load media elements
	add_action('admin_enqueue_scripts', 'my_admin_scripts');
		
	// user has role arrays
	function is_role( $search, $role_array ) {
		foreach( $role_array as $index => $data )
			if( $data == $search )
				return true;
		
		return false;
	}
	
	// main execution function
	function dctweb_extra_profile_fields( $user ) { 
		
		if( is_role( 'student', $user->roles ) )
			show_student_fields( $user );
		else if( is_role( 'professor', $user->roles ) )
			show_professor_fields( $user );
	
	}
	
	// show student fields
	function show_student_fields( $user ) { ?>
    
		<h3>學生資料表</h3>
	
		<table class="form-table">
        	<tr>
            	<th><label for="person_photo">照片</label></th>
                <td>
                	<div id="person_photo_preview" style="margin:5px; width:150px; height:200px;
                    background-image: url(<?php
					
					$attachment_id = get_user_meta( $user->ID, 'person_photo', true );
					$photo = wp_get_attachment_image_src( $attachment_id, 'medium' );
					echo esc_attr( $photo[0] );
					?>);
                    background-size: cover; background-position:center; border:2px #666666 solid;">
                    </div>
    				<input id="person_photo" type="hidden" size="36" name="person_photo" value="<?=
					 esc_attr( get_the_author_meta( 'person_photo', $user->ID ) )?>" /> 
    				<input id="upload_image_button" class="button" type="button" value="選擇照片" /><br />
                </td>
            </tr>
            <tr>
            	<th><label for="cover_photo">封面照片</label></th>
            	<td>
            		<div id="cover_photo_preview" style="margin:5px; width:150px; height:200px;
            		background-image: url(<?php

            		$attachment_id = get_user_meta( $user->ID, 'cover_photo', true );
					$photo = wp_get_attachment_image_src( $attachment_id, 'medium' );
					echo esc_attr( $photo[0] );
					?>);
					background-size: cover; background-position:center; border:2px #666 solid;">
					</div>
					<input id="cover_photo" type="hidden" size="36" name="cover_photo" value="<?=
						 esc_attr( get_the_author_meta( 'cover_photo', $user->ID ) )?>" /> 
    				<input id="upload_cover_button" class="button" type="button" value="選擇圖片檔案" /><br />
            	</td>
            </tr>
            <tr>
            	<th><label for="student_id">學號</label></th>
                <td>
<?php
	$login_user = wp_get_current_user();
	if( is_role('administrator', $login_user->roles ) )
	{
		$disable = '';
		$desc = '';
	}
	else
	{
		$disable = 'disabled';
		$desc = '學號不開放修改，如有錯誤請聯絡助教';
	}
	$content = esc_attr( get_the_author_meta( 'student_id', $user->ID ) );
?>
					<input <?=$disable?> type="text" name="student_id" id="student_id" value="<?= $content ?>" class="regular-text" /><br />
					<span class="description"><?=$desc?></span>
				</td>
            </tr>
                <th><label for="term_num">第幾屆</label></th>
                <td>
                	<select name="term_num">
                    <?php
                    	$term_num = esc_attr( get_the_author_meta( 'term_num', $user->ID ));
						if( $term_num == '' )
							echo '<option value="">-- 請選擇屆數 --</option>';
						else
							echo "<option value='$term_num'>第 $term_num 屆</option>";
					?>
                    	
                    <?php for( $i= (date('Y') - 2008); $i>0 ; $i-- ):?>
                    	<option value="<?=$i?>">第 <?=$i?> 屆</option>
                    <?php endfor; ?>
                    </select>
                    <br /><span class="description">請輸入職稱，或最能代表你的稱號</span>
                </td>
                <tr>
            </tr>
        	<tr>
            	<th><label for="person_title">稱號</label></th>
                <td>
					<input type="text" name="person_title" id="person_title" value="<?= 
					esc_attr( get_the_author_meta( 'person_title', $user->ID ) ) ?>" class="regular-text" /><br />
					<span class="description">請輸入職稱，或最能代表你的稱號</span>
				</td>
            </tr>
			<tr>
            	
				<th><label for="motto">名言</label></th>
				<td>
					<input type="text" name="motto" id="motto" value="<?=
					esc_attr( get_the_author_meta( 'motto', $user->ID ) ) ?>" class="regular-text" /><br />
					<span class="description">請輸入最能代表你的一句話</span>
				</td>
			</tr>
	
		</table>
	<?php }
	
	function show_professor_fields( $user ) { ?>
    
    <h3>教授資料</h3>
    under construction ...
    <?php } 
	
	
	// save custom fields
	add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
	add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

	function my_save_extra_profile_fields( $user_id ) {
	
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;
		
		$user = wp_get_current_user();
		if( is_role('administrator', $user->roles ) )
			update_usermeta( $user_id, 'student_id', $_POST['student_id'] );
		
		update_usermeta( $user_id, 'person_photo', $_POST['person_photo'] );
		update_usermeta( $user_id, 'cover_photo', $_POST['cover_photo'] );
		update_usermeta( $user_id, 'person_title', $_POST['person_title'] );
		update_usermeta( $user_id, 'motto', $_POST['motto'] );
		update_usermeta( $user_id, 'term_num', $_POST['term_num'] );
	}
	
	// attach media selector javascripts
	function my_admin_scripts() {
		wp_enqueue_media();
        wp_register_script('dctprofile-media-selector', get_template_directory_uri().'/js/profile-media-selector.js', array('jquery'));
        wp_enqueue_script('dctprofile-media-selector');
	}
?>