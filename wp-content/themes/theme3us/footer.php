		
	</main><!-- #main -->

	<footer id="footer" class="site-footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">
		<div class="container">
			<div class="footer-top">
				<?php
					dynamic_sidebar( 'top_footer');
				?>
			</div><!-- .footer-top -->
		</div>
		<div class="footer-bottom">
		    <div class="container">
    			<div class="row">
    			<?php
    				for ( $i = 1; $i <= 3; $i++ ) {
    					if ( is_active_sidebar( 'bottom-' . $i ) ) :
    						echo '<div class="col-lg-4 col-md-6 col-sm-12 bottom-' . $i . '">';
    						dynamic_sidebar( 'bottom-' . $i );
    						echo '</div>';
    					endif;
    				}
    			?>
    			</div>
    		</div>
		</div><!-- .footer-bottom -->
		<div class="copyright">
		    <div class="container">
		        <?php echo get_field( 'acf_copyright', 'option' ); ?>
		    </div>
		</div>
	</footer><!-- #footer -->
</div><!-- #wrapper -->

<?php wp_footer(); ?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/5b9f05c1c666d426648ad035/default';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
