=== Pierre's Wordspew ===
Contributors: Pierre Sudarovich
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8UN6MHBCHSQTG
Tags: Chat, Shoutbox, Wordspew, Ajax, Spam
Requires at least: 2.5
Tested up to: 3.0.3
Stable tag: trunk

A plugin that creates a live shoutbox, using AJAX as a backend. Users can chat freely from your blog without refreshing the page!

== Description ==

The shoutbox add a chat functionality to your blog and permit to easily interact with your users/visitors. It uses the Fade Anything Technique for extra glamour.

Features:
--------
* Chat in real time with everyone,
* there's a lot of process to catch spams to help you to keep your box as clean as possible,
* you can activate/deactivate a sound alert when someone post in the shoutbox,
* you can delete in real time comment directly in the shoutbox,
* you can delete, edit, ban IP in the admin console of the shoutbox,
* you can add banned words by using the comment moderation field of WP,
* you can adapt the look of your shoutbox in the admin consol and/or in an external stylesheet,
* you can configure who will be able to see or use the shoutbox,
* you can add themes to your shoutbox,
* you can use gravatar,
* old messages will be archived (you can selectively choose who will be able to see the archives),
* everyone will be able to send privates messages to anyone,
* you'll can choose who will administrate the shoutbox,
* you can activate/deactivate a "captcha" to help to fight against spam,
* the shoutbox is actually available in 25 languages,
* tested and working on IE6, IE7, IE8, Firefox, Opera, Chrome, Safari,
* a lot of more things...


== Installation ==

1. Upload the folder `pierres-wordspew` to your `/wp-content/plugins/` directory,
2. Activate the plugin through the "Plugins" menu in WordPress,
3. Use the Widget interface to place the shoutbox where you want it. Otherwise, if you use an old version of WP (before 2.x) call the function (usually in sidebar.php) by this way : `<?php if(function_exists(jal_get_shoutbox)) { jal_get_shoutbox(); } ?>`
 

== Frequently Asked Questions ==

In some explanations, i ask to edit a php file. Be careful to edit them with a good editor like Notepad++ and open each file with the format "UTF-8 without BOM". By the way you'll skip problems with headers in your blogs

= I'd like to change the default sound - is this as simple as changing msg.mp3? =
Yes, all you have to do is to name your file as `msg.mp3`. Be careful with the size of your file (in ko), try to keep it as light as possible.


= My smileys have borders around them. How to remove them? =
Edit `css.php`, at line 61 you'll find : `#chatoutput .wp-smiley { vertical-align: middle; }` add border: none; like this : `#chatoutput .wp-smiley { vertical-align: middle; border: none; }` and tada : no more border


= My smileys are not showing in my shoutbox, what is the problem? =
Go to Options -> Writing and check : `Convert emoticons`...


= Since my last update, i have to reload the page to be able to see new comments in my shoutbox or i always get these messages : "Your IP address have been banned from this blog..." or "SPAMMER : I DON'T LIKE SPAM !!!". What did i do wrong? =
Nothing ! you just have to clear your browser cache (and tell to your regulars users to do the same).


= Does the shoutbox works with WP-MU? =
Yes, since the version 5.0 :)


= I'd like to get the shoutbox in my native language. How can i do that? =
Download the files of your native language. Adapt it, eventually, to your needs by using a PO file editor such as :
KBabel (Linux) should be available as a package for your Linux distribution, so install the package.
poEdit (Linux/Windows) available from http://www.poedit.net/.
Put the wordspew-xx_XX.mo file in the `lang` folder (under `pierres-wordspew`), the PO file is just here to generate the MO translation file...


= Ok, i've done what you explain above, but the shoutbox is still in english How to make it works? =
Open your `wp-config.php` file (at the root of your blog) and search for : `define ('WPLANG', 'xx_XX');` where xx_XX is your language. If this line doesn't exist add it in your file. Save your modifications and re-upload the wp-config on your server.


