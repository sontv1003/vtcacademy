<?php
/*
Plugin Name: Featured Posts Scroll
Plugin URI: http://chasepettit.com
Description: A basic javascript based scrolling display of post titles and thumbnails.
Version: 1.22
Author: Chaser324
Author URI: http://chasepettit.com
License: GNU GPL2

/*  Copyright 2011  Chase Pettit  (email : chasepettit@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Register activate/deactivate hooks for the plugin
register_activation_hook( __FILE__, 'fps_activate' );
register_deactivation_hook( __FILE__, 'fps_deactivate' );

//Create menu for configure page
add_action('admin_menu', 'fps_admin_actions');

//Add the necessary stylesheet & script
add_action('wp_print_styles', 'fps_add_style');
add_action('init', 'fps_add_script');

// Register new image thumbnail sizes
add_action('admin_init', 'fps_define_image_sizes');

/* Activate the plugin by creating/initializing all options */
function fps_activate()
{
    $max_posts = get_option('fps_max_posts');
    if ( empty($max_posts) ) {
        $max_posts = '5';
        update_option('fps_max_posts', $max_posts);
    }

    $fps_image_full_size = get_option('fps_image_full_size');
    if ( empty($fps_image_full_size) ) {
        $fps_image_full_size = '0';
        update_option('fps_image_full_size', $fps_image_full_size);
    }

    $post_title_color = get_option('fps_title_color');
    if ( empty($post_title_color) ) {
        $post_title_color = 'ffffff';
        update_option('fps_title_color', $post_title_color);
    }

    $post_excerpt_color = get_option('fps_excerpt_color');
    if ( empty($post_excerpt_color) ) {
        $post_excerpt_color = 'ffffff';
        update_option('fps_excerpt_color', $post_excerpt_color);
    }

    $post_heading_color = get_option('fps_heading_color');
    if ( empty($post_heading_color) ) {
        $post_heading_color = 'b3320f';
        update_option('fps_heading_color', $post_heading_color);
    }

    $post_heading_text = get_option('fps_heading_text');
    if ( empty($post_heading_text) ) {
        $post_heading_text = 'Featured Posts';
        update_option('fps_heading_text', $post_heading_text);
    }
    
    $post_bg_color = get_option('fps_bg_color');
    if ( empty($post_bg_color) ) {
        $post_bg_color = '1b1b1b';
        update_option('fps_bg_color', $post_bg_color);
    }

    $post_textbg_color = get_option('fps_textbg_color');
    if ( empty($post_textbg_color) ) {
        $post_textbg_color = '000000';
        update_option('fps_textbg_color', $post_textbg_color);
    }

    $post_textbg_alpha = get_option('fps_textbg_alpha');
    if ( empty($post_textbg_alpha) ) {
        $post_textbg_alpha = '0.5';
        update_option('fps_textbg_alpha', $post_textbg_alpha);
    }
    
    $post_innershadow_color = get_option('fps_innershadow_color');
    if ( empty($post_innershadow_color) ) {
        $post_innershadow_color = '000000';
        update_option('fps_innershadow_color', $post_innershadow_color);
    }

    $post_outershadow_color = get_option('fps_outershadow_color');
    if ( empty($post_outershadow_color) ) {
        $post_outershadow_color = '000000';
        update_option('fps_outershadow_color', $post_outershadow_color);
    }

    $post_arrow_color = get_option('fps_arrow_color');
    if ( empty($post_arrow_color) ) {
        $post_arrow_color = 'orange';
        update_option('fps_arrow_color', $post_arrow_color);
    }
    
    $post_display_title = get_option('fps_display_title');
    if ( empty($post_display_title) ) {
        $post_display_title = '1';
        update_option('fps_display_title', $post_display_title);
    }

    $post_display_excerpt = get_option('fps_display_excerpt');
    if ( empty($post_display_excerpt) ) {
        $post_display_excerpt = '1';
        update_option('fps_display_excerpt', $post_display_excerpt);
    }

    $post_display_heading = get_option('fps_display_heading');
    if ( empty($post_display_heading) ) {
        $post_display_heading = '0';
        update_option('fps_display_heading', $post_display_heading);
    }

    $post_autoscroll = get_option('fps_autoscroll');
    if ( empty($post_autoscroll) ) {
        $post_autoscroll = '1';
        update_option('fps_autoscroll', $post_autoscroll);
    }

    $post_radius = get_option('fps_corner_radius');
    if ( empty($post_radius) ) {
        $post_radius = '5px';
        update_option('fps_corner_radius', $post_radius);
    }

    $post_dropshadow_x = get_option('fps_dropshadow_x');
    if ( empty($post_dropshadow_x) ) {
        $post_dropshadow_x = '0';
        update_option('fps_dropshadow_x', $post_dropshadow_x);
    }

    $post_dropshadow_y = get_option('fps_dropshadow_y');
    if ( empty($post_dropshadow_y) ) {
        $post_dropshadow_y = '5';
        update_option('fps_dropshadow_y', $post_dropshadow_y);
    }

    $post_dropshadow_blur = get_option('fps_dropshadow_blur');
    if ( empty($post_dropshadow_blur) ) {
        $post_dropshadow_blur = '5';
        update_option('fps_dropshadow_blur', $post_dropshadow_blur);
    }

    $post_dropshadow_spread = get_option('fps_dropshadow_spread');
    if ( empty($post_dropshadow_spread) ) {
        $post_dropshadow_spread = '0';
        update_option('fps_dropshadow_spread', $post_dropshadow_spread);
    }

    $post_outer_radius = get_option('fps_outer_corner_radius');
    if ( empty($post_outer_radius) ) {
        $post_outer_radius = $post_radius;
        update_option('fps_outer_corner_radius', $post_outer_radius);
    }

    $post_outer_dropshadow_x = get_option('fps_outer_dropshadow_x');
    if ( empty($post_outer_dropshadow_x) ) {
        $post_outer_dropshadow_x = $post_dropshadow_x;
        update_option('fps_outer_dropshadow_x', $post_outer_dropshadow_x);
    }

    $post_outer_dropshadow_y = get_option('fps_outer_dropshadow_y');
    if ( empty($post_outer_dropshadow_y) ) {
        $post_outer_dropshadow_y = $post_dropshadow_y;
        update_option('fps_outer_dropshadow_y', $post_outer_dropshadow_y);
    }

    $post_outer_dropshadow_blur = get_option('fps_outer_dropshadow_blur');
    if ( empty($post_outer_dropshadow_blur) ) {
        $post_outer_dropshadow_blur = $post_dropshadow_blur;
        update_option('fps_outer_dropshadow_blur', $post_outer_dropshadow_blur);
    }

    $post_outer_dropshadow_spread = get_option('fps_outer_dropshadow_spread');
    if ( empty($post_outer_dropshadow_spread) ) {
        $post_outer_dropshadow_spread = '0';
        update_option('fps_outer_dropshadow_spread', $post_outer_dropshadow_spread);
    }

    $post_height = get_option('fps_height');
    if ( empty($post_height) ) {
        $post_height = '245';
        update_option('fps_height', $post_height);
    }

    $post_width = get_option('fps_width');
    if ( empty($post_width) ) {
        $post_width = '550';
        update_option('fps_width', $post_width);
    }

    $post_display_slidenumbers = get_option('fps_display_slidenumbers');
    if ( empty($post_display_slidenumbers) ) {
        $post_display_slidenumbers = '1';
        update_option('fps_display_slidenumbers', $post_display_slidenumbers);
    }

    $post_arrow_position = get_option('fps_arrow_position');
    if ( empty($post_arrow_position) ) {
        $post_arrow_position = 'below';
        update_option('fps_arrow_position', $post_arrow_position);
    }

    $post_arrow_custom_url = get_option('fps_arrow_custom_url');
    if ( empty($post_arrow_custom_url) ) {
        $post_arrow_custom_url = '';
        update_option('fps_arrow_custom_url', $post_arrow_custom_url);
    }

    $post_selectedslide_textcolor = get_option('fps_selectedslide_textcolor');
    if ( empty($post_selectedslide_textcolor) ) {
        $post_selectedslide_textcolor = 'ffffff';
        update_option('fps_selectedslide_textcolor', $post_selectedslide_textcolor);
    }

    $post_unselectedslide_textcolor = get_option('fps_unselectedslide_textcolor');
    if ( empty($post_unselectedslide_textcolor) ) {
        $post_unselectedslide_textcolor = 'ffffff';
        update_option('fps_unselectedslide_textcolor', $post_unselectedslide_textcolor);
    }

    $post_selectedslide_bgcolor = get_option('fps_selectedslide_bgcolor');
    if ( empty($post_selectedslide_bgcolor) ) {
        $post_selectedslide_bgcolor = '303030';
        update_option('fps_selectedslide_bgcolor', $post_selectedslide_bgcolor);
    }

    $post_unselectedslide_bgcolor = get_option('fps_unselectedslide_bgcolor');
    if ( empty($post_unselectedslide_bgcolor) ) {
        $post_unselectedslide_bgcolor = '545454';
        update_option('fps_unselectedslide_bgcolor', $post_unselectedslide_bgcolor);
    }

    $post_selectedslide_bold = get_option('fps_selectedslide_bold');
    if ( empty($post_selectedslide_bold) ) {
        $post_selectedslide_bold = '1';
        update_option('fps_selectedslide_bold', $post_selectedslide_bold);
    }

    $post_selectedslide_italics = get_option('fps_selectedslide_italics');
    if ( empty($post_selectedslide_italics) ) {
        $post_selectedslide_italics = '0';
        update_option('fps_selectedslide_italics', $post_selectedslide_italics);
    }

    $post_unselectedslide_bold = get_option('fps_unselectedslide_bold');
    if ( empty($post_unselectedslide_bold) ) {
        $post_unselectedslide_bold = '1';
        update_option('fps_unselectedslide_bold', $post_unselectedslide_bold);
    }

    $post_unselectedslide_italics = get_option('fps_unselectedslide_italics');
    if ( empty($post_unselectedslide_italics) ) {
        $post_unselectedslide_italics = '0';
        update_option('fps_unselectedslide_italics', $post_unselectedslide_italics);
    }

    $post_slide_bgradius = get_option('fps_slide_bgradius');
    if ( empty($post_slide_bgradius) ) {
        $post_slide_bgradius = '2.0';
        update_option('fps_slide_bgradius', $post_slide_bgradius);
    }

    $post_selectedslide_dropshadow_x = get_option('fps_selectedslide_dropshadow_x');
    if ( empty($post_selectedslide_dropshadow_x) ) {
        $post_selectedslide_dropshadow_x = '0';
        update_option('fps_selectedslide_dropshadow_x', $post_selectedslide_dropshadow_x);
    }

    $post_selectedslide_dropshadow_y = get_option('fps_selectedslide_dropshadow_y');
    if ( empty($post_selectedslide_dropshadow_y) ) {
        $post_selectedslide_dropshadow_y = '2';
        update_option('fps_selectedslide_dropshadow_y', $post_selectedslide_dropshadow_y);
    }

    $post_selectedslide_dropshadow_blur = get_option('fps_selectedslide_dropshadow_blur');
    if ( empty($post_selectedslide_dropshadow_blur) ) {
        $post_selectedslide_dropshadow_blur = '2';
        update_option('fps_selectedslide_dropshadow_blur', $post_selectedslide_dropshadow_blur);
    }

    $post_selectedslide_dropshadow_spread = get_option('fps_selectedslide_dropshadow_spread');
    if ( empty($post_selectedslide_dropshadow_spread) ) {
        $post_selectedslide_dropshadow_spread = '0';
        update_option('fps_selectedslide_dropshadow_spread', $post_selectedslide_dropshadow_spread);
    }

    $post_selectedslide_inset = get_option('fps_selectedslide_inset');
    if ( empty($post_selectedslide_inset) ) {
        $post_selectedslide_inset = '1';
        update_option('fps_selectedslide_inset', $post_selectedslide_inset);
    }

    $post_unselectedslide_dropshadow_x = get_option('fps_unselectedslide_dropshadow_x');
    if ( empty($post_unselectedslide_dropshadow_x) ) {
        $post_unselectedslide_dropshadow_x = '0';
        update_option('fps_unselectedslide_dropshadow_x', $post_unselectedslide_dropshadow_x);
    }

    $post_unselectedslide_dropshadow_y = get_option('fps_unselectedslide_dropshadow_y');
    if ( empty($post_unselectedslide_dropshadow_y) ) {
        $post_unselectedslide_dropshadow_y = '0';
        update_option('fps_unselectedslide_dropshadow_y', $post_unselectedslide_dropshadow_y);
    }

    $post_unselectedslide_dropshadow_blur = get_option('fps_unselectedslide_dropshadow_blur');
    if ( empty($post_unselectedslide_dropshadow_blur) ) {
        $post_unselectedslide_dropshadow_blur = '0';
        update_option('fps_unselectedslide_dropshadow_blur', $post_unselectedslide_dropshadow_blur);
    }

    $post_unselectedslide_dropshadow_spread = get_option('fps_unselectedslide_dropshadow_spread');
    if ( empty($post_unselectedslide_dropshadow_spread) ) {
        $post_unselectedslide_dropshadow_spread = '0';
        update_option('fps_unselectedslide_dropshadow_spread', $post_unselectedslide_dropshadow_spread);
    }

    $post_unselectedslide_inset = get_option('fps_unselectedslide_inset');
    if ( empty($post_unselectedslide_inset) ) {
        $post_unselectedslide_inset = '0';
        update_option('fps_unselectedslide_inset', $post_unselectedslide_inset);
    }

    $post_selectedslide_dropshadow_color = get_option('fps_selectedslide_dropshadow_color');
    if ( empty($post_selectedslide_dropshadow_color) ) {
        $post_selectedslide_dropshadow_color = '000000';
        update_option('fps_selectedslide_dropshadow_color', $post_selectedslide_dropshadow_color);
    }

    $post_unselectedslide_dropshadow_color = get_option('fps_unselectedslide_dropshadow_color');
    if ( empty($post_unselectedslide_dropshadow_color) ) {
        $post_unselectedslide_dropshadow_color = '000000';
        update_option('fps_unselectedslide_dropshadow_color', $post_unselectedslide_dropshadow_color);
    }

    $post_slide_textshadow_x = get_option('fps_slide_textshadow_x');
    if ( empty($post_slide_textshadow_x) ) {
        $post_slide_textshadow_x = '0';
        update_option('fps_slide_textshadow_x', $post_slide_textshadow_x);
    }

    $post_slide_textshadow_y = get_option('fps_slide_textshadow_y');
    if ( empty($post_slide_textshadow_y) ) {
        $post_slide_textshadow_y = '1';
        update_option('fps_slide_textshadow_y', $post_slide_textshadow_y);
    }

    $post_slide_textshadow_blur = get_option('fps_slide_textshadow_blur');
    if ( empty($post_slide_textshadow_blur) ) {
        $post_slide_textshadow_blur = '0';
        update_option('fps_slide_textshadow_blur', $post_slide_textshadow_blur);
    }

    $post_slide_textshadow_color = get_option('fps_slide_textshadow_color');
    if ( empty($post_slide_textshadow_color) ) {
        $post_slide_textshadow_color = '000000';
        update_option('fps_slide_textshadow_color', $post_slide_textshadow_color);
    }

    $post_title_font = get_option('fps_title_font');
    if ( empty($post_title_font) ) {
        $post_title_font = '';
        update_option('fps_title_font', $post_title_font);
    }

    $post_excerpt_font = get_option('fps_excerpt_font');
    if ( empty($post_excerpt_font) ) {
        $post_excerpt_font = '';
        update_option('fps_excerpt_font', $post_excerpt_font);
    }

    $post_heading_font = get_option('fps_heading_font');
    if ( empty($post_heading_font) ) {
        $post_heading_font = '';
        update_option('fps_heading_font', $post_heading_font);
    }

    $post_selectedslide_font = get_option('fps_selectedslide_font');
    if ( empty($post_selectedslide_font) ) {
        $post_selectedslide_font = '';
        update_option('fps_selectedslide_font', $post_selectedslide_font);
    }

    $post_unselectedslide_font = get_option('fps_unselectedslide_font');
    if ( empty($post_unselectedslide_font) ) {
        $post_unselectedslide_font = '';
        update_option('fps_unselectedslide_font', $post_unselectedslide_font);
    }


    $post_title_fontstyle = get_option('fps_title_fontstyle');
    if ( empty($post_title_fontstyle) ) {
        $post_title_fontstyle = '';
        update_option('fps_title_fontstyle', $post_title_fontstyle);
    }

    $post_excerpt_fontstyle = get_option('fps_excerpt_fontstyle');
    if ( empty($post_excerpt_fontstyle) ) {
        $post_excerpt_fontstyle = '';
        update_option('fps_excerpt_fontstyle', $post_excerpt_fontstyle);
    }

    $post_heading_fontstyle = get_option('fps_heading_fontstyle');
    if ( empty($post_heading_fontstyle) ) {
        $post_heading_fontstyle = '';
        update_option('fps_heading_fontstyle', $post_heading_fontstyle);
    }

    $post_selectedslide_fontstyle = get_option('fps_selectedslide_fontstyle');
    if ( empty($post_selectedslide_fontstyle) ) {
        $post_selectedslide_fontstyle = '';
        update_option('fps_selectedslide_fontstyle', $post_selectedslide_fontstyle);
    }

    $post_unselectedslide_fontstyle = get_option('fps_unselectedslide_fontstyle');
    if ( empty($post_unselectedslide_fontstyle) ) {
        $post_unselectedslide_fontstyle = '';
        update_option('fps_unselectedslide_fontstyle', $post_unselectedslide_fontstyle);
    }


    $post_title_fontvariant = get_option('fps_title_fontvariant');
    if ( empty($post_title_fontvariant) ) {
        $post_title_fontvariant = '';
        update_option('fps_title_fontvariant', $post_title_fontvariant);
    }

    $post_excerpt_fontvariant = get_option('fps_excerpt_fontvariant');
    if ( empty($post_excerpt_fontvariant) ) {
        $post_excerpt_fontvariant = '';
        update_option('fps_excerpt_fontvariant', $post_excerpt_fontvariant);
    }

    $post_heading_fontvariant = get_option('fps_heading_fontvariant');
    if ( empty($post_heading_fontvariant) ) {
        $post_heading_fontvariant = '';
        update_option('fps_heading_fontvariant', $post_heading_fontvariant);
    }

    $post_selectedslide_fontvariant = get_option('fps_selectedslide_fontvariant');
    if ( empty($post_selectedslide_fontvariant) ) {
        $post_selectedslide_fontvariant = '';
        update_option('fps_selectedslide_fontvariant', $post_selectedslide_fontvariant);
    }

    $post_unselectedslide_fontvariant = get_option('fps_unselectedslide_fontvariant');
    if ( empty($post_unselectedslide_fontvariant) ) {
        $post_unselectedslide_fontvariant = '';
        update_option('fps_unselectedslide_fontvariant', $post_unselectedslide_fontvariant);
    }


    $post_title_fontweight = get_option('fps_title_fontweight');
    if ( empty($post_title_fontweight) ) {
        $post_title_fontweight = 'bold';
        update_option('fps_title_fontweight', $post_title_fontweight);
    }

    $post_excerpt_fontweight = get_option('fps_excerpt_fontweight');
    if ( empty($post_excerpt_fontweight) ) {
        $post_excerpt_fontweight = '';
        update_option('fps_excerpt_fontweight', $post_excerpt_fontweight);
    }

    $post_heading_fontweight = get_option('fps_heading_fontweight');
    if ( empty($post_heading_fontweight) ) {
        $post_heading_fontweight = 'bold';
        update_option('fps_heading_fontweight', $post_heading_fontweight);
    }

    $post_selectedslide_fontweight = get_option('fps_selectedslide_fontweight');
    if ( empty($post_selectedslide_fontweight) ) {
        $post_selectedslide_fontweight = 'bold';
        update_option('fps_selectedslide_fontweight', $post_selectedslide_fontweight);
    }

    $post_unselectedslide_fontweight = get_option('fps_unselectedslide_fontweight');
    if ( empty($post_unselectedslide_fontweight) ) {
        $post_unselectedslide_fontweight = 'bold';
        update_option('fps_unselectedslide_fontweight', $post_unselectedslide_fontweight);
    }


    $post_title_fontsize = get_option('fps_title_fontsize');
    if ( empty($post_title_fontsize) ) {
        $post_title_fontsize = '12pt';
        update_option('fps_title_fontsize', $post_title_fontsize);
    }

    $post_excerpt_fontsize = get_option('fps_excerpt_fontsize');
    if ( empty($post_excerpt_fontsize) ) {
        $post_excerpt_fontsize = '10pt';
        update_option('fps_excerpt_fontsize', $post_excerpt_fontsize);
    }

    $post_heading_fontsize = get_option('fps_heading_fontsize');
    if ( empty($post_heading_fontsize) ) {
        $post_heading_fontsize = '18pt';
        update_option('fps_heading_fontsize', $post_heading_fontsize);
    }

    $post_selectedslide_fontsize = get_option('fps_selectedslide_fontsize');
    if ( empty($post_selectedslide_fontsize) ) {
        $post_selectedslide_fontsize = '10pt';
        update_option('fps_selectedslide_fontsize', $post_selectedslide_fontsize);
    }

    $post_unselectedslide_fontsize = get_option('fps_unselectedslide_fontsize');
    if ( empty($post_unselectedslide_fontsize) ) {
        $post_unselectedslide_fontsize = '10pt';
        update_option('fps_unselectedslide_fontsize', $post_unselectedslide_fontsize);
    }


    $post_title_fontheight = get_option('fps_title_fontheight');
    if ( empty($post_title_fontheight) ) {
        $post_title_fontheight = '';
        update_option('fps_title_fontheight', $post_title_fontheight);
    }

    $post_excerpt_fontheight = get_option('fps_excerpt_fontheight');
    if ( empty($post_excerpt_fontheight) ) {
        $post_excerpt_fontheight = '10pt';
        update_option('fps_excerpt_fontheight', $post_excerpt_fontheight);
    }

    $post_heading_fontheight = get_option('fps_heading_fontheight');
    if ( empty($post_heading_fontheight) ) {
        $post_heading_fontheight = '';
        update_option('fps_heading_fontheight', $post_heading_fontheight);
    }

    $post_selectedslide_fontheight = get_option('fps_selectedslide_fontheight');
    if ( empty($post_selectedslide_fontheight) ) {
        $post_selectedslide_fontheight = '14pt';
        update_option('fps_selectedslide_fontheight', $post_selectedslide_fontheight);
    }

    $post_unselectedslide_fontheight = get_option('fps_unselectedslide_fontheight');
    if ( empty($post_unselectedslide_fontheight) ) {
        $post_unselectedslide_fontheight = '14pt';
        update_option('fps_unselectedslide_fontheight', $post_unselectedslide_fontheight);
    }


    $post_scroll_speed = get_option('fps_scroll_speed');
    if ( empty($post_scroll_speed) ) {
        $post_scroll_speed = '1000';
        update_option('fps_scroll_speed', $post_scroll_speed);
    }

    $post_scroll_fadeInSpeed = get_option('fps_scroll_fadeInSpeed');
    if ( empty($post_scroll_fadeInSpeed) ) {
        $post_scroll_fadeInSpeed = '200';
        update_option('fps_scroll_fadeInSpeed', $post_scroll_fadeInSpeed);
    }

    $post_scroll_fadeOutSpeed = get_option('fps_scroll_fadeOutSpeed');
    if ( empty($post_scroll_fadeOutSpeed) ) {
        $post_scroll_fadeOutSpeed = '100';
        update_option('fps_scroll_fadeOutSpeed', $post_scroll_fadeOutSpeed);
    }

    $post_scroll_interval = get_option('fps_scroll_interval');
    if ( empty($post_scroll_interval) ) {
        $post_scroll_interval = '7000';
        update_option('fps_scroll_interval', $post_scroll_interval);
    }

    $post_image_bg_color = get_option('fps_image_bg_color');
    if ( empty($post_image_bg_color) ) {
        $post_image_bg_color = '000000';
        update_option('fps_image_bg_color', $post_image_bg_color);
    }

    $post_image_scale = get_option('fps_image_scale');
    if ( empty($post_image_scale) ) {
        $post_image_scale = '1';
        update_option('fps_image_scale', $post_image_scale);
    }

    $post_image_height_noscale = get_option('fps_image_height_noscale');
    if ( empty($post_image_height_noscale) ) {
        $post_image_height_noscale = '0';
        update_option('fps_image_height_noscale', $post_image_height_noscale);
    }

    $post_image_width_noscale = get_option('fps_image_width_noscale');
    if ( empty($post_image_width_noscale) ) {
        $post_image_width_noscale = '0';
        update_option('fps_image_width_noscale', $post_image_width_noscale);
    }

    $post_image_height_stretch = get_option('fps_image_height_stretch');
    if ( empty($post_image_height_stretch) ) {
        $post_image_height_stretch = '1';
        update_option('fps_image_height_stretch', $post_image_height_stretch);
    }

    $post_image_width_stretch = get_option('fps_image_width_stretch');
    if ( empty($post_image_width_stretch) ) {
        $post_image_width_stretch = '1';
        update_option('fps_image_width_stretch', $post_image_width_stretch);
    }



    
}

