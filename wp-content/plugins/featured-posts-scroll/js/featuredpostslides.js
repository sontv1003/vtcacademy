/* featuredpostslides.js */

var type = 'none'; // Type of slider present (v1.0 only supports 'single')
var animationLocked = false; // Lock object for animations
var autoscrollInterval = new Array();
var $j = jQuery.noConflict(); // Prevent jQuery conflicts

/** Initialize jQuery based animations */
function init()
{
    // lock animations while initializing
    animationLocked = true;

    // calculate the height of each item's text
    $j('.fps-text').each(function() {
        var myHeight = $j(this).children('.fps-title').height();
        myHeight += $j(this).children('.fps-excerpt').height();
        myHeight += 6; // padding

        var containerHeight = $j(this).parent().height();
        containerHeight -= myHeight;

        $j(this).height(myHeight);
        $j(this).css('margin-top',containerHeight);
    });

    // determine if the single or triple flavor is in use
    if ($j('.fps-single').length != 0 && $j('.fps-single a li').length > 1)
    {
        type = 'single'

        // hide all but first entry in featured posts list
        $j('.featured-posts-wrapper').each(function() {
           $j(this).find('.fps-text').slice(1).fadeOut();
           $j(this).find('ul.featured-posts a li').slice(1).css('display','none');
        });      
    }
    else if ($j('.fps-triple').length != 0 && $j('ul.fps-triple a li').length > 3)
    {
        type = 'triple'

        // hide all but first three entries in featured posts list
        $j('.fps-text').slice(3).fadeOut();
        $j('.featured-posts-wrapper ul a li').slice(3).css('display','none');        
    }

    // initialize the scroll buttons and autoscroll
    initScrollButtons();
    initSlideNumbers();
    initAutoscroll();

    animationLocked = false;
}

