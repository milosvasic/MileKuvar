<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 */
 
session_start();
$pp_theme_version = THEMEVERSION;
 
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php wp_title('&lsaquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php 
	if ( is_single() ) { 
		if(has_post_thumbnail(get_the_ID(), 'large'))
		{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail', true);
?>
		<link rel="image_src" href="<?php echo $image_thumb[0]; ?>" />
<?php 
		} 
	}	
?>

<?php
	/**
	*	Get favicon URL
	**/
	$pp_favicon = get_option('pp_favicon');
	
	if(!empty($pp_favicon))
	{
?>
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/data/<?php echo $pp_favicon; ?>" />
<?php
	}
?>

<!-- Template stylesheet -->
<?php
	wp_enqueue_style("screen_css", get_stylesheet_directory_uri()."/css/bootstrap.min.css", false, $pp_theme_version, "all");
	wp_enqueue_style("screen_css", get_stylesheet_directory_uri()."/css/screen.css", false, $pp_theme_version, "all");
	wp_enqueue_style("supersized_css", get_stylesheet_directory_uri()."/css/supersized.css", false, $pp_theme_version, "all");
	wp_enqueue_style("fancybox_css", get_stylesheet_directory_uri()."/js/fancybox/jquery.fancybox-1.3.0.css", false, $pp_theme_version, "all"); d
?>

<?php
    $pp_contact_display_map = get_option('pp_contact_display_map');
    
    if(!empty($pp_contact_display_map))
    {
?>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<?php
	}
?>
	<script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.1/swfobject.js"></script>

<?php
	wp_enqueue_script("jquery", get_stylesheet_directory_uri()."/js/jquery.js", false, $pp_theme_version);
	wp_enqueue_script("fancybox_js", get_stylesheet_directory_uri()."/js/fancybox/jquery.fancybox-1.3.0.js", false, $pp_theme_version);
	wp_enqueue_script("jQuery_easing", get_stylesheet_directory_uri()."/js/jquery.easing.js", false, $pp_theme_version);
	wp_enqueue_script("jQuery_nivo", get_stylesheet_directory_uri()."/js/jquery.nivo.slider.js", false, $pp_theme_version);
	
	if(!empty($pp_contact_display_map))
    {
		wp_enqueue_script("jQuery_gmap", get_stylesheet_directory_uri()."/js/gmap.js", false, $pp_theme_version);
	}
	
	wp_enqueue_script("jquery.tubular.js", get_stylesheet_directory_uri()."/js/jquery.tubular.js", false, $pp_theme_version);
	wp_enqueue_script("jQuery_validate", get_stylesheet_directory_uri()."/js/jquery.validate.js", false, $pp_theme_version);
	wp_enqueue_script("history_js", get_stylesheet_directory_uri()."/js/jquery.history.js", false, $pp_theme_version);
	wp_enqueue_script("browser_js", get_stylesheet_directory_uri()."/js/browser.js", false, $pp_theme_version);
	wp_enqueue_script("hint_js", get_stylesheet_directory_uri()."/js/hint.js", false, $pp_theme_version);
	wp_enqueue_script("jquery_backstretch", get_stylesheet_directory_uri()."/js/jquery.backstretch.js", false, $pp_theme_version);
	wp_enqueue_script("custom_js", get_stylesheet_directory_uri()."/js/custom.js", false, $pp_theme_version);
	
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
		wp_enqueue_style("pp_skin", get_stylesheet_directory_uri()."/css/dark.css", false, $pp_theme_version, "all");
	}
	elseif($pp_skin == 'transparent')
	{
		wp_enqueue_style("pp_skin", get_stylesheet_directory_uri()."/css/transparent.css", false, $pp_theme_version, "all");
	}
?> 

<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/ie7.css" type="text/css" media="all"/>
<![endif]-->

<?php
if($pp_skin == 'dark' OR $pp_skin == 'transparent')
{
?>
<!--[if IE]>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/ie_dark.css" type="text/css" media="all"/>
<![endif]-->
<?php
}else{
?>
<!--[if IE]>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/ie.css" type="text/css" media="all"/>
<![endif]-->
<?php
}
?>

