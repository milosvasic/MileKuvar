<?php
/*
	Begin creating admin options
*/

$themename = THEMENAME;
$shortname = SHORTNAME;

$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array(
	0		=> "Choose a category"
);
foreach ($categories as $category_list ) {
       $wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}

$pages = get_pages(array('parent' => -1));
$wp_pages = array(
	0		=> "Choose a page"
);
foreach ($pages as $page_list ) {
       $wp_pages[$page_list->ID] = $page_list->post_title;
}

$galleries = get_posts(array('parent' => -1, 'post_type' => 'gallery', 'numberposts' => -1));
$wp_galleries = array(
	0		=> "Choose a gallery"
);
foreach ($galleries as $gallery_list ) {
       $wp_galleries[$gallery_list->ID] = $gallery_list->post_title;
}


$pp_handle = opendir(TEMPLATEPATH.'/fonts');
$pp_font_arr = array();

while (false!==($pp_file = readdir($pp_handle))) {
	if ($pp_file != "." && $pp_file != ".." && $pp_file != ".DS_Store") {
		$pp_file_name = basename($pp_file, '.js');
		
		if($pp_file_name != 'Quicksand_300.font')
		{
			$pp_name = $pp_file_name;
		
			$pp_font_arr[$pp_file_name] = $pp_name;
		}
	}
}
closedir($pp_handle);
asort($pp_font_arr);


