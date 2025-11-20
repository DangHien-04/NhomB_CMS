<?php
/**
 * Job Posting Section - Layout 2 cột (Grid Custom)
 */

$job_title      = get_theme_mod( 'job_posting_section_title', 'TOP JOBS' );
$ed_jobposting  = get_theme_mod( 'ed_jobposting', true );

if ( $ed_jobposting ) :
?>

<section id="job-posting-section" class="top-job-section">
    <div class="container">

        <?php if( $job_title ) : ?>
            <h2 class="section-title"><?php echo esc_html( $job_title ); ?></h2>
        <?php endif; ?>

        <div class="custom-job-grid">

        <?php  
            $args = [
                'post_type'      => 'job_listing',
                'post_status'    => 'publish',
                'posts_per_page' => 6, // Lấy đúng 6 cái để chia 3-3
                'orderby'        => 'date',
                'order'          => 'DESC'
            ];
            $jobs = new WP_Query($args);

            if ( $jobs->have_posts() ) :
                while ( $jobs->have_posts() ) : $jobs->the_post();

                    $id = get_the_ID();
                    
                    // Xử lý Logo
                    $logo_url = '';
                    if ( has_post_thumbnail( $id ) ) {
                        $logo_url = get_the_post_thumbnail_url( $id, 'thumbnail' );
                    } else {
                        $meta_logo = get_post_meta($id, '_company_logo', true);
                        if ( !empty($meta_logo) ) {
                            $logo_url = is_numeric( $meta_logo ) ? wp_get_attachment_image_src( $meta_logo, 'thumbnail' )[0] : $meta_logo;
                        }
                    }
                    if ( empty($logo_url) ) $logo_url = 'https://via.placeholder.com/100x100?text=Logo'; 

                    $location     = get_post_meta($id, '_job_location', true);
                    $types        = get_the_terms( $id, 'job_listing_type' );
                    $type_name    = ($types && !is_wp_error($types)) ? $types[0]->name : 'Fulltime';
                    $cats         = get_the_terms( $id, 'job_listing_category' );
                    $cat_name     = ($cats && !is_wp_error($cats)) ? $cats[0]->name : 'General';
                    $excerpt      = wp_trim_words(get_the_content(), 15, '...');
        ?>

            <div class="job-grid-item">
                <div class="job-card-layout">
                    
                    <div class="job-card-header">
                        <div class="job-logo-box">
                            <img src="<?php echo esc_url($logo_url); ?>" alt="Logo">
                        </div>

                        <div class="job-info-box">
                            <h3 class="job-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="job-date">Created: <?php echo get_the_date('M d, Y'); ?></p>
                            
                            <div class="job-meta-gray-bar">
                                <span><?php echo esc_html($type_name); ?></span>
                                <span><?php echo esc_html($cat_name); ?></span>
                                <?php if($location): ?><span><?php echo esc_html($location); ?></span><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="job-card-body">
                        <ul>
                            <li><?php echo esc_html($excerpt); ?></li>
                            <li>Excellent salary bonuses & recognition activities</li>
                            <li>Foreign language allowance (up to 500USD/month)</li>
                        </ul>
                    </div>

                </div>
            </div>

        <?php  
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="width:100%; text-align:center">No jobs found.</p>';
            endif;
        ?>
        
        </div> <div class="view-more-container">
            <a href="<?php echo get_post_type_archive_link( 'job_listing' ); ?>" class="btn-view-more-outline">
                VIEW MORE JOBS
            </a>
        </div>

    </div>
</section>

<?php endif; ?>

<style>
/* 1. Thiết lập Grid System (QUAN TRỌNG NHẤT: CHIA 2 CỘT) */
.custom-job-grid {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Chia làm 2 cột đều nhau */
    gap: 30px; /* Khoảng cách giữa 2 cột */
    width: 100%;
}

/* Responsive: Dưới 768px (iPad/Mobile) thì về 1 cột */
@media (max-width: 768px) {
    .custom-job-grid {
        grid-template-columns: 1fr;
    }
}

/* 2. Tổng thể Section */
#job-posting-section {
    background-color: #f4f4f4;
    padding: 70px 0;
}

.section-title {
    text-align: center;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 26px;
    margin-bottom: 50px;
    color: #222;
    width: 100%;
}

/* 3. Thẻ Job Card */
.job-grid-item {
    width: 100%; /* Chiếm hết ô grid */
}

.job-card-layout {
    background: #fff;
    padding: 30px;
    border-radius: 3px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    height: 100%; /* Để các thẻ cao bằng nhau */
}

/* 4. Header: Logo + Info */
.job-card-header {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
}

.job-logo-box {
    width: 90px;
    height: 90px;
    border: 1px solid black;
    margin-right: 20px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.job-logo-box img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.job-info-box {
    flex-grow: 1;
}

.job-title {
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    margin: 0 0 8px 0;
    line-height: 1.3;
}

.job-title a {
    color: #333;
    text-decoration: none;
}

.job-date {
    font-size: 12px;
    color: #999;
    margin-bottom: 10px;
}

/* 5. Meta Bar màu xám */
.job-meta-gray-bar {
    background-color: #f5f5f5;
    border-radius: 4px;
    padding: 6px 12px;
    display: inline-flex;
    flex-wrap: wrap;
    font-size: 12px;
    color: #666;
    gap: 10px;
}

.job-meta-gray-bar span {
    position: relative;
}

/* Gạch phân cách */
.job-meta-gray-bar span:not(:last-child)::after {
    content: "|";
    margin-left: 10px;
    color: #ccc;
}

/* 6. Body: Mô tả */
.job-card-body ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.job-card-body ul li {
    position: relative;
    padding-left: 15px;
    margin-bottom: 6px;
    font-size: 13px;
    color: #555;
    line-height: 1.5;
}

.job-card-body ul li::before {
    content: "•";
    position: absolute;
    left: 0;
    color: #999;
}

/* 7. Button View More */
.view-more-container {
    text-align: center;
    margin-top: 40px;
    width: 100%;
}

.btn-view-more-outline {
    display: inline-block;
    padding: 12px 45px;
    border: 1px solid #d4a576;
    color: #d4a576;
    text-transform: uppercase;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-view-more-outline:hover {
    background-color: #d4a576;
    color: #fff;
}
</style>