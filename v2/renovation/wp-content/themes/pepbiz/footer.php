<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package PepBiz
 */
?>

	</div><!-- #content -->
	  <div id="footer-widgets">
                <?php if( is_active_sidebar( 'footer-1' ) ) dynamic_sidebar( 'footer-1' ); ?>
       </div>
</div><!-- #page -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<nav id="footer-menu">
		<?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'depth'=>'1') ); ?>
		</nav>
		<div class="site-info">
			<?php do_action( 'pepbiz_credits' ); ?>
			<?php _e('Powered by', 'pepbiz'); ?> <a href="//wordpress.org" title="WordPress" target="_blank"><?php _e('WordPress', 'pepbiz'); ?></a> &amp;
			 <a href="<?php echo esc_url('http://pepthemes.com'); ?>" title="<?php _e('PepThemes', 'pepbiz'); ?>" target="_blank"><?php _e('PepThemes', 'pepbiz'); ?></a>.
	
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
<?php wp_footer(); ?></body>
</html>