= I wanted to add the shoutbox to a "new page" instead of my sidebar. How can i do that? =
Create a template in your theme folder and name it Shoutbox for example. It should be like this if you use the WP default theme...
`    
<?php
    /*
    Template Name: ShoutBox
    */
    ?>

    <?php get_header(); ?>

    <div id="content" class="widecolumn">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="post" id="post-<?php the_ID(); ?>">
                <h2><?php the_title(); ?></h2>
                <div class="entrytext">
                     <?php the_content('Read more...'); ?>
                 </div>
                <div>
                <?php jal_get_shoutbox(); ?>
                </div>
            </div>
          <?php endwhile; endif; ?>
            <?php edit_post_link('<small>Edit</small>'); ?>
    </div>

    <?php get_footer(); ?>
`

Now create a new page name it as you want and choose "Shoutbox" as template for this page. You, now, have your shoutbox in a page.


= Ok, ok we talk about the shoutbox, but how to implement it in my blog? =
If you have WP 1.5.x edit your sidebar.php add this line where you want your shoutbox appears : `<?php if(function_exists(jal_get_shoutbox)) { jal_get_shoutbox(); } ?>`. If you have WP >= 2.x go to Theme -> Widgets drag and drop the shoutbox widget where you want it. You can change the title by editing the property of the shoutbox widget.


= There's no break between comments in my shoutbox. What can i do to resolve that weird (and ugly) display? =
Edit `css.php` at line 53 you'll find : `#chatoutput ul#outputList li { padding: 4px; margin: 0; color: #<?php echo $shout_opt['text_color']; ?>; background: none; font-size: 1em; list-style: none; min-height: <?php echo $shout_opt['avatar_size']; ?>px; }` add display: block; in it like this : `#chatoutput ul#outputList li { padding: 4px; margin: 0; color: #<?php echo $shout_opt['text_color']; ?>; background: none; font-size: 1em; list-style: none; min-height: <?php echo $shout_opt['avatar_size']; ?>px; display: block; }`


= How can i remove the upper left rounded corner from the shoutbox? =
Edit `css.php` line 32 you'll find : `-moz-border-radius : 14px 0px 0px 0px;` just comment this line by adding // in front of it.


= I've added some banned words in my blacklist but users still can use them. What is wrong? =
You have to put your banned words list in Comment Moderation List, NOT in Black list.


= The CSS doesn't get properly read with FIREFOX... Opera and IE works fine. What is the problem? =
if you use WP-PostRatings and the shoutbox you've got some incompatibility issues. So edit `postratings.php` and search for : `header('Content-Type: text/html; charset='.get_option('blog_charset').'');`. Comment this line and all will be ok.


== Screenshots ==

1. Shoutbox view.

2. Admin interface of the shoutbox.


== Changelog ==

