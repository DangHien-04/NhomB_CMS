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
    grid-template-columns: repeat(2, 1fr);
    gap: 35px;
}

@media(max-width: 900px){
    .jobs-grid {
        grid-template-columns: 1fr;
    }
}

/* Ô JOB CARD */
.job-card {
    background: #fff;
    border: 1px solid #e3e3e3;
    padding: 25px 30px;
    transition: box-shadow .3s ease;
}

.job-card:hover {
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

/* HEADER: LOGO + TIÊU ĐỀ */
.job-header {
    display: flex;
    align-items: flex-start;
    gap: 22px;
    margin-bottom: 15px;
}

.job-logo {
    width: 100px;
    height: 100px;
    border: 1px solid #dcdcdc;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 12px;
    background: #fff;
}

.job-logo img {
    max-width: 100%;
    height: auto;
}

.job-title {
    font-size: 18px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.job-date {
    font-size: 13px;
    color: #777;
    margin-bottom: 12px;
}

/* HÀNG META (Fulltime – Category – Location) */
.job-meta-row {
    display: flex;
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 3px;
    overflow: hidden;
    width: fit-content;
}

/* Mỗi ô */
.job-meta-row span {
    font-size: 12px;
    padding: 6px 18px;
    color: #555;
    background: #fafafa;
    position: relative;
    white-space: nowrap;
}

/* Đường kẻ giữa các ô – cách trên 2px và dưới 2px */
.job-meta-row span:not(:last-child)::after {
    content: "";
    position: absolute;
    right: 0;
    top: 2px;       /* cách trên 2px */
    bottom: 2px;    /* cách dưới 2px */
    width: 1px;
    background: #dcdcdc;  /* màu đường kẻ */
}

.job-meta-row span:last-child {
    border-right: none;
}

/* DANH SÁCH LỢI ÍCH */
.job-benefits {
    list-style: none;
    margin-top: 18px;
    padding-left: 0;
    margin-left: 0px;  /* dịch toàn bộ danh sách qua trái */
}

.job-benefits li {
    position: relative;
    padding-left: 18px; /* để chữ cách dấu chấm 5–8px */
    font-size: 13px;
    line-height: 1.7;
    margin-bottom: 6px;
    color: #555;
}

.job-benefits li::before {
    content: "•";
    position: absolute;
    left: 0;      /* dấu chấm nằm sát mép mới */
    top: 0;
    font-size: 15px;
    color: #000;
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
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $jobs_query = new WP_Query(array(
            'post_type' => 'job_listing',
            'posts_per_page' => 6,
            'post_status' => 'publish',
            'paged' => $paged
        ));
        
        $total_jobs = $jobs_query->found_posts;
        $total_pages = $jobs_query->max_num_pages;
        
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
                        <a href="<?php the_job_permalink(); ?>" style="color: #2c2c2c !important;"><?php wpjm_the_job_title(); ?></a>
                    </h3>
                    <p class="job-date">Created: <?php echo get_the_date('M d, Y'); ?></p>
                <div class="job-meta-row">
                    <?php if (!empty($job_types)) : ?>
                      <?php foreach ($job_types as $jobtype) : ?>
    <span class="job-type-badge"><?php echo esc_html($jobtype->name); ?></span>
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
                    
                    <?php 
                    $company_tagline = get_post_meta(get_the_ID(), '_company_tagline', true);
                    if ($company_tagline) : ?>
                        <span class="company-tagline"><?php echo esc_html($company_tagline); ?></span>
                    <?php else : ?>
                        <span class="company-tagline">Company Tagline</span>
                    <?php endif; ?>
                </div>
                </div>
            </div>
            
            <div class="job-content">
                
              
                
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
        else:
        ?>
        <div class="job-card">
            <div class="job-content">
                <h3 class="job-title">No jobs found</h3>
                <p class="job-date">Please check back later</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <?php if ($total_jobs > 6): ?>
    <button class="load-more-jobs" onclick="loadMoreJobs()" style="display: block; margin-left: auto; margin-right: auto; margin-top: 40px; background: #fff; border: 2px solid #ff6900; color: #ff6900; padding: 15px 30px; font-weight: bold; cursor: pointer;">
        LOAD MORE JOBS
    </button>
    
    <script>
    let currentPage = <?php echo $paged; ?>;
    let totalPages = <?php echo $total_pages; ?>;
    
    function loadMoreJobs() {
        const button = document.querySelector('.load-more-jobs');
        button.classList.add('loading');
        button.textContent = 'Loading...';
        
        currentPage++;
        
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'action': 'load_more_jobs',
                'paged': currentPage,
                'nonce': '<?php echo wp_create_nonce('load_more_jobs_nonce'); ?>'
            })
        })
        .then(response => response.text())
        .then(data => {
            const jobsGrid = document.querySelector('.jobs-grid');
            jobsGrid.insertAdjacentHTML('beforeend', data);
            
            if (currentPage >= totalPages) {
                button.style.display = 'none';
            } else {
                button.classList.remove('loading');
                button.textContent = 'Load More Jobs';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.classList.remove('loading');
            button.textContent = 'Load More Jobs';
        });
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