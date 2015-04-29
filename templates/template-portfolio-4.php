<?php
/**
 * The main template file for display portfolio page.
 *
 * @package WordPress
 */

/**
*	Get all photos
**/ 

session_start();
$menu_sets_query = '';

$portfolio_items = -1;

$args = array( 
	'post_type' => 'attachment', 
	'numberposts' => $portfolio_items, 
	'post_status' => null, 
	'post_parent' => $post->ID,
	'order' => 'ASC',
	'orderby' => 'menu_order',
); 
$all_photo_arr = get_posts( $args );

?>
<script type="text/javascript"> 
$j(function() { $j('#map_contact').css('visibility', 'hidden'); });
$j(document).ready(function(){ 
	setTimeout(function() {
    	$j('#homepage_wrapper').animate({width: 'toggle'},{
			duration: 500,
		    complete: function() {
		    	$j('#homepage_wrapper').fadeIn();
		    	$j('#homepage_wrapper').children('.inner').fadeIn('slow');
		    	$j('#corner_right').css('display', 'block');
		    	$j('#corner_right_bottom').css('display', 'block');
		    	$j('#slidecaption').css('visibility', 'visible');
		    	$j('#supersized-loader').css({display: 'none'});
    	    }
		});
    }, 2000);
});
</script>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/screen.css" type="text/css" media="screen" />
<?php
if(isset($_SESSION['pp_skin']))
{
    $pp_skin = $_SESSION['pp_skin'];
}
else
{
    $pp_skin = get_option('pp_skin');
}

if($pp_skin == 'dark')
{
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/dark.css" type="text/css" media="screen" />
<?php
}
elseif($pp_skin == 'transparent')
	{
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/transparent.css" type="text/css" media="screen" />
<?php
	}
?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/custom.js"></script>
		
		<?php
			if(!empty($all_photo_arr))
			{
		?>
		
		<!-- Begin content -->
		<div id="page_content_wrapper">
			
			<?php
					$pp_gallery_width = 100;
					$pp_gallery_height = 100;
			?>
			
			<div class="inner">
		
				<div class="inner_wrapper">
				
				<div class="sidebar_content">
					<h1 class="page_header"><?php echo $post->post_title; ?></h1><hr/>
					
					<?php
						if(!empty($post->post_content))
						{
					?>
						<p><?php echo nl2br(stripslashes(html_entity_decode(do_shortcode($post->post_content)))); ?></p>
						<br/><br/>
					<?php
						}
					?>
				
				<?php
					foreach($all_photo_arr as $key => $photo)
					{
						$small_image_url = get_stylesheet_directory_uri().'/images/000_70.png';
						$hyperlink_url = get_permalink($photo->ID);
						
						if(!empty($photo->guid))
						{
							$image_url[0] = $photo->guid;
						
							$small_image_url = get_stylesheet_directory_uri().'/timthumb.php?src='.$image_url[0].'&amp;h='.$pp_gallery_height.'&amp;w='.$pp_gallery_width.'&amp;zc=1';
						}
						
						$last_class = '';
						if(($key+1)%4==0)
						{
							$last_class = 'last';
						}
				?>
				
				<div class="one_fourth <?php echo $last_class; ?>" style="margin-bottom:0;margin-top:2%">
					<?php 
    					if(!empty($small_image_url))
    					{
    				?>		
							<a rel="gallery" href="<?php echo $image_url[0]; ?>">
								<img src="<?php echo $small_image_url; ?>" alt="" class="frame img_nofade"/>
							</a>
					<?php
    					}		
    				?>			
					
				</div>
				
				<?php
					}
				?>
				</div>
			
			</div>
			<br class="clear"/>
			
		</div>
		<!-- End content -->
		
		<?php
			}
		?>
		
		</div>
		<br class="clear"/>

<?php get_footer(); ?>