<?php defined('ABSPATH') or die("No Hackers Sorry !"); ?>
<?php

	// use some wp build-in styles
	wp_enqueue_style( 'form-table', '/wp-admin/css/forms.css');
	wp_enqueue_style( 'form-button', '/wp-includes/css/buttons.css');
	wp_enqueue_script('password-strength-meter');

?>
<?php
	
	if( count($_POST) == 7 )
	{
		$show_function = 'register_account';
	}
	else if( isset( $_GET['code'] ) && isset( $_GET['student_id'] ) )
	{
		if( check_register_code( $_GET['code'], $_GET['student_id'] ) )
			$show_function = 'form_part_html';
	}
	
	if( $show_function == NULL )
		return_404();


?>
<?php get_header( 'simple' ) ?>
<?php

	// display the content
	$show_function();
	
	
	
	
	function register_account(){
		
		// do some server side check
		
		// check is code being modified
		if( !check_register_code( $_POST['rcode'], $_POST['student_id'] ) )
		{
			echo "有錯誤發生，註冊失敗，請聯絡管理員！";
			return ;
		}
		
		if( username_exists( $_POST['user_name'] ) )
		{
			echo "帳號已經被使用，請換一個帳號重新註冊";
			return ;
		}
		
		$userData = array(
			'user_login' => $_POST['user_name'],
			'user_pass' => $_POST['pass1'],
			'role' => 'student',
			'user_email' => $_POST['email'],
		);
		
		$user_id = wp_insert_user( $userData );
		
		// if create user succeed, would return user id, otherwise return object
		if( gettype($user_id) == 'integer' ) {
			update_usermeta( $user_id, 'student_id', $_POST['student_id'] );
			
			global $wpdb;
			
			$wpdb->update(
				'custom_register_code',
				array( 'available' => false ),
				array( 'code' => $_POST['rcode'] ),
				array( '%b' ),
				array( '%s' )
			);
			
			echo "註冊成功！ 你的資料已經出現在學生頁面上<br />
			請前往 <a href='http://140.119.162.60/master/wp-admin/profile.php'>個人資料編輯頁面</a> 進一步更新您的資料（不然大家都會看到你不完整的資料喔！）";
			
		}
		else
		{
			echo "註冊失敗 Something went wrong :/";
		}
	
	} // register account
