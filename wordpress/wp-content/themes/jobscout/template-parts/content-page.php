<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JobScout
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php if ( is_page('jobs') ) : ?>
<!-- Career Page Layout -->
<style>
/* RESET CƠ BẢN */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.site-content {
    background-color: #f5f5f5;
}
 .hero {
   width: 100vw;   /* Full viewport width */
    margin-left: calc(50% - 50vw);  /* Bẻ ra khỏi container */
    margin-right: calc(50% - 50vw);
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1528127269322-539801943592?w=1200') center/cover;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

.jobs-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
}

/* TIÊU ĐỀ JOB – LỌC */
.jobs-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}

.filter-dropdown {
    padding: 8px 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    min-width: 120px;
    max-width: 150px;
}

/* GRID 2 CỘT GIỐNG HÌNH */
.jobs-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    width: 100%;
}

@media (max-width: 768px) {
    .jobs-grid {
        grid-template-columns: 1fr;
    }
}

/* Job Card */
.job-card-layout {
    background: #fff;
    padding: 30px;
    border-radius: 3px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    height: 100%;
}

/* Header */
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

.job-info-box { flex-grow: 1; }

.job-title {
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    margin: 0 0 8px 0;
    line-height: 1.3;
}
.job-title a { color: #333; text-decoration: none; }

.job-date {
    font-size: 12px;
    color: #999;
    margin-bottom: 10px;
}

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
.job-meta-gray-bar span:not(:last-child)::after {
    content: "|";
    margin-left: 10px;
    color: #ccc;
}

/* Body */
.job-card-body ul { list-style: none; padding: 0; margin: 0; }
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

/* Button */
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
    background: transparent;
    cursor: pointer;
}

.btn-view-more-outline:hover {
    background-color: #d4a576;
    color: #fff;
}

</style>

<!-- Hero Section -->
<div class="hero">
    <h1>CAREER WITH US</h1>
</div>

<!-- Jobs Section -->
<div class="jobs-section">
    <div class="jobs-header">
        <h2>ALL JOBS</h2>
        <select class="filter-dropdown">
            <option>Latest Jobs</option>
            <option>Oldest Jobs</option>
            <option>By Location</option>
        </select>
    </div>

    <div class="jobs-grid">
        <?php
        $args = [
            'post_type'      => 'job_listing',
            'post_status'    => 'publish',
            'posts_per_page' => -1, // Lấy tất cả jobs
            'orderby'        => 'date',
            'order'          => 'DESC'
        ];
        $jobs = new WP_Query($args);
        
        $total_jobs = $jobs->found_posts;
        $displayed_count = 0; 
        
        if ( $jobs->have_posts() ) :
            while ( $jobs->have_posts() ) : $jobs->the_post();
                $displayed_count++; // Tăng biến đếm

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

                // 2. LOGIC ẨN HIỆN: Chỉ hiển thị 6 job đầu, các job còn lại ẩn
                $hidden_class = ($displayed_count > 6) ? 'hidden-job' : ''; 
                $hidden_style = ($displayed_count > 6) ? 'style="display:none;"' : '';
        ?>

        <div class="job-grid-item <?php echo $hidden_class; ?>" <?php echo $hidden_style; ?>>
            <div class="job-card-layout">
                
                <div class="job-card-header">
                    <div class="job-logo-box">
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Logo">
                    </div>
                    <div class="job-info-box">
                        <h3 class="job-title">
                            <a href="<?php the_permalink(); ?>"><?php echo mb_strlen(get_the_title()) > 20 ? mb_substr(get_the_title(), 0, 25) . '...' : get_the_title(); ?></a>
                        </h3>
                     <?php
$old_locale = get_locale();
switch_to_locale('en_US');
?>
<p class="job-date">Created: <?php echo get_the_date('M d, Y'); ?></p>
<?php
restore_previous_locale();
?>
                        <div class="job-meta-gray-bar">
                            <span><?php echo esc_html($type_name); ?></span>
                            <span><?php echo esc_html($cat_name); ?></span>
                            <?php if($location): ?><span><?php echo mb_strlen($location) > 20 ? mb_substr($location, 0, 20) . '...' : esc_html($location); ?></span><?php endif; ?>
                        </div>
                    </div>
                </div>

              <div class="job-card-body">
                                    <ul>
                                        <?php
                                        $content = get_the_content();
                                        $content = wp_strip_all_tags($content);

                                        // Tách nội dung thành các dòng
                                        $lines = preg_split('/[\n\r]+/', $content);
                                        $lines = array_filter(array_map('trim', $lines));

                                        // Hiển thị tối đa 3 dòng đầu tiên
                                        $count = 0;
                                        // Số từ tối đa cho mỗi dòng
                                        $max_words_per_line = 10; // Ví dụ: Giới hạn 15 từ

                                        foreach ($lines as $line) {
                                            if ($count >= 3)
                                                break;
                                            if (!empty($line)) {
                                                // Cắt bớt nội dung của từng dòng
                                                $trimmed_line = wp_trim_words($line, $max_words_per_line, '...');
                                                echo '<li>' . esc_html($trimmed_line) . '</li>';
                                                $count++;
                                            }
                                        }
                                        ?>
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
    </div>
    
    <?php if ($total_jobs > 6): ?>
    <div class="view-more-container">
     <button class="load-more-jobs" onclick="loadMoreJobs()" style="display: block; margin-left: auto; margin-right: auto; margin-top: 40px; background: #fff; border: 2px solid #ff6900; color: #ff6900; padding: 15px 30px; font-weight: bold; cursor: pointer;">
        LOAD MORE JOBS
    </button>
    </div>
    
    <script>
    let currentlyShowing = 6;
    let totalJobs = <?php echo $total_jobs; ?>;
    
    function loadMoreJobs() {
        const button = document.querySelector('.load-more-jobs');
        button.textContent = 'Loading...';
        button.disabled = true;
        
        // Hiển thị thêm 6 job tiếp theo
        const hiddenJobs = document.querySelectorAll('.hidden-job');
        let showCount = 0;
        
        for (let i = 0; i < hiddenJobs.length && showCount < 6; i++) {
            hiddenJobs[i].style.display = 'block';
            hiddenJobs[i].classList.remove('hidden-job');
            showCount++;
        }
        
        currentlyShowing += showCount;
        
        // Nếu đã hiển thị tất cả jobs, ẩn nút
        if (currentlyShowing >= totalJobs) {
            button.style.display = 'none';
        } else {
            button.textContent = 'LOAD MORE JOBS';
            button.disabled = false;
        }
    }
    </script>
    <?php endif; ?>
</div>

<?php else: ?>
<!-- Regular Page Content -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
        /**
         * 
         * @hooked jobscout_entry_header - 10
         * @hooked jobscout_post_thumbnail - 15
        */
        do_action( 'jobscout_before_page_entry_content' );
    
        /**
         * Entry Content
         * 
         * @hooked jobscout_entry_content - 15
         * @hooked jobscout_entry_footer  - 20
        */
        do_action( 'jobscout_page_entry_content' );    
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>