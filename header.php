<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>
<body class="<?php echo incir_body_class(); ?>">
<div class="line"></div>
<header>
    <div class="row header">
        <div class="columns large-12 large-centered text-center medium-12 medium-centered small-12 small-centered banner">
            <div class="logo">
                <h3 class="name"><a href="<?php echo home_url('/'); ?>"><?php echo bloginfo('name'); ?></a></h3>
                <h6 class="description"><?php echo bloginfo('description'); ?></h6>
            </div>
        </div>
    </div>
    <div class="full-width"></div>
    <div class="row hide-for-small-down nav">
        <div class="columns large-9 medium-9 menu">
            <?php incir_nav_menu(); ?>
        </div>
        <div class="columns large-3 medium-3 search">
            <form role="search" class="search right" action="<?php echo home_url( '/' ); ?>" method="get">
                <input type="search" class="search" name="s" value="<?php the_search_query(); ?>"/>
            </form>
            <span class="fi-magnifying-glass right"></span>
        </div>
    </div>
</header>