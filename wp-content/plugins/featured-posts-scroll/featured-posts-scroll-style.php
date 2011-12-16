<?php 
	header('content-type: text/css'); 
	define('WP_USE_THEMES', false);
    require_once((dirname(dirname( dirname( dirname ( __FILE__ ) ) ))).'/wp-config.php');
?>

<?php 
	// Retrieve all admin options
	$max_posts = get_option('fps_max_posts');
        
    $post_title_color = get_option('fps_title_color');
    $post_excerpt_color = get_option('fps_excerpt_color');
    $post_heading_color = get_option('fps_heading_color');

    $post_title_font = get_option('fps_title_font');
    $post_excerpt_font = get_option('fps_excerpt_font');
    $post_heading_font = get_option('fps_heading_font');
    $post_selectedslide_font = get_option('fps_selectedslide_font');
    $post_unselectedslide_font = get_option('fps_unselectedslide_font');

    $post_title_fontstyle = get_option('fps_title_fontstyle');
    $post_excerpt_fontstyle = get_option('fps_excerpt_fontstyle');
    $post_heading_fontstyle = get_option('fps_heading_fontstyle');
    $post_selectedslide_fontstyle = get_option('fps_selectedslide_fontstyle');
    $post_unselectedslide_fontstyle = get_option('fps_unselectedslide_fontstyle');

    $post_title_fontvariant = get_option('fps_title_fontvariant');
    $post_excerpt_fontvariant = get_option('fps_excerpt_fontvariant');
    $post_heading_fontvariant = get_option('fps_heading_fontvariant');
    $post_selectedslide_fontvariant = get_option('fps_selectedslide_fontvariant');
    $post_unselectedslide_fontvariant = get_option('fps_unselectedslide_fontvariant');

    $post_title_fontweight = get_option('fps_title_fontweight');
    $post_excerpt_fontweight = get_option('fps_excerpt_fontweight');
    $post_heading_fontweight = get_option('fps_heading_fontweight');
    $post_selectedslide_fontweight = get_option('fps_selectedslide_fontweight');
    $post_unselectedslide_fontweight = get_option('fps_unselectedslide_fontweight');

    $post_title_fontsize = get_option('fps_title_fontsize');
    $post_excerpt_fontsize = get_option('fps_excerpt_fontsize');
    $post_heading_fontsize = get_option('fps_heading_fontsize');
    $post_selectedslide_fontsize = get_option('fps_selectedslide_fontsize');
    $post_unselectedslide_fontsize = get_option('fps_unselectedslide_fontsize');

    $post_title_fontheight = get_option('fps_title_fontheight');
    $post_excerpt_fontheight = get_option('fps_excerpt_fontheight');
    $post_heading_fontheight = get_option('fps_heading_fontheight');
    $post_selectedslide_fontheight = get_option('fps_selectedslide_fontheight');
    $post_unselectedslide_fontheight = get_option('fps_unselectedslide_fontheight');
    
    $post_bg_color = get_option('fps_bg_color');
    $post_textbg_color = get_option('fps_textbg_color');
    $post_textbg_alpha = get_option('fps_textbg_alpha');
    
    $post_innershadow_color = get_option('fps_innershadow_color');
    $post_outershadow_color = get_option('fps_outershadow_color');

    $post_arrow_color = get_option('fps_arrow_color');

    $post_corner_radius = get_option('fps_corner_radius');
    $post_dropshadow_x = get_option('fps_dropshadow_x');
    $post_dropshadow_y = get_option('fps_dropshadow_y');
    $post_dropshadow_blur = get_option('fps_dropshadow_blur');
    $post_dropshadow_spread = get_option('fps_dropshadow_spread');

    $post_outer_corner_radius = get_option('fps_outer_corner_radius');
    $post_outer_dropshadow_x = get_option('fps_outer_dropshadow_x');
    $post_outer_dropshadow_y = get_option('fps_outer_dropshadow_y');
    $post_outer_dropshadow_blur = get_option('fps_outer_dropshadow_blur');
    $post_outer_dropshadow_spread = get_option('fps_outer_dropshadow_spread');

    $post_autoscroll = get_option('fps_autoscroll');

    $post_height = get_option('fps_height');
    $post_width = get_option('fps_width');

    $post_display_slidenumbers = get_option('fps_display_slidenumbers');

    $post_arrow_position = get_option('fps_arrow_position');
    $post_arrow_custom_url = get_option('fps_arrow_custom_url');

    $post_selectedslide_textcolor = get_option('fps_selectedslide_textcolor');
    $post_unselectedslide_textcolor = get_option('fps_unselectedslide_textcolor');

    $post_selectedslide_bgcolor = get_option('fps_selectedslide_bgcolor');
    $post_unselectedslide_bgcolor = get_option('fps_unselectedslide_bgcolor');

    $post_slide_bgradius = get_option('fps_slide_bgradius');

    $post_selectedslide_dropshadow_x = get_option('fps_selectedslide_dropshadow_x');
    $post_selectedslide_dropshadow_y = get_option('fps_selectedslide_dropshadow_y');
    $post_selectedslide_dropshadow_blur = get_option('fps_selectedslide_dropshadow_blur');
    $post_selectedslide_dropshadow_spread = get_option('fps_selectedslide_dropshadow_spread');
    $post_selectedslide_inset = get_option('fps_selectedslide_inset');

    $post_unselectedslide_dropshadow_x = get_option('fps_unselectedslide_dropshadow_x');
    $post_unselectedslide_dropshadow_y = get_option('fps_unselectedslide_dropshadow_y');
    $post_unselectedslide_dropshadow_blur = get_option('fps_unselectedslide_dropshadow_blur');
    $post_unselectedslide_dropshadow_spread = get_option('fps_unselectedslide_dropshadow_spread');
    $post_unselectedslide_inset = get_option('fps_unselectedslide_inset');

    $post_selectedslide_dropshadow_color = get_option('fps_selectedslide_dropshadow_color');
    $post_unselectedslide_dropshadow_color = get_option('fps_unselectedslide_dropshadow_color');
    $post_slide_textshadow_x = get_option('fps_slide_textshadow_x');
    $post_slide_textshadow_y = get_option('fps_slide_textshadow_y');
    $post_slide_textshadow_blur = get_option('fps_slide_textshadow_blur');
    $post_slide_textshadow_color = get_option('fps_slide_textshadow_color');

    $post_image_bg_color = get_option('fps_image_bg_color');

    $post_image_height_stretch = get_option('fps_image_height_stretch');
    $post_image_width_stretch = get_option('fps_image_width_stretch');


    // Format all color hex value strings
    $post_title_color = "#".$post_title_color;
    $post_excerpt_color = "#".$post_excerpt_color;
    $post_heading_color = "#".$post_heading_color;
    $post_bg_color = "#".$post_bg_color;
    $post_innershadow_color = "#".$post_innershadow_color;
    $post_outershadow_color = "#".$post_outershadow_color;
    $post_selectedslide_textcolor = "#".$post_selectedslide_textcolor;
    $post_unselectedslide_textcolor = "#".$post_unselectedslide_textcolor;
    $post_selectedslide_bgcolor = "#".$post_selectedslide_bgcolor;
    $post_unselectedslide_bgcolor = "#".$post_unselectedslide_bgcolor;
    $post_image_bg_color = "#".$post_image_bg_color;

    $post_selectedslide_dropshadow_color = "#".$post_selectedslide_dropshadow_color;
    $post_unselectedslide_dropshadow_color = "#".$post_unselectedslide_dropshadow_color;
    $post_slide_textshadow_color = "#".$post_slide_textshadow_color;

    $post_textbg_rgba = 'rgba('.hex2RGB($post_textbg_color, true).','.$post_textbg_alpha.')';
    $post_textbg_hex = "#".$post_textbg_color;


    // Height offset
	$height_offset = 0;
    if (($post_display_slidenumbers == '1' && $post_arrow_position != 'borderless') || $post_arrow_position == 'below')
    {
        $height_offset += 25;
    }

	// Define box shadow
	$unselected_shadow = $post_unselectedslide_dropshadow_x.'px '.
	                     $post_unselectedslide_dropshadow_y.'px '.
	                     $post_unselectedslide_dropshadow_blur.'px '.
                         $post_unselectedslide_dropshadow_spread.'px '.
	                     $post_unselectedslide_dropshadow_color.' ';
	$selected_shadow = $post_selectedslide_dropshadow_x.'px '.
	                   $post_selectedslide_dropshadow_y.'px '.
	                   $post_selectedslide_dropshadow_blur.'px '.
                       $post_selectedslide_dropshadow_spread.'px '.
	                   $post_selectedslide_dropshadow_color.' '; 

	if ($post_unselectedslide_inset == '1')
	{
	    $unselected_shadow .= 'inset';
	}

	if ($post_selectedslide_inset == '1')
	{
	    $selected_shadow .= 'inset';
	}

	// Define the arrow image being used
    if ($post_arrow_color == 'custom')
    {
        $arrow_url = $post_arrow_custom_url;
    }
    else if ($post_arrow_position == 'below')
    {
        $arrow_url = WP_PLUGIN_URL.'/featured-posts-scroll/images/pos2-arrows-'.$post_arrow_color.'.png';
    }
    else if ($post_arrow_position == 'borderless')
    {
        $arrow_url = WP_PLUGIN_URL.'/featured-posts-scroll/images/pos3-arrows-'.$post_arrow_color.'.png';
    }
    else
    {
        $arrow_url = WP_PLUGIN_URL.'/featured-posts-scroll/images/arrows-'.$post_arrow_color.'.png';
    }

    // Define drop-shadow
    $shadow = $post_dropshadow_x.'px '.$post_dropshadow_y.'px '.$post_dropshadow_blur.'px '.$post_dropshadow_spread.'px ';
    $outer_shadow = $post_outer_dropshadow_x.'px '.$post_outer_dropshadow_y.'px '.$post_outer_dropshadow_blur.'px '.$post_outer_dropshadow_spread.'px ';
