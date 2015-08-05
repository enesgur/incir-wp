<?php

get_header(); ?>
<div class="row">
    <section class="_404-page style-2 large-7 medium-7 small-12 left">
        <div class="column page-header">
            <article>
                <h3 class="page-title"><?php echo __('Oops! That page can&rsquo;t be found.', 'incir'); ?></h3>

                <p><?php echo __('It looks like nothing was found at this location. Maybe try a search?', 'incir'); ?></p>
                <?php echo incir_404_form(); ?>
            </article>
        </div>
    </section>
    <aside class="hide-for-small-down large-4 medium-4 right">
        <?php dynamic_sidebar('sidebar'); ?>
    </aside>
</div>

<?php get_footer(); ?>
