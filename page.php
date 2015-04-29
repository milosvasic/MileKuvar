<?php
/**
 * The main template file for display page.
 *
 * @package WordPress
*/

session_start();

/**
*	Get Current page object
**/
$page = get_page($post->ID);


/**
*	Get current page id
**/
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

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

<div id="page_content_wrapper">
<div class="inner">
<div class="sidebar_content">
			
	<h1 class="page_header"><?php the_title(); ?></h1><hr/>

	<!-- Begin main content -->
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		
		
    	<?php do_shortcode(the_content()); ?><br class="clear"/><br/><br/>

    <?php endwhile; ?>
    
<!-- End main content -->
</div>
</div>
</div>

<?php get_footer(); ?>