<?php
	
	// prevent hacking
	defined('ABSPATH') or die("No Hackers Sorry !");
	
	// test add custome meta post
	add_action( 'add_meta_boxes', 'add_project_member_metabox' );
	function add_project_member_metabox()
	{
		// need to do in loop
		$available_type = array( 'post' );
		
		add_meta_box( 
			'project_member',
			'專案成員',
			'project_member_metabox_html',
			'post',
			'normal',
			'core'
		);
	}
	
	function project_member_metabox_html()
	{
?>
			<input id="project_member_input" type="text" style="width: 300px" placeholder="請輸入名字、帳號或暱稱搜尋成員" />
            <div id="project_member_selected_show">
            </div>
            <input id="project_member_selected" name="member_selected" type="hidden" />
        
<?php
	}
	
	// put meta box right after title
	add_action( 'admin_head', 'js_hack_field_position' );
	function js_hack_field_position()
	{
		//target id : wp-content-media-buttons
		//our id : project_member
		
		wp_register_script('editor-project-member-selection', get_template_directory_uri().'/js/editor-project-member-selection.js', array('jquery'));
        wp_enqueue_script('editor-project-member-selection');
	}
	
	
	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	add_action( 'save_post', 'project_member_save_users' );
	function project_member_save_users( $post_id ) {
	
		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
	
		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
	
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
	
		} else {
	
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}
	
		/* OK, it's safe for us to save the data now. */
		
		// Make sure that it is set.
		if ( ! isset( $_POST['member_selected'] ) ) {
			return;
		}


		$selected_member = json_decode( $_POST['member_selected'] );
		
		// clear all member meta
		delete_post_meta( $post_id, 'project_member' );
		
		// add every member into meta
		foreach( $selected_member as $index => $member_user_id ):
			// Update the meta field in the database.
			add_post_meta( $post_id, 'project_member', $member_user_id );
		endforeach;
	}
	
	
	
	// register the ajax request
	add_action('wp_ajax_find_project_member', 'find_project_member');
	function find_project_member()
	{
		$search_string = $_POST['search_string'];
		
		// if search empty, return empty
		if( strlen( $search_string ) < 1 ) exit();
		
		// save all found users in
		$foundUsers;
		
		// search for url, nickname, login...
		$args = array(
			'search' => "*$search_string*",
			'search_columns' => array(
				'user_login',
				'user_nickname',
				'user_email',
				'user_url'
			),
			'role' => 'student'
		);
		
		$users = new WP_User_Query( $args );
		$results = $users->get_results();
		
		// get all results from english usernames
		foreach( $results as $index => $data )
			$foundUsers[ $data->ID ] = true;		
		
		// search for chinese characters
		// get each chinese chacters first
		$length_chi = mb_strlen( $search_string, 'utf-8' );

		$search_strings_chi = '%';
		for( $i=0; $i< $length_chi; $i++ )
		{
			$search_strings_chi .= mb_substr( $search_string, $i, 1, 'utf-8' );
			$search_strings_chi .= '%';
		}
		
		// seems wp_user_query cant search display_name, so do it in sql
		global $wpdb;
		$sql = "SELECT ID, display_name FROM dct_users WHERE display_name LIKE '$search_strings_chi'";
		
		$rows = $wpdb->get_results( $sql );
		foreach( $rows as $index => $data )
			$foundUsers[ $data->ID ] = true;
		
		// dont display selected users
		$selectedUsers = json_decode( $_POST['selected_users'] );
		if( !is_null($selectedUsers) )
		{
			foreach( $selectedUsers as $i => $idValue ):
				$foundUsers[ $idValue ] = false;
			endforeach;
		}
		// print all true users into divs
		$limitAmount = 5;
		
		// if no result exit
		if( empty( $foundUsers ) ) exit();
		foreach( $foundUsers as $indexId => $data ):
			// if set to false than skip
			if( !$data ) continue;
			
			echo get_user_div( $indexId );
			if( --$limitAmount == 0 ) break;
		endforeach;
		
		exit();
	}
	
	function get_user_div( $userId )
	{
		$targetUser = get_user_by( 'id', $userId );
		$photoId = get_user_meta( $userId, 'person_photo', true );
		$photo = wp_get_attachment_image_src( $photoId, 'thumbnail' );
		$photoUrl = $photo[0];
		
		$data = '';
		$data .= "<div id='member_$userId' class='editor-member-thumbnail' >";
		$data .= "<img src='$photoUrl' />";
		$data .= "<span class='display-name'>".$targetUser->display_name."</span>";
		$data .= "</div>";
		
		return $data;
	}
	
	// register the ajax request
	// get all member when editing init
	add_action('wp_ajax_get_project_members', 'get_project_members');
	function get_project_members()
	{
		if( !isset( $_POST['post_id'] ) ) exit();
		
		$member_ids = get_post_meta( $_POST['post_id'], 'project_member', false );
		
		foreach( $member_ids as $index => $id ):
			echo get_user_div_for_init( $id );
		endforeach;
		
		exit();
	}
	
	function get_user_div_for_init( $target_user_id )
	{
		$targetUser = get_user_by( 'id', $target_user_id );
		$photoId = get_user_meta( $target_user_id, 'person_photo', true );
		$photo = wp_get_attachment_image_src( $photoId, 'thumbnail' );
		$photoUrl = $photo[0];
		
		$data = '';
		$data .= "<div class='selected-member-thumbnail' id='selected_$target_user_id'>";
		$data .= "<img src='$photoUrl' />";
		$data .= '<span class="display-name">'.$targetUser->display_name.'</span>';
		$data .= '<span class="close-mark">X</span>';
		$data .= '</div>';
		
		return $data;
	}
	
	
		
	
?>