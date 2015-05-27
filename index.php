<?php
/**
 * The main template file. Modified from the Anan theme to use supersized.
 *
 * @package WordPress
 */

get_header(); 

if(isset($_SESSION['pp_homepage_style']))
{
	$pp_homepage_style = $_SESSION['pp_homepage_style'];
}
else
{
	$pp_homepage_style = get_option('pp_homepage_style');
}

$pp_homepage_slideshow = get_option('pp_homepage_slideshow');
$pp_homepage_slideshow_cat = get_option('pp_homepage_slideshow_cat');

if(empty($pp_homepage_style))
{
	$pp_homepage_style = 'slideshow';
}

if($pp_homepage_style == 'slideshow' && !empty($pp_homepage_slideshow_cat))
{
	$homepage_items = -1;

	$args = array( 
		'post_type' => 'attachment', 
		'numberposts' => $homepage_items, 
		'post_status' => null, 
		'post_parent' => $pp_homepage_slideshow_cat,
		'order' => 'ASC',
		'orderby' => 'menu_order',
	); 
	$all_photo_arr = get_posts( $args );
?>

<?php
$initial_image = $all_photo_arr[0]->guid;

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
						$pp_slider_timer = get_option('pp_slider_timer');
						
						if(empty($pp_slider_timer))
						{
							$pp_slider_timer = 5;
						}
						$pp_slider_timer = $pp_slider_timer*1000;
					?>
					slide_interval          :   <?php echo $pp_slider_timer; ?>,	//Length between transitions
					<?php						
						$pp_homepage_slideshow_trans = get_option('pp_homepage_slideshow_trans');
						
						if(empty($pp_homepage_slideshow_trans))
						{
							$pp_homepage_slideshow_trans = 6;
						}
					?>
					transition              :   <?php echo $pp_homepage_slideshow_trans; ?>, 		//0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
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

        	<?php $homeslides .= '{image : \''.$image_url[0].'\', title: "'.htmlentities($photo->post_title).'<br/><div class=\"slide_info\">'.htmlentities($photo->post_content).'</div>"},'; ?>
        	
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
		<a id="pauseplay" class="load-item"></a>
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
} // End if homepage as slideshow
else if($pp_homepage_style == 'static')
{
?>
		
		<?php
			$pp_homepage_bg = get_option('pp_homepage_bg'); 
			
			if(empty($pp_homepage_bg))
			{
				$pp_homepage_bg = '/example/bg.jpg';
			}
			else
			{
				$pp_homepage_bg = '/data/'.$pp_homepage_bg;
			}

		?>
		<script type="text/javascript"> 
			jQuery.backstretch( "<?php echo get_stylesheet_directory_uri().$pp_homepage_bg; ?>", {speed: 'slow'} );
		</script>
		
		<div id="supersized-loader" style="display: none; "></div>

<?php  

} // End if homepage as static image
else if($pp_homepage_style == 'youtube_video')
{
?>
<?php
$pp_homepage_youtube_video_id = get_option('pp_homepage_youtube_video_id');

if(!empty($pp_homepage_youtube_video_id))
{
?>

<script>
$j(document).ready(function() {
	$j('body').tubular('<?php echo $pp_homepage_youtube_video_id; ?>','wrapper');
	
	setTimeout(function() {
    	$j('#top_bar').fadeOut("slow");
    }, 3000);
    
	$j('#footer').css('display','none');
	
	$j(document).hover(
		function(){ //mouse over
			$j('#top_bar').fadeTo("slow", 1);
		},
		function(){ //mouse out
			$j('#top_bar').fadeOut("slow");
		}
	);
});
</script>
<?php
}
?>

<?php
} // End if homepage as youtube video
?>


<?php
	$pp_display_hide_homepage = get_option('pp_display_hide_homepage');