/* Deactivate plugin by deleting all option data */
function fps_deactivate()
{
    delete_option('fps_max_posts');
    delete_option('fps_image_full_size');
        
    delete_option('fps_title_color');
    delete_option('fps_excerpt_color');

    delete_option('fps_heading_color');
    delete_option('fps_heading_text');
    
    delete_option('fps_bg_color');
    delete_option('fps_textbg_color');
    delete_option('fps_textbg_alpha');
    
    delete_option('fps_innershadow_color');
    delete_option('fps_outershadow_color');

    delete_option('fps_arrow_color');
    
    delete_option('fps_display_title');
    delete_option('fps_display_excerpt');
    delete_option('fps_display_heading');

    delete_option('fps_autoscroll');

    delete_option('fps_corner_radius');
    delete_option('fps_dropshadow_x');
    delete_option('fps_dropshadow_y');
    delete_option('fps_dropshadow_blur');
    delete_option('fps_dropshadow_spread');

    delete_option('fps_outer_corner_radius');
    delete_option('fps_outer_dropshadow_x');
    delete_option('fps_outer_dropshadow_y');
    delete_option('fps_outer_dropshadow_blur');
    delete_option('fps_outer_dropshadow_spread');

    delete_option('fps_height');
    delete_option('fps_width');

    delete_option('fps_arrow_position');
    delete_option('fps_arrow_custom_url');

    delete_option('fps_display_slidenumbers');

    delete_option('fps_selectedslide_textcolor');
    delete_option('fps_unselectedslide_textcolor');

    delete_option('fps_selectedslide_bgcolor');
    delete_option('fps_unselectedslide_bgcolor');

    delete_option('fps_selectedslide_bold');
    delete_option('fps_selectedslide_italics');

    delete_option('fps_unselectedslide_bold');
    delete_option('fps_unselectedslide_italics');

    delete_option('fps_slide_bgradius');

    delete_option('fps_selectedslide_dropshadow_x');
    delete_option('fps_selectedslide_dropshadow_y');
    delete_option('fps_selectedslide_dropshadow_blur');
    delete_option('fps_selectedslide_dropshadow_spread');
    delete_option('fps_selectedslide_inset');

    delete_option('fps_unselectedslide_dropshadow_x');
    delete_option('fps_unselectedslide_dropshadow_y');
    delete_option('fps_unselectedslide_dropshadow_blur');
    delete_option('fps_unselectedslide_dropshadow_spread');
    delete_option('fps_unselectedslide_inset');

    delete_option('fps_selectedslide_dropshadow_color');
    delete_option('fps_unselectedslide_dropshadow_color');
    delete_option('fps_slide_textshadow_x');
    delete_option('fps_slide_textshadow_y');
    delete_option('fps_slide_textshadow_blur');
    delete_option('fps_slide_textshadow_color');

    delete_option('fps_title_font');
    delete_option('fps_excerpt_font');
    delete_option('fps_heading_font');
    delete_option('fps_selectedslide_font');
    delete_option('fps_unselectedslide_font');

    delete_option('fps_title_fontstyle');
    delete_option('fps_excerpt_fontstyle');
    delete_option('fps_heading_fontstyle');
    delete_option('fps_selectedslide_fontstyle');
    delete_option('fps_unselectedslide_fontstyle');

    delete_option('fps_title_fontvariant');
    delete_option('fps_excerpt_fontvariant');
    delete_option('fps_heading_fontvariant');
    delete_option('fps_selectedslide_fontvariant');
    delete_option('fps_unselectedslide_fontvariant');

    delete_option('fps_title_fontweight');
    delete_option('fps_excerpt_fontweight');
    delete_option('fps_heading_fontweight');
    delete_option('fps_selectedslide_fontweight');
    delete_option('fps_unselectedslide_fontweight');

    delete_option('fps_title_fontsize');
    delete_option('fps_excerpt_fontsize');
    delete_option('fps_heading_fontsize');
    delete_option('fps_selectedslide_fontsize');
    delete_option('fps_unselectedslide_fontsize');

    delete_option('fps_title_fontheight');
    delete_option('fps_excerpt_fontheight');
    delete_option('fps_heading_fontheight');
    delete_option('fps_selectedslide_fontheight');
    delete_option('fps_unselectedslide_fontheight');

    delete_option('fps_scroll_speed');
    delete_option('fps_scroll_fadeInSpeed');
    delete_option('fps_scroll_fadeOutSpeed');
    delete_option('fps_scroll_interval');

    delete_option('fps_image_bg_color');
    delete_option('fps_image_scale');
    delete_option('fps_image_height_noscale');
    delete_option('fps_image_width_noscale');
    delete_option('fps_image_height_stretch');
    delete_option('fps_image_width_stretch');
}

