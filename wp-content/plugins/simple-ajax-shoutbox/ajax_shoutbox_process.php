<?php
$httphost = @$_SERVER ['HTTP_HOST'];
$httpreferer = @$_SERVER ['HTTP_REFERER'];
$nonce = $_POST ['nonce'];
require_once '../../../wp-config.php';
require (ABSPATH . WPINC . '/registration.php');

function spam_check($request, $host, $path, $port = 80) {	
	$http_request = "POST $path HTTP/1.0\r\n";
	$http_request .= "Host: $host\r\n";
	$http_request .= "Content-Type: application/x-www-form-urlencoded; charset=" . get_settings ( 'blog_charset' ) . "\r\n";
	$http_request .= "Content-Length: " . strlen ( $request ) . "\r\n";
	$http_request .= "User-Agent: WordPress/$wp_version | Akismet/1.11\r\n";
	$http_request .= "\r\n";
	$http_request .= $request;
	
	$response = '';
	if (false !== ($fs = @fsockopen ( $host, $port, $errno, $errstr, 3 ))) {
		@fwrite ( $fs, $http_request );
		while ( ! feof ( $fs ) )
			$response .= @fgets ( $fs, 1160 );
		fclose ( $fs );
		$response = explode ( "\r\n\r\n", $response, 2 );
	}
	return $response;
}

