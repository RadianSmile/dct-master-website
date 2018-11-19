<?php

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-admin/admin.php' );

require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );

if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'Sorry, you are not allowed to manage options for this site.' ) );

?>



<div class="wrap">

	<table class="form-table" >
		<tr>
			<th scope="row">請選擇學生入學學期</th>
			<td>
				<select class="" id="semester-selector" name="">
					<?php for ($i = idate("Y") - (idate("n") > 7 ?  1911 : 1912 ) ; $i >= 97 ; $i-- ){?>
						<option value="<?php echo $i ;?>"><?php echo $i ;?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th scope="row">顯示原始連結</th>
			<td>
				<input id="show-btn" type="checkbox" name="" value="">
			</td>
		</tr>

		<tr>
			<th scope="row">註冊連結表</th>
			<td>


			<style >
				.hidden {
					display : none ;
				}
				.t, .t td, .t th {
					border : rgb(204, 204, 204) solid 1px ;
					width :auto !important;
				}
				table.t tr:nth-child(1) {
					background-color: rgb(213, 213, 213) ;
				}
				table.t td , table.t th {
					padding : 8px 10px 8px 10px;

				}

				[data-class='clickboard']:before{
					content : "以複製"
				}
				[data-class='clickboard'].yet:before{
					content : "點我複製"
				}
			</style>

			<?php for ($i = idate("Y") - (idate("n") > 7 ?  1911 : 1912 ) ; $i >= 97 ; $i-- ){?>
				<table  id="t<?php echo $i ; ?>" class="t hidden " cellspacing="0" cellpadding="0">
					<tr>
						<th>學號</th>
						<th>複製連結</th>
						<th class="link hidden">原始連結</th>
					</tr>
					<?php for ($j = 1 ; $j <= 20 ; $j++ ){
						$id = $i .'462'.str_pad($j , 3 , '0' , STR_PAD_LEFT ) ;
						$url = generate_register_link( $id ) ;
					?>
						<tr>
							<td><?php echo $id ; ?></td>
							<td>
								<?php submit_button("點我複製","small",$id, false ,array("data-id"=> $id , "data-clipboard-text" => $url , 'data-class'=>'clickboard' )); ?>
							</td>
							<td class="link hidden">
								<?php echo $url ; ?>
							</td>

						</tr>
					<?php } ?>
				</table>

			<?php } ?>






			</td>
		</tr>
	</table>




<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.6.0/clipboard.min.js"></script>
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous">
</script>

<script type="text/javascript">

	new Clipboard('.button');


	$(function($){
		$(document).on("change","#semester-selector",function(){
			$(".t").toggleClass("hidden",true)
			console.log($(this).val())
			$("#t" + $(this).val()).toggleClass("hidden",false)
		})
		$(document).on("click",".button",function(){
			$("[data-class='clickboard']").attr("value","點我複製")
			$(this).attr("value","已複製！")
		})
		$(document).on("change","#show-btn",function(){
			var b = !$(this).is(":checked")
			$(".link").toggleClass("hidden",b)
		})


		console.log("<?php echo idate("Y") - (idate("n") > 7 ?  1911 : 1912 ); ?>")
		$("#semester-selector").val("<?php echo idate("Y") - (idate("n") > 7 ?  1911 : 1912 ); ?>")
		$("#semester-selector").trigger("change")
	})

</script>