/* Setup menu page creation */
function fps_admin_actions()
{
    $page = add_menu_page('Featured Posts Scroll', 'Featured Posts Scroll', 'manage_options', 'featured-posts-scroll', 'fps_admin');
    
    add_action( 'admin_print_styles-' . $page, 'fps_menu_styles' );
}

/* Display the admin page if user has permissions */
function fps_admin() {
    if ( !current_user_can('manage_options') )
        wp_die( __('You do not have sufficient permissions to access this page.') );
    include('featured-posts-scroll-admin.php');
}

/* Enqueue stylesheets needed on the admin page */
function fps_menu_styles()
{
    wp_enqueue_style( 'jcolorpicker-style', WP_PLUGIN_URL.'/featured-posts-scroll/css/colorpicker.css' );
    wp_enqueue_style( 'jquery-ui-tabs-css','http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/cupertino/jquery-ui.css' );
}

/* Enqueue styles necessary for the plugin */
function fps_add_style()
{
    wp_enqueue_style('fps-style', WP_PLUGIN_URL.'/featured-posts-scroll/css/featuredposts.css');
    wp_enqueue_style('fps-style-dynamic', WP_PLUGIN_URL.'/featured-posts-scroll/featured-posts-scroll-style.php');
}

/* Enqueue scripts necessary for the plugin */
function fps_add_script()
{
    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('featuredpostslides', WP_PLUGIN_URL.'/featured-posts-scroll/js/featuredpostslides.php');
    }
    else {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('featuredpostslides-admin', WP_PLUGIN_URL.'/featured-posts-scroll/js/fps-admin.js');
        wp_enqueue_script('jcolorpicker', WP_PLUGIN_URL.'/featured-posts-scroll/js/colorpicker.js');
        wp_enqueue_script('admincolors', WP_PLUGIN_URL.'/featured-posts-scroll/js/admincolors.js');
    }
}

