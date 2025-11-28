<?php
/**
 * JobScout functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package JobScout
 */

$jobscout_theme_data = wp_get_theme();
if( ! defined( 'JOBSCOUT_THEME_VERSION' ) ) define ( 'JOBSCOUT_THEME_VERSION', $jobscout_theme_data->get( 'Version' ) );
if( ! defined( 'JOBSCOUT_THEME_NAME' ) ) define( 'JOBSCOUT_THEME_NAME', $jobscout_theme_data->get( 'Name' ) );

/**
 * Implement Local Font Method functions.
 */
require get_template_directory() . '/inc/class-webfont-loader.php';

/**
 * Custom Functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Standalone Functions.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Template Functions.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom functions for selective refresh.
 */
require get_template_directory() . '/inc/partials.php';

if( jobscout_is_rara_theme_companion_activated() ) :
	/**
	 * Modify filter hooks of RTC plugin.
	 */
	require get_template_directory() . '/inc/rtc-filters.php';
endif;

/**
 * Custom Controls
 */
require get_template_directory() . '/inc/custom-controls/custom-control.php';

/**
 * Force specific slugs to use the Contact Page template.
 */
function jobscout_force_contact_template( $template ) {
	if ( is_page() ) {
		$page_slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( in_array( $page_slug, array( 'contact', 'contact-2' ), true ) ) {
			$contact_template = locate_template( 'page-contact.php' );
			if ( $contact_template ) {
				return $contact_template;
			}
		}
	}

	return $template;
}
add_filter( 'template_include', 'jobscout_force_contact_template', 20 );

// Add inline CSS for full-width contact sections
function jobscout_contact_full_width_css() {
    if ( is_page() && ( get_post_field( 'post_name', get_queried_object_id() ) === 'contact' || get_post_field( 'post_name', get_queried_object_id() ) === 'contact-2' ) ) {
        ?>
        <style>
        /* Override ALL constraints for contact page */
        body.contact-page .site,
        body.contact-page .site-content,
        body.contact-page .site-content > *,
        body.contact-page .site-content .container,
        body.contact-page .contact-hero,
        body.contact-page .contact-address-block,
        body.contact-page .contact-info-grid {
            max-width: none !important;
            width: 100vw !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            box-sizing: border-box !important;
        }
        
        body.contact-page .site {
            margin: 0 !important;
            box-shadow: none !important;
        }
        
        /* Center content inside sections */
        body.contact-page .contact-hero__inner,
        body.contact-page .contact-section__inner {
            max-width: 960px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }
        </style>
        <?php
    }
}
add_action( 'wp_head', 'jobscout_contact_full_width_css' );

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Metabox
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Getting Started
*/
require get_template_directory() . '/inc/dashboard/dashboard.php';

/**
 * Plugin Recommendation
*/
require get_template_directory() . '/inc/tgmpa/recommended-plugins.php';

/**
 * Add theme compatibility function for woocommerce if active
*/
if( jobscout_is_woocommerce_activated() ){
    require get_template_directory() . '/inc/woocommerce-functions.php';    
}

/**
 * Modify filter hooks of WP Job Manager plugin.
 */
if( jobscout_is_wp_job_manager_activated() ) :
	require get_template_directory() . '/inc/wp-job-manager-filters.php';
endif;

/**
 * AJAX Handler for Load More Jobs
 */
add_action('wp_ajax_load_more_jobs', 'jobscout_load_more_jobs');
add_action('wp_ajax_nopriv_load_more_jobs', 'jobscout_load_more_jobs');

function jobscout_load_more_jobs() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'load_more_jobs_nonce')) {
        wp_die('Security check failed');
    }
    
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    
    $jobs_query = new WP_Query(array(
        'post_type' => 'job_listing',
        'posts_per_page' => 6,
        'post_status' => 'publish',
        'paged' => $paged
    ));
    
    if ($jobs_query->have_posts()) :
        while ($jobs_query->have_posts()) : $jobs_query->the_post();
            $company_name = get_post_meta(get_the_ID(), '_company_name', true);
            $job_location = get_the_job_location();
            $job_types = wpjm_get_the_job_types();
?>
        <div class="job-card">
            <div class="job-header">
                <div class="job-logo">
                    <?php the_company_logo('thumbnail'); ?>
                </div>
                <div class="job-title-wrap">
                    <h3 class="job-title">
                        <a href="<?php the_job_permalink(); ?>"><?php wpjm_the_job_title(); ?></a>
                    </h3>
                    <p class="job-date">Created: <?php echo get_the_date('M d, Y'); ?></p>
                </div>
            </div>
            
            <div class="job-content">
                <div class="job-tags">
                    <?php if (!empty($job_types)) : ?>
                        <?php foreach ($job_types as $jobtype) : ?>
                            <span class="tag"><?php echo esc_html($jobtype->name); ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <?php 
                    $categories = get_the_terms(get_the_ID(), 'job_listing_category');
                    if ($categories && !is_wp_error($categories)) :
                        foreach ($categories as $category) : ?>
                            <span class="tag"><?php echo esc_html($category->name); ?></span>
                        <?php endforeach;
                    endif;
                    ?>
                    
                    <?php if ($job_location) : ?>
                        <span class="tag"><?php echo esc_html($job_location); ?></span>
                    <?php endif; ?>
                </div>
                
                <ul class="job-benefits">
                    <?php
                    $content = get_the_content();
                    $content = wp_strip_all_tags($content);
                    $lines = preg_split('/[\n\r•]/', $content);
                    $count = 0;
                    
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (!empty($line) && $count < 3) {
                            echo '<li>' . esc_html($line) . '</li>';
                            $count++;
                        }
                    }
                    
                    if ($count === 0) {
                        $excerpt = wp_trim_words($content, 10, '...');
                        echo '<li>' . esc_html($excerpt) . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
<?php
        endwhile;
        wp_reset_postdata();
    endif;
    
    wp_die();
}

