<?php
/*
Template Name: 3 Column Home Page
*/
get_header();
incir_home_query();
?>
    <section class="home-page style-1">
        <div class="loader"></div>
        <div class="row" style="visibility: hidden;">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <?php if(empty(incir_post_format(get_the_ID()))) continue; ?>
                <?php if(incir_post_format(get_the_ID()) == 'post-image' && has_post_thumbnail(get_the_ID()) == false): continue; endif; ?>
                <div class="column large-4 medium-6 small-12 <?php echo incir_post_format(get_the_ID()); ?>">
                    <article>
                        <?php if (incir_post_format(get_the_ID()) == 'post-normal'): ?>
                        <?php if (has_post_thumbnail(get_the_ID())): ?>
                            <div class="thumbnails">
                                <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_post_thumbnail('large'); ?></a>
                            </div>
                        <?php endif; ?>
                            <div class="title text-center">
                                <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <div class="description">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="read-more"><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo __('Read More', 'incir'); ?></a>
                            </div>
                            <div class="meta">
                                <ul>
                                    <li class="left"><span class="fi-archive"></span><?php echo get_the_date('d-m-Y', get_the_ID()); ?></li>
                                    <li class="right"><span class="fi-list"></span><?php the_category(' '); ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-quote'): ?>
                            <div class="quote">
                                <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_content(); ?></a>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-image'): ?>
                            <div class="image">
                                <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_post_thumbnail('large'); ?></a>
                                <span></span>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-video'): ?>
                            <div class="video">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-music'): ?>
                            <div class="title text-center">
                                <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <div class="music">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (in_array(incir_post_format(get_the_ID()), array('post-normal', 'post-quote', 'post-image'))): ?>
                            <div class="social">
                                <ul>
                                    <?php foreach(incir_social_share() as $row): ?>
                                        <li><?php echo $row; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </article>
                </div>
            <?php endwhile; endif; ?>
        </div>
    </section>
<?php if (get_next_posts_link() != null || get_previous_posts_link() != null): ?>
    <div class="row">
        <div class="text-center">
            <?php echo incir_pagination(); ?>
        </div>
    </div>
<?php endif; ?>
<?php get_footer(); ?>