/* Define image sizes used by the plugin */
function fps_define_image_sizes()
{
    //add_theme_support( 'post-thumbnails' ); // Add support for posts
    $post_height = get_option('fps_height');
    $post_width = get_option('fps_width');
    $post_image_scale = get_option('fps_image_scale');
    $post_image_height_noscale = get_option('fps_image_height_noscale');
    $post_image_width_noscale = get_option('fps_image_width_noscale');

    $post_image_scale_bool = true;
    if ($post_image_scale == '0')
    {
        $post_image_scale_bool = false;
    }

    $post_width -= 45;
    $post_height -= 20;

    if ($post_image_height_noscale == '1' && $post_image_scale_bool == false)
    {
        $post_height = 9999;
    }

    if ($post_image_width_noscale == '1' && $post_image_scale_bool == false)
    {
        $post_width = 9999;
    }



    add_image_size( 'fps-post', ($post_width), ($post_height), $post_image_scale_bool );
}

/* Generate the plugin display */
function fps_show($atts)
{
    // Retrieve all admin options
    $max_posts = get_option('fps_max_posts');
    
    $post_display_title = get_option('fps_display_title');
    $post_display_excerpt = get_option('fps_display_excerpt');
    $post_display_heading = get_option('fps_display_heading');
    $post_display_slidenumbers = get_option('fps_display_slidenumbers');

    $post_heading_text = get_option('fps_heading_text');

    $post_autoscroll = get_option('fps_autoscroll');

    $post_arrow_position = get_option('fps_arrow_position');

    $fps_image_full_size = get_option('fps_image_full_size');

    

    $wrapper_classes .= "featured-posts-wrapper fps-single";
    $ul_classes .= "featured-posts fps-single";
    $bg_classes .= "featured-posts-background fps-single";
    $li_classes = "";

    // Check if auto scrolling is enabled
    if ($post_autoscroll == '1')
    {
        $wrapper_classes .= " fps-autoscroll";
    }

    // Generate the main output.
    // Do not generate if this is not on the first page (need to make this optional in 2.0)
    if (!is_paged())
    {
        $output .= '<!--Automatic Image Slider w/ CSS & jQuery with some customization-->';

        // div#featured-posts-wrapper
        $output .= '<div class="'.$wrapper_classes.'">';
        
        // Display heading if option selected
        if ($post_display_heading == '1')
        {
            $output .= '<p class="featured-posts-header">'.$post_heading_text.'</p>';
        }

        // Add left arrow and open unordered list
        if ($post_arrow_position == 'sides' || $post_arrow_position == 'borderless')
        {
            $output .= '<div class="scrollFeaturedPostsLeft"></div>';
        }
        $output .= '<ul class="'.$ul_classes.'">';

        // Generate arguments for query
        $post_details = NULL;
        if ($atts == NULL)
        {
            $args = array(
                'numberposts'     => $max_posts,
                'offset'          => 0,
                'category'        => '',
                'orderby'         => 'post_date',
                'order'           => 'DESC',
                'include'         => '',
                'exclude'         => '',
                'post_type'       => 'post',
                'tag'             => '',
                'post_status'     => 'publish' );
        }
        else
        {
            $args = $atts;
            $args['numberposts'] = $max_posts;
            $args['post_status'] = 'publish';
        }
        $recent_posts = get_posts( $args );

        if ( count($recent_posts)< $max_posts ) {
            $max_posts = count($recent_posts);
        }

        // Get details for each article retrieved in query
        foreach ( $recent_posts as $key=>$val ) 
        {
            setup_postdata($val);
            $post_details[$key]['post_title'] = $val->post_title;
            $post_details[$key]['post_excerpt'] = $val->post_excerpt;
            $post_details[$key]['post_permalink'] = get_permalink($val->ID);
            if (has_post_thumbnail($val->ID))
            {
                if ($fps_image_full_size == '0')
                {
                    $post_details[$key]['post_img_src'] = wp_get_attachment_image_src( get_post_thumbnail_id($val->ID), 'fps-post');
                }
                else
                {
                    $post_details[$key]['post_img_src'] = wp_get_attachment_image_src( get_post_thumbnail_id($val->ID), 'full');
                }
            }
            else
            {
                $post_details[$key]['post_img_src'][0] = '';
            }
        }

        // Generate list item for each post retrieved in queue
        for ( $i = 0; $i < $max_posts; $i++ )
        {
            $post_permalink = $post_details[$i]['post_permalink'];
            $post_title = $post_details[$i]['post_title'];
            $post_excerpt = $post_details[$i]['post_excerpt'];
            $post_img = $post_details[$i]['post_img_src'][0];


            $output .= '<li class="'.$li_classes.'" >';
                    $output .= '<div class="fps-image-div" >';
                        $output .= '<a href="'.$post_permalink.'">';
                            $output .= '<img class="fps-image" src="'.$post_img.'" />';
                        $output .= '</a>';
                    $output .= '</div>';


                    $output .= '<div class="fps-text">';
                        if ($post_display_title == '1')
                        {
                            $output .= '<a href="'.$post_permalink.'">';
                                $output .= '<p class="fps-title">'.$post_title.'</p>';
                            $output .= '</a>';
                        }
                        if ($post_display_excerpt == '1')
                        {
                            $output .= '<a href="'.$post_permalink.'">';
                                $output .= '<p class="fps-excerpt">'.$post_excerpt.'</p>';
                            $output .= '</a>';
                        }
                    $output .= '</div>';
                $output .= '</li>';
        }
        $output .= '</ul>';
        if ($post_arrow_position == 'sides' || $post_arrow_position == 'borderless')
        {
            $output .= '<div class="scrollFeaturedPostsRight"></div>';
        }

        if ($post_display_slidenumbers == '1' && $post_arrow_position != 'borderless')
        {
            // Populate fps-slideNumberList li classes based on admin options


            $output .= '<ul class="fps-slideNumberList">';
            $output .= '<li class="fps-selectedSlide" title="'.$post_details[0]['post_title'].'">1</li>';
            for ( $i = 2; $i <= count($recent_posts) && $i <= $max_posts; $i++ )
            {
                $output .= '<li title="'.$post_details[($i-1)]['post_title'].'">'.$i.'</li>';
            }

            $output .= '</ul>';
        }

        if ($post_arrow_position == 'below')
        {
            $output .= '<div class="scrollFeaturedPostsRight-below"></div>';
            $output .= '<div class="scrollFeaturedPostsLeft-below"></div>';            
        }


        if ($post_arrow_position != 'borderless')
        {
            $output .= '<div class="'.$bg_classes.'"></div>';    
        }
        
        $output .= '</div>'; // div#featured-posts-wrapper
    }
    else
    {
        $output = '';
    }

    return $output;
}

// Handle short code
function fps_shortcode_handler($atts)
{
    return fps_show($atts);
}

// Add the short code [fps]
add_shortcode('fps', 'fps_shortcode_handler');

?>