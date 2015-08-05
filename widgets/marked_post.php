<?php

class marked_post extends WP_Widget
{
    /**
     * Marked Post init method.
     */
    public function __construct()
    {
        $widget_options = array('description' => __('Show the selected contents in the sidebar.', 'incir'));
        parent::WP_Widget(false, __('Marked Post', 'incir'), $widget_options);
    }

    public function update($new, $old)
    {
        return $new;
    }

    protected function post_control($posts)
    {
        $posts = explode(',', $posts);
        $list = array();
        foreach ($posts as $row) {
            if (get_post_status($row) != false) {
                $list[] = $row;
            }
        }

        return implode(',', $list);
    }

    public function form($instance)
    {
        $posts = isset($instance['posts']) ? $this->post_control($instance['posts']) : '';
        $label = isset($instance['label']) ? $instance['label'] : '';
        echo '<p>';
        echo '<label for="' . $this->get_field_id('label') . '">' . __('Title', 'incir') . '</label>';
        echo '<input type="text" id="' . $this->get_field_id('label') . '" class="widefat" name="' . $this->get_field_name('label') . '" value="' . $label . '" />';
        echo '</p>';
        echo '<p style="position: relative;">';
        echo '<label for="' . $this->get_field_id('title') . '">' . __('Search the post', 'incir') . '</label>';
        echo '<input type="text" class="incir-marked-post widefat" />';
        echo '<input type="hidden" id="' . $this->get_field_id('posts') . '" value="' . $posts . '" class="incir-marked-post widefat" name="' . $this->get_field_name('posts') . '" />';
        echo '<input type="hidden" class="incir-marked-post-url" value="' . get_template_directory_uri() . '/json/marked_post.php" />';
        echo '</p>';
        echo '<div class="incir-marked-list" style="display: none"></div>';
        echo '<div class="incir-marked-post">';
        echo $this->render_post_list($posts);
        echo '</div>';
    }

    protected function render_post_list($list)
    {
        if (empty($list)) {
            return '';
        }
        $list = explode(',', $list);
        $layout = "<li name='%d' class='incir-marked-post'>%s</li>\n";
        $return = array();
        foreach ($list as $row) {
            $post = get_the_title($row);
            $return[] = sprintf($layout, $row, $post);
        }
        return implode('', $return);
    }

    public function widget($args, $instance)
    {
        extract($args);
        $posts = $instance['posts'];

        $posts = explode(',', $posts);
        echo $before_widget;
        echo $before_title;
        echo $instance['label'];
        echo $after_title;
        if (!empty($posts)) {
            $this->render_post($posts);
        }
        echo $after_widget;
    }

    protected function render_post($posts)
    {
        $args = array(
            'post__in' => $posts
        );
        $query = new WP_Query($args);
        while ($query->have_posts()):
            $query->the_post(); ?>
            <div class="<?php echo incir_post_format(get_the_ID()); ?>">
                <article>
                    <?php if (incir_post_format(get_the_ID()) == 'post-normal'): ?>
                        <?php if (has_post_thumbnail(get_the_ID())): ?>
                            <div class="thumbnails">
                                <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_post_thumbnail('medium'); ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="title">
                            <h2><a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_title(); ?></a></h2>
                        </div>
                        <div class="description">
                            <?php incir_the_excerpt(120); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (incir_post_format(get_the_ID()) == 'post-quote'): ?>
                        <div class="quote">
                            <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_content(); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php if (incir_post_format(get_the_ID()) == 'post-image'): ?>
                        <div class="image">
                            <a href="<?php echo get_permalink(get_the_ID()); ?>"><?php the_content(); ?></a>
                            <span></span>
                        </div>
                    <?php endif; ?>
                    <?php if (incir_post_format(get_the_ID()) == 'post-video'): ?>
                        <div class="video">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (incir_post_format(get_the_ID()) == 'post-music'): ?>
                        <div class="music">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </article>
            </div>
        <?php endwhile;
    }

}
