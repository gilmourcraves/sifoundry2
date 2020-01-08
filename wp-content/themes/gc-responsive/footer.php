
		<div class="push"></div>
		</div>
		<footer>
			<div class="container-page container-section-grey">
				<div class="container footer-page-inner">


					<div class="row">
						<div class="col-md-12">

							<nav role="navigation">
							<?php
							wp_nav_menu( array(
								'menu'            => 'footer',
								'theme_location'  => 'footer',
								'depth'           => 2,
								'container'       => 'div',
								'container_class' => 'menu-footer',
								'menu_class'      => 'nav-footer'
							) );
							?>
							</nav>

							<div class="container-bottom-scroll-to-top">
								<div class="scroll-to-top"></i></div>
							</div>

							<?php if ( is_active_sidebar( 'social_widget' ) ) : ?>
								<div id="social-widget" role="complementary">
									<?php dynamic_sidebar( 'social_widget' ); ?>
								</div>
							<?php endif; ?>
							<?php if ( is_active_sidebar( 'footer_widget' ) ) : ?>
								<div id="footer-widget" class="container-footer">
									<?php dynamic_sidebar( 'footer_widget' ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>


					<div class="row">
						<div class="col-md-12">

							<?php if ( is_active_sidebar( 'copyright_widget' ) ) : ?>
								<div id="copyright-widget" role="complementary">
									<?php dynamic_sidebar( 'copyright_widget' ); ?>
								</div>
							<?php endif; ?>

						</div>
					</div>



				</div>
			</div>
		</footer>


        <?php wp_footer(); ?>


</body>
</html>