if (! eregi ( $httphost, $httpreferer ) or empty ( $httpreferer )) {
	echo "<div class='error_message' align='center'>" . __ ( 'Unknown referrer.' ) . "</div>";
	exit ();
} else {
	@header ( 'Content-Type: text/html; charset=' . get_option ( 'blog_charset' ) );
	global $wpdb;
	$options = get_option ( 'widget_shoutbox' );
	$siteurl = get_option ( 'siteurl' );
	$table_name = $wpdb->prefix . "messagebox";
	switch ($_POST ['op']) {
		case "add" :
			if (is_user_logged_in ()) {
				global $current_user;
				get_currentuserinfo ();
				$user = $current_user->display_name;
				$website = $current_user->user_url;
				$proceed = true;
			} else if($options['registered_user'] == 'true'){
				echo "<div class='error_message' align='center'>" . __ ( 'Only registered user allowed.' ) . "</div>";
				$proceed = false;
			} else if ( isset ( $_POST ['user'] ) ) {
				if (username_exists ( trim ( $_POST ['user'] ) )) {
					echo "<div class='error_message' align='center'>" . __ ( 'Name already exists, please choose another.' ) . "</div>";
					$proceed = false;
				} elseif (strlen ( $_POST ['user'] ) == 0) {
					echo "<div class='error_message' align='center'><b>" . __ ( 'Name empty.' ) . "</b></div>";
					$proceed = false;
				} else {
					$user = $wpdb->escape ( trim ( strip_tags ( $_POST ['user'] ) ) );
					$website = $wpdb->escape ( attribute_escape ( clean_url ( $_POST ['website'] ) ) );
					$proceed = true;
				}
			} else {
				if (! @validate ( $_POST ['user'] )) {
					echo "<div class='error_message' align='center'>" . __ ( 'Name empty.' ) . "</div>";
					$proceed = false;
				} else {
					$proceed = true;		
				}
			}
			
			$message = $wpdb->escape ( $_POST ['message'] );	
			
			if (strlen ( $message ) == 0) {
				echo "<div class='error_message' align='center'><b>" . __ ( 'Message empty.' ) . "</b></div>";
				$proceed = false;
			}
			
			$key = get_option ( 'wordpress_api_key' );
			if ($options ['check_spam'] == 'true' && ! empty ( $key )) {
				$akismet_api_host = $key . '.rest.akismet.com';
				
				$comment ['user_ip'] = preg_replace ( '/[^0-9., ]/', '', $_SERVER ['REMOTE_ADDR'] );
				$comment ['user_agent'] = $_SERVER ['HTTP_USER_AGENT'];
				$comment ['referrer'] = $httpreferer;
				$comment ['blog'] = get_option ( 'home' );
				$comment ['comment_author'] = $user;
				$comment ['comment_author_url'] = 'http://' . preg_replace ( '/^http[s]?:\/\//i', '', $website );
				$comment ['comment_content'] = $message;
				
				$ignore = array ('HTTP_COOKIE' );
				
				foreach ( $_SERVER as $key => $value )
					if (! in_array ( $key, $ignore ))
						$comment ["$key"] = $value;
				
				$query_string = '';
				foreach ( $comment as $key => $data )
					$query_string .= $key . '=' . urlencode ( stripslashes ( $data ) ) . '&';
				$response = spam_check ( $query_string, $akismet_api_host, '/1.1/comment-check', 80 );
				
				if ('true' == $response [1]) {
					echo "<div class='error_message' align='center'><b>" . __ ( 'Blocked by Akismet.' ) . "</b></div>";
					$proceed = false;
				}
			}
						
			if ($proceed) {
				$tzNOW = current_time ( 'mysql' );
				
				if ($wpdb->get_var ( "SELECT count(*) FROM " . $table_name . " WHERE ip='" . @$_SERVER ['REMOTE_ADDR'] . "' AND (post_date + INTERVAL " . $options ['flood_time'] . " SECOND) > '$tzNOW'" ) > 1) {
					echo "<div class='error_message' align='center'>" . __ ( 'Please try again after a few seconds.' ) . "</div>";
				} else {
					if($wpdb->query ( "INSERT INTO " . $table_name . " (id,user_login,website,post_date,message,status,ip) VALUES (null,'$user','$website','$tzNOW','$message','1','" . @$_SERVER ['REMOTE_ADDR'] . "')" )){
						$row = $wpdb->get_row ( "SELECT *,DATE_FORMAT(post_date,'%H:%i') as post_date FROM " . $table_name . " ORDER BY id DESC LIMIT 1" );
						$m_id = intval ( $row->id );
						$m_user = ($options ['allow_html'] == 'true') ? $row->user_login : htmlspecialchars ( strip_tags ( $row->user_login ) );
						$m_date = $row->post_date;
						$m_text = stripslashes (convert_smilies ( (($options ['allow_html'] == 'true') ? $row->message : htmlspecialchars ( strip_tags ( $row->message ) ) ) ) );
						$m_ip = $row->ip;
						$m_website = preg_replace ( '/^http[s]?:\/\//i', '', $row->website );
						
						$m_user = (! empty ( $m_website )) ? "<a href='http://$m_website' title='$m_user' rel='external nofollow'>$m_user</a>" : $m_user;
						$can_moderate = (function_exists ( 'current_user_can' ) && current_user_can ( 'moderate_comments' )) ? true : false;
						
						echo "<div style='margin-bottom:4px;display:none;' id='sb_new_message'>\n";
						echo "<div><b>$m_user</b> <img src='$siteurl/wp-content/plugins/simple-ajax-shoutbox/inc/comment.png' border='0' style='padding:0px;' alt='Comment' ";
						if ($can_moderate) {
							echo "title='" . __ ( 'IP address' ) . ': ' . $m_ip . "'";
						}
						echo "/> <span class='info'>$m_date</span> ";
						if ($can_moderate) {
							echo " <a href='#delete' onclick=\"delete_message('$m_id')\" rel='$m_id'>[delete]</a>";
						}
						echo "</div>";
						echo "<div class='small'>$m_text</div>\n";
						echo "</div>\n";
					} else {
						echo "<div class='error_message' align='center'><b>" . __ ( 'Database insert failure. Try reinstall plugin.' ) . "</b></div>";
					}
				}
			}
			
			break;
		case 'delete' :
			if (is_user_logged_in ()) {
				if (function_exists ( 'current_user_can' ) && current_user_can ( 'moderate_comments' )) {
					$m_id = intval ( $_POST ['m_id'] );
					$wpdb->query ( "DELETE FROM " . $table_name . " WHERE id = '$m_id'" );
					echo $m_id;
					break;
				} 			
//				else {
//					$deleted = false;
//				}
//			} else {
//				$deleted = false;
//			}
//			
//			if ($deleted == true) {
//				echo $m_id;
//			} else {
//				echo '0';
			}
			echo '0';
			break;
		default :
			if ($result = $wpdb->get_results ( "SELECT *,DATE_FORMAT(post_date,'%H:%i') as post_date FROM " . $table_name . " ORDER BY id DESC LIMIT " . $options ['max_messages'] )) {
				$can_moderate = (function_exists ( 'current_user_can' ) && current_user_can ( 'moderate_comments' )) ? true : false;
				foreach ( $result as $row ) {
					$m_id = intval ( $row->id );
					$m_user = ($options ['allow_html'] == 'true') ? $row->user_login : htmlspecialchars ( strip_tags ( $row->user_login ) );
					$m_date = $row->post_date;
					$m_text = stripslashes (convert_smilies ( (($options ['allow_html'] == 'true') ? $row->message : htmlspecialchars ( strip_tags ( $row->message ) ) ) ) );
					$m_ip = $row->ip;
					$m_website = preg_replace ( '/^http[s]?:\/\//i', '', $row->website );
					
					$m_user = (! empty ( $m_website )) ? "<a href='http://$m_website' title='$m_user' rel='external nofollow'>$m_user</a>" : $m_user;					
					
					echo "<div style='margin-bottom:4px;' id='sb_message_$m_id'>\n";
					echo "<div><b>$m_user</b> <img src='$siteurl/wp-content/plugins/simple-ajax-shoutbox/inc/comment.png' border='0' style='padding:0px;' alt='Comment' ";
					if ($can_moderate) {
						echo "title='" . __ ( 'IP address' ) . ': ' . $m_ip . "'";
					}
					echo "/> <span class='info'>$m_date</span> ";
					if ($can_moderate) {
						echo " <a href='#delete' onclick=\"delete_message('$m_id')\" rel='$m_id'>[delete]</a>";
					}
					echo "</div>";
					echo "<div class='small'>$m_text</div>\n";
					echo "</div>\n";
				}
			} else {
				echo "<div align='center'><b>" . __ ( 'No message.' ) . "</b></div>";
			}
			break;
	}
}
die ();
?>