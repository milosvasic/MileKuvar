<?php
/**
 * The main template file for display archive page.
 *
 * @package WordPress
 */

$post_type = get_post_type();

if($post_type == 'menus')
{
	include (TEMPLATEPATH . "/templates/template-menus.php");
	exit;
}

?>