?>



.featured-posts-wrapper.fps-single {
height: <?php echo ($post_height + $height_offset) ?>px;
width: <?php echo $post_width ?>px;
}

.featured-posts-background.fps-single {
height: <?php echo ($post_height + $height_offset) ?>px;
width: <?php echo ($post_width-25) ?>px;
-moz-border-radius: <?php echo $post_outer_corner_radius ?>; 
border-radius: <?php echo $post_outer_corner_radius ?>;
-moz-box-shadow: <?php echo $outer_shadow ?> <?php echo $post_outershadow_color ?>; 
-webkit-box-shadow: <?php echo $outer_shadow ?> <?php echo $post_outershadow_color ?>; 
box-shadow: <?php echo $outer_shadow ?> <?php echo $post_outershadow_color ?>;
}

ul.featured-posts.fps-single {
height: <?php echo ($post_height-20) ?>px; 
width: <?php echo ($post_width-45) ?>px;
-moz-border-radius: <?php echo $post_corner_radius ?>; 
border-radius: <?php echo $post_corner_radius ?>;
-moz-box-shadow: <?php echo $shadow ?> <?php echo $post_innershadow_color ?>; 
-webkit-box-shadow: <?php echo $shadow ?> <?php echo $post_innershadow_color ?>; 
box-shadow: <?php echo $shadow ?> <?php echo $post_innershadow_color ?>;
}

