



<?php

	// prevent hacking
	defined('ABSPATH') or die("No Hackers Sorry !");


	/**
	 * 注意：每呼叫一次都會產生新的連結
	 *
	 * @param  string $student_id 學號
	 * @return string 註冊連結
	 */
	function generate_register_link( $student_id )
	{
		global $wpdb;

		// do the hash code
		$hash1 = $student_id . ' welcome to nccu dct ! haha';
		$hash2 = 'nccudct ' . date( 'Y-m-d H:i:s', time() ) . 'register! yoyo';
		$code = md5( $hash2 ).md5( $hash1 );


		// insert into db for checking
		$result = $wpdb->insert(
			'custom_register_code',
			array(
				'code' => $code,
				'available' => true
			),
			array(
				'%s',
				'%b'
			)
		);

		$url = get_site_url().'/new-register/?student_id='.$student_id.'&code='.$code.'&d='.$result;

		return $url;
	}


/**
 *
 * 這個 function 被用在 page-new-register.php 要傳入 code 跟 studentid
 *
 * 這個 function 用來驗證註冊碼是否正確。
 *
 * @param  string $code
 * @param  [type] $student_id [description]
 * @return bool             回傳 registaer code 是否正確
 */
	function check_register_code( $code, $student_id )
	{
		global $wpdb;

		$row = $wpdb->get_row(
			$wpdb->prepare("SELECT * FROM custom_register_code WHERE code = %s ", $code)
			);


		// if code not exsist or not avaliable
		if( empty( $row ) )
			return false;
		else if( $row->available != true )
			return false;

		// check length : 32
		$checkCode = substr( $code, 32, 32 );
		$hash1 = $student_id . ' welcome to nccu dct ! haha';

		// check the code is true with the student_id
		if( $checkCode == md5( $hash1 ) )
			return true;
		else
			return false;
	}

	// defined the function for check user names
	add_action( 'wp_ajax_nopriv_check_username', 'check_username_ajax' );
	add_action( 'wp_ajax_check_username', 'check_username_ajax' );


	/**
	 * 確認 username 在不在
	 * @return [type] [description]
	 */
	function check_username_ajax()
	{
		if( isset($_POST['entered_username']) )
		{
			if( username_exists( $_POST['entered_username'] ) )
				echo "EXIST";
			else
				echo "OK";
		}
		else
			echo "FAIL";

		die();
	}









// add menu
//
//
//
//
function add_registration_menu (){
	add_menu_page('學生註冊連結','學生註冊連結','manage_options','register-link-list', 'show_register_link_list','');
}
add_action('admin_menu', 'add_registration_menu');

function show_register_link_list(){
	global $title;

	print '<div class="wrap">';
	print "<h1>$title</h1>";

	$file = dirname(__FILE__) . '/page-register-link-list.php'  ;

	if ( file_exists( $file ) ){
		 require_once $file;
	}
	print '</div>';
}


// function  (){
// }



?>
