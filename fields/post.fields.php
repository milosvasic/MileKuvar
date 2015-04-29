<?php

add_filter( 'manage_posts_columns', 'rt_add_gravatar_col');
function rt_add_gravatar_col($cols) {
	$cols['thumbnail'] = __('Thumbnail');
	return $cols;
}

add_action( 'manage_posts_custom_column', 'rt_get_author_gravatar');
function rt_get_author_gravatar($column_name ) {
	if ( $column_name  == 'thumbnail'  ) {
		echo get_the_post_thumbnail(get_the_ID(), array(100, 100));
	}
}

/*
	Begin creating custom fields
*/

function post_type_menus() {
	$labels = array(
    	'name' => _x('Menus', 'post type general name'),
    	'singular_name' => _x('Menu', 'post type singular name'),
    	'add_new' => _x('Add New Menu', 'book'),
    	'add_new_item' => __('Add New Menu'),
    	'edit_item' => __('Edit Menu'),
    	'new_item' => __('New Menu'),
    	'view_item' => __('View Menu'),
    	'search_items' => __('Search Menus'),
    	'not_found' =>  __('No Menu found'),
    	'not_found_in_trash' => __('No Menus found in Trash'), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail'),
    	'menu_icon' => get_bloginfo( 'stylesheet_directory' ).'/functions/images/sign.png'
	); 		

	register_post_type( 'menus', $args );
	
  	$labels = array(			  
  	  'name' => _x( 'Menus Categories', 'taxonomy general name' ),
  	  'singular_name' => _x( 'Menus Category', 'taxonomy singular name' ),
  	  'search_items' =>  __( 'Search Categories' ),
  	  'all_items' => __( 'All Categories' ),
  	  'parent_item' => __( 'Parent Category' ),
  	  'parent_item_colon' => __( 'Parent Category:' ),
  	  'edit_item' => __( 'Edit Category' ), 
  	  'update_item' => __( 'Update Category' ),
  	  'add_new_item' => __( 'Add New Category' ),
  	  'new_item_name' => __( 'New Category Name' ),
  	); 							  
  	
  	register_taxonomy(
		'menu-cats',
		'menus',
		array(
			'public'=>true,
			'hierarchical' => true,
			'labels'=> $labels,
			'query_var' => 'menu_cats',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'menu_cats', 'with_front' => false ),
		)
	);			  
} 
								  
add_action('init', 'post_type_menus');

add_action("manage_posts_custom_column", "my_custom_columns");
add_filter("manage_edit-menus_columns", "my_menus_columns");

function my_menus_columns($columns)
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Menu Title",
		"description" => "Description",
		"price" => "Price",
		"thumbnail" => "Photo",
	);
	return $columns;
}

function my_custom_columns($column)
{
	global $post;
	
	$price = get_post_meta($post->ID, 'menu_price', true);

	if ("description" == $column) echo $post->post_content;
	elseif ("price" == $column) echo $price;
}

$postmetas = 
	array (
		'menus' => array(
			
			/*
			    Begin Slide Source custom fields
			*/
			
			array("section" => "Menu Options", "id" => "menu_price", "title" => "Price (ex. 100 USD):"),
			array("section" => "Menu Stars", "id" => "menu_stars", "type" => "select", "title" => "Select how many stars you for this menu:", 
				"items" => array(
					"5" => "5", 
					"4" => "4", 
					"3" => "3", 
					"2" => "2",
					"1" => "1",
			)),

			/*
			    End Slide Source custom fields
			*/
		),
	);

/*print '<pre>';
print_r($post_obj);
print '</pre>';*/

function create_meta_box() {

	global $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}
	
	if ( function_exists('add_meta_box') && isset($postmetas) && count($postmetas) > 0 ) {  
		foreach($postmetas as $key => $postmeta)
		{
			if($_GET['post_type']==$key)
			{
				add_meta_box( 'metabox', ucfirst($key).' Options', 'new_meta_box', $key, 'side', 'high' );  
			}
		}
	}

}  

function new_meta_box() {
	global $post, $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}

	echo '<input type="hidden" name="myplugin_noncename" id="myplugin_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	$meta_section = '';

	foreach ( $postmetas as $key => $postmeta ) {
	
		if($_GET['post_type'] == $key)
		{
		
			foreach ( $postmeta as $each_meta ) {
		
				$meta_id = $each_meta['id'];
				$meta_title = $each_meta['title'];
				
				$meta_type = '';
				if(isset($each_meta['type']))
				{
					$meta_type = $each_meta['type'];
				}
				
				if(empty($meta_section) OR $meta_section != $each_meta['section'])
				{
					$meta_section = $each_meta['section'];
					
					echo "<br/><h3>".$meta_section."</h3><br/>";
				}
				$meta_section = $each_meta['section'];
				
				echo "<p><label for='$meta_id'>$meta_title </label>";
				
				if ($meta_type == 'checkbox') {
					$checked = get_post_meta($post->ID, $meta_id, true) == '1' ? "checked" : "";
					echo "<input type='checkbox' name='$meta_id' id='$meta_id' value='1' $checked /></p>";
				}
				else if ($meta_type == 'select') {
					echo "<p><select name='$meta_id' id='$meta_id'>";
					
					if(!empty($each_meta['items']))
					{
						foreach ($each_meta['items'] as $item)
						{
							echo '<option value="'.$item.'"';
							
							if($item == get_post_meta($post->ID, $meta_id, true))
							{
								echo ' selected ';
							}
							
							echo '>'.$item.'</option>';
						}
					}
					
					echo "</select></p>";
				}
				else if ($meta_type == 'textarea') {
					echo "<p><textarea name='$meta_id' id='$meta_id' class='code' style='width:100%' rows='7'>".get_post_meta($post->ID, $meta_id, true)."</textarea></p>";
				}			
				else {
					echo "<input type='text' name='$meta_id' id='$meta_id' class='code' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
				}
			}
		}
	}
	
	echo '<br/>';

}

function save_postdata( $post_id ) {

	global $postmetas;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( isset($_POST['myplugin_noncename']) && !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) )) {
		return $post_id;
	}

	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

	// Check permissions

	if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		} else {
		if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}

	// OK, we're authenticated

	if ( $parent_id = wp_is_post_revision($post_id) )
	{
		$post_id = $parent_id;
	}

	foreach ( $postmetas as $postmeta ) {
		foreach ( $postmeta as $each_meta ) {
	
			if ($_POST[$each_meta['id']]) {
				update_custom_meta($post_id, $_POST[$each_meta['id']], $each_meta['id']);
			}
			
			if ($_POST[$each_meta['id']] == "") {
				delete_post_meta($post_id, $each_meta['id']);
			}
		
		}
	}

}

function update_custom_meta($postID, $newvalue, $field_name) {

	if (!get_post_meta($postID, $field_name)) {
		add_post_meta($postID, $field_name, $newvalue);
	} else {
		update_post_meta($postID, $field_name, $newvalue);
	}

}

//init

add_action('admin_menu', 'create_meta_box'); 
add_action('save_post', 'save_postdata'); 

/*
	End creating custom fields
*/

?>