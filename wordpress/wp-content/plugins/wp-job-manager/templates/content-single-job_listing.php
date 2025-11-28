<?php

/**
 * Single Job Listing - Full Design + Breadcrumbs + Fixed Bullets & Logo Size
 */

if (!defined('ABSPATH')) {
    exit;
}

global $post;
$id = get_the_ID();

if (job_manager_user_can_view_job_listing($id)):

    // --- DATA ---
    $logo_url = get_the_company_logo($id, 'thumbnail');
    if (!$logo_url)
        $logo_url = 'https://via.placeholder.com/100x100?text=Logo';

    $location = get_the_job_location($post);

    $types = get_the_terms($id, 'job_listing_type');
    $type_name = ($types && !is_wp_error($types) && isset($types[0])) ? $types[0]->name : 'Fulltime';

    $cats = get_the_terms($id, 'job_listing_category');
    $cat_name = ($cats && !is_wp_error($cats) && isset($cats[0])) ? $cats[0]->name : 'General';

    $date = get_the_date('M d, Y');
?>

    <div class="single_job_listing custom-single-job-wrap">

        <div class="container">

            <div class="job-breadcrumbs">
                <a href="<?php echo home_url(); ?>">Home</a>
                <span class="sep">/</span>
                <a href="<?php echo get_post_type_archive_link('job'); ?>">All Jobs</a>
                <span class="sep">/</span>
                <span class="current"><?php the_title(); ?></span>
            </div>

            <div class="single-job-header">
                <div class="job-header-inner">
                    <div class="sj-logo">
                        <img src="<?php echo esc_url($logo_url); ?>" alt="Logo">
                    </div>
                    <div class="sj-info">
                        <h1 class="sj-title"><?php the_title(); ?></h1>
                        <?php
                        $old_locale = get_locale();
                        switch_to_locale('en_US');
                        ?>
                        <p class="job-date">Created: <?php echo get_the_date('M d, Y'); ?></p>
                        <?php
                        restore_previous_locale();
                        ?>
                        <div class="sj-meta-bar">
                            <span><?php echo esc_html($type_name); ?></span>
                            <?php
                            $company_name = get_post_meta($id, '_company_name', true);
                            if (!empty($company_name)) {
                                echo '<span>' . esc_html($company_name) . '</span>';
                            } else {
                                echo '<span>' . esc_html($cat_name) . '</span>';
                            }
                            ?>
                            <?php if ($location): ?><span><?php echo esc_html($location); ?></span><?php endif; ?>
                        </div>
                    </div>
                    <div class="sj-actions">
                        <a href="#" class="btn-share">SHARE</a>
                        <?php if (candidates_can_apply()): ?>
                            <div class="btn-apply-wrap">
                                <?php get_job_manager_template('job-application.php'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="single-job-body row">
                <div class="col-md-8 sj-content-col">
                    <div class="job-description-box">
                        <?php wpjm_the_job_description(); ?>
                    </div>
                </div>
                <div class="col-md-4 sj-sidebar-col">
                    <div class="sj-widget">
                        <h3 class="widget-title">Staff Rating</h3>
                        <div class="rating-box">
                            <span class="stars">★★★★☆</span>
                            <span class="score">4.0</span>
                        </div>
                    </div>
                    <div class="sj-widget">
                        <h3 class="widget-title">Company Photos</h3>
                        <div class="company-photos">
                            <img src="https://via.placeholder.com/300x250?text=Office+Photo" alt="Office">
                            <span class="photo-count">+5</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="other-jobs-section">
                <h2 class="other-jobs-title">OTHER JOBS</h2>

                <div class="custom-job-grid">
                    <?php
                    $args = [
                        'post_type' => 'job_listing',
                        'post_status' => 'publish',
                        'posts_per_page' => 6,
                        'post__not_in' => [$id],
                        'orderby' => 'rand'
                    ];
                    $other_jobs = new WP_Query($args);

                    if ($other_jobs->have_posts()):
                        while ($other_jobs->have_posts()):
                            $other_jobs->the_post();
                            $o_id = get_the_ID();

                            $o_logo = '';
                            if (has_post_thumbnail($o_id)) {
                                $o_logo = get_the_post_thumbnail_url($o_id, 'thumbnail');
                            } else {
                                $meta_logo = get_post_meta($o_id, '_company_logo', true);
                                if (!empty($meta_logo)) {
                                    $o_logo = is_numeric($meta_logo) ? wp_get_attachment_image_src($meta_logo, 'thumbnail')[0] : $meta_logo;
                                }
                            }
                            if (empty($o_logo))
                                $o_logo = 'https://via.placeholder.com/100x100?text=Logo';

                            $o_location = get_post_meta($o_id, '_job_location', true);

                            // Lấy đoạn trích ngắn hơn một chút để danh sách trông gọn hơn
                            $o_excerpt = wp_trim_words(get_the_content(), 12, '...');

                            $o_types = get_the_terms($o_id, 'job_listing_type');
                            $o_type = ($o_types && !is_wp_error($o_types) && isset($o_types[0])) ? $o_types[0]->name : 'Fulltime';
                            $o_cats = get_the_terms($o_id, 'job_listing_category');
                            $o_cat = ($o_cats && !is_wp_error($o_cats) && isset($o_cats[0])) ? $o_cats[0]->name : 'General';
                    ?>

                            <div class="job-grid-item">
                                <div class="job-card-layout">
                                    <div class="job-card-header">
                                        <div class="job-logo-box">
                                            <img src="<?php echo esc_url($o_logo); ?>" alt="Logo">
                                        </div>
                                        <div class="job-info-box">
                                            <h3 class="job-title">
                                                <a
                                                    href="<?php the_permalink(); ?>"><?php echo mb_strlen(get_the_title()) > 20 ? mb_substr(get_the_title(), 0, 25) . '...' : get_the_title(); ?></a>
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
                                                <span><?php echo esc_html($o_type); ?></span>
                                                <?php
                                                $company_name = get_post_meta($id, '_company_name', true);
                                                if (!empty($company_name)) {
                                                    $company_name = mb_strlen($company_name) > 20 ? mb_substr($company_name, 0, 20) . '...' : $company_name;
                                                    echo '<span>' . esc_html($company_name) . '</span>';
                                                } else {
                                                    $cat_name = mb_strlen($cat_name) > 20 ? mb_substr($cat_name, 0, 20) . '...' : $cat_name;
                                                    echo '<span>' . esc_html($cat_name) . '</span>';
                                                }
                                                ?>
                                                <?php if ($location): ?><span><?php echo mb_strlen($location) > 20 ? mb_substr($location, 0, 20) . '...' : esc_html($location); ?></span><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="job-card-body">
                                        <ul class="custom-ul"> <?php
                                                                $content = get_the_content();
                                                                $content = wp_strip_all_tags($content);

                                                                // Tách nội dung thành các dòng
                                                                $lines = preg_split('/[\n\r]+/', $content);
                                                                $lines = array_filter(array_map('trim', $lines));

                                                                // Hiển thị tối đa 3 dòng đầu tiên
                                                                $count_line = 0;
                                                                $max_words_per_line = 8;

                                                                foreach ($lines as $line) {
                                                                    if ($count_line >= 3)
                                                                        break;
                                                                    if (!empty($line)) {
                                                                        // Rút gọn nội dung của từng dòng
                                                                        $trimmed_line = wp_trim_words($line, $max_words_per_line, '...');
                                                                        echo '<li>' . esc_html($trimmed_line) . '</li>';
                                                                        $count_line++;
                                                                    }
                                                                }

                                                                // Nếu không đủ 3 dòng, thêm dòng trống
                                                                while ($count_line < 3) {
                                                                    echo '<li>&nbsp;</li>';
                                                                    $count_line++;
                                                                }
                                                                ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else:
                        echo '<p class="col-12 text-center">No other jobs found.</p>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php get_job_manager_template_part('access-denied', 'single-job_listing'); ?>
<?php endif; ?>


<style>
    /* --- FULL WIDTH CONTAINER --- */
    .custom-single-job-wrap {
        background-color: #f4f4f4;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        padding-top: 40px;
        padding-bottom: 80px;
        margin-bottom: -28px;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    body {
        overflow-x: hidden;
    }

    /* --- BREADCRUMBS --- */
    .job-breadcrumbs {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
        margin-left: 5px;
    }

    .job-breadcrumbs a {
        color: #d4a576;
        text-decoration: none;
        transition: color 0.2s;
    }

    .job-breadcrumbs a:hover {
        color: #333;
    }

    .job-breadcrumbs .sep {
        margin: 0 8px;
        color: #ccc;
    }

    .job-breadcrumbs .current {
        color: #333;
        font-weight: 500;
    }

    /* --- HEADER JOB --- */
    .single-job-header {
        background: #fff;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid #e5e5e5;
    }

    .job-header-inner {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .sj-logo {
        width: 100px;
        height: 100px;
        border: 1px solid black;
        margin-right: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sj-logo img {
        max-width: 100%;
        height: auto;
    }

    .sj-info {
        flex-grow: 1;
    }

    .sj-title {
        font-size: 22px;
        text-transform: uppercase;
        font-weight: 700;
        margin: 0 0 5px 0;
        color: #333;
    }

    .sj-date {
        font-size: 13px;
        color: #999;
        margin-bottom: 10px;
    }

    .sj-meta-bar span {
        background: #f5f5f5;
        padding: 5px 12px;
        font-size: 12px;
        color: #666;
        margin-right: 5px;
        border-radius: 3px;
    }

    /* ==================================================================
--- ACTIONS (Share & Apply) - CHỈNH SỬA LẠI ĐỂ ĐỒNG NHẤT ---
================================================================== */
    .sj-actions {
        display: flex;
        flex-direction: column;
        gap: 15px;
        width: 100%;
        max-width: 200px;
        margin-left: auto;
    }

    /* Đảm bảo nút SHARE có kiểu dáng và chiều cao cố định */
    a.btn-share {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 48px;
        /* Cố định chiều cao */
        background-color: #ffffff;
        border: 1px solid #000000;
        color: #000000 !important;
        text-transform: uppercase;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none !important;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        box-sizing: border-box;
        /* Quan trọng: Tính border và padding vào width/height */
    }

    a.btn-share:hover {
        background-color: #f5f5f5;
        color: #000000 !important;
    }

    /* Đảm bảo nút APPLY cũng có cùng chiều cao */
    .application_button,
    input.application_button {
        /* Ghi đè các style của plugin WordPress Job Manager */
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 48px !important;
        /* Cố định chiều cao bằng nút SHARE */
        line-height: 1 !important;
        /* Giúp căn chỉnh văn bản bên trong */

        /* Thiết kế màu cam */
        background: #d4a576 !important;
        /* Đã đổi màu nền thành cam */
        border: 1px solid #d4a576 !important;
        color: #ffffff !important;
        /* Đã đổi màu chữ thành trắng */

        text-transform: uppercase;
        font-weight: 700;
        font-size: 14px;
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: none !important;
        box-sizing: border-box !important;
    }

    .application_button:hover,
    input.application_button:hover {
        background-color: #b58b5f !important;
        /* Màu cam đậm hơn khi hover */
        border-color: #b58b5f !important;
        color: #ffffff !important;
    }

    .application_details {
        display: none;
    }

    /* --- BODY --- */
    .single-job-body {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .col-md-8,
    .col-md-4 {
        padding: 0 15px;
    }

    .col-md-8 {
        width: 66.66%;
    }

    .col-md-4 {
        width: 33.33%;
    }

    .job-description-box {
        background: #fff;
        padding: 30px;
        border: 1px solid #e5e5e5;
    }

    .job-description-box h3 {
        font-size: 16px;
        font-weight: 700;
        margin: 20px 0 10px 0;
        color: #333;
    }

    .job-description-box p {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
    }

    /* --- SIDEBAR --- */
    .sj-widget {
        background: #fff;
        padding: 20px;
        border: 1px solid #e5e5e5;
        margin-bottom: 20px;
    }

    .sj-widget .widget-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 15px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .rating-box {
        font-size: 20px;
        color: #d4a576;
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .rating-box .score {
        color: #333;
        font-weight: bold;
        font-size: 16px;
    }

    .company-photos {
        position: relative;
    }

    .company-photos img {
        width: 100%;
        height: auto;
        display: block;
    }

    .company-photos .photo-count {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 24px;
        font-weight: bold;
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
    }

    /* ==================================================================
--- OTHER JOBS SECTION (ĐÃ CHỈNH SỬA BULLET POINTS) ---
================================================================== */
    .other-jobs-section {
        margin-top: 50px;
    }

    .other-jobs-title {
        text-align: center;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 24px;
        margin-bottom: 30px;
        color: #333;
    }

    .custom-job-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        width: 100%;
    }

    .job-grid-item {
        width: 100%;
        display: flex;
    }

    .job-card-layout {
        background: #fff;
        padding: 25px;
        border-radius: 3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    /* CHỈNH SỬA LOGO */
    .job-logo-box {
        width: 100px;
        height: 100px;
        border: 1px solid black;
        margin-right: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .job-logo-box img {
        max-width: 100%;
        height: auto;
    }

    .job-card-header {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
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

    /* CHỈNH SỬA BULLET POINTS (MÀU ĐEN) */
    .job-card-body {
        flex-grow: 1;
    }

    /* Reset style của theme */
    .custom-ul {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        background: none !important;
        border: none !important;
    }

    /* Style cho từng dòng li */
    .custom-ul li {
        position: relative !important;
        padding-left: 20px !important;
        /* Khoảng cách cho dấu chấm */
        margin-bottom: 8px !important;
        font-size: 13px !important;
        color: #555 !important;
        line-height: 1.5 !important;
        background: none !important;
        border: none !important;
    }

    /* Tạo dấu chấm tròn màu ĐEN (ghi đè mọi icon của theme) */
    .custom-ul li::before {
        content: "•" !important;
        /* Ký tự dấu chấm */
        position: absolute !important;
        left: 0 !important;
        top: -1px !important;
        color: #333 !important;
        /* Đã chuyển thành màu đen/xám đậm */
        font-size: 18px !important;
        /* Kích thước dấu chấm */
        line-height: 1 !important;
        font-family: Arial, sans-serif !important;
        font-weight: normal !important;
        background: none !important;
        border: none !important;
        width: auto !important;
        height: auto !important;
    }

    /* Responsive */
    @media (max-width: 768px) {

        .col-md-8,
        .col-md-4 {
            width: 100%;
            margin-bottom: 20px;
        }

        .custom-job-grid {
            grid-template-columns: 1fr;
        }

        .job-header-inner {
            flex-direction: column;
            text-align: center;
        }

        .sj-logo {
            margin: 0 0 15px 0;
        }

        .sj-actions {
            width: 100%;
            margin-top: 15px;
            margin-left: 0;
            max-width: 100%;
        }

        .job-logo-box {
            width: 90px;
            height: 90px;
        }

    }


    /* Mobile Newsletter */
    @media (max-width: 768px) {
        .cn-inner {
            flex-direction: column;
            text-align: center;
        }

        .cn-form {
            margin-left: 0;
            width: 100%;
        }

        .cn-text h2 {
            margin: 0 0 20px 0;
            text-align: center;
        }

        .cn-form form {
            flex-direction: column;
            width: 100%;
        }

        .cn-form .input-group {
            width: 100%;
            margin-right: 0;
            margin-bottom: 15px;
        }

        .cn-form input[type="email"] {
            padding: 0 15px 0 50px;
        }

        .cn-form button {
            width: 100%;
        }
    }
</style>