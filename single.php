<?php
get_header();
?>
    <div class="row">
        <section class="single-page style-2 large-7 medium-7 small-12 left">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <div class="column <?php echo incir_post_format(get_the_ID()); ?>">
                    <article>
                        <?php if (incir_post_format(get_the_ID()) == 'post-normal'): ?>
                            <div class="post-type fi-pencil"></div>
                            <?php if (has_post_thumbnail(get_the_ID())): ?>
                                <div class="thumbnails text-center">
                                    <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_post_thumbnail(array(800, 800)); ?></a>
                                </div>
                            <?php endif; ?>
                            <div class="title">
                                <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <hr class="meta"/>
                            <div class="meta row">
                                <div class="left-meta column large-12">
                                    <ul>
                                        <li><span
                                                <?php $time = human_time_diff(get_the_time('U'), current_time('timestamp')); ?>
                                                class="fi-archive"></span><?php the_date('F j, Y g:i a'); //echo sprintf(__('%s ago'), $time); ?>
                                        </li>
                                        <li><span class="fi-torso"></span><?php echo the_author_posts_link(); ?></li>
                                    </ul>
                                </div>
                                <div class="right-meta column large-12">
                                    <ul>
                                        <li><span class="fi-list"></span><?php the_category(' '); ?></li>

                                        <li><span
                                                class="fi-comment"></span><?php comments_number(__('no comment', 'incir'), '1', '%'); ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <hr class="meta"/>
                            <div class="content">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-quote'): ?>
                            <div class="post-type fi-quote"></div>
                            <div class="quote">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-image'): ?>
                            <div class="post-type fi-camera"></div>
                            <div class="title text-center">
                                <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <div class="image">
                                <a href="<?php echo incir_get_thumbnails_url(get_the_ID()); ?>"><?php the_post_thumbnail('large'); ?></a>
                            </div>
                            <div class="content">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-video'): ?>
                            <div class="post-type fi-video"></div>
                            <div class="title text-center">
                                <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <div class="content video">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (incir_post_format(get_the_ID()) == 'post-music'): ?>
                            <div class="post-type fi-music"></div>
                            <div class="title text-center">
                                <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                            </div>
                            <div class="content music">
                                <?php the_content(); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (in_array(incir_post_format(get_the_ID()), array('post-normal', 'post-quote', 'post-image')) && !empty(incir_social_share())): ?>
                            <hr/>
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
            <?php comments_template('/comments.php'); ?>
        </section>
        <aside class="hide-for-small-down large-4 medium-4 right">
            <?php dynamic_sidebar('sidebar'); ?>
        </aside>
    </div>
    <div class="clearfix"></div>
<?php get_footer(); ?>
