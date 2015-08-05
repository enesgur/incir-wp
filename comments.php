<?php

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}

?>
<?php if (have_comments()) : ?>
    <div id="comments" class="column comments">
        <ul class="comment-list">
            <?php
            wp_list_comments('callback=incir_comment_list');
            ?>
        </ul>
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="navigation comment-navigation" role="navigation">
                <ul class="nav-links">
                    <?php
                    if ($prev_link = get_previous_comments_link(__('Older Comments', 'incir'))) :
                        printf('<li class="nav-previous">%s</li>', $prev_link);
                    endif;

                    if ($next_link = get_next_comments_link(__('Newer Comments', 'incir'))) :
                        printf('<li class="nav-next">%s</li>', $next_link);
                    endif;
                    ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (comments_open() && post_type_supports(get_post_type(), 'comments')) : ?>
    <div id="comment-form" class="column comment-form">
        <article><?php comment_form(array('class_submit' => 'button secondary radius')); ?></article>
    </div>
<?php endif; ?>
