<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'pepbiz'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	

	$options[] = array(
		'name' => __('Basic Settings', 'pepbiz'),
		'type' => 'heading');

	$options[] = array( "name" => __('Custom logo image', 'pepbiz'),
						"desc" => __('You can upload custom image for your website logo (optional).', 'pepbiz'),
						"id" => "pepbiz_logo_image",
						"type" => "upload");
 	$options[] = array( "name" => __('Phone number', 'pepbiz'),
						"id" => "pepbiz_phone",
                        "desc" => __('Phone number is displayed in the top left corner of the page.', 'pepbiz'),
						"type" => "text");     

	$options[] = array(
		'name' => __('Social Networks', 'pepbiz'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Facebook account', 'pepbiz_theme_options'),
		'desc' => __('Enter Facebook account (e.g. pepthemes) or leave empty if you dont wish to use Facebook', 'pepbiz'),
		'id' => 'facebook_link',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Twitter account', 'pepbiz_theme_options'),
		'desc' => __('Enter Twitter account (e.g. pepthemes) or leave empty if you dont wish to use Twitter', 'pepbiz'),
		'id' => 'twitter_link',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Google+ account', 'pepbiz_theme_options'),
		'desc' => __('Enter Google+ account (e.g. 12345667890123) or leave empty if you dont wish to use Google+','pepbiz'),
		'id' => 'google_link',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('YouTube Account', 'pepbiz_theme_options'),
		'desc' => __('Enter YouTube account (e.g. pepthemes) or leave empty if you dont wish to use YouTube','pepbiz'),
		'id' => 'youtube_link',
		'std' => '',
		'type' => 'text');
	$options[] = array(
		'name' => __('Flickr Account', 'pepbiz_theme_options'),
		'desc' => __('Enter url of Flickr account (e.g. pepthemes) or leave empty if you dont wish to use Flickr', 'pepbiz'),
		'id' => 'flickr_link',
		'std' => '',
		'type' => 'text');

	$options[] = array(
		'name' => __('Slider', 'pepbiz'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Enable Slider', 'pepbiz'),
		'desc' => __('Check this to enable the Slider.', 'pepbiz'),
		'id' => 'slider_enabled',
		'type' => 'checkbox',
		'std' => '0' );
	
	$options[] = array(
		'name' => __('Using the Slider', 'pepbiz'),
		'desc' => __('This Slider supports upto 5 images. To show only 3 Slides in the slider, upload only 3 images. Leave the rest Blank. For best results, upload images with width more than 960px.', 'pepbiz'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Slide 1', 'pepbiz'),
		'desc' => __('First Slide Image', 'pepbiz'),
		'id' => 'slide1',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'pepbiz'),
		'id' => 'slidetitle1',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url Address', 'pepbiz'),
		'id' => 'slideurl1',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slide 2', 'pepbiz'),
		'desc' => __('Second Slide Image', 'pepbiz'),
		'class' => '',
		'id' => 'slide2',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'pepbiz'),
		'id' => 'slidetitle2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url Address', 'pepbiz'),
		'id' => 'slideurl2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Slide 3', 'pepbiz'),
		'desc' => __('Third Slide Image', 'pepbiz'),
		'id' => 'slide3',
		'class' => '',
		'type' => 'upload');	
	
	$options[] = array(
		'desc' => __('Title', 'pepbiz'),
		'id' => 'slidetitle3',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url Address', 'pepbiz'),
		'id' => 'slideurl3',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slide 4', 'pepbiz'),
		'desc' => __('Fourth Slide Image', 'pepbiz'),
		'id' => 'slide4',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'desc' => __('Title', 'pepbiz'),
		'id' => 'slidetitle4',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url Address', 'pepbiz'),
		'id' => 'slideurl4',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slide 5', 'pepbiz'),
		'desc' => __('Fifth Slide Image', 'pepbiz'),
		'id' => 'slide5',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'desc' => __('Title', 'pepbiz'),
		'id' => 'slidetitle5',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Url Address', 'pepbiz'),
		'id' => 'slideurl5',
		'std' => '',
		'type' => 'text');	


	return $options;
}