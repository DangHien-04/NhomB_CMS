<?php
/**
 * Single Post Template - CLONE 100% FROM JOB LAYOUT + NEWSLETTER FIX
 */

get_header();

$current_id = get_the_ID();
$date = get_the_date('M d, Y');

// Lấy Category
$cat_list = get_the_category();
$cat_name = !empty($cat_list) ? $cat_list[0]->name : 'News';

// Lấy Thumbnail (Logo)
$thumb_url = get_the_post_thumbnail_url($current_id, 'thumbnail');
if (!$thumb_url)
      $thumb_url = 'https://via.placeholder.com/100x100?text=Img';
?>

<div class="single_job_listing custom-single-job-wrap">
      <div class="container">

            <div class="job-breadcrumbs">
                  <a href="<?php echo home_url(); ?>">Home</a>
                  <span class="sep">/</span>
                  <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">All News</a>
                  <span class="sep">/</span>
                  <span class="current">News Detail</span>
            </div>

            <div class="single-job-header">
                  <div class="job-header-inner">
                        <div class="sj-logo">
                              <img src="<?php echo esc_url($thumb_url); ?>" alt="Thumbnail">
                        </div>
                        <div class="sj-info">
                              <h1 class="sj-title"><?php the_title(); ?></h1>
                              <p class="sj-date">Posted: <?php echo esc_html($date); ?></p>
                              <div class="sj-meta-bar">
                                    <span><?php echo esc_html($cat_name); ?></span>
                                    <span>Ho Chi Minh City</span>
                              </div>
                        </div>
                        <div class="sj-actions">
                              <a href="#" class="btn-share">SHARE</a>
                        </div>
                  </div>
            </div>

            <div class="single-job-body row">
                  <div class="col-md-8 sj-content-col">
                        <div class="job-description-box">
                              <?php while (have_posts()):
                                    the_post(); ?>
                                    <div class="news-content-styled">
                                          <?php the_content(); ?>
                                    </div>
                              <?php endwhile; ?>
                        </div>
                  </div>
                  <div class="col-md-4 sj-sidebar-col"></div>
            </div>

            <div class="other-jobs-section">
                  <h2 class="other-jobs-title">NEWEST BLOG ENTRIES</h2>

                  <div class="blog-horizontal-grid">
                        <?php
                        $args = [
                              'post_type' => 'post',
                              'posts_per_page' => 6,
                              'post__not_in' => [$current_id],
                              'orderby' => 'date',
                              'order' => 'DESC'
                        ];
                        $related = new WP_Query($args);

                        if ($related->have_posts()):
                              while ($related->have_posts()):
                                    $related->the_post();
                                    $r_img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                                    if (!$r_img)
                                          $r_img = 'https://via.placeholder.com/300x200?text=Blog+Img';
                                    $r_excerpt = wp_trim_words(get_the_excerpt(), 15, '...');
                                    ?>
                                    <div class="blog-grid-item">
                                          <div class="blog-card-horizontal">
                                                <div class="blog-card-img">
                                                      <img src="<?php echo esc_url($r_img); ?>" alt="<?php the_title(); ?>">
                                                </div>
                                                <div class="blog-card-content">
                                                      <h3 class="blog-card-title">
                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                      </h3>
                                                      <p class="blog-card-excerpt">
                                                            <?php echo esc_html($r_excerpt); ?>
                                                      </p>
                                                      <a href="<?php the_permalink(); ?>" class="blog-readmore">Read More</a>
                                                </div>
                                          </div>
                                    </div>
                              <?php
                              endwhile;
                              wp_reset_postdata();
                        endif;
                        ?>
                  </div>
            </div>

      </div>
</div>

<?php get_footer(); ?>

