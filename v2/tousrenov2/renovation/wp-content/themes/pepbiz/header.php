<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package PepBiz
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="top-bar">
		 
			 <?php if ( of_get_option('pepbiz_phone') ) : ?>
            <div id="top-bar-left"><?php _e('Call us at','pepbiz'); ?> <?php echo of_get_option('pepbiz_phone'); ?></div>
            <?php endif; ?>
		
		<div id="top-bar-right">
			<ul class="social">

				<?php if(of_get_option('facebook_link')): ?>
				<li><a href="<?php echo esc_url('http://facebook.com/' .of_get_option('facebook_link')); ?>" title="Facebook"><img src="<?php echo get_template_directory_uri();?>/images/facebook.png" alt="Facebook"></a></li>
				<?php endif; ?>
				<?php if (of_get_option('twitter_link')):?>
				<li><a href="<?php echo  esc_url('http://twitter.com/'.of_get_option('twitter_link')); ?>" title="Twitter"> <img src="<?php echo get_template_directory_uri();?>/images/twitter.png" alt="Twitter"></a></li>
				<?php endif; ?>
				<?php if(of_get_option('google_link')) :?>
				<li><a href="<?php echo esc_url('http://plus.google.com/' .of_get_option('google_link'));?>" title="Google+"><img src="<?php echo get_template_directory_uri();?>/images/google+.png" alt="Google+"></a></li>
				<?php endif; ?>
				<?php if(of_get_option('flickr_link')) :?>
				<li><a href="<?php echo esc_url('http://flickr.com/' .of_get_option('flickr_link')); ?>" title="Flickr"><img src="<?php echo get_template_directory_uri();?>/images/flickr.png" alt="Flickr"></a></li>
				<?php endif; ?>
			 	<?php if(of_get_option('youtube_link')):?>
				<li><a href="<?php echo esc_url('http://youtube.com/'. of_get_option('youtube_link')); ?>" title="YouTube"><img src="<?php echo get_template_directory_uri();?>/images/youtube.png" alt="Youtube"></a></li>
				<?php endif; ?>
 			</ul>
		</div>
	</div>
	

<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>

	<header id="masthead" class="site-header" role="banner">

		<div id="site-branding">
		 <?php if (of_get_option('pepbiz_logo_image')) : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-img"><img src="<?php echo esc_attr(of_get_option('pepbiz_logo_image')); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
                    <?php else : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo('description'); ?>" rel="home"><?php bloginfo('name'); ?></a></h1><h2 class="site-description"><?php bloginfo('description'); ?></h2>
                    <?php endif; ?>		
		</div>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menu', 'pepbiz' ); ?></h1>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'pepbiz' ); ?></a>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
	<?php
    if ( (function_exists( 'of_get_option' )) && (of_get_option('slidetitle5',true) !=1) ) {
	if ( ( of_get_option('slider_enabled') != 0 ) && ( (is_home() == true) || (is_front_page() ==true) ) )  
		{ ?>
    <div id="slider-wrapper">
    <ul class="bxslider">
    	<?php
		  		$slider_flag = false;
		  		for ($i=1;$i<6;$i++) {
					if ( of_get_option('slide'.$i, true) != "" ) {
						echo "<li><a href='".esc_url(of_get_option('slideurl'.$i, true))."'><img src='".of_get_option('slide'.$i, true)."' title='".of_get_option('slidetitle'.$i, true)."'></a></li>";    
						$slider_flag = true;
					}
				}
           ?>
     </ul>   
	</div>
    
    <?php } 
	}
?>
