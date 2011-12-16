=== Featured Posts Scroll ===
Contributors: Chaser324
Donate link: http://bit.ly/ouu3IA
Author URI: http://chasepettit.com/
Plugin URI: http://chasepettit.com/2011/03/featured-posts-scroll/
Tags: posts, scroll, slider, featured, featured post, featured posts, recent post, recent posts
Requires at least: 2.9.1
Tested up to: 3.2
Stable tag: 1.22

A basic javascript based scrolling display of post titles and thumbnails.

== Description ==

[Live Demo](http://chasepettit.com/2011/03/featured-posts-scroll/)
[More Info](http://chasepettit.com/2011/03/featured-posts-scroll/)
[Comments/Suggestions](http://chasepettit.com/2011/03/featured-posts-scroll/)
[About Author](http://chasepettit.com/about/)

This will scroll a set of posts (either automatically or via user click) in any desired location within a template or a post.
The appearance is highly customizable via the admin options menu (colors, drop shadows, rounded corners, & more).

If there are any additional features or bug fixes you would like to see in future versions, feel free to contact me.

If you find this plugin useful please remember to rate it and comment.      

== Installation ==

= Installation =

* Use the built-in WordPress plugin installer.

   OR

* Download the zip file and extract the contents.
   Upload the 'featured-posts-scroll' folder to your plugins directory (wp-content/plugins/).
* Activate the plugin through the WordPress 'Plugins' menu.
* Recommendation: Refer to "How to Use" and "FAQ" for useful info.

= How to Use =

To use this plugin to display the most recent posts in any category and with any tag:

* Copy and paste the code below to your desired template location:
<code><?php if (function_exists('fps_show')) { echo fps_show(NULL); } ?></code>

If you would like to customize what posts are displayed:

* Copy and paste the code below to your desired template location:
<code><?php if (function_exists('fps_show')) {
            $args = array(
                'cat'     => '',/* comma separated list of category ids to include (put '-' in front of ids to exclude) */
                'tag'     => '' /* comma separated list tag slugs to include */);
            echo fps_show($args);
        }?></code>
* Modify the '$args' array to filter out only the posts that you would like displayed. Delete any entries in the array you don't want to use (be careful with the commas. See here(http://codex.wordpress.org/Function_Reference/WP_Query#Parameters) for more details on all valid query parameters. Contact me if you have any questions about getting just the posts that you want.
* Recommendation: Create a new 'featured' tag and put it on the posts that you want to displayed and add that category's slug to the array in the code above.

If you would like to display the featured posts scroll inside of a post:

* Insert the following shortcode in your post:
<code>[fps]</code>
* Arguments can also be used with the shortcode to specify posts to display:
<code>[fps cat="-3" tag="featured"]</code>



== Frequently Asked Questions ==

= FAQ =

= Where do the images displayed come from? =
Images are based on the "Featured Image" selected on the Edit Post screen. If the option is not displayed, click Screen Options in the top right of the Edit Post screen and check the "Featured Image" checkbox.

= I changed the size of the post scroll, but my images didn't change size. What do I need to do? =
Any new image added to your site should have a thumbnail created in the correct new size. However, the old thumbnails will need to be regenerated. This can be done for all images on your site with the excellent ["Regenerate Thumbnails" plugin](http://wordpress.org/extend/plugins/regenerate-thumbnails/).

= What guidelines should I use when creating custom arrow images? =
The easiest way to figure this out is just to look at the images included with the plugin (wp-content/plugins/featured-posts-scroll/images), and format your images in the same basic manner. For the default arrow position (sides of the image), the arrow image should be 46x100. For the alternate arrow position at the bottom of the scroll, the arrow image should be 48x48. For the "no border" position, the arrow image should be 70x120.

For any configuration, the image should be split into four evenly sized quadrants. The top row is left/right arrows as they normally appear and the bottom row are the arrows as they appear when hovered over. The left column should be arrows pointing left, and the right column should be arrows pointing right.

== Screenshots ==

1. Admin Screen
2. Appearance Customization
3. New Features: Slide Numbers, Alternate Arrow Position, Custom Sizing
4. New in Release 1.13: Borderless Arrow Position, Drop Shadow Spread Parameter

== Changelog ==

= 1.22 =
* Fixed autoscrolling. (Corrected jQuery reference in autoscroll callback function)

= 1.21 =
* Refactored JavaScript to prevent causing issues with plugins that assume "$" references jQuery.

= 1.20 =
* Fixed slide numbers.

= 1.19 =
* Fixed issue where autoscrolling would only work on one instance of a scroll at any one time.

= 1.18 =
* Fixed auto-scrolling when arrows are at side positions.

= 1.17 =
* Added option to always use the full size image instead of generated thumbnails.
* Fixed IE 6/7 support.
* Fixed original arrow position support.

= 1.16 =
* Implemented tabbed admin page.

= 1.15 =
* Corrected labeling of "Crop Mode" option and made it the default option.

= 1.14 =
* Added admin option for image background color.
* Fixed bug where bg didn't appear behind arrows in bottom position when slide numbers were not also selected.
* Added some admin options for controlling image scaling/cropping.

= 1.13 =
* Added "Spread" parameter for drop shadows.
* Added new "No Border" arrow position. Note that Slide Numbers are not currently available with this configuration.

= 1.12 =
* Added user-defined auto-scroll interval, scroll speed, text fade in/out times.
* Fixed some issues in versions of Firefox prior to 4.0 (broken scrolling, inconsistent text colors).
* Addressed image tiling issue. Images now get centered in view if not large enough. Next version will have user specified background color.
* Corrected minor admin page issues (typos).

= 1.11 =
* Modified link formatting to enable the ability for the user to open links in alternate tab/window.
* Added shortcode argument support.
* Removed bold/italic options for slide numbers.
* Added several font options for customizing appearnace of all plugin text.
* Corrected issue with heading text not displaying (bug introduced in 1.10).

= 1.10 =
* Reorganized admin page. Attempted to make arrangement more logical and remove clutter.
* Removed <style> elements from generated HTML. An external stylesheet is now generated based on admin options.
* Addressed issue where title/excerpt could overflow container by ten pixels.
* Addressed issue where title/excerpt would initially appear in a default position potentially in the middle of the post image.
* Created separate settings for inner/outer box corner radii and drop shadows.
* Removed drop-shadow and rounded-corners enable/disable settings. Disabling these features is now done by changing all related settings to zero.

= 1.9 =
* Added alternate arrow location under main image.
* Added options for displaying slide numbers under main image.
* Added option to allow user to use their own custom arrow image.
* Corrected an issue with right margin introduced by custom height/width code.
* Other minor bug fixes.

= 1.8 =
* User specified height/width.

= 1.7 =
* Addressed issues caused by IE7 float bugs.
* When text background alpha is set to "1.0", specify color in standard hex format rather than newer rgba format which is not compatible with older browswers.

= 1.6 =
* Minor CSS corrections.

= 1.4 =
* Added capability to have multiple instances of the Featured Posts Scroll.

= 1.3 =
* Corrected issue with title/excerpt underlining in Chrome.
* Corrected issue where scrolling didn't work in Firefox versions prior to 4.0.
* Accounted for bug in non-webkit browsers where nested elements clip rounded borders.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.22 =
* Fixed autoscrolling. (Corrected jQuery reference in autoscroll callback function)