ul.featured-posts.fps-single li {
background-color: <?php echo $post_image_bg_color ?>;
height: <?php echo ($post_height-20) ?>px; 
width: <?php echo ($post_width-45) ?>px;
-moz-border-radius: <?php echo $post_corner_radius ?>; 
border-radius: <?php echo $post_corner_radius ?>;
}

ul.featured-posts.fps-single li .fps-text {
width: <?php echo ($post_width-55) ?>px;
}

.scrollFeaturedPostsLeft, .scrollFeaturedPostsRight {
margin: <?php echo (($post_height-45)/2) ?>px 0px <?php echo (($post_height-45)/2) ?>px;
}

.fps-slideNumberList li {
color: <?php echo $post_unselectedslide_textcolor ?>; 
text-shadow: <?php echo $post_slide_textshadow_x ?>px <?php echo $post_slide_textshadow_y ?>px <?php echo $post_slide_textshadow_blur ?>px <?php echo $post_slide_textshadow_color ?>; 
font-family: <?php echo $post_unselectedslide_font ?>;
font-style: <?php echo $post_unselectedslide_fontstyle ?>;
font-variant: <?php echo $post_unselectedslide_fontvariant ?>;
font-weight: <?php echo $post_unselectedslide_fontweight ?>;
font-size: <?php echo $post_unselectedslide_fontsize ?>;
line-height: <?php echo $post_unselectedslide_fontheight ?>;
background: <?php echo $post_unselectedslide_bgcolor ?>; 
-moz-border-radius: <?php echo $post_slide_bgradius ?>; 
border-radius: <?php echo $post_slide_bgradius ?>; 
-moz-box-shadow: <?php echo $unselected_shadow ?> ; 
-webkit-box-shadow: <?php echo $unselected_shadow ?> ; 
box-shadow: <?php echo $unselected_shadow ?> ;
}

.fps-slideNumberList li.fps-selectedSlide, .fps-slideNumberList li:hover {
color: <?php echo $post_selectedslide_textcolor ?>; 
text-shadow: <?php echo $post_slide_textshadow_x ?>px <?php echo $post_slide_textshadow_y ?>px <?php echo $post_slide_textshadow_blur ?>px <?php echo $post_slide_textshadow_color ?>; 
font-family: <?php echo $post_selectedslide_font ?>;
font-style: <?php echo $post_selectedslide_fontstyle ?>;
font-variant: <?php echo $post_selectedslide_fontvariant ?>;
font-weight: <?php echo $post_selectedslide_fontweight ?>;
font-size: <?php echo $post_selectedslide_fontsize ?>;
line-height: <?php echo $post_selectedslide_fontheight ?>;
background: <?php echo $post_selectedslide_bgcolor ?>; 
-moz-box-shadow: <?php echo $selected_shadow ?>; 
-webkit-box-shadow: <?php echo $selected_shadow ?>;
box-shadow: <?php echo $selected_shadow ?>;
}

