<?php
/**
 * Job Posting Section - Layout 2 cột + Chức năng Load More (JavaScript)
 */

$job_title = get_theme_mod('job_posting_section_title', 'TOP JOBS');
$ed_jobposting = get_theme_mod('ed_jobposting', true);

if ($ed_jobposting):
    ?>

    <section id="job-posting-section" class="top-job-section">
        <div class="container">

            <?php if ($job_title): ?>
                <h2 class="section-title"><?php echo esc_html($job_title); ?></h2>
            <?php endif; ?>

            <div class="custom-job-grid">

                <?php
                // 1. QUERY: Lấy nhiều job hơn (Ví dụ 12 job)
                $args = [
                    'post_type' => 'job_listing',
                    'post_status' => 'publish',
                    'posts_per_page' => 12, // Lấy 12 job (Hiển thị 6, ẩn 6 để load more)
                    'orderby' => 'date',
                    'order' => 'DESC'
                ];
                $jobs = new WP_Query($args);

                // Biến đếm để xác định job nào ẩn, job nào hiện
                $count = 0;

                if ($jobs->have_posts()):
                    while ($jobs->have_posts()):
                        $jobs->the_post();
                        $count++; // Tăng biến đếm
            
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
                        if (empty($logo_url))
                            $logo_url = 'https://via.placeholder.com/100x100?text=Logo';

                        $location = get_post_meta($id, '_job_location', true);
                        $types = get_the_terms($id, 'job_listing_type');
                        $type_name = ($types && !is_wp_error($types)) ? $types[0]->name : 'Fulltime';
                        $cats = get_the_terms($id, 'job_listing_category');
                        $cat_name = ($cats && !is_wp_error($cats)) ? $cats[0]->name : 'General';
                        $excerpt = wp_trim_words(get_the_content(), 15, '...');

                        // 2. LOGIC ẨN HIỆN: Nếu là job thứ 7 trở đi thì thêm class 'hidden-job'
                        $hidden_class = ($count > 6) ? 'hidden-job' : '';
                        $hidden_style = ($count > 6) ? 'style="display:none;"' : '';
                        ?>

                        <div class="job-grid-item <?php echo $hidden_class; ?>" <?php echo $hidden_style; ?>>
                            <div class="job-card-layout">

                                <div class="job-card-header">
                                    <div class="job-logo-box">
                                        <img src="<?php echo esc_url($logo_url); ?>" alt="Logo">
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
                                            <span><?php echo esc_html($type_name); ?></span>
                                            <span><?php echo esc_html($cat_name); ?></span>
                                            <?php if ($location): ?><span><?php echo mb_strlen($location) > 20 ? mb_substr($location, 0, 20) . '...' : esc_html($location); ?></span><?php endif; ?>
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
                                        $count_line = 0; // Đổi tên biến để tránh trùng lặp
                                        $max_words_per_line = 9; // Giới hạn 15 từ cho mỗi dòng
                            
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
                    echo '<p style="width:100%; text-align:center">No jobs found.</p>';
                endif;
                ?>

            </div> <?php if ($jobs->found_posts > 6): ?>
                <div class="view-more-container">
                    <button id="load-more-btn" class="btn-view-more-outline">
                        VIEW MORE JOBS
                    </button>
                </div>
            <?php endif; ?>

        </div>
    </section>

<?php endif; ?>

<script>
    // 4. JAVASCRIPT XỬ LÝ LOAD MORE
    document.addEventListener("DOMContentLoaded", function () {
        var loadMoreBtn = document.getElementById('load-more-btn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function (e) {
                e.preventDefault();

                // Tìm tất cả các job đang bị ẩn
                var hiddenJobs = document.querySelectorAll('.hidden-job');

                // Hiển thị từng cái một
                hiddenJobs.forEach(function (job) {
                    job.style.display = 'block'; // Hiện lại
                    job.classList.remove('hidden-job'); // Xóa class ẩn
                });

                // Sau khi hiện hết thì ẩn nút đi
                this.style.display = 'none';
            });
        }
    });
</script>

<style>
    /* Grid 2 cột */
    .custom-job-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        width: 100%;
    }

    @media (max-width: 768px) {
        .custom-job-grid {
            grid-template-columns: 1fr;
        }
    }

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
    }

    /* Job Card */
    .job-card-layout {
        background: #fff;
        padding: 30px;
        border-radius: 3px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
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

    /* Body */
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
        /* Thêm con trỏ tay */
    }

    .btn-view-more-outline:hover {
        background-color: #d4a576;
        color: #fff;
    }
</style>