/** Add click event handlers to scroll buttons */
function initScrollButtons()
{
    if (type != 'none')
    {
        $j('.scrollFeaturedPostsRight').each(function(index) {
            $j(this).click(function() {
                if (animationLocked == false)
                {
                    scrollFeaturedPosts(this, 'right');
                }
                clearInterval(autoscrollInterval[index]);
            });
        });

        $j('.scrollFeaturedPostsLeft').each(function(index) {
            $j(this).click(function() {
                if (animationLocked == false)
                {
                    scrollFeaturedPosts(this, 'left');
                }
                clearInterval(autoscrollInterval[index]);
            });
        });

        $j('.scrollFeaturedPostsRight-below').each(function(index) {
            $j(this).click(function() {
                if (animationLocked == false)
                {
                    scrollFeaturedPosts(this, 'right');
                }
                clearInterval(autoscrollInterval[index]);
            });
        });

        $j('.scrollFeaturedPostsLeft-below').each(function(index) {
            $j(this).click(function() {
                if (animationLocked == false)
                {
                    scrollFeaturedPosts(this, 'left');
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
                if (animationLocked == false)
                {
                    scrollToPost(this);
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
            if ($j(this).hasClass('fps-autoscroll'))
            {
                if ($j('.featured-posts-wrapper').slice(index,index+1).children('.scrollFeaturedPostsRight').length > 0)
                {
                    var callback = 
                        "scrollFeaturedPosts($j('.featured-posts-wrapper').slice(" + 
                        index + "," + (index + 1) + ").children('.scrollFeaturedPostsRight'), 'right')";
                    autoscrollInterval[index] = setInterval(
                        callback, 7000);
                }
                else
                {
                    var callback = 
                        "scrollFeaturedPosts($j('.featured-posts-wrapper').slice(" + 
                        index + "," + (index + 1) + ").children('.scrollFeaturedPostsRight-below'), 'right')";
                    autoscrollInterval[index] = setInterval(
                        callback, 7000);
                }
            }
        });
    }
}

function scrollToPost(slideButton)
{
    if (!($j(slideButton).hasClass('fps-selectedSlide')))
    {
        // lock animations
        animationLocked = true;

        // get the currently displayed element(s)
        var currentItem = $j(slideButton).parent().siblings('ul.featured-posts').children().children('li:visible');

        // get the next item to display
        var nextItemIndex = parseInt($j(slideButton).text());
        
        var nextItem = $j(slideButton).parent().siblings('ul.featured-posts').children().children('li').eq(nextItemIndex-1);

        setSelectedSlide(nextItem);
        animate(nextItem, currentItem, 'right')
    }
}

function scrollFeaturedPosts(button, dir)
{
    if (animationLocked != true)
    {
        // lock animations
        animationLocked = true;

        // get the currently displayed element(s)
        var currentItem = $j(button).siblings('ul.featured-posts').children().children('li:visible');

        if ($j(currentItem).length == 0)
        {
            currentItem = $j(button).siblings('ul.featured-posts').children('a:first').children('li');
        }

        var nextItem;

        if (type == 'single')
        {        
            if (dir == 'right')
            {
                nextItem = currentItem.parent().next().children('li');
                if (nextItem.length == 0)
                {
                    nextItem = currentItem.parent().siblings().first().children('li');
                }
            }
            else if (dir == 'left')
            {
                nextItem = currentItem.parent().prev().children('li');
                if (nextItem.length == 0)
                {
                    nextItem = currentItem.parent().siblings().last().children('li');
                }
            }
        }
        else
        {
            if (dir == 'right')
            {
                nextItem = currentItem.last().nextAll();
                if (nextItem.length > 3)
                {
                    nextItem = nextItem.slice(0,3);
                }
                else if (nextItem.length < 3)
                {
                    currentItem.siblings().first().appendTo($j('.featured-posts-wrapper ul'));

                    if (nextItem.length < 2)
                    {
                        currentItem.siblings().first().appendTo($j('.featured-posts-wrapper ul'));
                    }

                    if (nextItem.length < 1)
                    {
                        currentItem.siblings().first().appendTo($j('.featured-posts-wrapper ul'));
                    }

                    nextItem = currentItem.last().nextAll();
                }
            }
            else if (dir == 'left')
            {
                nextItem = currentItem.last().prevAll();
                if (nextItem.length > 3)
                {
                    nextItem = nextItem.slice(-3);
                }
                else if (nextItem.length < 3)
                {
                    currentItem.siblings().last().prependTo($j('.featured-posts-wrapper ul'));

                    if (nextItem.length < 2)
                    {
                        currentItem.siblings().last().prependTo($j('.featured-posts-wrapper ul'));
                    }

                    if (nextItem.length < 1)
                    {
                        currentItem.siblings().last().prependTo($j('.featured-posts-wrapper ul'));
                    }

                    nextItem = currentItem.last().prevAll();
                }
            }
        }

        setSelectedSlide(nextItem);
        animate(nextItem, currentItem, dir);
    }
}

function setSelectedSlide(toShow)
{
    // Remove class from current slide
    $j(toShow).parent().parent().siblings('ul.fps-slideNumberList').children('li.fps-selectedSlide').removeClass('fps-selectedSlide');

    // Get the index of the next item to be displayed
    var nextSlideIndex = $j(toShow).parent().index();

    $j(toShow).parent().parent().siblings('ul.fps-slideNumberList').children('li').eq(nextSlideIndex).addClass('fps-selectedSlide');
}

function animate(toShow, toHide, dir)
{
    var shownWidth = toHide.width();

    // fade out text on currently displayed item
    $j(toHide).find('.fps-text').fadeOut(100, function() {
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

        toHide.animate({width:'0px'}, 1000, function() {
            toHide.css('display','none');
            toHide.css('width','');
            toShow.css('float','');
            toHide.css('float','');
            $j(toShow).find('.fps-text').fadeIn(200, function() {
                animationLocked = false;
            });
        });

        toShow.animate({width: shownWidth},1000);
    });
}

jQuery(document).ready(init);