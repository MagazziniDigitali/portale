<?php
/**
 * Header file for the Twenty Twenty WordPress default theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

        if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

?><!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<link rel="profile" href="https://gmpg.org/xfn/11">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
		<link rel="stylesheet" href="/area-riservata/src/style.css">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<?php
		wp_body_open();
		?>

		<header id="site-header" class="header-footer-group" role="banner">

			<div class="header-inner section-inner">

				<div class="header-titles-wrapper">

					<?php

					// Check whether the header search is activated in the customizer.
					$enable_header_search = get_theme_mod( 'enable_header_search', true );

					if ( true === $enable_header_search ) {

						?>

						<button class="toggle search-toggle mobile-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
							<span class="toggle-inner">
								<span class="toggle-icon">
									<?php twentytwenty_the_theme_svg( 'search' ); ?>
								</span>
								<span class="toggle-text"><?php _e( 'Search', 'twentytwenty' ); ?></span>
							</span>
						</button><!-- .search-toggle -->

					<?php } ?>

					<div class="header-titles">

						<?php
							// Site title or logo.
							twentytwenty_site_logo();

							// Site description.
							twentytwenty_site_description();
						?>

					</div><!-- .header-titles -->

					<button class="toggle nav-toggle mobile-nav-toggle" data-toggle-target=".menu-modal"  data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
						<span class="toggle-inner">
							<span class="toggle-icon">
								<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
							</span>
							<span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span>
						</span>
					</button><!-- .nav-toggle -->

				</div><!-- .header-titles-wrapper -->

				<div class="header-navigation-wrapper">

					<?php
					if ( has_nav_menu( 'primary' ) || ! has_nav_menu( 'expanded' ) ) {
						?>

							<nav class="primary-menu-wrapper" aria-label="<?php esc_attr_e( 'Horizontal', 'twentytwenty' ); ?>" role="navigation">

								<ul class="primary-menu reset-list-style">

								<?php
								if ( has_nav_menu( 'primary' ) ) {

									wp_nav_menu(
										array(
											'container'  => '',
											'items_wrap' => '%3$s',
											'theme_location' => 'primary',
										)
									);

								} elseif ( ! has_nav_menu( 'expanded' ) ) {

									wp_list_pages(
										array(
											'match_menu_classes' => true,
											'show_sub_menu_icons' => true,
											'title_li' => false,
											'walker'   => new TwentyTwenty_Walker_Page(),
										)
									);

								}
								?>
								<?php
									if(!isset($_SESSION['username'])) { ?>

										<li id="menu-item-C02" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-C02">
											<p class="btn btn-outline-primary">Area Riservata</p>

											<ul class="sub-menu">
												<li id="menu-item-C03" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-C03">
													<a href="/area-riservata/login">Login</a>
												</li>
												
												<li id="menu-item-C04" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-C04">
													<a href="/area-riservata/signup">Registrati</a>
												</li>
											</ul>
										</li>
									
									<?php } else { ?>

										<li id="menu-item-C02" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-C02">
											<p class="btn btn-outline-primary"><?php echo $_SESSION['username'];?></p>

											<ul class="sub-menu">
												<li id="menu-item-C03" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-C03">
													<a href="/area-riservata/">Home</a>
												</li>

												<li id="menu-item-C04" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-C04">
													<a href="
													<?php if ($_SESSION['role'] == 'superadmin'){ ?>
														/area-riservata/admin/profile
													<?php } elseif ($_SESSION['role'] == 'admin_istituzione'){ ?>
														/area-riservata/istituzione/profile
													<?php } else { ?>
														/area-riservata/user/profile
													<?php } ?>
													
													">Profilo</a>
												</li>
												<?php if ($_SESSION['role'] == 'superadmin'){ ?>
													<li id="menu-item-C04" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-C04">
														<a href="

															/area-riservata/admin/import



														">Import Istituzioni</a>
													</li>
												<?php } ?>
												<?php if (($_SESSION['role'] != 'superadmin') && ($_SESSION['istituzione'] != 'istituzioneBase') && ($_SESSION['istituzione'] != '') && ($_SESSION['ebook'] == 'y')){ ?>
												<li id="menu-item-C05" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-C05">
													<a href="
													<?php if ($_SESSION['role'] == 'admin_istituzione'){ ?>
														/area-riservata/istituzione/upload-bagit
													<?php } elseif ($_SESSION['role'] == 'user_istituzione'){ ?>
														/area-riservata/user/upload-bagit
													<?php } ?>
													">Carica BAGIT</a>
												</li>
												<?php } ?>
												<li id="menu-item-C06" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-C06">
													<a href="/area-riservata/logout">Logout</a>
												</li>
											</ul>
										</li>
									<?php } ?>

								</ul>

							</nav><!-- .primary-menu-wrapper -->

						<?php
					}

					if ( true === $enable_header_search || has_nav_menu( 'expanded' ) ) {
						?>

						<div class="header-toggles hide-no-js">

						<?php
						if ( has_nav_menu( 'expanded' ) ) {
							?>

							<div class="toggle-wrapper nav-toggle-wrapper has-expanded-menu">

								<button class="toggle nav-toggle desktop-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
									<span class="toggle-inner">
										<span class="toggle-text"><?php _e( 'Menu', 'twentytwenty' ); ?></span>
										<span class="toggle-icon">
											<?php twentytwenty_the_theme_svg( 'ellipsis' ); ?>
										</span>
									</span>
								</button><!-- .nav-toggle -->

							</div><!-- .nav-toggle-wrapper -->

							<?php
						}

						if ( true === $enable_header_search ) {
							?>

							<div class="toggle-wrapper search-toggle-wrapper">

								<button class="toggle search-toggle desktop-search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
									<span class="toggle-inner">
										<?php twentytwenty_the_theme_svg( 'search' ); ?>
										<span class="toggle-text"><?php _e( 'Search', 'twentytwenty' ); ?></span>
									</span>
								</button><!-- .search-toggle -->

							</div>

							<?php
						}
						?>

						</div><!-- .header-toggles -->
						<?php
					}
					?>

				</div><!-- .header-navigation-wrapper -->

			</div><!-- .header-inner -->

			<?php
			// Output the search modal (if it is activated in the customizer).
			if ( true === $enable_header_search ) {
				get_template_part( 'template-parts/modal-search' );
			}
			?>

		</header><!-- #site-header -->

		<?php
		// Output the menu modal.
		get_template_part( 'template-parts/modal-menu' );
