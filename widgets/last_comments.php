<?php

class last_comments extends WP_Widget
{

    public function __construct()
    {
        $widget_options = array('description' => __('Recent comments show the desired amount.', 'incir'));
        parent::WP_Widget(false, 'incir ' . __('Recent Comments', 'incir'), $widget_options);
    }

    public function update($new, $old)
    {
        if (!is_numeric($new['last_comment']) || $new['last_comment'] == 0) {
            $new['last_comment'] = 1;
        }
        return $new;
    }

    public function form($instance)
    {
        $label = isset($instance['label']) ? $instance['label'] : __('Last Comments', 'incir');
        $value = isset($instance['last_comment']) ? $instance['last_comment'] : 5;
        echo '<p>';
        echo '<label for="' . $this->get_field_id('label') . '">' . __('Title', 'incir') . '</label>';
        echo '<input type="text" id="' . $this->get_field_id('label') . '" class="widefat" name="' . $this->get_field_name('label') . '" value="' . $label . '" />';
        echo '</p>';

        echo '<p>';
        echo '<label for="' . $this->get_field_id('last_comment') . '">' . __('The number of comments to be displayed.', 'incir') . '</label>';
        echo '<input type="number" id="' . $this->get_field_id('last_comment') . '" min= "1" step="1" class="widefat" name="' . $this->get_field_name('last_comment') . '"  value="' . $value . '" />';
        echo '</p>';
    }

    public function widget($args, $instance)
    {
        extract($args);

        echo $before_widget;
        echo $before_title;
        echo $instance['label'];
        echo $after_title;
        echo $this->last_comments($instance['last_comment']);
        echo $after_widget;
    }

    protected function last_comments($count)
    {
        $args = array(
            'order' => 'DESC',
            'status' => 'all',
            'number' => $count,
        );
        $comments = get_comments($args);
        $output = '<ul>';

        foreach ($comments as $row) {
            $user['unique'] = isset($row->user_id) ? $row->user_id : $row->comment_author_email;
            $user['name'] = $row->comment_author;
            $user['post_id'] = $row->comment_post_ID;
            $user['comment'] = $row->comment_content;

            $output .= '<li>' . $this->output($user, $row) . '</li>';
        }
        $output .= '</ul>';
        return $output;
    }

    protected function output($user, $data)
    {
        // Avatar
        $avatar = get_avatar($data, 80);
        // Post URL
        $url = get_permalink($user['post_id']);
        // Author Name
        $name = $user['name'];
        // Body
        $comment = wp_trim_words($user['comment'], 20, '...');

        $html = '<div class="comment">';
        $html .= '<div class="avatar">';
        $html .= '<a href="' . $url . '">' . $avatar . '</a>';
        $html .= '</div>';
        $html .= '<div class="author">';
        $html .= '<a href="' . $url . '">' . $name . '</a>';
        $html .= '</div>';
        $html .= '<div class="text"><p>';
        $html .= $comment;
        $html .= '</p></div>';
        $html .= '</div>';

        return $html;
    }
}
