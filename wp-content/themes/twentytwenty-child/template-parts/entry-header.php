<?php
/**
 * Displays the post header
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$entry_header_classes = '';

if ( is_singular() ) {
	$entry_header_classes .= ' header-footer-group';
}

?>


	<?php if ( is_front_page() || is_home() && ! is_page() ){ ?>

		<header id="homeHeader" class="entry-header has-text-align-center<?php echo esc_attr( $entry_header_classes ); ?>">

	<?php } else { ?>

		<header id="homeHeader" class="entry-header has-text-align-center welcomePad"> <!--<?php echo esc_attr( $entry_header_classes ); ?>-->
		<!--		<header class="entry-header has-text-align-center<?php echo esc_attr( $entry_header_classes ); ?>">
 -->
	<?php } ?>

	<div class="entry-header-inner section-inner medium">

		<?php
		/**
		 * Allow child themes and plugins to filter the display of the categories in the entry header.
		 *
		 * @since Twenty Twenty 1.0
		 *
		 * @param bool   Whether to show the categories in header, Default true.
		 */
		$show_categories = apply_filters( 'twentytwenty_show_categories_in_entry_header', true );

		if ( true === $show_categories && has_category() ) {
			?>

			<div class="entry-categories">
				<span class="screen-reader-text"><?php _e( 'Categories', 'twentytwenty' ); ?></span>
				<div class="entry-categories-inner">
					<?php the_category( ' ' ); ?>
				</div><!-- .entry-categories-inner -->
			</div><!-- .entry-categories -->

			<?php
		}

		if ( is_singular() ) {
            the_title( '<h5 class="entry-title">', '</h5>' );

            if ( is_front_page() || is_home() && ! is_page() ){
                echo '<h2 style="font-size: 35px;">Servizio nazionale coordinato di conservazione e accesso a<br>lungo termine per le risorse digitali</h2>';
            }
		} else {
			the_title( '<h2 class="entry-title heading-size-1"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' );
        }
        
		$intro_text_width = '';

		if ( is_singular() ) {
			$intro_text_width = ' small';
		} else {
			$intro_text_width = ' thin';
		}

		if ( has_excerpt() && is_singular() ) {
			?>

			<div class="intro-text section-inner max-percentage<?php echo $intro_text_width; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static output ?>">
				<?php the_excerpt(); ?>
			</div>

			<?php
		}

		// Default to displaying the post meta.
		twentytwenty_the_post_meta( get_the_ID(), 'single-top' );
		?>

	</div><!-- .entry-header-inner -->

</header><!-- .entry-header -->