?>
<!-- <div href="javascript:;" data-rel="#homepage_wrapper" id="expand_button" <?php if(empty($pp_display_hide_homepage)) { echo 'style="display:block;"'; } ?>>
		<table id="contact_table">
  <tr>
    <td><img src="http://localhost/milekuvar/wp-content/uploads/2014/09/Phone-icon.png" width="25px"></img></td>
    <td><h4> 011/061/064/069 21 600 60</h4></td> 
    
  </tr>
  <tr>
    <td><img src="http://localhost/milekuvar/wp-content/uploads/2014/09/Map-icon.png" width="25px"></img></td>
    <td><h4>Birčaninova 39</h4></td> 
  </tr>
  <tr>
    <td><img src="http://localhost/milekuvar/wp-content/uploads/2014/09/Clock-icon.png" width="25px"></img></img></td>
    <td><h4 id="clock">9h - 21h</h4></td> 
  </tr>
</table>
			

			
</div> -->
<div class="header-info">

			<div style="height: 0.3cm"></div>
			<div class="header-info-part">
				<div class="header-info-part-label"><h6 id="header-info-part-label-h4">Mile Kuvar</h6></div>
                <span style="color:#fcd662;font-weight:bolder;font-size:medium">Birčaninova 39</span><br>
				 <span style="color:#fcd662;font-weight:bolder">milekuvar@mail.com</span>
			</div>
			
			<div class="header-info-part2">
				<div class="header-info-part-label"><h6 id="header-info-part-label-h4">Radno Vreme</h6></div>
                 <span style="color:#fcd662;font-weight:bolder">Radni dan: 8-22h</span><br>
				 <span style="color:#fcd662;font-weight:bolder">Subota: 9-22h</span><br>
				 <span style="color:#fcd662;font-weight:bolder">Nedelja: 10-18h</span><br>
			</div>
			
			<div class="header-info-part2">
				<div class="header-info-part-label"><h6 id="header-info-part-label-h4" style="width: 215px;">Radno Vreme dostave</h6></div>
                 <span style="color:#fcd662;font-weight:bolder">Radni dan: 9-21:30h</span><br>
				 <span style="color:#fcd662;font-weight:bolder">Subota: 9-21:30h</span><br>
				 <span style="color:#fcd662;font-weight:bolder">Nedelja: 10-17:30h</span><br>
			</div>
			
			<div class="header-info-part3" style="margin-left: 75px;">
				<table>
					<tr style="background:none;">
						<td style="padding: 0;border-bottom: 0"><img width="16" src="wp-content\themes\MileKuvar\images\about_icon\telenor.png" style="float:right;margin-right:10px">
						</td>
						<td style="padding: 0;border-bottom: 0"><span style="color:#fcd662;font-weight:bolder">069/21-600-60</span></td>
					</tr>
					<tr style="background:none;">
						<td style="padding: 0;border-bottom: 0"><img width="16" src="wp-content\themes\MileKuvar\images\about_icon\mts.png" style="float:right;margin-right:10px">
						</td>
						<td style="padding: 0;border-bottom: 0"><span style="color:#fcd662;font-weight:bolder">064/21-600-60</span></td>
					</tr>
					<tr style="background:none;">
						<td style="padding: 0;border-bottom: 0"><img width="20" src="wp-content\themes\MileKuvar\images\about_icon\vip.png" style="float:right;margin-right:10px">
						</td>
						<td style="padding: 0;border-bottom: 0"><span style="color:#fcd662;font-weight:bolder">061/21-600-60</span></td>
					</tr>
					<tr style="background:none;">
						<td style="padding: 0;border-bottom: 0"><img width="16" src="wp-content\themes\MileKuvar\images\about_icon\telekom.png" style="float:right;margin-right:10px">
						</td>
						<td style="padding: 0;border-bottom: 0"><span style="color:#fcd662;font-weight:bolder">011/26-830-00</span></td>
					</tr>
				</table>

			</div>
			
		
<br class="clear"/></br>
<div class="header-info" style="left:0;margin-top:110px;height:auto !important;"><h1 style="color:#fcd662;font-weight:600">MESTO ZA INFORMACIJE</h1></div>
			
 
		</div>

