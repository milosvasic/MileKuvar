<?php
/**
 * The main template file for 404 page.
 *
 * @package WordPress
*/

get_header(); 
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
		
		<h1 class="page_header"><?php _e( 'Not Found', THEMEDOMAIN ); ?></h1><br/><hr/>

	<!-- Begin main content -->
	<?php _e( 'Apologies, but the page you requested could not be found.', THEMEDOMAIN ); ?>
			
	</div>
	<!-- End content -->
	<br class="clear"/><br/>
		
</div>
				

<?php get_footer(); ?>