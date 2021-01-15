<?php
/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */
?>
		<footer id="site-footer" role="contentinfo" class="header-footer-group">

			<div class="section-inner">
				<div class="row">
					<div class="col-md-3 col-xs-12">
						<div class="footer-credits">

							<p class="footer-copyright">&copy;
								<?php
								echo date_i18n(
									/* translators: Copyright date format, see https://www.php.net/date */
									_x( 'Y', 'copyright date format', 'twentytwenty' )
								);
								?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
							</p><!-- .footer-copyright -->

						</div><!-- .footer-credits -->
					</div>
					<div class="col-md-7 col-xs-12">
						<div class="row">
							<div class="col-md-3 col-xs-12"><img class="loghiFooter" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" ?>wp-content/uploads/2020/10/logo_dgbid.jpg" alt="DGBIC"></div>
							<div class="col-md-3 col-xs-12"><img class="loghiFooter" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" ?>wp-content/uploads/2020/10/bncr.jpg" alt="BNCR"></div>
							<div class="col-md-3 col-xs-12"><img class="loghiFooter" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" ?>wp-content/uploads/2020/10/bncf.jpg" alt="BNCF"></div>
							<div class="col-md-3 col-xs-12"><img class="loghiFooter" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/" ?>wp-content/uploads/2020/10/marciana.gif" alt="Marciana"></div>
						</div>
					</div>
					<div class="col-md-2 col-xs-12">
						<a class="to-the-top" href="#site-header">
							<span class="to-the-top-long">
								<?php
								/* translators: %s: HTML character for up arrow. */
								printf( __( 'To the top %s', 'twentytwenty' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
								?>
							</span><!-- .to-the-top-long -->
							<span class="to-the-top-short">
								<?php
								/* translators: %s: HTML character for up arrow. */
								printf( __( 'Up %s', 'twentytwenty' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
								?>
							</span><!-- .to-the-top-short -->
						</a><!-- .to-the-top -->
					</div>
				</div>

				<div class="row mt-5">
					<div class="col-md-12 col-xs-12 text-center">
						<p class="powered-by-wordpress">
							<small><a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentytwenty' ) ); ?>">
								<?php _e( 'Powered by WordPress', 'twentytwenty' ); ?>
							</a></small>
						</p>
					</div>
				</div>
				

			</div><!-- .section-inner -->

		</footer><!-- #site-footer -->

		<script>
			var magazziniDigitali = document.querySelector('li#menu-item-32');
			var memoria = document.querySelector('li#menu-item-30>a');
			var consultazione = document.querySelector('li#menu-item-33>a');

			magazziniDigitali.classList.add('d-none');
			memoria.classList.add('d-none');
			consultazione.classList.add('d-none');

			<?php
			if(isset($_SESSION['username']) && $_SESSION['username'] == 'superadmin') { ?>

				memoria.classList.remove('d-none');
				consultazione.classList.remove('d-none');
				magazziniDigitali.classList.remove('d-none');

			<?php } elseif (isset($_SESSION['username'])) { ?>

				magazziniDigitali.classList.remove('d-none');
				
			<?php } ?>

		</script>
		
		<?php wp_footer(); ?>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	</body>
</html>