<div id="homepage_wrapper" <?php if(empty($pp_display_hide_homepage)) { echo 'style="display:none;"'; } ?>>
	<div class="close_button">
		<a href="javascript:;" data-rel="#homepage_wrapper" id="close_button">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/close_button.png" alt=""/>
		</a>
	</div>
	<div class="inner">
	
	<div id="page_content_wrapper">
	<div class="inner">
	<div class="sidebar_content">
		<?php
			$pp_homepage_title = get_option('pp_homepage_title');
			
			if(!empty($pp_homepage_title))
			{
		?>
			<h1 class="page_header"><?php echo $pp_homepage_title; ?></h1>
		<?php
			}
		?>
		<?php 
			$pp_homepage_small_slideshow_cat = get_option('pp_homepage_small_slideshow_cat');
			
			if(!empty($pp_homepage_small_slideshow_cat))
			{
				echo do_shortcode('[nivoslide gallery_id="'.$pp_homepage_small_slideshow_cat.'" effect="boxRainGrow" width="495" height="300"]');
				
				echo '<br class="clear"/><br/>';
			}
		?>
		
		<?php 
			if(isset($_SESSION['pp_home_style']))
			{
			    switch($_SESSION['pp_home_style'])
			    {
			    	case 1:
			    		$pp_homepage_content = array(1923);
			    		break;
			    	case 2:
			    		$pp_homepage_content = array(1797);
			    		break;
			    	case 3:
			    		$pp_homepage_content = array(1668);
			    		break;
			    	case 4:
			    		$pp_homepage_content = array(2575);
			    		break;
			    	case 5:
			    		$pp_homepage_content = array(2581);
			    		break;
			    	case 6:
			    		$pp_homepage_content = array(2586);
			    		break;
			    	default:
			    		$pp_homepage_content = array(1923);
			    		break;
			    }
			}
			else
			{
			    $pp_homepage_content = unserialize(get_option('pp_homepage_content_sort_data'));
			}
			
			global $wp_query;
			
			$has_homepage_content = get_option('pp_homepage_content');

			if(is_array($pp_homepage_content) && !empty($pp_homepage_content) && !empty($has_homepage_content))
			{
			
			    foreach($pp_homepage_content as $key => $pp_homepage)
			    {
			    	$template_name = get_post_meta( $pp_homepage, '_wp_page_template', true );
			    	
			    	if(empty($template_name) OR $template_name == 'default')
					{
					    $obj_home = get_page($pp_homepage);
					    $pp_home_content = $obj_home->post_content;
					    
						echo do_shortcode($pp_home_content);
					}
					else
		    		{
		    		    $hide_header = TRUE;
		    		    
		    		    if($key > 0)
		    		    {
		    		    	echo '<br class="clear"/><br/><br/>';
		    		    }
		    		    else
		    		    {
		    		    	echo '<br class="clear"/><br/>';
		    		    }
		    		    
		    		    if(file_exists(TEMPLATEPATH.'/'.$template_name))
		    		    {
		    		    	$current_page_id = $pp_homepage;
		    		    	include(TEMPLATEPATH.'/'.$template_name);
		    		    }
		    		}
				}
			}
		    		
		    	if(isset($pp_homepage_content[$key+1]))
		    	{	
		?>
		
		    	<br class="clear"/><br/>
		
		<?php
				}
		?>
		
		<div id="footer">
			<br class="clear"/><br/>
			<div id="copyright">
			    <?php
			    	/**
			    	 * Get footer text
			    	 */
			
			    	$pp_footer_text = get_option('pp_footer_text');
			
			    	if(empty($pp_footer_text))
			    	{
						$pp_footer_text = 'Copyright © 2014 M.V.';
			    	}
			    	
			    	echo stripslashes(html_entity_decode($pp_footer_text));
			    ?>
			</div>
		</div>
		</div>
		</div>
		
	</div>
</div>
