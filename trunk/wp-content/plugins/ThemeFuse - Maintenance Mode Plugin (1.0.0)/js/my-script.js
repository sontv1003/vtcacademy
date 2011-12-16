jQuery(document).ready(function() {
	
	uploadFile('#upload_image_button', '#tf_maintenance_logo', 'tf_maintenance_logo');
	uploadFile('#upload_image_button1', '#tf_maintenance_bg', 'tf_maintenance_bg');
	
});

function uploadFile($upload_button, $input_field, $input_field_t) {
	
	jQuery($upload_button).click(function() {
	 formfield = jQuery($input_field).attr($input_field_t);
	 var checkinput = 1;
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 return false;
	});
	
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery($input_field).val(imgurl);
		tb_remove();
	}
}