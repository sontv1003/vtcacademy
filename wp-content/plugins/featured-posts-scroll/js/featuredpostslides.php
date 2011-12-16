<?php 
    header('content-type: application/x-javascript'); 
    define('WP_USE_THEMES', false);
    require_once((dirname(dirname(dirname(dirname(dirname( __FILE__ ) ) )))).'/wp-config.php');
?>

<?php
    $post_scroll_speed = get_option('fps_scroll_speed');
    $post_scroll_fadeInSpeed = get_option('fps_scroll_fadeInSpeed');
    $post_scroll_fadeOutSpeed = get_option('fps_scroll_fadeOutSpeed');
    $post_scroll_interval = get_option('fps_scroll_interval');
?>


var FeaturedPostsLib = this.FeaturedPostsLib || {};
FeaturedPostsLib.fps = FeaturedPostsLib.fps || {};

(function($j) {
    var type = 'none'; // Type of slider present (v1.0 only supports 'single')
    var fpg_animLocked = new Array(); // Lock object for animations
    var autoscrollInterval = new Array();

    /** Initialize jQuery based animations */
    FeaturedPostsLib.fps.init = function()
    {
        // determine if the single or triple flavor is in use
        if ($j('.fps-single').length != 0 && $j('.fps-single li').length > 1)
        {
            type = 'single';

            // hide all but first entry in featured posts list
            $j('.featured-posts-wrapper').each(function() {
               $j(this).find('.fps-text').slice(1).fadeOut();
               $j(this).find('ul.featured-posts li').slice(1).css('display','none');
            });      
        }

        // init animations
        initAutoscroll();

        // initialize the scroll and slide buttons
        initScrollButtons();
        initSlideNumbers();

        // release animation locks
        for (var i=1; i<=fpg_animLocked.length; i++)
        {
            fpg_animLocked[i-1] = false;
        }
    };


    /** Add click event handlers to scroll buttons */
    function initScrollButtons()
    {
        if (type != 'none')
        {
            $j('.scrollFeaturedPostsRight').each(function(index) {
                $j(this).click(function() {
                    if (fpg_animLocked[index] == false)
                    {
                        FeaturedPostsLib.fps.scrollFeaturedPosts(this, 'right', index);
                    }
                    clearInterval(autoscrollInterval[index]);
                });
            });

            $j('.scrollFeaturedPostsLeft').each(function(index) {
                $j(this).click(function() {
                    if (fpg_animLocked[index] == false)
                    {
                        FeaturedPostsLib.fps.scrollFeaturedPosts(this, 'left', index);
                    }
                    clearInterval(autoscrollInterval[index]);
                });
            });

            $j('.scrollFeaturedPostsRight-below').each(function(index) {
                $j(this).click(function() {
                    if (fpg_animLocked[index] == false)
                    {
                        FeaturedPostsLib.fps.scrollFeaturedPosts(this, 'right', index);
                    }
                    clearInterval(autoscrollInterval[index]);
                });
            });

            $j('.scrollFeaturedPostsLeft-below').each(function(index) {
                $j(this).click(function() {
                    if (fpg_animLocked[index] == false)
                    {
                        FeaturedPostsLib.fps.scrollFeaturedPosts(this, 'left', index);
                    }
                    clearInterval(autoscrollInterval[index]);
                });
            });
        }
        else
        {
            $j('.scrollFeaturedPostsRight').remove(); 
            $j('.scrollFeaturedPostsLeft').remove();
            $j('.featured-posts-wrapper ul').css('margin-left', '22px');
        }
    }


    function initSlideNumbers()
    {
        if (type != 'none')
        {
            $j('ul.fps-slideNumberList').each(function(index) {
                $j(this).children('li').click(function() {
                    if (fpg_animLocked[index] == false)
                    {
                        scrollToPost(this, index);
                    }
                    clearInterval(autoscrollInterval[index]);
                });
            });
        }
    }


    function initAutoscroll()
    {
        if (type != 'none')
        {
            $j('.featured-posts-wrapper').each(function(index) {
                fpg_animLocked[index] = true;
                if ($j(this).hasClass('fps-autoscroll'))
                {
                    if ($j('.featured-posts-wrapper').slice(index,index+1).children('.scrollFeaturedPostsRight').length > 0)
                    {
                        var callback = 
                            "FeaturedPostsLib.fps.scrollFeaturedPosts(jQuery('.featured-posts-wrapper').slice(" + 
                            index + "," + (index + 1) + ").children('.scrollFeaturedPostsRight'), 'right', " + index + ")";
                        autoscrollInterval[index] = setInterval(
                            callback, <?php echo $post_scroll_interval ?>);
                    }
                    else
                    {
                        var callback = 
                            "FeaturedPostsLib.fps.scrollFeaturedPosts(jQuery('.featured-posts-wrapper').slice(" + 
                            index + "," + (index + 1) + ").children('.scrollFeaturedPostsRight-below'), 'right', " + index + ")";
                        autoscrollInterval[index] = setInterval(
                            callback, <?php echo $post_scroll_interval ?>);
                    }
                }
            });
        }
    }


    function scrollToPost(slideButton, index)
    {
        if (!($j(slideButton).hasClass('fps-selectedSlide')))
        {
            // lock animations
            fpg_animLocked[index] = true;

            var currentItem = $j(slideButton).parent().siblings('ul.featured-posts').children('li:visible');

            // get the next item to display
            var nextItemIndex = parseInt($j(slideButton).text());
            
            var nextItem = $j(slideButton).parent().siblings('ul.featured-posts').children('li').eq(nextItemIndex-1);

            setSelectedSlide(nextItem);
            animate(nextItem, currentItem, 'right', index)
        }
    }


    FeaturedPostsLib.fps.scrollFeaturedPosts = function(button, dir, index)
    {
        if (fpg_animLocked[index] != true)
        {
            // lock animations
            fpg_animLocked[index] = true;

            // get the currently displayed element(s)
            var currentItem = $j(button).siblings('ul.featured-posts').children('li:visible');

            var nextItem;

            if (type == 'single')
            {        
                if (dir == 'right')
                {
                    nextItem = currentItem.next();

                    if (nextItem.length == 0)
                    {
                        nextItem = currentItem.siblings().first();
                    }
                }
                else if (dir == 'left')
                {
                    nextItem = currentItem.prev();

                    if (nextItem.length == 0)
                    {
                        nextItem = currentItem.siblings().last();
                    }
                }
            }

            setSelectedSlide(nextItem);
            animate(nextItem, currentItem, dir, index);
        }
    };


    function setSelectedSlide(toShow)
    {
        // Remove class from current slide
        $j(toShow).parent().siblings('ul.fps-slideNumberList').children('li.fps-selectedSlide').removeClass('fps-selectedSlide');

        // Get the index of the next item to be displayed
        var nextSlideIndex = (($j(toShow).index()));

        $j(toShow).parent().siblings('ul.fps-slideNumberList').children('li').eq(nextSlideIndex).addClass('fps-selectedSlide');
    }


    function animate(toShow, toHide, dir, index)
    {
        var shownWidth = toHide.width();

        // fade out text on currently displayed item
        $j(toHide).find('.fps-text').fadeOut(<?php echo $post_scroll_fadeOutSpeed ?>, function() {
            // Make new item visible.
            toShow.css('display','');

            // Position the elements to animate based on direction
            if (dir == 'right')
            {
                toShow.css({float:'right'});
                toShow.css({width:'0px'});
                toHide.css({float:'left'});
            }
            else
            {
                toShow.css({float:'left'});
                toShow.css({width:'0px'});
                toHide.css({float:'right'});
            }

            toHide.animate({width:'0px'}, <?php echo $post_scroll_speed ?>, function() {
                toHide.css('display','none');
                toHide.css('width','');
                toShow.css('float','');
                toHide.css('float','');
                $j(toShow).find('.fps-text').fadeIn(<?php echo $post_scroll_fadeInSpeed ?>, function() {
                    fpg_animLocked[index] = false;
                });
            });

            toShow.animate({width: shownWidth},<?php echo $post_scroll_speed ?>);
        });
    }

}(jQuery))

jQuery(document).ready(FeaturedPostsLib.fps.init);