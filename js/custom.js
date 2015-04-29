/*
	Easy plugin to get element index position
	Author: Peerapong Pulpipatnan
	http://themeforest.net/user/peerapong
*/

var $j = jQuery.noConflict();

/* jquery.imagefit 
 *
 * Version 0.2 by Oliver Boermans <http://www.ollicle.com/eg/jquery/imagefit/>
 *
 * Extends jQuery <http://jquery.com>
 *
 */
(function($) {
	$.fn.imagefit = function(options) {
		var fit = {
			all : function(imgs){
				imgs.each(function(){
					fit.one(this);
					})
				},
			one : function(img){
				$(img)
					.width('100%').each(function()
					{
						$(this).height(Math.round(
							$(this).attr('startheight')*($(this).width()/$(this).attr('startwidth')))
						);
					})
				}
		};
		
		this.each(function(){
				var container = this;
				
				// store list of contained images (excluding those in tables)
				var imgs = $('img', container).not($("table img"));
				
				// store initial dimensions on each image 
				imgs.each(function(){
					$(this).attr('startwidth', $(this).width())
						.attr('startheight', $(this).height())
						.css('max-width', $(this).attr('startwidth')+"px");
				
					fit.one(this);
				});
				// Re-adjust when window width is changed
				$(window).bind('resize', function(){
					fit.all(imgs);
				});
			});
		return this;
	};
})(jQuery);


$j.fn.getIndex = function(){
	var $jp=$j(this).parent().children();
    return $jp.index(this);
}
 
jQuery.fn.extend({
  slideRight: function() {
    return this.each(function() {
    	jQuery(this).show();
    });
  },
  slideLeft: function() {
    return this.each(function() {
    	jQuery(this).hide();
    });
  },
  slideToggleWidth: function() {
    return this.each(function() {
      var el = jQuery(this);
      if (el.css('display') == 'none') {
        el.slideRight();
      } else {
        el.slideLeft();
      }
    });
  }
});

$j.fn.setNav = function(){
	$j('#main_menu li ul').css({display: 'none'});

	$j('#main_menu li').each(function()
	{	
		var $jsublist = $j(this).find('ul:first');
		
		$j(this).hover(function()
		{	
			$jsublist.css({opacity: 1});
			
			$jsublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).fadeIn(200, function()
			{
				$j(this).css({overflow:'visible', height:'auto', display: 'block'});
			});	
		},
		function()
		{	
			$jsublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).fadeOut(200, function()
			{
				$j(this).css({overflow:'hidden', display:'none'});
			});	
		});	
		
	});
	
	$j('#main_menu li').each(function()
	{
		
		$j(this).hover(function()
		{	
			$j(this).find('a:first').addClass('hover');
		},
		function()
		{	
			$j(this).find('a:first').removeClass('hover');
		});	
		
	});
	
	$j('#menu_wrapper .nav ul li ul').css({display: 'none'});

	$j('#menu_wrapper .nav ul li').each(function()
	{	
		
		var $jsublist = $j(this).find('ul:first');
		
		$j(this).hover(function()
		{	
			$jsublist.css({opacity: 1});
			
			$jsublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).fadeIn(200, function()
			{
				$j(this).css({overflow:'visible', height:'auto', display: 'block'});
			});	
		},
		function()
		{	
			$jsublist.stop().css({overflow:'hidden', height:'auto', display:'none'}).fadeOut(200, function()
			{
				$j(this).css({overflow:'hidden', display:'none'});
			});	
		});	
		
	});
	
	$j('#menu_wrapper .nav ul li').each(function()
	{
		
		$j(this).hover(function()
		{	
			$j(this).find('a:first').addClass('hover');
		},
		function()
		{	
			$j(this).find('a:first').removeClass('hover');
		});	
		
	});
}

