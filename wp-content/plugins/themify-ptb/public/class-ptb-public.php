<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://themify.me
 * @since      1.0.0
 *
 * @package    PTB
 * @subpackage PTB/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    PTB
 * @subpackage PTB/public
 * @author     Themify <ptb@themify.me>
 */
class PTB_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @var      string $plugin_name The name of the plugin.
     * @var      string $version The version of this plugin.
     */
    private static $options = false;
    private static $shortcode = false;
    private static $template = false;
    private static $render_instance = false;
    public static  $render_content = false;

    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        self::$options = PTB::get_option();
        add_shortcode($this->plugin_name, array($this, 'ptb_shortcode'));
    }

    /**
     * Register the Javascript/Stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in PTB_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The PTB_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $plugin_url = plugin_dir_url(__FILE__);
        wp_enqueue_script($this->plugin_name . '-lightbox', $plugin_url . 'js/lightbox.js', array('jquery'), '2.1.1', false);
        wp_enqueue_script('themify-isotope', $plugin_url . 'js/jquery.isotope.min.js', array('jquery'), '2.2.0', false);
        wp_enqueue_script($this->plugin_name, $plugin_url . 'js/ptb-public.js', array('themify-isotope', $this->plugin_name . '-lightbox'), $this->version, false);
        global $wp_styles;
        $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src'));
        if (!in_array('font-awesome.css', $srcs) && !in_array('font-awesome.min.css', $srcs)) {
            wp_enqueue_style('themify-font-icons-css', plugin_dir_url(dirname(__FILE__)) . 'admin/themify-icons/font-awesome.min.css', array(), $this->version, 'all');
        }
        wp_enqueue_style($this->plugin_name . '-themify-framework', plugin_dir_url(dirname(__FILE__)) . 'admin/themify-icons/themify.framework.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, $plugin_url . 'css/ptb-public.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . '-lightbox', $plugin_url . 'css/lightbox.css', array(), '0.9.9', 'all');
    }

    /**
     * Register the ajax url
     *
     * @since    1.0.0
     */
    public static function define_ajaxurl() {
        ?>
        <script type="text/javascript">
            ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        </script>
        <?php
    }

    public function ptb_filter_wp_head() {
        $option = PTB::get_option();
        $custom_css = $option->get_custom_css();
        if ($custom_css) {
            echo '<!-- PTB CUSTOM CSS --><style type="text/css">' . $custom_css . '</style><!--/PTB CUSTOM CSS -->';
        }
    }

    public function ptb_filter_body_class($classes) {

        $post_type = get_post_type();
        $templateObject = self::$options->get_post_type_template_by_type($post_type);
        if (is_null($templateObject)) {
            return $classes;
        }

        $single = $templateObject->has_single() && is_singular($post_type);
        $archive = !$single && self::$template && $templateObject->has_archive();
        if ($archive) {
            $classes[] = $this->plugin_name . '_archive';
            $classes[] = $this->plugin_name . '_archive_' . $post_type;
        } elseif ($single) {
            $classes[] = $this->plugin_name . '_single';
            $classes[] = $this->plugin_name . '_single_' . $post_type;
        }

        return $classes;
    }

    /** 		
     * @param $title		
     * @param null $id		
     * 		
     * @return string		
     */
    public function ptb_filter_post_type_title($title, $id = null) {

        if ($id !== get_the_ID() || self::$shortcode) {
            return $title;
        }
        $post_type = get_post_type();
        $templateObject = self::$options->get_post_type_template_by_type($post_type);
        return isset($templateObject) && ((is_singular($post_type) && $templateObject->has_single()) || (self::$template && $templateObject->has_archive())) ? '' : $title;
    }

    /* 		
     * @since 1.0.0		
     * 		
     * @param $content		
     * 		
     * @return string		
     */

    public function ptb_filter_post_type_content_post($content) {
        global $post;
        $post_type = $post->post_type;
        $templateObject = self::$options->get_post_type_template_by_type($post_type);

        if (is_null($templateObject) || self::$render_content) {
            self::$render_content = false;
            return $content;
        } elseif (self::$render_instance == 'excerpt') {
            return !self::$render_content ? $content : '&nbsp;';
        }
        self::$render_instance = 'content';
        $single = $templateObject->has_single() && is_singular($post_type);
        $archive = !$single && self::$template;
        if ($single || $archive) {
            $cmb_options = $post_support = $post_taxonomies = array();
            self::$options->get_post_type_data($post_type, $cmb_options, $post_support, $post_taxonomies);
            $post_meta = array_merge(array(), get_post_custom(), get_post('', ARRAY_A));
            $post_meta['post_url'] = get_permalink();
            $post_meta['taxonomies'] = !empty($post_taxonomies) ? wp_get_post_terms(get_the_ID(), array_values($post_taxonomies)) : array();
            $themplate = new PTB_Form_PTT_Them($this->plugin_name, $this->version);
            $themplate_layout = $single ? $templateObject->get_single() : $templateObject->get_archive();

            if (isset($themplate_layout['layout'])) {
                return $themplate->display_public_themplate($themplate_layout, $post_support, $cmb_options, $post_meta, $post_type, $single);
            }
        }

        return $content;
    }

    /* 		
     * @since 1.0.0		
     * 		
     * @param $exceprt		
     * 		
     * @return string		
     */

    public function ptb_filter_post_type_exceprt_post($content) {
        global $post;
        $post_type = $post->post_type;
        $templateObject = self::$options->get_post_type_template_by_type($post_type);

        if (is_null($templateObject) || self::$render_content) {
            if (self::$render_instance != 'content') {
                self::$render_content = false;
            }
            return $content;
        } elseif (self::$render_instance == 'content' || is_singular()) {
            return '&nbsp;';
        }
        self::$render_instance = 'excerpt';
        $archive = self::$template && $templateObject->has_archive();
        if ($archive) {
            $cmb_options = $post_support = $post_taxonomies = array();
            self::$options->get_post_type_data($post_type, $cmb_options, $post_support, $post_taxonomies);
            $post_meta = array_merge(array(), get_post_custom(), get_post('', ARRAY_A));
            $post_meta['post_url'] = get_permalink();
            $post_meta['taxonomies'] = !empty($post_taxonomies) ? wp_get_post_terms(get_the_ID(), array_values($post_taxonomies)) : array();
            $themplate = new PTB_Form_PTT_Them($this->plugin_name, $this->version);
            $themplate_layout = $templateObject->get_archive();

            if (isset($themplate_layout['layout'])) {
                echo $themplate->display_public_themplate($themplate_layout, $post_support, $cmb_options, $post_meta, $post_type, false);
                return '&nbsp;';
            }
        }

        return $content;
    }

    public function ptb_filter_post_type_class($classes) {
        if (!self::$shortcode) {
            if (!self::$template) {
                $post_type = get_post_type();
                $templateObject = self::$options->get_post_type_template_by_type($post_type);
                $single = isset($templateObject) && $templateObject->has_single() && is_singular($post_type);
            } else {
                $single = true;
            }
            if ($single) {
                $classes[] = 'ptb_post';
                $classes[] = 'clearfix';
            }
        }
        return $classes;
    }

    public function ptb_filter_post_type_start() {
        if (self::$template && !self::$shortcode) {
            if (!is_category()) {
                $grid = self::$template->get_archive();
                $grid = $grid[self::$options->prefix_ptt_id . 'layout_post'];
                echo '<div class="ptb_loops_wrapper ptb_' . $grid . ' clearfix">';
            } else {
                echo '<div class="ptb_category_wrapper clearfix">';
            }
        }
    }

    public function ptb_filter_post_type_end() {
        if (self::$template && !self::$shortcode) {
            echo '</div>';
        }
    }

    public function ptb_post_thumbnail($html) {
        if (!self::$shortcode) {
            $post_type = get_post_type();
            $templateObject = self::$options->get_post_type_template_by_type($post_type);
            return isset($templateObject) && ((is_singular($post_type) && $templateObject->has_single()) || (self::$template && $templateObject->has_archive())) ? '' : $html;
        }
        return $html;
    }

    /** 		
     * @param WP_Query $query		
     * 		
     * @return WP_Query		
     */
    public function ptb_filter_cpt_category_archives(&$query) {
        if (!self::$shortcode && !is_admin() && ($query->is_post_type_archive() || $query->is_category() || $query->is_tag() || $query->is_tax()) && (!isset($query->query_vars['suppress_filters']) || $query->query_vars['suppress_filters'])) {
            self::$template = false;
            if ($query->is_post_type_archive() && isset($query->query['post_type'])) {

                $args = array();
                $t = self::$options->get_post_type_template_by_type($query->query['post_type']);
                if ($t && $t->has_archive()) {
                    self::$template = $t;
                    $args[] = $query->query['post_type'];
                }
            } elseif (!empty($query->tax_query->queries)) {
                $tax = $query->tax_query->queries;
                $tax = current($tax);
                $tax = $tax['taxonomy'];
                $taxonomy = get_taxonomy($tax);
                unset($tax);
                if ($taxonomy) {
                    $args = $taxonomy->object_type;
                    if ($args) {
                        array_reverse($args);
                        foreach ($args as $type) {
                            $t = self::$options->get_post_type_template_by_type($type);
                            if ($t && $t->has_archive()) {
                                self::$template = $t;
                                break;
                            }
                        }
                    }
                }
            }
            if (self::$template) {
                $archive = self::$template->get_archive();
                if ($archive['ptb_ptt_pagination_post'] > 0) {
                    if ($archive['ptb_ptt_offset_post'] > 0) {
                        $query->set('posts_per_page', intval($archive['ptb_ptt_offset_post']));
                    }
                } else {
                    $query->set('nopaging', 1);
                }
                if (isset(PTB_Form_PTT_Archive::$sortfields[$archive['ptb_ptt_orderby_post']])) {
                    $query->set('orderby', $archive['ptb_ptt_orderby_post']);
                } else {
                    $query->set('orderby', 'meta_value');
                    $query->set('meta_key', $this->plugin_name . '_' . $archive['ptb_ptt_orderby_post']);
                }
                $query->set('order', $archive['ptb_ptt_order_post']);
                $query->set('post_type', $args);
                if ($query->is_main_query()) {
                    $query->set('suppress_filters', true); //wpml filter		
                }
            }
        }

        return $query;
    }

    /**
     * @since 1.0.0
     *
     * @param $atts
     *
     * @return string|void
     */
    public function ptb_shortcode($atts) {

        $post_types = explode(',', esc_attr($atts['type']));
        $type = current($post_types);
        $template = self::$options->get_post_type_template_by_type($type);
        if (null == $template) {
            return;
        }
        unset($atts['type']);
        // WP_Query arguments
        $args = array(
            'orderby' => 'date',
            'order' => 'DESC',
            'post_type' => $type,
            'post_status' => 'publish',
            'nopaging' => false,
            'style' => 'list-post',
            'posts_per_page' => isset($atts['posts_per_page']) && intval($atts['posts_per_page']) > 0 ? $atts['posts_per_page'] : get_option('posts_per_page'),
            'paged' => is_front_page() ? get_query_var('page', 1) : get_query_var('paged', 1),
        );
        if (isset($atts['offset']) && intval($atts['offset']) > 0) {
            $args['offset'] = intval($atts['offset']);
        }
        $args = wp_parse_args($atts, $args);
        unset($atts);
        if (!$args['paged'] || !is_numeric($args['paged'])) {
            $args['paged'] = 1;
        }
        if (isset($args['post_id']) && is_numeric($args['post_id'])) {
            $args['p'] = $args['post_id'];
            $args['style'] = '';
        } else {
            $taxes = array();
            foreach ($args as $key => $value) {

                if (strpos($key, 'ptb_tax_') !== false) {
                    $key = str_replace('ptb_tax_', '', $key);
                    $taxes[] = array(
                        'taxonomy' => esc_attr($key),
                        'field' => 'slug',
                        'terms' => esc_attr($value)
                    );
                }
            }

            if (!empty($taxes)) {
                $args['tax_query'] = $taxes;
                $args['tax_query']['relation'] = 'AND';
            }
            if (!isset(PTB_Form_PTT_Archive::$sortfields[$args['orderby']])) {
                $args['meta_key'] = 'ptb_' . $args['orderby'];
                $args['orderby'] = 'meta_value';
            }
        }
        self::$shortcode = true;
        // The Query
        $query = new WP_Query(apply_filters('themify_ptb_shortcode_query', $args));

        // The Loop
        if ($query->have_posts()) {
            $html = '';
            $themplate = new PTB_Form_PTT_Them($this->plugin_name, $this->version);
            $themplate_layout = isset($args['p']) ? $template->get_single() : $template->get_archive();
            $cmb_options = $post_support = $post_taxonomies = array();
            self::$options->get_post_type_data($type, $cmb_options, $post_support, $post_taxonomies);

            $terms = array();
            $html.= '<div class="ptb_loops_wrapper ptb_loops_shortcode clearfix ptb_' . $args['style'] . '">';
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $post_meta = array();
                $class = array('ptb_post', 'clearfix');
                $post_meta['post_url'] = get_permalink();
                $post_meta['taxonomies'] = !empty($post_taxonomies) ? wp_get_post_terms($post_id, array_values($post_taxonomies)) : array();
                if (isset($args['post_filter']) && !empty($post_meta['taxonomies'])) {
                    foreach ($post_meta['taxonomies'] as $p) {
                        $class[] = 'ptb-tax-' . $p->term_id;
                        $terms[] = $p->term_id;
                    }
                }
                $post_meta = array_merge($post_meta, get_post_custom(), get_post('', ARRAY_A));
                $html .= '<article id="post-' . $post_id . '" class="' . implode(' ', get_post_class($class)) . '">';
                $html .= $themplate->display_public_themplate($themplate_layout, $post_support, $cmb_options, $post_meta, $type, false);
                $html .= '</article>';
            }
            $html .= '</div>';
            if (isset($args['pagination']) && $query->max_num_pages > 1) {
                $html.='<div class="ptb_pagenav">';
                $html .= paginate_links(array(
                    'total' => $query->max_num_pages,
                    'current' => $args['paged']
                ));
                $html.='</div>';
            }
            if (isset($args['post_filter']) && !isset($args['post_id']) && !empty($terms)) {
                $query_terms = get_terms($post_taxonomies, array('hide_empty' => true, 'fields' => 'id=>name', 'include' => $terms));
                if (!empty($query_terms)) {
                    $filter = '';
                    foreach ($query_terms as $tid => $name) {
                        $filter.='<li data-tax="' . $tid . '"><a onclick="return false;" href="' . get_term_link(intval($tid)) . '">' . $name . '</a></li>';
                    }
                    $html = '<ul class="ptb-post-filter">' . $filter . '</ul>' . $html;
                }
            }
            // Restore original Post Data
            wp_reset_postdata();
            self::$shortcode = false;
            return $html;
        }
        self::$shortcode = false;
        return '';
    }

    public function single_lightbox() {
        if (!empty($_GET) && isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = intval($_GET['id']);
            $post = get_post($id);
            if (!$post || $post->post_status != 'publish') {
                wp_die();
            }
            $short_code = '[ptb post_id=' . $id . ' type=' . $post->post_type . ']';

            echo '<div class="ptb_single_lightbox">' .
            do_shortcode($short_code);
            '</div>';
            exit;
        }
    }

}