<?php get_header(); ?>

<div class="container-page container-first-row">
    <div id="main">

    <?php while(have_posts()): the_post() ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">


            <h1><?php the_title()?></h1>
            <?php
            // check if the post has a Post Thumbnail assigned to it.
            if ( has_post_thumbnail() ) {
            the_post_thumbnail();
            }
            the_content();?>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
            comments_template();
            endif;?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

    </div>
</div>

<?php get_footer(); ?>

