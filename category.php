<?php
/**
 * The main template file for display blog page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

if(!isset($hide_header) OR !$hide_header)
{
	get_header(); 
}

?>

<script type="text/javascript"> 
$j('.nav li').not(".blog, .menu-item-type-custom, .menu-item-object-post, .menu-item-object-category, .menu-item-object-post_tag").each(function()
{
	current_url = $j(this).children('a').attr('href');
	$j(this).children('a').attr('href', $j('#home_url').attr('value')+'#'+$j(this).attr('id'));
	$j(this).children('a').attr('rel', current_url);
});

$j('.nav li').not(".blog, .menu-item-type-custom").children('a').click(function(){
	location.href = $j(this).attr('href');
	return false;
});

$j(document).ready(function(){ $j('#map_contact').css('display', 'none'); });
</script>

<a href="javascript:;" rel="#homepage_wrapper" id="expand_button">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon_arrow_right.png" alt=""/>
</a>

<div id="homepage_wrapper">
	<div class="close_button">
		<a href="javascript:;" rel="#homepage_wrapper" id="close_button">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close_button.png" alt=""/>
		</a>
	</div>
	<div class="inner">
		<?php
			$pp_blog_bg = get_option('pp_blog_bg'); 
			
			if(empty($pp_blog_bg))
			{
				$pp_blog_bg = '/example/bg.jpg';
			}
			else
			{
				$pp_blog_bg = '/data/'.$pp_blog_bg;
			}
		?>
		<script type="text/javascript"> 
			jQuery.backstretch( "<?php echo get_stylesheet_directory_uri().$pp_blog_bg; ?>", {speed: 'slow'} );
		</script>
	
		<!-- Begin content -->
		<div id="page_content_wrapper">
			
			<div class="inner">

				<!-- Begin main content -->
				<div class="inner_wrapper">

					<div class="sidebar_content">
					
						<h1 class="page_header"><?php
							printf( __( ' %s', '' ), '' . single_cat_title( '', false ) . '' );
						?></h1>
					
<?php

global $more; $more = false; # some wordpress wtf logic

if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = '';
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	    
	    
	  	$pp_blog_image_width = 490;
		$pp_blog_image_height = 240;
	}
?>
						
						
						<!-- Begin each blog post -->
						<div class="post_wrapper">
						
							<?php
								if(!empty($image_thumb))
								{
							?>
							
							<div class="post_img img_shadow_536" style="width:<?php echo $pp_blog_image_width+10; ?>px;height:<?php echo $pp_blog_image_height+20; ?>px">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
									<img src="<?php echo get_stylesheet_directory_uri(); ?>/timthumb.php?src=<?php echo $image_thumb[0]; ?>&amp;h=<?php echo $pp_blog_image_height; ?>&amp;w=<?php echo $pp_blog_image_width; ?>&amp;zc=1" alt="" class="frame img_nofade" width="<?php echo $pp_blog_image_width; ?>" height="<?php echo $pp_blog_image_height; ?>"/>
								</a>
							</div>
							
							<?php
								}
							?>
							
							<div class="post_header">
								<div class="post_header_h3">
									<h3 class="cufon">
										<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
									</h3>
								</div>
								<br class="clear"/>
								
								<div class="post_detail">
								
									<?php echo _e( 'Posted by', THEMEDOMAIN ); ?> <?php echo get_the_author(); ?> on <?php echo get_the_time('d M Y'); ?> /
									<a href=""><?php comments_number('0 Comment', '1 Comment', '% Comments'); ?></a>
								</div>
							</div>
							
							<div class="post_social">
								<iframe class="facebook_button" src="//www.facebook.com/plugins/like.php?app_id=262802827073639&amp;href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=box_count&amp;width=200&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:60px; height:90px;" allowTransparency="true" style="float:left;"></iframe>
								
								<a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="ipeerapong" style="float:left;">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
							</div>
							
							<br class="clear"/><br/><hr/>
							
							<?php
								$pp_blog_display_full = get_option('pp_blog_display_full');
								
								if(!empty($pp_blog_display_full))
								{
									the_content();
								}
								else
								{
									the_excerpt();
							?>
							
									<br/><br/>
									<a href="<?php the_permalink(); ?>"><?php echo _e( 'Read more', THEMEDOMAIN ); ?> →</a>
							
							<?php
								}
							?>
							
						</div>
						<!-- End each blog post -->
						



<?php endwhile; endif; ?>

						<div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
						
					</div>
					
				</div>
				<!-- End main content -->
				
			</div>
			<br class="clear"/>
			
		</div>
		<!-- End content -->
		<br class="clear"/><br/>
		
	</div>
				

<?php get_footer(); ?>