$options = array (
 
//Begin admin header
array( 
		"name" => $themename." Options",
		"type" => "title"
),
//End admin header
 

//Begin first tab "General"
array( 
		"name" => "General",
		"type" => "section",
		"icon" => "gear.png",
)
,

array( "type" => "open"),

array( "name" => "Skins",
	"desc" => "Select font style your body text",
	"id" => $shortname."_skin",
	"type" => "select",
	"options" => array(
		'light' => 'Light',
		'dark' => 'Dark',
		'transparent' => 'Transparent',
	),
	"std" => ''
),
array( "name" => "Logo",
	"desc" => "Image logo which shows above of main menu",
	"id" => $shortname."_logo",
	"type" => "image",
	"std" => "",
),
array( "name" => "Custom Favicon",
	"desc" => "A favicon is a 16x16 pixel icon that represents your site;",
	"id" => $shortname."_favicon",
	"type" => "image",
	"std" => "",
),
array( "name" => "Google Analytics Domain ID ",
	"desc" => "Get analytics on your site. Simply give us your Google Analytics Domain ID (something like UA-123456-1)",
	"id" => $shortname."_ga_id",
	"type" => "text",
	"std" => ""

),
/*array( "name" => "Show search box under main menu",
	"desc" => "",
	"id" => $shortname."_menu_display_search",
	"type" => "iphone_checkboxes",
	"std" => 1
),*/
array( "name" => "Show fullscreen image description",
	"desc" => "",
	"id" => $shortname."_display_full_desc",
	"type" => "iphone_checkboxes",
	"std" => 1
),
	
array( "type" => "close"),
//End first tab "General"

//Begin first tab "Font"
array( 
		"name" => "Font",
		"type" => "section",
		"icon" => "edit.png",
)
,

array( "type" => "open"),

/*array( "name" => "Header Font",
	"desc" => "Select font for header text",
	"id" => $shortname."_font",
	"type" => "font",
	"options" => $pp_font_arr,
	"std" => ""
),*/
array( "name" => "H1 Size (in pixels)",
	"desc" => "",
	"id" => $shortname."_h1_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "40",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H2 Size (in pixels)",
	"desc" => "",
	"id" => $shortname."_h2_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "32",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H3 Size (in pixels)",
	"desc" => "",
	"id" => $shortname."_h3_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "26",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H4 Size (in pixels)",
	"desc" => "",
	"id" => $shortname."_h4_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "24",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H5 Size (in pixels)",
	"desc" => "",
	"id" => $shortname."_h5_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "22",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
array( "name" => "H6 Size (in pixels)",
	"desc" => "",
	"id" => $shortname."_h6_size",
	"type" => "jslider",
	"size" => "40px",
	"std" => "18",
	"from" => 13,
	"to" => 60,
	"step" => 1,
),
	
array( "type" => "close"),
//End first tab "Font"


//Begin first tab "Colors"
array( 
		"name" => "Colors",
		"type" => "section",
		"icon" => "color.png",
)
,

array( "type" => "open"),

/*array( "name" => "Font Color",
	"desc" => "Select color for the font (default #6f705c)",
	"id" => $shortname."_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#6f705c"

),

array( "name" => "Link Color",
	"desc" => "Select color for the link (default #444444)",
	"id" => $shortname."_link_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#444444"

),

array( "name" => "Hover Link Color",
	"desc" => "Select color for the hover link (default #999999)",
	"id" => $shortname."_hover_link_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#999999"

),

array( "name" => "H1, H2, H3, H4, H5, H6 Color",
	"desc" => "Select color for the H1, H2, H3, H4, H5, H6 (default #454a2e)",
	"id" => $shortname."_h1_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#454a2e"

),*/

array( "name" => "Button Background Color",
	"desc" => "Select color for the button background (default #FE7201)",
	"id" => $shortname."_button_bg_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#FE7201"

),

array( "name" => "Button Font Color",
	"desc" => "Select color for the button font (default #ffffff)",
	"id" => $shortname."_button_font_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#ffffff"

),

array( "name" => "Button Border Color",
	"desc" => "Select color for the button border (default #E56701)",
	"id" => $shortname."_button_border_color",
	"type" => "colorpicker",
	"size" => "60px",
	"std" => "#E56701"

),


array( "type" => "close"),
//End first tab "Colors"


//Begin second tab "Homepage"
array( "name" => "Homepage",
	"type" => "section",
	"icon" => "home.png",	
),
array( "type" => "open"),

array( "name" => "Homepage slideshow style",
	"desc" => "Select style for contents in homepage slideshow",
	"id" => $shortname."_homepage_style",
	"type" => "select",
	"options" => array(
		'slideshow' => 'Slideshow',
		'youtube_video' => 'Youtube Video Background',
		'static' => 'Static image',
	),
	"std" => "ASC"
),
array( "name" => "Choose Homepage background Gallery",
	"desc" => "",
	"id" => $shortname."_homepage_slideshow_cat",
	"type" => "select",
	"options" => $wp_galleries,
	"std" => ""
),
array( "name" => "Slider timer (in second)",
	"desc" => "",
	"id" => $shortname."_slider_timer",
	"type" => "jslider",
	"size" => "40px",
	"std" => "5",
	"from" => 1,
	"to" => 12,
	"step" => 1,
),
array( "name" => "Homepage Gallery Transition Effect",
	"desc" => "Select transition type for contents in homepage slideshow",
	"id" => $shortname."_homepage_slideshow_trans",
	"type" => "select",
	"options" => array(
		1 => 'Fade',
		2 => 'Slide Top',
		3 => 'Slide Right',
		4 => 'Slide Bottom',
		5 => 'Slide Left',
		6 => 'Carousel Right',
		7 => 'Carousel Left',
	),
	"std" => "Fade"
),
array( "name" => "Homepage Youtube Video ID (if select Youtube Video Background style)",
	"desc" => "For example: Vt6y5nNQVMA",
	"id" => $shortname."_homepage_youtube_video_id",
	"type" => "text",
	"std" => "Vt6y5nNQVMA"
),
array( "name" => "Hompage Background Image",
	"desc" => "Select image for homepage background. If you disable homepage slideshow (Recommended size 1440x900 pixels)",
	"id" => $shortname."_homepage_bg",
	"type" => "image",
	"size" => "290px",
),
array( "name" => "Homepage Title",
	"desc" => "",
	"id" => $shortname."_homepage_title",
	"type" => "text",
	"std" => "Simply Delicious"
),
array( "name" => "Choose Homepage slideshow gallery",
	"desc" => "",
	"id" => $shortname."_homepage_small_slideshow_cat",
	"type" => "select",
	"options" => $wp_galleries,
	"std" => ""
),
array( "name" => "Select and sort contents on your homepage. Use pages you want to show on your homepage <br/><br/><a href='".admin_url("post-new.php?post_type=page")."' class='button'>Create Page</a>",
	"sort_title" => "Homepage Content Manager",
	"desc" => "",
	"id" => $shortname."_homepage_content",
	"type" => "sortable",
	"options" => $wp_pages,
	"options_disable" => array(1, 2, 3),
	"std" => ''
),
array( "name" => "Display/Hide Homepage content",
	"desc" => "",
	"id" => $shortname."_display_hide_homepage",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "type" => "close"),
//End second tab "Homepage"


//Begin second tab "Blog"
array( "name" => "Blog",
	"type" => "section",
	"icon" => "book-open-bookmark.png",	
),
array( "type" => "open"),

array( "name" => "Enable Background Slideshow",
	"desc" => "",
	"id" => $shortname."_blog_slideshow",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Choose Blog Gallery (if enable slideshow)",
	"desc" => "",
	"id" => $shortname."_blog_slideshow_cat",
	"type" => "select",
	"options" => $wp_galleries,
	"std" => ""
),
array( "name" => "Slider timer (in second)",
	"desc" => "",
	"id" => $shortname."_blog_slider_timer",
	"type" => "jslider",
	"size" => "40px",
	"std" => "5",
	"from" => 1,
	"to" => 12,
	"step" => 1,
),
array( "name" => "Blog Gallery Transition Effect",
	"desc" => "Select transition type for contents in blog slideshow",
	"id" => $shortname."_blog_slideshow_trans",
	"type" => "select",
	"options" => array(
		1 => 'Fade',
		2 => 'Slide Top',
		3 => 'Slide Right',
		4 => 'Slide Bottom',
		5 => 'Slide Left',
		6 => 'Carousel Right',
		7 => 'Carousel Left',
	),
	"std" => "Fade"
),
array( "name" => "Blog Background Image",
	"desc" => "Select image for blog background (Recommended size 1440x900 pixels)",
	"id" => $shortname."_blog_bg",
	"type" => "image",
	"size" => "290px",
),
array( "name" => "Display full blog post content on blog page",
	"desc" => "",
	"id" => $shortname."_blog_display_full",
	"type" => "iphone_checkboxes",
	"std" => 1
),

array( "type" => "close"),
//End second tab "Portfolios"


//Begin fourth tab "Contact"
array( "name" => "Contact",
	"type" => "section",
	"icon" => "mail-receive.png",	
),
array( "type" => "open"),

array( "name" => "Your email address",
	"desc" => "Enter which email address will be sent from contact form",
	"id" => $shortname."_contact_email",
	"type" => "text",
	"std" => ""
),
array( "name" => "Show map in contact page",
	"desc" => "Select display map in contact page",
	"id" => $shortname."_contact_display_map",
	"type" => "iphone_checkboxes",
	"std" => 1
),
array( "name" => "Address Latitude",
	"desc" => "<a href=\"http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/\">Find here</a>",
	"id" => $shortname."_contact_lat",
	"type" => "text",
	"std" => ""
),
array( "name" => "Address Longtitude",
	"desc" => "<a href=\"http://www.tech-recipes.com/rx/5519/the-easy-way-to-find-latitude-and-longitude-values-in-google-maps/\">Find here</a>",
	"id" => $shortname."_contact_long",
	"type" => "text",
	"std" => ""
),
array( "name" => "Map Zoom level",
	"desc" => "",
	"id" => $shortname."_contact_map_zoom",
	"type" => "jslider",
	"size" => "40px",
	"std" => "12",
	"from" => 1,
	"to" => 18,
	"step" => 1,
),
array( "name" => "Map Info box content",
	"desc" => "Enter text to display in map info box",
	"id" => $shortname."_contact_info_box",
	"type" => "text",
	"std" => ""
),
//End fourth tab "Contact"

//Begin fifth tab "Footer"
array( "type" => "close"),
array( "name" => "Footer",
	"type" => "section",
	"icon" => "layout-select-footer.png",	
),
array( "type" => "open"),
	
array( "name" => "Menu Footer Content",
	"desc" => "Enter menu footer text or HTML content",
	"id" => $shortname."_menu_footer_text",
	"type" => "textarea",
	"std" => ""

),
array( "name" => "Page Footer Content",
	"desc" => "Enter footer text or HTML content",
	"id" => $shortname."_footer_text",
	"type" => "textarea",
	"std" => ""

),
//End fifth tab "Footer"

 
array( "type" => "close")
 
);
?>