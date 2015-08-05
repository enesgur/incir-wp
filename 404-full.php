<?php

get_header(); ?>
    <div class="row">
        <section class="_404-page style-3 large-12 medium-12 small-12 left">
            <div class="column page-header">
                <article>
                    <h3 class="page-title"><?php echo  __('Oops! That page can&rsquo;t be found.', 'incir'); ?></h3>

                    <p><?php echo __('It looks like nothing was found at this location. Maybe try a search?', 'incir'); ?></p>
                    <?php echo incir_404_form(); ?>
                </article>
            </div>
        </section>
    </div>

<?php get_footer(); ?>