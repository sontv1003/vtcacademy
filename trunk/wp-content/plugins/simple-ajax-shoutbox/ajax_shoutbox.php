<?php
/*
Plugin Name: Simple Ajax Shoutbox
Plugin URI: http://socialenemy.com/2009/06/simple-wordpress-ajax-shoutbox/
Description: This plugin will enable shoutbox into your sidebar widget. Using AJAX technology so visitor does'nt have to refresh each time they post messages into this shoutbox. It also has simple design, so it will definetely fit in your site, does'nt matter what your template is. See also: <a href="http://socialenemy.com/2009/06/simple-wordpress-ajax-shoutbox/">Information</a>.
Version: 1.2.3
Author: Indra Prasetya
Author URI: http://socialenemy.com/

Copyright 2009, Indra Prasetya

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

add_action('widgets_init', array('ajax_shoutbox', 'register'));
register_activation_hook( __FILE__, array('ajax_shoutbox', 'activate'));
register_deactivation_hook( __FILE__, array('ajax_shoutbox', 'deactivate'));
add_action('wp_head', array('ajax_shoutbox', 'style'));
add_action('plugins_loaded', array('ajax_shoutbox', 'load_library'));

if(!class_exists('ajax_shoutbox')){
	class ajax_shoutbox {
		function widget($args){
			extract($args);
			$options = get_option('widget_shoutbox');		
			$siteurl = get_option ('siteurl');
			$plugin_path = $siteurl . '/wp-content/plugins/simple-ajax-shoutbox/';
			
			echo $before_widget;
			echo $before_title . $options['title'] . $after_title;
			
			echo "<!-- Simple Ajax Shoutbox v1.2.3 by Indra http://socialenemy.com //-->\n";
			echo "<div id='sb_messages'>";
			echo "<noscript><div class='error_message' align='center'>" . __('Please enable javascript.') . "</div></noscript>";
			echo "<br/><center><img src='$siteurl/wp-content/plugins/simple-ajax-shoutbox/inc/loading.gif' alt='Loading' title='Loading'/></center>";			
			echo "<br/><center><a href='http://socialenemy.com/' target='_blank'><span style='text-decoration:none;'>WP Shoutbox</span></a></center>";			
			echo "</div>\n";
			
			echo "<div id='input_area'>\n";
				echo "<table width='100%' border='0' cellspacing='1' cellpadding='0'>\n";
				if($options['registered_user'] == 'true' && !is_user_logged_in()){
					echo "<tr><td colspan='2' align='center'><div class='info'>" . __('Only registered user allowed') . "</div></td></tr>\n";
					echo "</table>\n";
				} else {
					if (is_user_logged_in()) {
						global $current_user;	get_currentuserinfo();
						echo "<input type='hidden' id='sb_name' value='" . $current_user->display_name . "'>\n";
						echo "<input type='hidden' id='sb_website' value='" . $current_user->user_url . "'>\n";
					} else {
						if($options['registered_user'] == 'true'){
							echo "<tr><td colspan='2'><div class='info'>" . __('Only registered user allowed.') . "</div></td></tr>\n";
						} else {
							echo "<tr><td colspan='2'><div class='info'>" . __('Name') . "</div><input id='sb_name' type='text' class='sb_input' maxlength='100'></td></tr>\n";
							echo "<tr><td colspan='2'><div class='info'>" . __('Website') . "</div><input id='sb_website' type='text' class='sb_input' maxlength='255'></td></tr>\n";
						}
					}
					echo "<tr><td colspan='2'>";
					echo "<div class='info'>" . __('Message') . "</div><input id='sb_message' type='text' class='sb_input' maxlength='255'></td></tr>\n";
					echo "<tr><td><input type='submit' value='" . __('Add') . "' id='sb_addmessage'> <span id='sb_status'></span></td>\n";
					echo "<td style='text-align:right;'>";
					if (get_option('use_smilies')) 
					  echo "<img src='$siteurl/wp-includes/images/smilies/icon_smile.gif' border='0' alt='Smile' title='"  .__('Smilies') . "' id='sb_showsmiles'>";
					echo "</td></tr>\n";
					echo "</table>\n";
				}
				
				echo "<div id='sb_smiles' align='center'>\n";
		
				if (get_option('use_smilies')) {
					$wpsmiliestrans = array (':mrgreen:' => 'icon_mrgreen.gif', ':neutral:' => 'icon_neutral.gif', ':twisted:' => 'icon_twisted.gif', ':arrow:' => 'icon_arrow.gif', ':shock:' => 'icon_eek.gif', ':smile:' => 'icon_smile.gif', ':???:' => 'icon_confused.gif', ':cool:' => 'icon_cool.gif', ':evil:' => 'icon_evil.gif', ':grin:' => 'icon_biggrin.gif', ':idea:' => 'icon_idea.gif', ':oops:' => 'icon_redface.gif', ':razz:' => 'icon_razz.gif', ':roll:' => 'icon_rolleyes.gif', ':wink:' => 'icon_wink.gif', ':cry:' => 'icon_cry.gif', ':eek:' => 'icon_surprised.gif', ':lol:' => 'icon_lol.gif', ':mad:' => 'icon_mad.gif', ':sad:' => 'icon_sad.gif', '8-)' => 'icon_cool.gif', '8-O' => 'icon_eek.gif', ':-(' => 'icon_sad.gif', ':-)' => 'icon_smile.gif', ':-?' => 'icon_confused.gif', ':-D' => 'icon_biggrin.gif', ':-P' => 'icon_razz.gif', ':-o' => 'icon_surprised.gif', ':-x' => 'icon_mad.gif', ':-|' => 'icon_neutral.gif', ';-)' => 'icon_wink.gif', '8)' => 'icon_cool.gif', '8O' => 'icon_eek.gif', ':(' => 'icon_sad.gif', ':)' => 'icon_smile.gif', ':?' => 'icon_confused.gif', ':D' => 'icon_biggrin.gif', ':P' => 'icon_razz.gif', ':o' => 'icon_surprised.gif', ':x' => 'icon_mad.gif', ':|' => 'icon_neutral.gif', ';)' => 'icon_wink.gif', ':!:' => 'icon_exclaim.gif', ':?:' => 'icon_question.gif' );
					foreach ((array)$wpsmiliestrans as $smiley => $img ) {
						$smiley_masked = attribute_escape(trim($smiley));
						echo "<img src='$siteurl/wp-includes/images/smilies/$img' alt='$smiley_masked' class='wp-smiley' style='padding:1px;cursor:pointer;' onclick=\"add_item(' $smiley_masked')\"/>";
					}
				}
				
				if($options['shoutbox_bl'] == 'true'){
					echo "<br/><center><a href='http://socialenemy.com/2009/06/simple-wordpress-ajax-shoutbox/' target='_blank'>WP Shoutbox</a></center>";
				}
				echo "</div>\n";
			echo "</div>\n";
			echo "<!-- Simple Ajax Shoutbox v1.2.3 by Indra http://socialenemy.com //-->\n";
			
			echo $after_widget;
?>
			<script type="text/javascript">
				var plugin_path = "<?php echo $plugin_path; ?>";
				var reload_time = <?php echo $options['shoutbox_reload'];?>;
				jQuery(function($){sb_reload();$("div#sb_messages").mouseover(function(){$("div#input_area").show("slow");$("span#sb_status").html("")});$("input#sb_addmessage").click(function(){var b=$("input#sb_name").val();var c=$("input#sb_website").val();var d=$("input#sb_message").val();$("span#sb_status").html("Crunching...").show();$("input#sb_addmessage").attr("disabled","disabled");var e="&";$.ajax({type:"POST",url:plugin_path+"ajax_shoutbox_process.php",cache:false,data:"op=add"+e+"user="+b+e+"message="+d+e+"website="+c,success:function(a){$("div#sb_messages").prepend(a);$("div#sb_new_message").show("slow");$("input#sb_message").val("");$("input#sb_addmessage").removeAttr("disabled");$("span#sb_status").html("Thanks!").fadeOut("slow");$("div#input_area").hide("slow")},error:function(a){$("span#sb_status").html("Request error")}})});$("img#sb_showsmiles").click(function(){$("div#sb_smiles").fadeIn("slow")})});function add_item(a){var b=jQuery("input#sb_message").val()+a;jQuery("input#sb_message").val(b)}function sb_reload(){jQuery("div#sb_messages").load(plugin_path+"ajax_shoutbox_process.php?"+new Date().getTime());jQuery("span#sb_status").ajaxSend(function(a,b,c){jQuery(this).html("Reloading..").show()});jQuery("div#sb_messages").ajaxError(function(a,b,c){jQuery(this).html("<div class='error_message' align='center'>Request error</div>");jQuery("span#sb_status").fadeOut("slow")});jQuery("span#sb_status").ajaxSuccess(function(a,b,c){jQuery(this).fadeOut("slow")});setTimeout("sb_reload()",reload_time*1000)}function delete_message(c){if(!confirm("Delete this message?"))return false;var d="&";jQuery.ajax({type:"POST",url:plugin_path+"ajax_shoutbox_process.php",cache:false,data:"op=delete"+d+"m_id="+c,success:function(a,b){if(parseInt(a)>0)jQuery('div#sb_message_'+a).hide('slow');jQuery('input#sb_message').val('');jQuery('div#input_area').hide('slow')}})}
			</script>
<?php
		}
		
		function control() {
			$options = $newoptions = get_option('widget_shoutbox');
			if($_POST["shoutbox_submit"]) {
				$newoptions['title'] = strip_tags(stripslashes($_POST["shoutbox_title"]));
				if(empty($newoptions['title'])) $newoptions['title'] = 'Shoutbox';
				$newoptions['max_messages'] = strip_tags(stripslashes($_POST["max_messages"]));
				if(empty($newoptions['max_messages'])) $newoptions['max_messages'] = '20';
				$newoptions['flood_time'] = strip_tags(stripslashes($_POST["flood_time"]));
				if(empty($newoptions['flood_time'])) $newoptions['flood_time'] = '30';
				$newoptions['shoutbox_reload'] = strip_tags(stripslashes($_POST["shoutbox_reload"]));
				if(empty($newoptions['shoutbox_reload'])) $newoptions['shoutbox_reload'] = '30';
				$newoptions['shoutbox_bl'] = ($_POST["shoutbox_bl"] == 'true')? 'true' : 'false';
				$newoptions['allow_html'] = ($_POST["allow_html"] == 'true')? 'true' : 'false';
				$newoptions['check_spam'] = ($_POST["check_spam"] == 'true')? 'true' : 'false';
				$newoptions['registered_user'] = ($_POST["registered_user"] == 'true')? 'true' : 'false';
			}
			if ($options != $newoptions) {
				$options = $newoptions;
				update_option('widget_shoutbox', $options);
			}
			
			$title = htmlspecialchars($options['title'], ENT_QUOTES);
			$max_messages = $options['max_messages'];
			$flood_time = $options['flood_time'];
			$shoutbox_reload = $options['shoutbox_reload'];
			$shoutbox_bl = ($options['shoutbox_bl'] == 'true')? 'checked="checked"' : '';
			$allow_html = ($options['allow_html'] == 'true')? 'checked="checked"' : '';
			$check_spam = ($options['check_spam'] == 'true')? 'checked="checked"' : '';
			$registered_user = ($options['registered_user'] == 'true')? 'checked="checked"' : '';
?>
			<p><label for="shoutbox_title"><?php _e('Title:'); ?><br/><input	style="width: 250px;" id="shoutbox_title" name="shoutbox_title"	type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="shoutbox_max_messages"><?php _e('Max messages in shoutbox:'); ?><br/><input style="width: 50px;" id="max_messages" name="max_messages" type="text" value="<?php echo $max_messages; ?>" /></label></p>
			<p><label for="shoutbox_flood"><?php _e('Flood time in seconds:'); ?><br/><input style="width: 50px;" id="shoutbox_flood" name="shoutbox_flood" type="text" value="<?php echo $flood_time; ?>" /></label></p>
			<p><label for="shoutbox_reload"><?php _e('Reload time in seconds:'); ?><br/><input style="width: 50px;" id="shoutbox_reload" name="shoutbox_reload" type="text" value="<?php echo $shoutbox_reload; ?>" /></label></p>
			<p><label for="shoutbox_registered"><?php _e('Only Registered User:'); ?><br/><input type="checkbox" id="registered_user" name="registered_user" type="text" value="true" <?php echo $registered_user;?> /> Only registered user allowed.</label></p>
			<p><label for="shoutbox_html"><?php _e('Allow HTML:'); ?><br/><input type="checkbox" id="allow_html" name="allow_html" type="text" value="true" <?php echo $allow_html;?> /> Disabling this will strip URL and malicious script.</label></p>
			<p><label for="shoutbox_spam"><?php _e('Check Spam:'); ?><br/><input type="checkbox" id="check_spam" name="check_spam" type="text" value="true" <?php echo $check_spam;?> /> Check using Akismet, may degrades process time.</label></p>
			<p><label for="shoutbox_bl"><?php _e('Add backlink:'); ?><br/><input type="checkbox" id="shoutbox_bl" name="shoutbox_bl" type="text" value="true" <?php echo $shoutbox_bl;?> /> You can disable this, but if you enable it, Thanks!</label></p>
			<input type="hidden" id="shoutbox_submit" name="shoutbox_submit" value="1" />
<?php
		}
			
		function style() {
?>
			<style type="text/css">
				.error_message{margin-bottom:4px; padding:3px; border:1px solid #B36462; color:#B36462; background-color:#EEDBDB;}				
				.sb_input{width:100%; margin:2px 0;}
				#sb_smiles{margin-top:4px; display:none;}
				#sb_messages{padding:2px; overflow:auto; height:250px;text-align:left;}
				#sb_showsmiles{cursor:pointer;}
				#input_area{display:none;text-align:left;}
			</style>
<?php
		}
		
		function activate(){
			global $wpdb;
			$table_name = $wpdb->prefix . "messagebox";
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
				$table_name = $wpdb->prefix . "messagebox";
				$sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
				  id int(10) NOT NULL auto_increment,
				  user_login varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL default '',
				  website varchar(255) COLLATE latin1_general_ci NOT NULL default '',
				  post_date datetime NOT NULL default '0000-00-00 00:00:00',
				  message text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
				  status tinyint(1) NOT NULL default '0',
				  ip varchar(15) COLLATE latin1_general_ci NOT NULL default '',
				  PRIMARY KEY  (`id`)
				);";
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql);
			}
			//initial values
			$data = array( 'title' => 'Shoutbox', 'max_messages' => '20', 'flood_time' => '30', 'shoutbox_reload' => '30', 'shoutbox_bl' => 'true', 'allow_html' => 'false', 'check_spam' => 'true', 'registered_user' => 'false');
	    if (!get_option('widget_shoutbox')){
	      add_option('widget_shoutbox', $data);
	    } else {
	      update_option('widget_shoutbox', $data);
	    }		
		}
		
		function deactivate(){
			global $wpdb;
			$table_name = $wpdb->prefix . "messagebox";
			$wpdb->query("DROP TABLE " . $table_name);
			delete_option('widget_shoutbox');
		}
		
		function load_library() {
			wp_enqueue_script('jquery');
		}
		
		function register(){
			register_sidebar_widget('Shoutbox', array('ajax_shoutbox', 'widget'));
			register_widget_control('Shoutbox', array('ajax_shoutbox', 'control'));
		}
	}
}
?>