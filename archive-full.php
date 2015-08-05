<?php
get_header();
?>
    <div class="row">
        <section class="archive-page style-3 large-12 medium-12 small-12 left">
            <?php if (have_posts()): ?>
                <div class="column page-header">
                    <article>
                        <h3 class="page-title"><?php the_archive_title(); ?></h3>
                        <?php the_archive_description('<p>', '</p>'); ?>
                    </article>
                </div><!-- .page-header -->
                <?php while (have_posts()): the_post(); ?>
                    <?php if (empty(incir_post_format(get_the_ID()))) continue; ?>
                    <?php if (incir_post_format(get_the_ID()) == 'post-image' && has_post_thumbnail(get_the_ID()) == false): continue; endif; ?>
                    <div class="column <?php echo incir_post_format(get_the_ID()); ?>  text-center">
                        <article>
                            <?php if (incir_post_format(get_the_ID()) == 'post-normal'): ?>
                                <div class="post-type fi-pencil"></div>
                                <?php if (has_post_thumbnail(get_the_ID())): ?>
                                    <div class="thumbnails">
                                        <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_post_thumbnail(array(800, 800)); ?></a>
                                    </div>
                                <?php endif; ?>
                                <div class="title text-center">
                                    <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </div>
                                <div class="description">
                                    <?php the_excerpt(); ?>
                                </div>
                                <div class="read-more"><a
                                        href="<?php echo get_permalink(get_the_ID()); ?>"><?php echo __('Read More', 'incir'); ?></a>
                                </div>
                                <div class="meta">
                                    <ul>
                                        <li class="left"><span
                                                class="fi-archive"></span><?php echo get_the_date('d-m-Y', get_the_ID()); ?>
                                        </li>
                                        <?php if (get_post_type(get_the_ID()) != 'page'): ?>
                                            <li class="right"><span class="fi-list"></span><?php the_category(' '); ?>
                                            </li>
                                        <?php endif; ?>
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
                                    <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </div>
                                <div class="image">
                                    <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_post_thumbnail('large'); ?></a>
                                    <span></span>
                                </div>
                            <?php endif; ?>
                            <?php if (incir_post_format(get_the_ID()) == 'post-video'): ?>
                                <div class="post-type fi-video"></div>
                                <div class="title text-center">
                                    <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </div>
                                <div class="video">
                                    <?php the_content(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (incir_post_format(get_the_ID()) == 'post-music'): ?>
                                <div class="post-type fi-music"></div>
                                <div class="title text-center">
                                    <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a>
                                    </h2>
                                </div>
                                <div class="music">
                                    <?php the_content(); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (in_array(incir_post_format(get_the_ID()), array('post-normal', 'post-quote', 'post-image'))): ?>
                                <div class="social">
                                    <ul>
                                        <?php foreach (incir_social_share() as $row): ?>
                                            <li><?php echo $row; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </article>
                    </div>
                <?php endwhile;
            else: ?>
                <div class="column">
                    <article>
                        <h3><?php echo __('Sorry, we couldn\'t find any article', 'incir'); ?></h3>
                    </article>
                </div>
            <?php endif; ?>
        </section>
        <?php if (get_next_posts_link() != null || get_previous_posts_link() != null): ?>
            <div class="row">
                <div class="text-center">
                    <?php echo incir_pagination(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="clearfix"></div>
<?php get_footer(); ?>