?>
<?php function form_part_html(){ ?>
<style>
div.wp-core-ui label {
	color: #FFF;
}

div.wp-core-ui .description {
	color: #DDD;
	font-size: 80%;
}
</style>
<div class="wp-core-ui">
	<h2 style="padding: 0px; margin: 30px 0px;">新帳號註冊</h2>
    <?= has_action( 'wp_ajax_nopriv_custom_ajax_test' ) ?>
    <form action="" method="post" id="register_form">
    <table class="form-table">
    	<tr>
            <th><label for="user_name">帳號名稱</label></th>
            <td>
    			<input type="text" name="user_name" id="username"  />
                <span id="username_valid_display"></span><br />
                <span class="description">登入用的帳號名稱，之後無法修改</span>
            </td>
		</tr>
        <tr>
            <th><label for="user_name">密碼</label></th>
            <td>
    			<input type="password" name="pass1" id="pass1"  /><br />
                <span class="description">不限制密碼，但為了安全起見，建議長度在十碼以上，並混用大小寫、數字、特殊符號如 ! @ # $ %</span>
            </td>
		</tr>
        <tr>
            <th><label for="user_name">密碼確認</label></th>
            <td>
    			<input type="password" name="pass2" id="pass2"  /><br />
                <div id="pass-strength-result" style="color: #555; display: block; visibility: hidden">強度偵測器</div>
            </td>
		</tr>
    	<tr>
            <th><label for="user_name">學號</label></th>
            <td>
    			<input type="text" name="student_id" value="<?=$_GET['student_id']?>" disabled />
                <br />
                <span class="description">如果學號有錯，請聯絡助教，我們會重新寄一封註冊信給您</span>
            </td>
		</tr>
        <tr>
            <th><label for="email">Email</label></th>
            <td>
    			<input id="email" type="text" name="email" /><br />
                <span class="description">請輸您最常使用的校外信箱，避免您漏掉重要資訊</span>
            </td>
		</tr>
    	
        
    </table>
        <input name="rcode" type="hidden" value="<?=$_GET['code']?>" />
        <input type="hidden" name="student_id" value="<?=$_GET['student_id']?>" />
    <p class="submit">
    	<input type="submit" disabled name="submit" id="submit" class="button button-primary" value="確認註冊"  />
    </p>
    </form>
</div>


<script type="text/javascript">

var username_valid = false;
	
jQuery( document ).ready( function( $ ) {
	
	// form checking 
	function check_all_element()
	{
		if( $('input#username').val().trim() !== '' )
		if( $('input#pass1').val() === $('input#pass2').val() )
		if( $('input#pass2').val().trim() !== '' )
		if( $('input#email').val().trim() !== '' )
		if( $('input#email').val().match(/[^@\s]+@[^@\s\.]+\.[^@\s]+/) == $('input#email').val() )
		if( username_valid ) // check in other function
		{
			$('#submit').removeAttr( 'disabled' );
			return;
		}
		
		$('#submit').attr('disabled', 'disabled');
	}
	
	$('#register_form').keyup(function(e) {
		check_all_element();
	});	
	
	// check is username avilable
	$('#username').change(function(e) {
		var ajaxurl = '<?=admin_url( 'admin-ajax.php' )?>';
			
		var data = {
			'action' : 'check_username',
			'entered_username' : $(this).val()
		};
			
		$.post( ajaxurl, data, function( response ){
			// when ajax return a value
			
			if( response == 'OK' )
			{
				$('#username_valid_display').css('color', '#0C9');
				$('#username_valid_display').text('可以使用！');
				username_valid = true;
			}
			else
			{
				$('#username_valid_display').css('color', '#F36');
				$('#username_valid_display').text('已被註冊，請換一個帳號');
				username_valid = false;
			}
			
			check_all_element();
		});
			
    });
	
    // Binding to trigger checkPasswordStrength
    $( 'body' ).on( 'keyup', 'input[id=pass1], input[id=pass2]',
        function( event ) {
			$('#pass-strength-result').css('visibility', 'visible');
            checkPasswordStrength(
                $('input[id=pass1]'),         // First password field
                $('input[id=pass2]'), // Second password field
                $('#pass-strength-result'),           // Strength meter
                $('input[type=submit]'),           // Submit button
                [$('input#username').val()]        // Blacklisted words
            );
        }
    );
});

function checkPasswordStrength( $pass1,
                                $pass2,
                                $strengthResult,
                                $submitButton,
                                blacklistArray ) {
        var pass1 = $pass1.val();
    var pass2 = $pass2.val();
 
    // Reset the form & meter
	$submitButton.attr( 'disabled', 'disabled' );
    $strengthResult.removeClass( 'short bad good strong' );
 
    // Extend our blacklist array with those from the inputs & site data
    blacklistArray = blacklistArray.concat( wp.passwordStrength.userInputBlacklist() )
 
    // Get the password strength
    var strength = wp.passwordStrength.meter( pass1, blacklistArray, pass2 );
 
    // Add the strength meter results
    switch ( strength ) {
 
        case 2:
            $strengthResult.addClass( 'bad' ).html( pwsL10n.bad );
            break;
 
        case 3:
            $strengthResult.addClass( 'good' ).html( pwsL10n.good );
            break;
 
        case 4:
            $strengthResult.addClass( 'strong' ).html( pwsL10n.strong );
            break;
 
        case 5:
            $strengthResult.addClass( 'short' ).html( pwsL10n.mismatch );
            break;
 
        default:
            $strengthResult.addClass( 'short' ).html( pwsL10n.short );
 
    }
	
    return strength;
}
</script>
<?php } // form part html ?>
<?php get_footer( 'simple' ) ?>