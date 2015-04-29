<?php

if ( function_exists('register_sidebar') )
    register_sidebar(array('name' => 'Main Sidebar'));


//Register dynamic sidebar
/*$dynamic_sidebar = get_option('pp_sidebar');

if(!empty($dynamic_sidebar))
{
	foreach($dynamic_sidebar as $sidebar)
	{
		if ( function_exists('register_sidebar') )
	    register_sidebar(array('name' => $sidebar));
	}
}*/

?>