// AJAX handler for job filtering
function filter_jobs_ajax_handler() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'filter_jobs_nonce')) {
        wp_die('Security check failed');
    }
    
    $filter_type = sanitize_text_field($_POST['filter_type']);
    
    // Set up query arguments based on filter type
    $args = [
        'post_type'      => 'job_listing',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    ];
    
    switch($filter_type) {
        case 'latest':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
        case 'oldest':
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
            break;
        case 'location':
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = '_job_location';
            $args['order'] = 'ASC';
            break;
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
    }
    
    $jobs = new WP_Query($args);
    $total_jobs = $jobs->found_posts;
    $displayed_count = 0;
    $html = '';
    
    if ($jobs->have_posts()) {
        while ($jobs->have_posts()) {
            $jobs->the_post();
            $displayed_count++;
            
            $id = get_the_ID();
            
            // Xử lý Logo
            $logo_url = '';
            if (has_post_thumbnail($id)) {
                $logo_url = get_the_post_thumbnail_url($id, 'thumbnail');
            } else {
                $meta_logo = get_post_meta($id, '_company_logo', true);
                if (!empty($meta_logo)) {
                    $logo_url = is_numeric($meta_logo) ? wp_get_attachment_image_src($meta_logo, 'thumbnail')[0] : $meta_logo;
                }
            }
            if (empty($logo_url)) $logo_url = 'https://via.placeholder.com/100x100?text=Logo';
            
            $location     = get_post_meta($id, '_job_location', true);
            $types        = get_the_terms($id, 'job_listing_type');
            $type_name    = ($types && !is_wp_error($types)) ? $types[0]->name : 'Fulltime';
            $cats         = get_the_terms($id, 'job_listing_category');
            $cat_name     = ($cats && !is_wp_error($cats)) ? $cats[0]->name : 'General';
            
            // Logic ẩn/hiện
            $hidden_class = ($displayed_count > 6) ? 'hidden-job' : '';
            $hidden_style = ($displayed_count > 6) ? 'style="display:none;"' : '';
            
            $html .= '<div class="job-grid-item ' . $hidden_class . '" ' . $hidden_style . '>';
            $html .= '<div class="job-card-layout">';
            $html .= '<div class="job-card-header">';
            $html .= '<div class="job-logo-box">';
            $html .= '<img src="' . esc_url($logo_url) . '" alt="Logo">';
            $html .= '</div>';
            $html .= '<div class="job-info-box">';
            $html .= '<h3 class="job-title">';
            $html .= '<a href="' . get_permalink() . '">' . (mb_strlen(get_the_title()) > 20 ? mb_substr(get_the_title(), 0, 25) . '...' : get_the_title()) . '</a>';
            $html .= '</h3>';
            
            $old_locale = get_locale();
            switch_to_locale('en_US');
            $html .= '<p class="job-date">Created: ' . get_the_date('M d, Y') . '</p>';
            restore_previous_locale();
            
            $html .= '<div class="job-meta-gray-bar">';
            $html .= '<span>' . esc_html($type_name) . '</span>';
            
            $company_name = get_post_meta($id, '_company_name', true);
            if (!empty($company_name)) {
                $company_name = mb_strlen($company_name) > 20 ? mb_substr($company_name, 0, 20) . '...' : $company_name;
                $html .= '<span>' . esc_html($company_name) . '</span>';
            } else {
                $cat_name = mb_strlen($cat_name) > 20 ? mb_substr($cat_name, 0, 20) . '...' : $cat_name;
                $html .= '<span>' . esc_html($cat_name) . '</span>';
            }
            
            if ($location) {
                $html .= '<span>' . (mb_strlen($location) > 20 ? mb_substr($location, 0, 20) . '...' : esc_html($location)) . '</span>';
            }
            
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            
            $html .= '<div class="job-card-body">';
            $html .= '<ul>';
            
            $content = get_the_content();
            $content = wp_strip_all_tags($content);
            $lines = preg_split('/[\n\r]+/', $content);
            $lines = array_filter(array_map('trim', $lines));
            
            $count = 0;
            $max_words_per_line = 10;
            
            foreach ($lines as $line) {
                if ($count >= 3) break;
                if (!empty($line)) {
                    $trimmed_line = wp_trim_words($line, $max_words_per_line, '...');
                    $html .= '<li>' . esc_html($trimmed_line) . '</li>';
                    $count++;
                }
            }
            
            $html .= '</ul>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $html = '<p style="width:100%; text-align:center">No jobs found.</p>';
    }
    
    wp_send_json_success([
        'html' => $html,
        'total_jobs' => $total_jobs,
        'displayed_count' => $displayed_count
    ]);
}

add_action('wp_ajax_filter_jobs', 'filter_jobs_ajax_handler');
add_action('wp_ajax_nopriv_filter_jobs', 'filter_jobs_ajax_handler');