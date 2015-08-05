<?php
/*
Template Name: Sidebar Home Page
*/
get_header();
incir_home_query();
?>
    <div class="row">
        <section class="home-page style-2 large-7 medium-7 small-12 left">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <?php if(empty(incir_post_format(get_the_ID()))) continue; ?>
                <?php if(incir_post_format(get_the_ID()) == 'post-image' && has_post_thumbnail(get_the_ID()) == false): continue; endif; ?>
                <div class="column <?php echo incir_post_format(get_the_ID()); ?>">
                    <article>
                        <?php if (incir_post_format(get_the_ID()) == 'post-normal'): ?>
                            <div class="post-type fi-pencil"></div>
                            <?php if (has_post_thumbnail(get_the_ID())): ?>
                                <div class="thumbnails text-center">
                                    <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_post_thumbnail(array(800, 800)); ?></a>
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
                                    <li class="left"><span class="fi-archive"></span><?php the_date('d-m-Y'); ?></li>
                                    <li class="right"><span class="fi-list"></span><?php the_category(' '); ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-quote'): ?>
                            <div class="post-type fi-quote"></div>
                            <div class="quote">
                                <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_content(); ?></a>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-image'): ?>
                            <div class="post-type fi-camera"></div>
                            <div class="title text-center">
                                <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <div class="image">
                                <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_post_thumbnail('large'); ?></a>
                                <span></span>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-video'): ?>
                            <div class="post-type fi-video"></div>
                            <div class="title text-center">
                                <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <div class="video">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-music'): ?>
                            <div class="post-type fi-music"></div>
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
            <?php if (get_next_posts_link() != null || get_previous_posts_link() != null): ?>
                <div class="row">
                    <div class="text-center">
                        <?php echo incir_pagination(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </section>
        <aside class="hide-for-small-down large-4 medium-4 right">
            <?php dynamic_sidebar('sidebar'); ?>
        </aside>
    </div>
    <div class="clearfix"></div>
<?php get_footer(); ?>