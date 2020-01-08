<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php include 'includes/icons.php'; ?>

	<title><?php wp_title(); ?></title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css" integrity="sha384-v2Tw72dyUXeU3y4aM2Y0tBJQkGfplr39mxZqlTBDUZAb9BGoC40+rdFCG0m10lXk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">


	<?php wp_head(); ?>

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">

</head>

<body <?php body_class(); ?>>

<div class="gc-wrapper">
    <div class="container-page container-section-nav">
        <div class="container">

            <header>

                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-nav" id="main-nav">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#gc-navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar top-bar"></span>
                                <span class="icon-bar middle-bar"></span>
                                <span class="icon-bar bottom-bar"></span>
                            </button>
                            <a class="navbar-brand" href="<?php echo home_url(); ?>">
                                <?php get_header_image(); ?>
                                <?php if(get_header_image() != ''): ?>
                                    <img src="<?php header_image(); ?>" class="img-responsive logo" alt="<?php  bloginfo('name'); ?>" />
                                <?php else: ?>
                                    <h1><?php  bloginfo('name'); ?></h1>
                                <?php endif; ?>
                            </a>
                        </div>

                        <?php
                        wp_nav_menu( array(
                                'menu'              => 'primary',
                                'theme_location'    => 'primary',
                                'depth'             => 2,
                                'container'         => 'div',
                                'container_class'   => 'collapse navbar-collapse',
                                'container_id'      => 'gc-navbar-collapse',
                                'menu_class'        => 'nav navbar-nav main-menu',
                                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                'walker'            => new wp_bootstrap_navwalker())
                        );
                        ?>
                    </div>
                </nav>

            </header>


        </div>
    </div>


