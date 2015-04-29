<?php
/**
 * Template Name: Contact
 * The main template file for display contact page.
 *
 * @package WordPress
*/

session_start();

/**
*	if not submit form
**/
if(!isset($_GET['your_name']))
{
?>

<?php 
if(!isset($hide_header) OR !$hide_header)
{
?>
<script type="text/javascript"> 
$j(document).ready(function(){ 
	setTimeout(function() {
		$j('#map_contact').css('visibility', 'visible'); 
    	$j('#homepage_wrapper').animate({width: 'toggle'},{
			duration: 500,
		    complete: function() {
		    	$j('#homepage_wrapper').fadeIn();
		    	$j('#homepage_wrapper').children('.inner').fadeIn('slow');
		    	$j('#corner_right').css('display', 'block');
		    	$j('#corner_right_bottom').css('display', 'block');
		    	$j('#slidecaption').css('visibility', 'visible');
		    	$j('#supersized-loader').css({display: 'none'});
		    	$j('#slidecaption').css('visibility', 'hidden');
    	    }
		});
		
		$j.validator.setDefaults({
			submitHandler: function() { 
			    var actionUrl = $j('#contact_form').attr('action');
			    
			    $j.ajax({
  			    	type: 'GET',
  			    	url: actionUrl,
  			    	data: $j('#contact_form').serialize(),
  			    	success: function(msg){
  			    		$j('#contact_form').hide();
  			    		$j('#reponse_msg').html(msg);
  			    	}
			    });
			    
			    return false;
			}
		});
			    
			
		$j('#contact_form').validate({
			rules: {
			    your_name: "required",
			    email: {
			    	required: true,
			    	email: true
			    },
			    message: "required"
			},
			messages: {
			    your_name: "Please enter your name",
			    email: "Please enter a valid email address",
			    agree: "Please enter some message"
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

	<?php the_content(); ?>

	<!-- Begin main content -->
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		

    	<?php do_shortcode(the_content()); ?><br class="clear"/><br/>

    <?php endwhile; ?>
    
<?php
	$target_url = curPageURL();
}
else
{
	$obj_contact = get_page($current_page_id);
	$target_url = $obj_contact->guid;
	$pp_contact_content = $obj_contact->post_content;
					    
	echo do_shortcode($pp_contact_content).'<br class="clear"/><br/>';
}
?>
    	
<h2>Mile Kuvar</h2>
<p>Birčaninova 39</p>
<p>milekuvar@mail.com</p>
<br/>
<h3>Telefon</h3>
<p>011 / 26-830-00</p>
<br/>
<h3>Radno vreme</h3>
<p>Radni dan: 8-22h</p>
<p>Subota: 9-22h</p>
<p>Nedelja: 10-18h</p>

<?php 
if(!isset($hide_header) OR !$hide_header)
{
?>
</div>
</div>
</div>
				
<?php
get_footer();

} // En if not hide header
}

//if submit form
else
{

	/*
	|--------------------------------------------------------------------------
	| Mailer module
	|--------------------------------------------------------------------------
	|
	| These module are used when sending email from contact form
	|
	*/
	
	//Get your email address
	$contact_email = get_option('pp_contact_email');
	
	//Enter your email address, email from contact form will send to this addresss. Please enter inside quotes ('myemail@email.com')
	define('DEST_EMAIL', $contact_email);
	
	//Change email subject to something more meaningful
	define('SUBJECT_EMAIL', __( 'Email from contact form', THEMEDOMAIN ));
	
	//Thankyou message when message sent
	define('THANKYOU_MESSAGE', __( 'Thank you! We will get back to you as soon as possible', THEMEDOMAIN ));
	
	//Error message when message can't send
	define('ERROR_MESSAGE', __( 'Oops! something went wrong, please try to submit later.', THEMEDOMAIN ));
	
	
	/*
	|
	| Begin sending mail
	|
	*/
	
	$from_name = $_GET['your_name'];
	$from_email = $_GET['email'];
	
	$mime_boundary_1 = md5(time());
    $mime_boundary_2 = "1_".$mime_boundary_1;
    $mail_sent = false;
 
    # Common Headers
    $headers = "";
    $headers .= 'From: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
    $headers .= 'Reply-To: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
    $headers .= 'Return-Path: '.$from_name.'<'.$from_email.'>'.PHP_EOL;        // these two to set reply address
    $headers .= "Message-ID: <".$now."webmaster@".$_SERVER['SERVER_NAME'].">";
    $headers .= "X-Mailer: PHP v".phpversion().PHP_EOL;                  // These two to help avoid spam-filters
	
	$message = 'Name: '.$from_name.PHP_EOL;
	$message.= 'Email: '.$from_email.PHP_EOL.PHP_EOL;
	$message.= 'Message: '.PHP_EOL.$_GET['message'];
	    
	
	if(!empty($from_name) && !empty($from_email) && !empty($message))
	{
		mail(DEST_EMAIL, SUBJECT_EMAIL, $message, $headers);
	
		echo THANKYOU_MESSAGE;
		
		exit;
	}
	else
	{
		echo ERROR_MESSAGE;
		
		exit;
	}
	
	/*
	|
	| End sending mail
	|
	*/
}

?>
