<?php
/**
 * The template for displaying search results pages.
 *
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

<div class="container-page container-first-row">
	<div id="main">
		<div class="container-section-white container-section-search-top">
			<div class="container">
				<h1 class="search" style="">RESULTS FOR: <span class="orange"><?php print  get_search_query(); ?></span></h1>

				<div class="row">
					<div class="col-md-8 col-xs-12">
					<?php
					global $wp_query;
					$total_results = $wp_query->found_posts;
					?>

					Number of Results: <?php print $total_results ?><br /><br />

					</div>
				</div>
			</div>
		</div>

		<div class="container-section-white">
			<div class="container">


				<form class="search-main" action="/" method="get" role="search" id="searchform">
					<div class="row">
						<div class="col-md-6 col-xs-9">

							<input type="text" name="s" id="s" class="form-control form-search-input" />


						</div>

						<div class="col-md-2 col-xs-3">

							<input name="submit" type="submit" id="submit" class="submit btn btn-default" value="Search">

						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="container-section-white">
				<div class="container">
				<ul class="list-search">
				<?php
				// Start the loop.
				while ( have_posts() ) : the_post();
					?>

					<li>


							<div class="row">
								<div class="col-md-3">
									<a href="<?php echo get_permalink( get_the_ID() ); ?>">
										<div class="item-image" style="background-image: url(<?php echo get_primary_image(get_the_ID(), 'large'); ?>); background-size: cover; background-position: center center">

										</div>
									</a>
								</div>

								<div class="col-md-9">
									<a href="<?php echo get_permalink( get_the_ID() ); ?>"
									   class="blog-title"><?php the_title(); ?></a><br/>



									<div class="container-excerpt">
										<p><?php echo get_excerpt(140)?></p>
									</div>
								</div>

							</div>



					</li>



					<?php
					esc_url( get_permalink() );

					// End the loop.
				endwhile; ?>
				</ul>


					<?php gc_pagination(); ?>

				</div>
		</div>
	</div>

	<?php


// If no content, include the "No posts found" template.
else : ?>

	<div class="container-section-white">
		<div class="container">

			<h1>Search</h1>
	There were no results for <?php echo get_search_query(); ?>

		</div>
	</div>


	<?php
endif;
?>

		</div>
	</div>
<?php get_footer(); ?>