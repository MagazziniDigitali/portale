<?php
/**
 * Displays the menu icon and modal
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

?>

<div class="menu-modal cover-modal header-footer-group" data-modal-target-string=".menu-modal">

	<div class="menu-modal-inner modal-inner">

		<div class="menu-wrapper section-inner">

			<div class="menu-top">

				<button class="toggle close-nav-toggle fill-children-current-color" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".menu-modal">
					<span class="toggle-text"><?php _e( 'Close Menu', 'twentytwenty' ); ?></span>
					<?php twentytwenty_the_theme_svg( 'cross' ); ?>
				</button><!-- .nav-toggle -->

				<?php

				$mobile_menu_location = '';

				// If the mobile menu location is not set, use the primary and expanded locations as fallbacks, in that order.
				if ( has_nav_menu( 'mobile' ) ) {
					$mobile_menu_location = 'mobile';
				} elseif ( has_nav_menu( 'primary' ) ) {
					$mobile_menu_location = 'primary';
				} elseif ( has_nav_menu( 'expanded' ) ) {
					$mobile_menu_location = 'expanded';
				}

				if ( has_nav_menu( 'expanded' ) ) {

					$expanded_nav_classes = '';

					if ( 'expanded' === $mobile_menu_location ) {
						$expanded_nav_classes .= ' mobile-menu';
					}

					?>

					<nav class="expanded-menu<?php echo esc_attr( $expanded_nav_classes ); ?>" aria-label="<?php esc_attr_e( 'Expanded', 'twentytwenty' ); ?>" role="navigation">

						<ul class="modal-menu reset-list-style">
							<?php
							if ( has_nav_menu( 'expanded' ) ) {
								wp_nav_menu(
									array(
										'container'      => '',
										'items_wrap'     => '%3$s',
										'show_toggles'   => true,
										'theme_location' => 'expanded',
									)
								);
							}
							?>
						</ul>

						

					</nav>

					<?php
				}

				if ( 'expanded' !== $mobile_menu_location ) {
					?>

					<nav class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'twentytwenty' ); ?>" role="navigation">

						<ul class="modal-menu reset-list-style">

						<?php
						if ( $mobile_menu_location ) {

							wp_nav_menu(
								array(
									'container'      => '',
									'items_wrap'     => '%3$s',
									'show_toggles'   => true,
									'theme_location' => $mobile_menu_location,
								)
							);

						} else {

							wp_list_pages(
								array(
									'match_menu_classes' => true,
									'show_toggles'       => true,
									'title_li'           => false,
									'walker'             => new TwentyTwenty_Walker_Page(),
								)
							);

						}
						?>						
							<?php
								if(!isset($_SESSION['username'])) { ?>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-C01">
										<div class="ancestor-wrapper">
											<a href="/area-riservata/login/">Area Riservata</a>
											<button class="toggle sub-menu-toggle fill-children-current-color" data-toggle-target=".menu-modal .menu-item-C01 > .sub-menu" data-toggle-type="slidetoggle" data-toggle-duration="250" aria-expanded="false">
												<span class="screen-reader-text">Mostra il sottomenu</span>
												<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="20" height="12" viewBox="0 0 20 12">
												<polygon fill="" fill-rule="evenodd" points="1319.899 365.778 1327.678 358 1329.799 360.121 1319.899 370.021 1310 360.121 1312.121 358" transform="translate(-1310 -358)"></polygon></svg>
											</button>
										</div>
										<ul class="sub-menu">
											<li class="menu-item menu-item-type-post_type menu-item-object-page"><div class="ancestor-wrapper"><a href="/area-riservata/login/">Login</a></div></li>
											<li class="menu-item menu-item-type-post_type menu-item-object-page"><div class="ancestor-wrapper"><a href="/area-riservata/signup">Registrati</a></div></li>
										</ul>
									</li>
								<?php } else { ?>

									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-C01">
										<div class="ancestor-wrapper">
											<a href="/area-riservata/login/">
											<?php echo $_SESSION['username'];?></a>
											<button class="toggle sub-menu-toggle fill-children-current-color" data-toggle-target=".menu-modal .menu-item-C01 > .sub-menu" data-toggle-type="slidetoggle" data-toggle-duration="250" aria-expanded="false">
												<span class="screen-reader-text">Mostra il sottomenu</span>
												<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="20" height="12" viewBox="0 0 20 12">
												<polygon fill="" fill-rule="evenodd" points="1319.899 365.778 1327.678 358 1329.799 360.121 1319.899 370.021 1310 360.121 1312.121 358" transform="translate(-1310 -358)"></polygon></svg>
											</button>
										</div>
										<ul class="sub-menu">
											<li class="menu-item menu-item-type-post_type menu-item-object-page"><div class="ancestor-wrapper"><a href="/area-riservata/">Home</a></div></li>
											<li class="menu-item menu-item-type-post_type menu-item-object-page">
												<div class="ancestor-wrapper">
													<a href="
														<?php if ($_SESSION['role'] == 'superadmin'){ ?>
															/area-riservata/admin/profile
														<?php } elseif ($_SESSION['role'] == 'admin_istituzione'){ ?>
															/area-riservata/istituzione/profile
														<?php } else { ?>
															/area-riservata/user/profile
														<?php } ?>
														
														">Profilo
													</a>
												</div>
											</li>
											<?php 
											if ($_SESSION['role'] != 'superadmin' || $_SESSION['istituzione'] != 'istituzioneBase' || $_SESSION['istituzione'] != '' && ($_SESSION['ebook'] == 'y')){ ?>
											<li class="menu-item menu-item-type-post_type menu-item-object-page">
												<div class="ancestor-wrapper">
													<a href="
													<?php if ($_SESSION['role'] == 'admin_istituzione'){ ?>
														http://md-collaudo.depositolegale.it/area-riservata/istituzione/upload-bagit
													<?php } elseif ($_SESSION['role'] == 'user_istituzione'){ ?>
														http://md-collaudo.depositolegale.it/area-riservata/user/upload-bagit
													<?php } ?>
														
														">Carica BAGIT
													</a>
												</div>
											</li>
											<?php } ?>
											<li class="menu-item menu-item-type-post_type menu-item-object-page"><div class="ancestor-wrapper"><a href="/area-riservata/logout">Logout</a></div></li>
										</ul>
									</li>

							<?php } ?>
						</ul>

					</nav>

					<?php
				}
				?>

			</div><!-- .menu-top -->

			<div class="menu-bottom">

				<?php if ( has_nav_menu( 'social' ) ) { ?>

					<nav aria-label="<?php esc_attr_e( 'Expanded Social links', 'twentytwenty' ); ?>" role="navigation">
						<ul class="social-menu reset-list-style social-icons fill-children-current-color">

							<?php
							wp_nav_menu(
								array(
									'theme_location'  => 'social',
									'container'       => '',
									'container_class' => '',
									'items_wrap'      => '%3$s',
									'menu_id'         => '',
									'menu_class'      => '',
									'depth'           => 1,
									'link_before'     => '<span class="screen-reader-text">',
									'link_after'      => '</span>',
									'fallback_cb'     => '',
								)
							);
							?>

						</ul>
					</nav><!-- .social-menu -->

				<?php } ?>

			</div><!-- .menu-bottom -->

		</div><!-- .menu-wrapper -->

	</div><!-- .menu-modal-inner -->

</div><!-- .menu-modal -->
