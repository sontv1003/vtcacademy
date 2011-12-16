=== Plugin Name ===
Contributors: Indra Prasetya
Donate link: http://socialenemy.com/2009/06/simple-wordpress-ajax-shoutbox/
Tags: ajax, comments, widget
Requires at least: 2.6.0
Tested up to: 2.8.4
Stable tag: 1.2.3

Simple AJAX shoutbox, add shoutbox on your sidebar.

== Description ==

This plugin will add a shoutbox on your sidebar. Using AJAX technology so visitor doesnt have to refresh page to view their messages. It automatically reload every few seconds so you can see other visitor messages live. It has simple design, so it will blend to your current theme whatever it is. No extra graphics, color, text. Just a simple box. Support smilies, smilies tags are instantly converted to graphics smilies.

Note: Template must widget ready!

Still need work:
1. Javascript crash, causing shoutbox only show blank screen.

== Installation ==

1. Upload `ajax-shoutbox` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Enable it on sidebar from admin widget manager (Appearance->Widgets).

== Frequently Asked Questions ==

= Where can i delete the message? =

Log in as admin and delete directly from messagebox. You should find a delete link there.

= Where can i found configuration for this plugin? =

You can find all of it on widget manager (Appearance->Widgets).

== Screenshots ==

1. Shoutbox on sidebar
2. Widget configuration

== Changelog ==

= 1.0 =
* New plugin published.

= 1.1 =
* Fix path.

= 1.2 =
* Fix image not shown.

= 1.2.1 =
* Added HTML enable/disable for security issue.
* Language support.

= 1.2.2 =
* Akismet support for spam checking.
* Tweak AJAX process, more efficient.
* Add only registered user allowed to post.

= 1.2.3 =
* Change registered user login into display name.
* Fix compatibility with jquery 1.3.2 and IE.
* Few cosmetic changes.