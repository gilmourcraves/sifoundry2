<?php
/**
 * Template Name: Flexible Content
 * Description: The Flexible Content allows for pages that have various movable sections
 */

?>


<?php get_header(); ?>

<div class="container-page">
	<div id="main">

		<?php while(have_posts()): the_post() ?>


			<?php

			if( have_rows('sections') ):


				// loop through the rows of data
				while ( have_rows('sections') ) : the_row();

					/* SECTION HERO //////////////////////////*/
					if( get_row_layout() == 'hero_video_section' ):

						$title = get_sub_field('title');

						?>

						<section id="hero-video">
							<div class="container">
								<div class="container-gc">
									<div class="container-header">
										<h2><?php echo $title ?></h2>
									</div>
								</div>
							</div>
						</section>

						<?php

					/* BASIC SECTION  //////////////////////////*/
					elseif( get_row_layout() == 'basic_section' ):

						$section_id = get_sub_field('section_id');
						$title = get_sub_field('title');


						?>

						<section id="<?php echo $section_id ?>" class="section-basic <?php the_sub_field('background_class'); ?>" style="background: <?php the_sub_field('background_color'); ?>">

							<div class="container">

								<div class="container-content">

									<h2><?php echo $title ?></h2>

									<?php the_sub_field('content', false); ?>

								</div>

							</div>

						</section>

						<?php
					/* BASIC SECTION WITH BACKGROUND AND CAROUSEL //////////////////////////*/
					elseif( get_row_layout() == 'basic_section_with_carousel' ):

						$section_id = get_sub_field('section_id');

						?>


						<section id="<?php the_sub_field('section_id'); ?>" class="<?php the_sub_field('background_class'); ?>" style="background: <?php the_sub_field('background_color'); ?>">

							<div class="container">
								<div class="col-md-5">
									<h2><?php the_sub_field('title'); ?></h2>
									<?php the_sub_field('content'); ?>

								</div>
								<div class="col-md-7">

									<div class="engineered-carousel">

										<?php

										while( have_rows('carousel') ): the_row();

											$caption = get_sub_field('caption');

											$image = get_sub_field('image');
											$size = 'full';
											$arr  = array(
												'class' => "img-responsive",
											);

											?>

											<div class="carousel-cell">
												<?php if ( $image != '' ): ?>
													<?php echo wp_get_attachment_image( $image, $size, 0, $arr ); ?>
												<?php endif; ?>
												<div class="caption"><?php echo $caption; ?></div>
											</div>

											<?php

										endwhile;
										?>
									</div>

								</div>
							</div>

						</section>

						<?php

					/* CLIENT CAROUSEL //////////////////////////*/
					elseif( get_row_layout() == 'client_carousel' ):

						$section_id = get_sub_field('section_id');

						?>


						<section id="<?php the_sub_field('section_id'); ?>" class="<?php the_sub_field('background_class'); ?>" style="background: <?php the_sub_field('background_color'); ?>">

							<div class="container">
								<div class="row">
									<div class="col-md-5">
										<h2><?php the_sub_field('title'); ?></h2>
										<?php the_sub_field('content'); ?>

									</div>
								</div>

								<div class="row">
									<div class="col-md-12">

										<div class="client-carousel">

											<?php

											while( have_rows('carousel') ): the_row();

												$i = 0;

												$image = get_sub_field('image');
												$quote = get_sub_field('quote');
												$quote_source = get_sub_field('quote_source');

												?>

												<?php if($i % 2 == 0): ?>

												<div class="carousel-cell">

													<span class="carousel-quote"></span>

												<?php endif;  ?>

														 <span class="container-img"><img src="<?php echo $image['url'] ?>"
														                                  alt="<?php echo $image['alt'] ?>"
														                                  data-quote="<?php echo $quote ?>"
														                                  data-source="<?php echo $quote_source ?>"></span>


												<?php if($i % 2 == 0): ?>

												</div>

												<?php endif;  ?>

												<?php
											$i++;

											endwhile;
											?>
										</div>

								</div>
							</div>

						</section>

						<?php

					/* PARALLAX SECTION WITH BACKGROUND //////////////////////////*/
					elseif( get_row_layout() == 'parallax_section' ):

						$background_image = get_sub_field('background_image');

						?>

						<section id="<?php the_sub_field('section_id'); ?>" class="<?php the_sub_field('background_class'); ?>" style="background: <?php the_sub_field('background_color'); ?>">

							<div class="container">

								<div class="col-md-6">


								</div>
								<div class="col-md-6">

									<div class="container-offset">


										<h2><?php the_sub_field('title'); ?></h2>

										<?php the_sub_field('content', false); ?>


									</div>

								</div>

							</div>



						</section>

						<?php

					endif;

				endwhile;

			else :

				// no layouts found

			endif;

			?>


		<?php endwhile; ?>


	</div>
</div>

<?php get_footer(); ?>