<style type="text/css">

      #header-info-part-label-h4 {
        font-family: "Bebas Neue", Arial; 
        
      }
	  
	  #header-info-part-label-p {
        font-family: "Bebas Neue", Arial; 
        
      }

<?php
	$pp_h1_size = get_option('pp_h1_size');
	
	if(!empty($pp_h1_size))
	{
?>
h1 { font-size:<?php echo $pp_h1_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h2_size = get_option('pp_h2_size');
	
	if(!empty($pp_h2_size))
	{
?>
h2 { font-size:<?php echo $pp_h2_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h3_size = get_option('pp_h3_size');
	
	if(!empty($pp_h3_size))
	{
?>
h3 { font-size:<?php echo $pp_h3_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h4_size = get_option('pp_h4_size');
	
	if(!empty($pp_h4_size))
	{
?>
h4 { font-size:<?php echo $pp_h4_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h5_size = get_option('pp_h5_size');
	
	if(!empty($pp_h5_size))
	{
?>
h5 { font-size:<?php echo $pp_h5_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_h6_size = get_option('pp_h6_size');
	
	if(!empty($pp_h6_size))
	{
?>
h6 { font-size:<?php echo $pp_h6_size; ?>px; }
<?php
	}
	
?>

<?php
	$pp_button_bg_color = get_option('pp_button_bg_color');
	
	if(!empty($pp_button_bg_color))
	{
		$pp_button_bg_color_light = '#'.hex_lighter(substr($pp_button_bg_color, 1), 20);
?>
input[type=submit], input[type=button], a.button { 
	background: <?php echo $pp_button_bg_color; ?>;
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $pp_button_bg_color_light; ?>), to(<?php echo $pp_button_bg_color; ?>));
	background: -moz-linear-gradient(top,  <?php echo $pp_button_bg_color_light; ?>,  <?php echo $pp_button_bg_color; ?>);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $pp_button_bg_color_light; ?>', endColorstr='<?php echo $pp_button_bg_color; ?>');
}
input[type=submit]:active, input[type=button]:active, a.button:active
{
	background: <?php echo $pp_button_bg_color; ?>;
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $pp_button_bg_color; ?>), to(<?php echo $pp_button_bg_color_light; ?>));
	background: -moz-linear-gradient(top,  <?php echo $pp_button_bg_color; ?>,  <?php echo $pp_button_bg_color_light; ?>);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $pp_button_bg_color_light; ?>', endColorstr='<?php echo $pp_button_bg_color; ?>');
}
<?php
	}
	
?>

<?php
	$pp_button_font_color = get_option('pp_button_font_color');
	
	if(!empty($pp_button_font_color))
	{
?>
input[type=submit], input[type=button], a.button { 
	color: <?php echo $pp_button_font_color; ?>;
}
input[type=submit]:hover, input[type=button]:hover, a.button:hover
{
	color: <?php echo $pp_button_font_color; ?>;
}
<?php
	}
	
?>

<?php
	$pp_button_border_color = get_option('pp_button_border_color');
	
	if(!empty($pp_button_border_color))
	{
?>
input[type=submit], input[type=button], a.button { 
	border: 1px solid <?php echo $pp_button_border_color; ?>;
}
<?php
	}
	
?>

</style>

</head>

<body <?php body_class(); ?>>

	<input type="hidden" id="home_url" name="home_url" value="<?php echo get_home_url(); ?>"/>

	<!-- Begin template wrapper -->
	
		<div id="menu_mini_state_btn"></div>
		<div id="menu_wrapper">
			
			<!-- Begin logo -->
			
<?php do_action('icl_language_selector'); ?>		
			<?php
				//get custom logo
				$pp_logo = get_option('pp_logo');
							
				if(empty($pp_logo))
				{
					if($pp_skin == 'light')
					{
						$pp_logo = get_stylesheet_directory_uri().'/images/logo_black.png';
					}
					else
					{
						$pp_logo = get_stylesheet_directory_uri().'/images/logo_red.png';
					}
				}
				else
				{
					$pp_logo = get_stylesheet_directory_uri().'/data/'.$pp_logo;
				}

			?>
						
			<a id="custom_logo" class="logo_wrapper" href="<?php echo home_url(); ?>"><img src="<?php echo $pp_logo?>" alt=""/></a>
						
			<!-- End logo -->
		
		    <!-- Begin main nav -->
		    <?php 	
		    			//Get page nav
		    			wp_nav_menu( 
		    					array( 
		    						'menu_id'			=> 'main_menu',
		    						'menu_class'		=> 'nav',
		    						'theme_location' 	=> 'primary-menu',
		    					) 
		    			); 
		    ?>
		    
		    <!-- End main nav -->
		    
		    <?php
			    $pp_menu_display_search = get_option('pp_menu_display_search');
			    
			    if(false)
			    {
			?>
					<br class="clear"/>
			    	<div id="menu_search">
			    		<!-- Begin search box -->
			    		<form class="search_box" action="<?php bloginfo( 'url' ); ?>" method="get">
			    			<p><input type="text" title="<?php echo _e( 'Search...', THEMEDOMAIN ); ?>" id="s" name="s" value="<?php echo get_search_query(); ?>"/><img src="<?php echo bloginfo( 'stylesheet_directory' ); ?>/images/icon_search.png"></p>
			    		</form>
			    		<!-- End search box -->
						
			    	</div>
			<?php
			    }
			?>
			
<br/>

			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" style="display:none">

			<input id="serachmain" type="text" name="s">
			<br></br>
			<input type="submit" style="color:red !important;margin-left:12%" value="Pretrazi">
			

</form>
		    
		    <br class="clear"/>
		    <div id="menu_footer">
				<?php
					/**
					 * Get footer text
					 */
	
					$pp_menu_footer_text = get_option('pp_menu_footer_text');
	
					if(empty($pp_menu_footer_text))
					{
						$pp_footer_text = 'Copyright © 2014 M.V.';
					}
					
					echo stripslashes(html_entity_decode($pp_menu_footer_text));
				?>
			</div>
		</div>

<script>
var menu_key = 1;
$j('.nav li').not(".blog, .menu-item-type-custom, .menu-item-object-post, .menu-item-object-category, .menu-item-object-post_tag").each(function()
{
	current_url = $j(this).children('a').attr('href');
	
	if(typeof($j(this).attr('id')) != 'undefined')
   	{
		$j(this).children('a').attr('href', '#'+$j(this).attr('id'));
	}
	else
	{
		$j(this).attr('id', 'menu-'+menu_key);
		$j(this).children('a').attr('href', '#menu-'+menu_key);
	}
	
	$j(this).children('a').attr('rel', current_url);
	menu_key++;
});
</script>

<?php
    $pp_contact_display_map = get_option('pp_contact_display_map');
    
    if(!empty($pp_contact_display_map))
    {
    	$pp_contact_lat = get_option('pp_contact_lat');
    	$pp_contact_long = get_option('pp_contact_long');
    	$pp_contact_map_zoom = get_option('pp_contact_map_zoom');
    	
    	$pp_contact_info_box = get_option('pp_contact_info_box');
    	$has_pp_contact_info_box = 'false';
    	
    	if(!empty($pp_contact_info_box))
    	{
    		$has_pp_contact_info_box = 'true';
    	}
    	
?>
<div id="map_contact"></div>
<script>
$j("#map_contact").gMap({ zoom: <?php echo $pp_contact_map_zoom; ?>, markers: [ { latitude: '<?php echo $pp_contact_lat; ?>', longitude: '<?php echo $pp_contact_long; ?>',popup: <?php echo $has_pp_contact_info_box; ?>, html: '<br/><h4 class="cufon"><?php echo $pp_contact_info_box; ?></h4>' } ], mapTypeControl: true, zoomControl: false, scrollwheel: false });
</script>
<?php
	}
?>




<?php
	$pp_display_hide_homepage = get_option('pp_display_hide_homepage');
?>

