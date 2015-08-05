<?php
get_header();
?>
    <div class="row">
        <section class="page-page large-12 medium-12 small-12">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <div class="column <?php echo incir_post_format(get_the_ID()); ?>">
                    <article>
                        <?php if (has_post_thumbnail(get_the_ID())): ?>
                            <div class="thumbnails text-center ">
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
                                    <li><span class="fi-torso"></span><a
                                            href="<?php the_author_link(); ?>"><?php the_author(); ?></a></li>
                                </ul>
                            </div>
                            <?php if (comments_open(get_the_ID())): ?>
                                <div class="right-meta column large-12">
                                    <ul>
                                        <li><span
                                                class="fi-comment"></span><?php comments_number(__('no comment', 'incir'), '1', '%'); ?>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <hr class="meta"/>
                        <div class="content">
                            <?php the_content(); ?>
                        </div>
                        <hr/>
                        <div class="social">
                            <ul>
                                <?php foreach(incir_social_share() as $row): ?>
                                    <li><?php echo $row; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </article>
                </div>
            <?php endwhile; endif; ?>
            <?php comments_template('/comments.php'); ?>
        </section>
        <!--        <aside class="hide-for-small-down large-4 medium-4 right">-->
        <!--            --><?php //dynamic_sidebar('sidebar'); ?>
        <!--        </aside>-->
    </div>
    <div class="clearfix"></div>
<?php get_footer(); ?>