$j(document).ready(function(){ 

	$j(document).setNav();

	$j('.pp_gallery a').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
	
	$j('a[rel=gallery]').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
	
	$j('.img_frame').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
	
	$j('.flickr li a').fancybox({ 
		padding: 0,
		overlayColor: '#000', 
		transitionIn: 'elastic',
		transitionOut: 'elastic',
		overlayOpacity: .8
	});
    
    $j('.img_nofade').hover(function(){  
			$j(this).animate({opacity: .5}, 300);
 		}  
  		, function(){  
  			$j(this).animate({opacity: 1}, 300);
  		}  	
	);
	
	$j('.nav > li a').not("ul li ul a").each(function()
	{
		if($j(this).attr('title') && $j(this).children('span').html() == null)
		{
			$j(this).append('<span>'+$j(this).attr('title')+'</span>');
		}
	});
		
	$j.history.init(function(hash){
        if(hash == "") {
            // initialize your app
        } else {
        	// restore the state from hash
        	if(typeof($j('#'+hash).children('a').attr('rel')) != 'undefined')
        	{
        		$j('.nav li').removeClass('current-menu-item');
        	
            	target_url = $j('#'+hash).children('a').attr('rel');
				target_id = $j('#'+hash).attr('id');
				current_target_id = $j('#homepage_wrapper').attr('rel');
				
				$j('#homepage_wrapper').attr('rel', target_id);

				if(current_target_id != target_id)
				{
					$j('#supersized-loader').css({display: 'block'});
					$j('#homepage_wrapper').children('.inner').css('display', 'none');
					$j('#corner_right').css('display', 'none');
					$j('#corner_right_bottom').css('display', 'none');
					$j('#homepage_wrapper').css('display', 'none');
					$j('#expand_button').css('display', 'none');
					
					$j.ajax({
					  	url: target_url,
					  	type: "GET",
					  	dataType: "HTML",
					  	success: function(data){
					    	$j('#homepage_wrapper').children('.inner').html(data);
					  	}
					});
				}

				$j('#map_contact').css('position', 'fixed');
				$j('#'+hash).addClass('current-menu-item');
				$j('#map_contact').css('position', 'fixed');
				scroll(0,0);
			}
        }
    },
    { unescape: ",/" });
	
	$j('.nav li.page_item:not(.blog), li.menu-item-object-page:not(.blog), li ul li.menu-item-object-page:not(.blog), li ul li.page_item:not(.blog)').unbind("click").click(function(){
		target_url = $j(this).children('a').attr('href');
		target_id = $j(this).attr('id');
		current_target_id = $j('#homepage_wrapper').attr('rel');
		
		target_url = target_url.replace(/^.*#/, '');
        $j.history.load(target_url);
        return false;
	});
	
	$j('.nav li.blog, .nav li ul li.blog, .nav li.menu-item-object-post, .nav li ul li.menu-item-object-post, .nav li.menu-item-object-category, .nav li ul li.menu-item-object-category, .nav li.menu-item-object-post_tag, .nav li ul li.menu-item-object-post_tag').click(function(){
		location.href = $j(this).children('a').attr('href');
		return false;
	});
	
	$j('.nav li.menu-item-object-custom, .nav li ul li.menu-item-object-custom').click(function(){
		location.href = $j(this).children('a').attr('href');
		return false;
	});
	
	$j('.nav li.menu-item-object-gallery, li ul li.menu-item-object-gallery').unbind("click").click(function(){
		target_url = $j(this).children('a').attr('href');
		target_id = $j(this).attr('id');
		current_target_id = $j('#homepage_wrapper').attr('rel');
		
		target_url = target_url.replace(/^.*#/, '');
        $j.history.load(target_url);
        return false;
	});
	
	$j('.nav li.menu-item-object-menu-cats, li ul li.menu-item-object-menu-cats').unbind("click").click(function(){
		target_url = $j(this).children('a').attr('href');
		target_id = $j(this).attr('id');
		current_target_id = $j('#homepage_wrapper').attr('rel');
		
		target_url = target_url.replace(/^.*#/, '');
        $j.history.load(target_url);
        return false;
	});
	
	 $j('#close_button').click(function(){
    	close_target = $j(this).attr('data-rel');
    	$j(close_target).children('.inner').hide();

    	if($j(close_target).css('display') != 'none')
		{
			$j(close_target).stop().animate({width: 'toggle'});
			$j(close_target).hide();
		}
		$j('#corner_right').hide();
		$j('#corner_right_bottom').hide();
		$j('#expand_button').fadeIn();
    });
    
    $j('#expand_button').click(function(){
    	$j(this).hide();
    	close_target = $j(this).attr('data-rel');
    	$j(close_target).show();
		$j(close_target).children('.inner').css('display', 'block');
		$j('#corner_right').fadeIn();
		$j('#corner_right_bottom').fadeIn();
    });
	
	$j('input[title!=""]').hint();
	
	$j('textarea[title!=""]').hint();
	
	if(BrowserDetect.browser == 'Explorer' && BrowserDetect.version < 9)
 	{
   		$j(".nav li:last-child").css("border-bottom","0px");
	}

});
