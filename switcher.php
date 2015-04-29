<?php
session_start();
$pp_url = 'http://themes.themegoods.com/pluto_wp/';

if(isset($_GET['pp_skin']))
{
	$_SESSION['pp_skin'] = $_GET['pp_skin'];
}

if(isset($_GET['pp_homepage_style']))
{
	$_SESSION['pp_homepage_style'] = $_GET['pp_homepage_style'];
	header( 'Location: '.$pp_url ) ;
	exit;
}

header( 'Location: '.$_SERVER['HTTP_REFERER'] ) ;
?>