= 6.1 =
* Added Greek translation thanks to [Harry Karayannis](http://gvrteam.gr/)

= 6.0 =
* **Security fix !!** and it concerns all older release, so please update your shoutbox with this release.
* Optimization of code for js and css parts. All dynamic datas are stored in php and all static in js and css files. it should optimize the loading time and response of the shoutbox.
* In `wordspew_archive.php` there were an old bug with the time shown with the `strftime` function. Corrected.
* The variable of the wordpress table prefix is not shown anymore (for security reason too).
* I merged the two files `ajax_shout.php` and `fade.php` in a unique `ajax_shout.js` so there will be less http requests and shorter responses times.
* **I wish to really thanks [Kevin Fernandez](http://www.howgeek.com/) who discover the security flaw.**

= 5.61 =
* Little correction on the new attribute `onclick` (for the resize of the shoutbox). I used `onClick` who does not validate as XHTML 1.0... Thanks to [xcopfly](http://xcopfly.com/) who informs me about the bug :).

= 5.60 =
* Added the possibility per user to dynamically adjust the height of the shoutbox (the defined size will be kept thanks to the use of a cookie).
* Correction of a little bug if the username have space(s) in it ; if the field get the focus then loose it, spaces were replaced by sign `+`.
* Latin script caraters can be now used in the "Username" field (before it shows no name).
* replacement of the two littles sounds icons (thanks to [runpokertour](http://www.runpokertour.com/)) by two cutest.
* Update of french and spanish translation.

= 5.55 =
* Sorry, I forget to set a variable... So, Admin have to set the captcha too. It's now corrected.

= 5.54 =
* **IMPORTANT !! the shoutbox requires, now, at least Wordpress 2.5.** I've clean the code and don't use anymore `version_compare` ; it's why the minimum version of WP is now 2.5 ;).

= 5.52 =
* Like some of you use security plugins who hide the value of the `$wp_version` variable, i've done some modifications on pages where I use `version_compare`. BTW you shouldn't have any problem with user nickname or smileys.

= 5.51 =
* Updated Danish translation. Thanks to [Henrik](http://troels-hansen.net/)

= 5.50 =
* Correction of some bugs.
* RSS feeds and Archives didn't show correctly : corrected.
* Due to the new level (0) of unregistered users in WP 3.x, the options to show the shoutbox, show the archives, use the shoutbox etc. didn't works anymore ; it's now corrected.

= 5.36 =
* Replacement of code `$html = implode('', file($_SERVER['DOCUMENT_ROOT']."/wp-config.php"));` who can cause errors if the blog is installed in a subfolder and not in the root folder.

= 5.35 =
* Correction of code to make it (normally ;)) fully compatible with WP 3.x (no more error during the install or the update process)
* correction in the code to show normal time since the last event in the shoutbox (before that, `40 years and six month` was shown),
* update of the url of my website

= 5.32 =
* Little correction in `widgetized.php` to produce XHTML conform code,
* update of the french translation.

= 5.3 =
* Compatibility with Wordpress version 3.x
* favor to the use of `define('WP_DEBUG', true);` some menage have been done in the code, so normally there will be no more warning message during the activation of the plugin under WP 3.x
* use of wp_register_sidebar_widget and wp_register_widget_control instead of register_sidebar_widget and register_widget_control so there no more backward compatibility with WP under 2.2 release. **IMPORTANT !!** Like i use this "new" call of `register_sidebar_widget` and `register_widget_control`, users will have to re-drop the shoutbox on their sidebars in the widget page of their blog ;)

= 5.2 =
* Added the possibility to totally deactivate the spam filters.

= 5.1 =
* Use of `version_compare` cleaner than `round($wp_version)`
* correction of a little bug in `wordspew-rss.php` where the variable `$theuser_nickname` was not correctly set.

= 5.0 =
* Wordpress-Mu Compatible !!
* Added the possibility to archive THEN delete ALL the messages from the shoutbox table by adding a new button in the admin interface,
* the list of archived messages are now directly accessible from the admin interface,
* added the possibility to manipulate archives from the admin interface (view or delete),
* removed the expiration delay from wordspew_archive.php (it was refreshed every 5 minutes before), now the data will always been fresh.

= 4.51 =
* Changed MSN to Bing to reflect the new name of Microsoft bot.

= 4.50 =
* Added the possibility to select precisely who will be able to **use** the shoutbox. Selected users will be able to see and participate to chat, other users will simply view the discussion.
* **TO ALL** : Think to verify **who is able to post messages in the shoutbox**, because in the update process, only "Subscribers" will be able to do it. You'll, perhaps, have to change it ;).

= 4.40 =
* Added Portuguese and Polish translations. Thanks to [eLias](http://www.jokerpt.com/) for Portuguese and [Kamil](http://blumare.pl/) for Polish :).
* You have now the possibility to empty the selected archive in the admin interface.
* You can use the shoutbox only on some pages, or on particulars sections. You can use this values: `@homepage`, `@frontpage`, `@pages`, `@single`, `@archives`, `@category`.
If you use one of this keyword without any "parameter" you'll use the "default" shoutbox (without any theme).
Otherwise, you can use 2 kinds of values to be more specific. `(linked)`, `(rubric)`.
If you use the term : `@pages(rubric)` It meens that you want to use a specific shoutbox for **ALL** pages.
If you use the term : `@pages(linked)` It meens that you want to use a specific shoutbox on **EACH** page.
You can use these 2 keywords with : `@pages`, `@single`, `@archives` (only rubric, here.) and `@category`.
Finally, if you want to use the shoutbox in a page template you've done by yourself, enter: `@page[The name of your page]`.

= 4.32 =
* (05 Oct 2009) - First Release.


== Upgrade Notice ==

= 6.0 =
This version fixes a security related bug. Please, upgrade immediately.
