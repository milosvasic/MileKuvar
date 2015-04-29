<?php
/**
 * Template Name: Blog
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

<?php
$pp_blog_slideshow = get_option('pp_blog_slideshow');
$pp_blog_slideshow_cat = get_option('pp_blog_slideshow_cat');

if(!empty($pp_blog_slideshow) && !empty($pp_blog_slideshow_cat))
{
	$blog_items = -1;

	$args = array( 
		'post_type' => 'attachment', 
		'numberposts' => $blog_items, 
		'post_status' => null, 
		'post_parent' => $pp_blog_slideshow_cat,
		'order' => 'ASC',
		'orderly' => 'menu_order',
	); 
	$all_photo_arr = get_posts( $args );
?>

<?php
$initial_image = $all_photo_arr[0]->guid;

?>

<?php 
if(!isset($hide_header) OR !$hide_header)
{
?>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/supersized.3.1.3.min.js"></script>
		
		<script type="text/javascript">  
			
			jQuery(function($){
				$.supersized({
				
					//Functionality
					slideshow               :   1,		//Slideshow on/off
					autoplay				:	1,		//Slideshow starts playing automatically
					start_slide             :   1,		//Start slide (0 is random)
					random					: 	0,		//Randomize slide order (Ignores start slide)
					<?php						
						$pp_blog_slider_timer = get_option('pp_blog_slider_timer');
						
						if(empty($pp_blog_slider_timer))
						{
							$pp_blog_slider_timer = 5;
						}
						$pp_blog_slider_timer = $pp_blog_slider_timer*1000;
					?>
					slide_interval          :   <?php echo $pp_blog_slider_timer; ?>,	//Length between transitions
					<?php						
						$pp_blog_slideshow_trans = get_option('pp_blog_slideshow_trans');
						
						if(empty($pp_blog_slideshow_trans))
						{
							$pp_blog_slideshow_trans = 6;
						}
					?>
					transition              :   <?php echo $pp_blog_slideshow_trans; ?>, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	500,	//Speed of transition
					new_window				:	1,		//Image links open in new window/tab
					pause_hover             :   0,		//Pause slideshow on hover
					keyboard_nav            :   1,		//Keyboard navigation on/off
					performance				:	1,		//0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	0,		//Disables image dragging and right click with Javascript
					image_path				:	'img/', //Default image path

					//Size & Position
					min_width		        :   0,		//Min width allowed (in pixels)
					min_height		        :   0,		//Min height allowed (in pixels)
					vertical_center         :   1,		//Vertically center background
					horizontal_center       :   1,		//Horizontally center background
					fit_portrait         	:   0,		//Portrait images will not exceed browser height
					fit_landscape			:   0,		//Landscape images will not exceed browser width
					
					//Components
					navigation              :   1,		//Slideshow controls on/off
					thumbnail_navigation    :   0,		//Thumbnail navigation
					slide_counter           :   0,		//Display slide numbers
					slide_captions          :   1,		//Slide caption (Pull from "title" in slides array)
					slides 					:  	[		//Slideshow Images
														  
	

		<?php
			foreach($all_photo_arr as $key => $photo)
			{
			    $small_image_url = get_stylesheet_directory_uri().'/images/000_70.png';
			    $hyperlink_url = get_permalink($photo->ID);
			    
			    if(!empty($photo->guid))
			    {
			    	$image_url[0] = $photo->guid;
			    
			    	$small_image_url = get_stylesheet_directory_uri().'/timthumb.php?src='.$image_url[0].'&amp;h=50&amp;w=50&amp;zc=1';
			    }

		?>

        	<?php $homeslides .= '{image : \''.$image_url[0].'\', title: "'.$photo->post_title.'<br/><div class=\"slide_info\">'.$photo->post_content.'</div>"},'; ?>
        	
        <?php
        	}
        ?>

						<?php $homeslides = substr($homeslides,0,-1);
						echo $homeslides; ?>						]
												
				}); 
		    });
		    
		</script>
		

		<!--Arrow Navigation--> 
		<a id="prevslide" class="load-item"></a> 
		<a id="nextslide" class="load-item"></a>
		
		<?php						
		    $pp_display_full_desc = get_option('pp_display_full_desc');
		    
		    if(!empty($pp_display_full_desc))
		    {
		?>
			<!--Slide captions displayed here--> 
			<div id="slidecaption"></div>
		<?php
			}
		?>

<?php
} // End if blog as slideshow
else
{
?>

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
		
		<div id="supersized-loader" style="display: none; "></div>

<?php	
} // End if blog as static image

} // End if not hide header
?>

<?php 
if(!isset($hide_header) OR !$hide_header)
{
?>
<a href="javascript:;" data-rel="#homepage_wrapper" id="expand_button">
	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon_arrow_right.png" alt=""/>
</a>

<div id="homepage_wrapper">
	<div class="close_button">
		<a href="javascript:;" data-rel="#homepage_wrapper" id="close_button">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close_button.png" alt=""/>
		</a>
	</div>
	<div class="inner">
	
		<!-- Begin content -->
		<div id="page_content_wrapper">
			
			<div class="inner">

				<!-- Begin main content -->
				<div class="inner_wrapper">

					<div class="sidebar_content">
					
						<h1 class="page_header"><?php _e( 'Blog', THEMEDOMAIN ); ?></h1>
<?php
}
?>
					
<?php

global $more; $more = false; # some wordpress wtf logic

$query_string ="post_type=post&paged=$paged";

query_posts($query_string);

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
								<iframe class="facebook_button" src="//www.facebook.com/plugins/like.php?app_id=262802827073639&amp;href=<?php echo urlencode(get_permalink()); ?>&amp;send=false&amp;layout=box_count&amp;width=200&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:60px; height:90px;" allowTransparency="true"></iframe>
								
								<a href="https://twitter.com/share" data-text="<?php the_title(); ?>" data-url="<?php echo get_permalink(); ?>" class="twitter-share-button" data-count="vertical">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
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

<?php 
if(!isset($hide_header) OR !$hide_header)
{
?>				
					</div>
					
				</div>
				<!-- End main content -->
				
			</div>
			
		</div>
		<!-- End content -->
		<br class="clear"/><br/>

	<?php get_footer(); ?>

<?php
}
?>