<style>
      /* --- 1. LAYOUT NỀN XÁM FULL MÀN HÌNH --- */
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

            /* QUAN TRỌNG: Điều chỉnh margin này để không đè lên footer gây lệch */
            margin-bottom: -50px;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      }

      body {
            overflow-x: hidden;
      }

      /* --- 2. CÁC CLASS COPY TỪ JOB (Để giống hệt) --- */
      .job-breadcrumbs {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            margin-left: 5px;
      }

      .job-breadcrumbs a {
            color: #d4a576;
            text-decoration: none;
      }

      .job-breadcrumbs .sep {
            margin: 0 8px;
            color: #ccc;
      }

      .job-breadcrumbs .current {
            color: #333;
            font-weight: 500;
      }

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
            border: 1px solid #eee;
            padding: 3px;
            margin-right: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
      }

      .sj-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

      .sj-actions {
            margin-left: auto;
      }

      /* Nút Share */
      a.btn-share {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 140px;
            height: 45px;
            background-color: #ffffff;
            border: 1px solid #000000;
            color: #000000 !important;
            text-transform: uppercase;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none !important;
            transition: all 0.3s;
      }

      a.btn-share:hover {
            background-color: #333;
            color: #fff !important;
      }

      /* Body & Content */
      .single-job-body {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
      }

      .col-md-8 {
            width: 66.66%;
            padding: 0 15px;
      }

      .col-md-4 {
            width: 33.33%;
            padding: 0 15px;
      }

      .job-description-box {
            background: #fff;
            padding: 40px;
            border: 1px solid #e5e5e5;
            min-height: 300px;
      }

      .news-content-styled p {
            margin-bottom: 20px;
            line-height: 1.7;
            color: #444;
            font-size: 15px;
      }

      .news-content-styled img {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
      }

      /* Related News (Horizontal) */
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

      .blog-horizontal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            width: 100%;
      }

      .blog-grid-item {
            width: 100%;
      }

      .blog-card-horizontal {
            background: #fff;
            padding: 20px;
            display: flex;
            align-items: flex-start;
            height: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
      }

      .blog-card-img {
            width: 160px;
            height: 110px;
            flex-shrink: 0;
            margin-right: 20px;
            overflow: hidden;
      }

      .blog-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
      }

      .blog-card-horizontal:hover .blog-card-img img {
            transform: scale(1.05);
      }

      .blog-card-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
      }

      .blog-card-title {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 8px 0;
            line-height: 1.3;
            color: #333;
      }

      .blog-card-title a {
            color: #333;
            text-decoration: none;
      }

      .blog-card-title a:hover {
            color: #d4a576;
      }

      .blog-card-excerpt {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 10px;
      }

      .blog-readmore {
            font-size: 12px;
            font-weight: 700;
            color: #d4a576;
            text-transform: uppercase;
            text-decoration: none;
            margin-top: auto;
      }

      .blog-readmore:hover {
            color: #b58b5f;
            text-decoration: underline;
      }

      /* ==========================================================================
   --- 3. FIX LỖI NEWSLETTER (VŨ KHÍ BÍ MẬT) ---
   Dùng !important và Flexbox để ép mọi thứ thẳng hàng bất chấp theme
   ========================================================================== */

      /* Target thẳng vào khung cam Newsletter */
      .jobscout-newsletter-section,
      .footer-newsletter,
      section.newsletter-section {
            display: flex !important;
            align-items: center !important;
            /* Căn giữa dọc */
            justify-content: center !important;
            padding-top: 40px !important;
            padding-bottom: 40px !important;
      }

      /* Target vào Container bên trong nó */
      .jobscout-newsletter-section .container,
      .footer-newsletter .container,
      section.newsletter-section .container {
            display: flex !important;
            align-items: center !important;
            /* Căn giữa dọc lần 2 */
            justify-content: center !important;
            flex-direction: row !important;
            /* Ép nằm ngang */
            width: 100% !important;
            max-width: 1140px !important;
      }

      /* Target Chữ "Subscribe To..." */
      .jobscout-newsletter-section .section-title,
      .newsletter-section h2 {
            margin: 0 40px 0 0 !important;
            /* Cách form 40px */
            padding: 0 !important;
            line-height: 1 !important;
            text-align: left !important;
            width: auto !important;
            flex-shrink: 0;
            /* Không bị bóp méo */
      }

      /* Target cái Form */
      .jobscout-newsletter-section form,
      .newsletter-section form {
            display: flex !important;
            align-items: center !important;
            /* Input và Button thẳng hàng */
            margin: 0 !important;
            padding: 0 !important;
            flex-grow: 0;
      }

      /* Target ô nhập liệu (Input) */
      .jobscout-newsletter-section input[type="email"],
      .newsletter-section input[type="email"] {
            height: 50px !important;
            /* Chiều cao cố định */
            line-height: 50px !important;
            margin: 0 !important;

            /* --- DÒNG QUAN TRỌNG ĐÃ SỬA --- */
            padding-left: 60px !important;
            /* Đẩy chữ sang phải 60px để né icon */
            padding-right: 20px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            /* ------------------------------ */

            border-radius: 0 !important;
            border: none !important;
            min-width: 350px !important;
            vertical-align: middle !important;
            box-sizing: border-box !important;
            background-color: #fff !important;
      }

      /* Target nút Bấm (Button) */
      .jobscout-newsletter-section input[type="submit"],
      .newsletter-section button[type="submit"] {
            height: 50px !important;
            /* Chiều cao bằng ô nhập */
            line-height: 50px !important;
            margin: 0 0 0 10px !important;
            /* Cách ô nhập 10px */
            padding: 0 30px !important;
            border-radius: 0 !important;
            border: 1px solid #fff !important;
            background-color: transparent !important;
            color: #fff !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            vertical-align: middle !important;
            box-sizing: border-box !important;
            cursor: pointer !important;
      }

      /* Hover nút */
      .jobscout-newsletter-section input[type="submit"]:hover,
      .newsletter-section button[type="submit"]:hover {
            background-color: #fff !important;
            color: #d4a576 !important;
      }

      /* Responsive Mobile */
      @media (max-width: 768px) {

            .col-md-8,
            .col-md-4 {
                  width: 100%;
            }

            .blog-horizontal-grid {
                  grid-template-columns: 1fr;
            }

            .sj-actions {
                  margin: 20px auto 0 auto;
            }

            .job-header-inner {
                  flex-direction: column;
                  text-align: center;
            }

            /* Mobile Newsletter */
            .jobscout-newsletter-section .container {
                  flex-direction: column !important;
                  text-align: center !important;
            }

            .jobscout-newsletter-section .section-title {
                  margin: 0 0 20px 0 !important;
                  margin-right: 0 !important;
            }

            .jobscout-newsletter-section form {
                  flex-direction: column;
                  width: 100%;
            }

            .jobscout-newsletter-section input[type="email"] {
                  width: 100%;
                  margin-bottom: 10px !important;
                  min-width: unset !important;
            }

            .jobscout-newsletter-section input[type="submit"] {
                  width: 100%;
                  margin-left: 0 !important;
            }
      }
</style>