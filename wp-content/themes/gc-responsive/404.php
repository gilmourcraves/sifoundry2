<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage gc-responsive
 * @since gc-responsive 1.0
 */
?>

<?php
header("HTTP/1.1 301 Moved Permanently");
header("Location: ".get_bloginfo('url'));
exit();
?>

<?php get_header(); ?>


	<div class="container-page container-first-row">
		<div id="main">

				<div class="container">
				<h1 data-aos="fade-right" data-aos-duration="500" data-aos-anchor="body">Page Not Found - 404 Error</h1>

					<?php if ( is_active_sidebar( '404_widget' ) ) : ?>

							<?php dynamic_sidebar( '404_widget' ); ?>

					<?php endif; ?>


				</div>
		</div>
	</div>



<?php get_footer(); ?>