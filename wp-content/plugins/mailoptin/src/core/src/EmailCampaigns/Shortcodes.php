<?php

namespace MailOptin\Core\EmailCampaigns;

class Shortcodes
{
    use TemplateTrait;

    protected $old_shortcode_tags;

    /** @var \WP_Post */
    protected $wp_post_obj;

    protected $email_campaign_id;

    protected $post_id;

    protected $posts;

    public function __construct($email_campaign_id)
    {
        $this->email_campaign_id = $email_campaign_id;
    }

    /**
     *
     * @param int|\WP_Post $post
     */
    public function from($post)
    {
        if ($post instanceof \stdClass) {
            $this->wp_post_obj = $post;
        } else {
            $this->wp_post_obj = get_post($post);
        }

        // do not remove old shortcodes if this is email digest because we already have it implemented
        // but need from() for initialization.
        if (empty($this->posts)) {
            $this->removeOldShortcodes();
        }

        $this->define_shortcodes();

        return $this;
    }

    public function fromCollection($posts)
    {
        $this->posts = $posts;

        add_shortcode('posts-loop', [$this, 'posts_loop_tag']);

        return $this;
    }

    public function removeOldShortcodes()
    {
        global $shortcode_tags;
        $this->old_shortcode_tags = $shortcode_tags;
        $shortcode_tags           = array();
    }

    public function restoreOldShortcode()
    {
        global $shortcode_tags;
        $shortcode_tags = $this->old_shortcode_tags;
    }

    public function parse($content)
    {
        $parsed_content = do_shortcode($content);

        $this->restoreOldShortcode();

        return $parsed_content;
    }

    public function define_shortcodes()
    {
        add_shortcode('post-title', [$this, 'post_title_tag']);
        add_shortcode('post-content', [$this, 'post_content_tag']);
        add_shortcode('post-excerpt', [$this, 'post_excerpt_tag']);
        add_shortcode('post-feature-image', [$this, 'post_feature_image_tag']);
        add_shortcode('post-feature-image-url', [$this, 'post_feature_image_url_tag']);
        add_shortcode('post-url', [$this, 'post_url_tag']);
        add_shortcode('post-date', [$this, 'post_date_tag']);
        add_shortcode('post-date-gmt', [$this, 'post_date_gmt_tag']);
        add_shortcode('post-categories', [$this, 'post_categories_tag']);
        add_shortcode('post-terms', [$this, 'post_terms_tag']);
        add_shortcode('post-id', [$this, 'post_id_tag']);
        add_shortcode('post-author-name', [$this, 'post_author_name_tag']);
        add_shortcode('post-author-website', [$this, 'post_author_website_tag']);
        add_shortcode('post-author-email', [$this, 'post_author_email_tag']);
        add_shortcode('post-meta', [$this, 'post_meta_tag']);

        add_shortcode('unsubscribe', [$this, 'unsubscribe']);
        add_shortcode('webversion', [$this, 'webversion']);
        add_shortcode('company-name', [$this, 'company_name']);
        add_shortcode('company-address', [$this, 'company_address']);
        add_shortcode('company-address2', [$this, 'company_address2']);
        add_shortcode('company-city', [$this, 'company_city']);
        add_shortcode('company-state', [$this, 'company_state']);
        add_shortcode('company-zip', [$this, 'company_zip']);
        add_shortcode('company-country', [$this, 'company_country']);

        do_action('mo_define_email_automation_shortcodes', $this->wp_post_obj);
    }

    public function posts_loop_tag($atts, $content)
    {
        if (empty($this->posts)) return '';

        $this->removeOldShortcodes();
        $output = '';
        foreach ($this->posts as $post) {
            $this->from($post);
            $this->define_shortcodes();
            $output .= do_shortcode($content);
        }

        $this->restoreOldShortcode();

        return $output;
    }

    public function post_title_tag()
    {
        return $this->wp_post_obj->post_title;
    }

    public function post_feature_image_tag()
    {
        return sprintf(
            '<img class="mo-post-feature-image" src="%s" alt="%s">',
            $this->feature_image($this->wp_post_obj),
            $this->wp_post_obj->post_title
        );
    }

    public function post_feature_image_url_tag()
    {
        return $this->feature_image($this->wp_post_obj);
    }

    public function post_url_tag()
    {
        return $this->post_url($this->wp_post_obj);
    }

    public function post_date_tag()
    {
        return $this->wp_post_obj->post_date;
    }

    public function post_date_gmt_tag()
    {
        return $this->wp_post_obj->post_date_gmt;
    }

    public function post_content_tag()
    {
        return $this->post_content($this->wp_post_obj);
    }

    public function post_excerpt_tag()
    {
        return wpautop($this->wp_post_obj->post_excerpt);
    }

    public function webversion()
    {
        return '{{webversion}}';
    }

    public function unsubscribe()
    {
        return '{{unsubscribe}}';
    }

    public function company_name()
    {
        return '{{company_name}}';
    }

    public function company_address()
    {
        return '{{company_address}}';
    }

    public function company_address2()
    {
        return '{{company_address_2}}';
    }

    public function company_city()
    {
        return '{{company_city}}';
    }

    public function company_state()
    {
        return '{{company_state}}';
    }

    public function company_zip()
    {
        return '{{company_zip}}';
    }

    public function company_country()
    {
        return '{{company_country}}';
    }

    public function post_categories_tag($atts)
    {
        $atts = shortcode_atts(['link' => 'true'], $atts);

        $output = '';

        $categories = get_the_term_list($this->wp_post_obj->ID, 'category', '', ', ');

        if ( ! is_wp_error($categories)) {
            $output = $atts['link'] == 'true' ? $categories : strip_tags($categories);
        }

        return $output;
    }

    public function post_terms_tag($atts)
    {
        $output = '';

        $atts = shortcode_atts(['tax' => '', 'link' => 'true'], $atts);

        $tax = sanitize_key($atts['tax']);

        if ( ! empty($tax)) {

            $terms = get_the_term_list($this->wp_post_obj->ID, $tax, '', ', ');

            if ( ! is_wp_error($terms)) {
                $output = $atts['link'] == 'true' ? $terms : strip_tags($terms);
            }
        }

        return $output;
    }

    public function post_id_tag()
    {
        return $this->wp_post_obj->ID;
    }

    public function post_author_name_tag($atts)
    {
        $atts    = shortcode_atts(['link' => 'true'], $atts);
        $wp_user = get_user_by('id', $this->wp_post_obj->post_author);

        $output = $wp_user->display_name;

        if ($atts['link'] == 'true') {
            $output = '<a href="' . $wp_user->user_url . '">' . $wp_user->display_name . '</a>';
        }

        return $output;
    }

    public function post_author_website_tag()
    {
        return get_user_by('id', $this->wp_post_obj->post_author)->user_url;
    }

    public function post_author_email_tag()
    {
        return get_user_by('id', $this->wp_post_obj->post_author)->user_email;
    }

    public function post_meta_tag($atts)
    {
        $atts = shortcode_atts(['key' => ''], $atts);

        $key = sanitize_key($atts['key']);

        if(empty($key)) return '';

        return get_post_meta($this->wp_post_obj->ID, $key, true);
    }
}