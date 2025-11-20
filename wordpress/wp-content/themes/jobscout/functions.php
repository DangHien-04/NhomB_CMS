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