.fps-text {
background: <?php echo $post_textbg_hex ?>; 
background: <?php echo $post_textbg_rgba ?>;
}

a:link.featured-posts-image,a:visited.featured-posts-image,a:hover.featured-posts-image {
color: <?php echo $post_title_color ?>;
}

.scrollFeaturedPostsLeft, .scrollFeaturedPostsRight {
background-image: url(<?php echo $arrow_url ?>);
}

.scrollFeaturedPostsLeft-below, .scrollFeaturedPostsRight-below {
background-image: url(<?php echo $arrow_url ?>);
}

.featured-posts-background {
background: <?php echo $post_bg_color ?>;
}

p.fps-title, p.fps-title a:link, p.fps-title a:visited, p.fps-title a:active {
font-family: <?php echo $post_title_font ?>;
font-style: <?php echo $post_title_fontstyle ?>;
font-variant: <?php echo $post_title_fontvariant ?>;
font-weight: <?php echo $post_title_fontweight ?>;
font-size: <?php echo $post_title_fontsize ?>;
line-height: <?php echo $post_title_fontheight ?>;
color: <?php echo $post_title_color ?>;
}

p.fps-excerpt, p.fps-excerpt a:link, p.fps-excerpt a:visited, p.fps-excerpt a:active {
font-family: <?php echo $post_excerpt_font ?>;
font-style: <?php echo $post_excerpt_fontstyle ?>;
font-variant: <?php echo $post_excerpt_fontvariant ?>;
font-weight: <?php echo $post_excerpt_fontweight ?>;
font-size: <?php echo $post_excerpt_fontsize ?>;
line-height: <?php echo $post_excerpt_fontheight ?>;
color: <?php echo $post_excerpt_color ?>;
}

p.featured-posts-header {
font-family: <?php echo $post_heading_font ?>;
font-style: <?php echo $post_heading_fontstyle ?>;
font-variant: <?php echo $post_heading_fontvariant ?>;
font-weight: <?php echo $post_heading_fontweight ?>;
font-size: <?php echo $post_heading_fontsize ?>;
line-height: <?php echo $post_heading_fontheight ?>;
color: <?php echo $post_heading_color ?>;
}

ul.featured-posts.fps-single li .fps-image-div img.fps-image {
<?php if ($post_image_height_stretch == '1') : ?>
height: <?php echo ($post_height-20) ?>px;
<?php endif; ?>
<?php if ($post_image_width_stretch == '1') : ?>
width: <?php if ($post_arrow_position == 'borderless') {echo ($post_width-20);} else {echo ($post_width-45);} ?>px;
<?php endif; ?>
}

 





<?php 
/***** ARROWS BELOW MODIFICATIONS *****/
// Modify margin/height/width if arrows are below image
if ($post_arrow_position == 'below') : 
?>

.featured-posts-wrapper.fps-single {
width: <?php echo ($post_width - 25) ?>px;
}

ul.featured-posts.fps-single {
margin-left: 10px;
}

ul.fps-slideNumberList {
margin-top: 10px; 
margin-left: 10px;
}

.featured-posts-background.fps-single {
margin: 0px 0px 12px;
}

<?php 
/***** END - ARROWS BELOW MODIFICATIONS *****/
endif; ?>






<?php 
/***** BORDERLESS MODIFICATIONS *****/
// Modify margin/height/width if arrows are below image
if ($post_arrow_position == 'borderless') : 
?>

ul.featured-posts.fps-single {
width: <?php echo ($post_width-20) ?>px;
}

ul.featured-posts.fps-single li {
width: <?php echo ($post_width-20) ?>px;
}

ul.featured-posts.fps-single li .fps-text {
width: <?php echo ($post_width-30) ?>px;
}

.scrollFeaturedPostsLeft, .scrollFeaturedPostsRight {
margin: <?php echo (($post_height-55)/2) ?>px 0px <?php echo (($post_height-55)/2) ?>px;
z-index: 10;
height: 60px;
}

.scrollFeaturedPostsLeft {
background-position: 0px 0px;
margin-right: -25px;
width: 35px;
}

.scrollFeaturedPostsRight {
background-position: -35px 0px;
margin-left: -25px;
width: 35px;
}

.scrollFeaturedPostsLeft:hover {
background-position: 0px -60px;
}

.scrollFeaturedPostsRight:hover {
background-position: -35px -60px;
}

.scrollFeaturedPostsLeft:active {
background-position: 0px 0px;
}

.scrollFeaturedPostsRight:active {
background-position: -35px 0px;
}

<?php 
/***** END - BORDERLESS MODIFICATIONS *****/
endif; ?>






<?php

/* Convert a hex RGB string into individual RGB decimal values */
function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}

?>