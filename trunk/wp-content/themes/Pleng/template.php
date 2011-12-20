<?php
/**
* Template Name: Ho tro truc tuyen
*/



if(!isset($hide_header) OR !$hide_header)
{
	get_header();
}

if(!isset($hide_header) OR !$hide_header)
{
?>

		<br class="clear"/>

		<div class="<?php echo $caption_class?>">
				<div class="caption_inner">
					<?php
						$page_desc = get_post_meta($current_page_id, 'page_desc', true);

						switch($caption_style)
						{
							case 'Description Only':

							if(!empty($page_desc))
							{
					?>

						<div class="caption_header">
							<h2 class="cufon"><?php echo $page_desc; ?></h2>
						</div>
					<?php
							}
							break;

							case 'Title Only':
					?>
						<div class="caption_header">
							<h1 class="cufon"><?php the_title(); ?></h1>
						</div>
					<?php
							break;

							case 'Title & Description':
					?>
						<div class="caption_header">
							<h1 class="cufon"><?php the_title(); ?></h1>
						</div>
						<div class="caption_desc">
							<?php echo $page_desc; ?>
						</div>
					<?php
							break;
						}
					?>
					<br class="clear"/>
				</div>
			</div>

		<div class="home_boxes_footer"></div>

		<!-- Begin content -->
		<div id="content_wrapper">

			<div class="line_shadow">&nbsp;</div>

			<div class="breadcrumbs"><div class="inner"><?php if(!$is_front_page) { echo pp_breadcrumbs(); } ?></div></div>

			<div class="inner">

				<!-- Begin main content -->
				<div class="inner_wrapper">
                                    <div class="template_shoutbox">
<?php dynamic_sidebar('Chatbox'); ?>


                                        
                                       
                                    </div>
                                    <div class="template_lienhe">
                                  <?php dynamic_sidebar('Blog Sidebar'); ?>
                                    </div>
<?php
}
?>

					<?php
						if($add_sidebar && $page_style == 'Left Sidebar')
						{
					?>
						<div class="sidebar_wrapper <?php echo $sidebar_class; ?>">

							<div class="sidebar_top <?php echo $sidebar_class; ?>"></div>

							<div class="sidebar <?php echo $sidebar_class; ?> <?php echo $sidebar_home; ?>">

								<div class="content">
							 
									<ul class="sidebar_widget">
									<?php dynamic_sidebar($page_sidebar); ?>
									</ul>

								</div>

							</div>
							<br class="clear"/>

							<div class="sidebar_bottom <?php echo $sidebar_class; ?>"></div>
						</div>
					<?php
						}
					?>

					<?php if($add_sidebar) { ?>
						<div class="sidebar_content">
					<?php } ?>

					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

						<?php do_shortcode(the_content()); break;  ?>

					<?php endwhile; ?>

					<?php if($add_sidebar) { ?>
						</div>
					<?php } ?>

					<?php
						if($add_sidebar && $page_style == 'Right Sidebar')
						{
					?>

						<div class="sidebar_wrapper <?php echo $sidebar_class; ?>">

							<div class="sidebar_top <?php echo $sidebar_class; ?>"></div>

							<div class="sidebar <?php echo $sidebar_class; ?> <?php echo $sidebar_home; ?>">

								<div class="content">

									<ul class="sidebar_widget">
									<?php dynamic_sidebar($page_sidebar); ?>
									</ul>

								</div>

							</div>
							<br class="clear"/>

							<div class="sidebar_bottom <?php echo $sidebar_class; ?>"></div>
						</div>
					<?php
						}
					?>

				</div>
				<!-- End main content -->

				<br class="clear"/>
			</div>

<?php
if(!isset($hide_header) OR !$hide_header OR is_null($hide_header))
{
?>
		</div>
		<!-- End content -->


<?php get_footer(); ?>

<?php
}
?>