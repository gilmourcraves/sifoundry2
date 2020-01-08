<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *

 */
?>

<?php get_header(); ?>


<div class="container-page container-first-row">
	<div id="main">

		<div class="container">

			<div class="row">
				<div class="col-md-8">

					<h1>Browsing: <?php single_cat_title(); ?></h1>

				</div>
				<div class="col-md-4">
					<?php if ( is_active_sidebar( 'primary_sidebar' ) ) : ?>
						<?php dynamic_sidebar( 'primary_sidebar' ); ?>
					<?php endif; ?>
				</div>
			</div>

			<hr/>

			<section id="blog-items">
				<div class="row">
					<div class="col-md-12">

						<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
							$post_categories = get_the_category_list( ', ', get_the_ID() );
							$the_title       = get_the_title();
							$the_title       = strlen( $the_title ) > 80 ? substr( $the_title, 0, 80 ) . "..." : $the_title;
							?>
							<article class="blog-item">

								<div class="col-md-4">

									<div class="container-blog-item"
									     style="background-image: url(<?php echo get_primary_image( get_the_ID(), 'large' ); ?>); background-size: cover; background-position: center center">


										<a href="<?php echo get_permalink( get_the_ID() ); ?>"
										   class="blog-title"><?php echo $the_title; ?></a><br/>


									</div>

									<ul class="blog-item-info blog-item-info-archive">
										<li><span class="blog-date">  <?php the_time( 'F j, Y' ); ?></span></li>
										<li><span class="blog-author">  <?php the_author(); ?></span></li>
										<li><span class="blog-categories">  <?php echo $post_categories; ?></span></li>
									</ul>

								</div>

							</article>
						<?php endwhile;
						else: ?>

							<p>Sorry, no posts to list</p>

						<?php endif; ?>

						<?php gc_pagination(); ?>

					</div>


				</div>
			</section>

		</div>
	</div>
</div>

<?php get_footer(); ?>


