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

				$scroll_spy = '';
				$first_item = true;

				// loop through the rows of data
				while ( have_rows('sections') ) : the_row();

					/* SECTION HERO //////////////////////////*/
					if( get_row_layout() == 'hero_section' ):
						$main_image = get_sub_field('main_image');
						$main_image_mobile = get_sub_field('main_image_mobile');
						$full = $main_image['url'];
						$mobile_large= $main_image_mobile['url' ];
						$mobile_small = $main_image_mobile['sizes' ]['medium'];

						?>


						<section id="hero">
							<div class="container">
								<div class="row">
									<div class="col-md-12">
										<div class="container-section-intro">
											<h1 data-aos="fade-right" data-aos-duration="500"
											    data-aos-anchor="body"><?php the_sub_field( 'header' ); ?></h1>

											<p class="subhead" data-aos="fade-right" data-aos-duration="500"
											   data-aos-anchor="body"
											   data-aos-delay="1000"><?php the_sub_field( 'subhead', false ); ?></p>

											<p class="main-text" data-aos="fade-in" data-aos-duration="500"
											   data-aos-anchor="body"
											   data-aos-delay="1200"><?php the_sub_field( 'main_text', false ); ?></p>

											<img src="<?php echo $full; ?>" class="img-responsive hero-image hidden-sm hidden-xs"/>
											<img src="<?php echo $mobile_large; ?>" class="img-responsive hero-image-mobile hidden-md hidden-lg"/>
										</div>
									</div>
								</div>

							</div>
						</section>

						<?php

					/* BASIC SECTION WITH BACKGROUND //////////////////////////*/
					elseif( get_row_layout() == 'basic_section' ):

						$section_id = get_sub_field('section_id');
						$header = get_sub_field('header');
						$layout = get_sub_field('layout');

						$scroll_spy = $scroll_spy . list_scroll_spy($section_id, $title, $first_item);

						if($first_item == true) {
							$first_item = false;
						}
						?>

						<section id="<?php the_sub_field('section_id'); ?>" class="<?php the_sub_field('background_class'); ?>">

							<?php if($layout == 'full_width'): // full width ?>

								<?php if(strlen($header) > 0): ?>
									<div class="container-section-intro">
										<h1><?php the_sub_field('header'); ?></h1>
										<p class="subhead"><?php the_sub_field('subtitle', false); ?></p>
									</div>
								<?php endif; ?>

								<?php the_sub_field('content', false); ?>

							<?php elseif ($layout == 'text_left'):  // text left ?>


									<div class="container container-text-left">
										<div class="col">
											<div class="col-md-6 col-md-offset-1">
												<div class="copy">
													<h1><?php the_sub_field('header'); ?></h1>
													<p class="subhead"><?php the_sub_field('subtitle', false); ?></p>
													<p><?php the_sub_field('content', false); ?></p>
												</div>
											</div>
											<div class="col-md-5">
												<?php
												$hero_image = get_sub_field('hero_image');
												$size = 'medium';
												$arr = array(
													'class'	=> "img-responsive",
												);
												?>
												<div class="hero-img hidden-sm hidden-xs">
													<?php if($hero_image != ''): ?>
														<?php  echo wp_get_attachment_image($hero_image, $size, 0, $arr ); ?>
													<?php endif; ?>
												</div>

												<?php
												$hero_image_mobile = get_sub_field('hero_image_mobile');
												$size = 'medium';
												$arr = array(
													'class'	=> "img-responsive",
												);
												?>
												<div class="hero-img hidden-md hidden-lg">
													<?php if($hero_image_mobile != ''): ?>
														<?php  echo wp_get_attachment_image($hero_image_mobile, $size, 0, $arr ); ?>
													<?php endif; ?>
												</div>
											</div>
										</div>

									</div>


							<?php elseif ($layout == 'text_right'): // text right ?>

								<?php $scroll_spy = $scroll_spy . list_scroll_spy($section_id, $title, $first_item); ?>


								<div class="container container-text-right">
									<div class="col">
										<div class="col-md-6 col-md-offset-1 hidden-sm hidden-xs">
											<?php
											$hero_image = get_sub_field('hero_image');
											$size = 'medium';
											$arr = array(
												'class'	=> "img-responsive",
											);
											?>
											<div class="hero-img">
												<?php if($hero_image != ''): ?>
													<?php  echo wp_get_attachment_image($hero_image, $size, 0, $arr ); ?>
												<?php endif; ?>
											</div>
										</div>
										<div class="col-md-5">
											<div class="copy">
												<h1><?php the_sub_field('header'); ?></h1>
												<p class="subhead"><?php the_sub_field('subtitle', false); ?></p>
												<p><?php the_sub_field('content', false); ?></p>
											</div>
										</div>
										<div class="col-sm-12 hidden-md hidden-lg">
											<?php
											$hero_image_mobile = get_sub_field('hero_image_mobile');
											$size = 'medium';
											$arr = array(
												'class'	=> "img-responsive",
											);
											?>
											<div class="hero-img">
												<?php if($hero_image_mobile != ''): ?>
													<?php  echo wp_get_attachment_image($hero_image_mobile, $size, 0, $arr ); ?>
												<?php endif; ?>
											</div>
										</div>
									</div>

								</div>


					        <?php endif; ?>

						</section>

						<?php
					/* BASIC SECTION WITH BACKGROUND AND CAROUSEL //////////////////////////*/
					elseif( get_row_layout() == 'basic_section_with_carousel' ):

						$section_id = get_sub_field('section_id');
						$title = get_sub_field('title');
						$header = get_sub_field('header');

						?>

						<?php $scroll_spy = $scroll_spy . list_scroll_spy($section_id, $title, $first_item); ?>


						<section id="<?php the_sub_field('section_id'); ?>" class="<?php the_sub_field('background_class'); ?>">

							<?php if(strlen($title) > 0): ?>
								<div class="container-section-intro">
									<h1><?php the_sub_field('title'); ?></h1>
									<p class="subhead"><?php the_sub_field('subtitle', false); ?></p>
								</div>
							<?php endif; ?>

							<div class="container container-carousel-approvals">
								<div id="owl-carousel-approvals" class="owl-carousel owl-carousel-approvals">

									<?php
									$counter = 0;
									while( have_rows('carousel') ): the_row();
										$image = get_sub_field('image');
										?>
										<div class="carousel-item">
											<?php if($image != ''): ?>
												<span class="carousel-item-img">
												<?php if($counter == 0): ?>
													<img src="<?php echo $image['url']; ?>"  class="img-responsive img-approval-mobile active" alt="approval types" />
												<?php else: ?>
													<img src="<?php echo $image['url']; ?>"  class="img-responsive img-approval-mobile" alt="approval types" />
												<?php endif; ?>
												</span>
											<?php endif; ?>
											<div class="container-text">
											<h3><?php the_sub_field('title'); ?></h3>
											<p><?php the_sub_field('content'); ?></p>
											</div>
										</div>
										<?php
									$counter++;
									endwhile;
									?>

								</div>
							</div>

							<?php the_sub_field('cta', false); ?>


						</section>

						<?php

					/* VIDEO SECTION WITH BACKGROUND //////////////////////////*/
					elseif( get_row_layout() == 'video_section' ):
						?>

						<?php $scroll_spy = $scroll_spy . list_scroll_spy($section_id, $title, $first_item); ?>

						<section id="<?php the_sub_field('section_id'); ?>" style="background: url(<?php the_sub_field('background_image'); ?>) no-repeat; background-size: cover;">
							<div class="bg-gray-filter"></div>

							<div class="container">
								<div id="owl-carousel-videos">


									<?php
									$counter = 0;
									while( have_rows('video') ): the_row();


										$image = get_sub_field('image');
										$logo = get_sub_field('logo');
										$description = get_sub_field('description');
										$video_embed_code = get_sub_field('video_embed_code');
										?>

										<div class="item open-video-modal" data-modal="video-modal-<?php echo $counter ?>">
											<div class="row">
												<div class="col-md-6">
													<div class="img-item" style="background-image: url(<?php echo($image) ?>);"><img src="/wp-content/themes/gc-responsive/images/icon-play.svg" alt="play-video" class="icon-play" /></div>
												</div>
												<div class="col-md-6">
													<img src="<?php echo($logo) ?>" class="img-responsive img-logo" alt="company logo">
												</div>
											</div>
											<div class="row">
												<div class="col-md-12">
													<p><?php echo($description) ?></p></div>
											</div>
										</div>
										<?php
										$counter++;
									endwhile;
									?>

								</div>
							</div>

							<?php
							$counter = 0;
							while( have_rows('video') ): the_row();
								$video_embed_code = get_sub_field('video_embed_code');
								?>
									<div class="video-modal" id="video-modal-<?php echo $counter ?>">
										<div class="vidyard-outer-container ">
											<div class="vidyard-inner-container ">
										<script type="text/javascript" id="vidyard_embed_code_<?php echo $video_embed_code ?>" src="//play.vidyard.com/<?php echo $video_embed_code ?>.js?v=3.1.1&type=inline&width=1100&height=620"></script>
											</div>
										</div>
									</div>

								<?php
								$counter++;
							endwhile;
							?>
						</section>

						<?php

					endif;

				endwhile;

			else :

				// no layouts found

			endif;

			?>


		<?php endwhile; ?>

<!--		<nav class="navbar-scrollspy aos-init aos-animate" data-aos="fade-in" data-aos-duration="500" data-aos-anchor="#universal-mico-apps">
			<ul class="nav list-scrollspy">

				<?php /*echo $scroll_spy  */?>
			</ul>
			<a class="scroll-to-top" href="#">TO TOP</a>

		</nav>-->

	</div>
</div>

<?php get_footer(); ?>

