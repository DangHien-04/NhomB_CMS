<?php
/**
 * Single Post Template - Custom Newsletter Hardcoded
 */

get_header(); 

$current_id = get_the_ID();
$date       = get_the_date('M d, Y');
$cat_list   = get_the_category();
$cat_name   = !empty($cat_list) ? $cat_list[0]->name : 'News';
$thumb_url  = get_the_post_thumbnail_url($current_id, 'thumbnail');
if(!$thumb_url) $thumb_url = 'https://via.placeholder.com/100x100?text=Img';
?>

<div class="custom-single-job-wrap">
    <div class="container">
        
        <div class="job-breadcrumbs">
            <a href="<?php echo home_url(); ?>">Home</a>
            <span class="sep">/</span>
            <a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">All News</a>
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
                    <?php while ( have_posts() ) : the_post(); ?>
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
                        'post_type'      => 'post',
                        'posts_per_page' => 6, 
                        'post__not_in'   => [$current_id],
                        'orderby'        => 'date',
                        'order'          => 'DESC'
                    ];
                    $related = new WP_Query($args);
                    if ($related->have_posts()) :
                        while ($related->have_posts()) : $related->the_post();
                            $r_img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                            if(!$r_img) $r_img = 'https://via.placeholder.com/300x200?text=Blog+Img';
                            $r_excerpt  = wp_trim_words(get_the_excerpt(), 15, '...');
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
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>

    </div>
</div>



<?php get_footer(); ?>

<style>
/* --- GIỮ NGUYÊN CSS CŨ CỦA BẠN Ở ĐÂY --- */
.custom-single-job-wrap { background-color: #f4f4f4; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw; padding-top: 40px; padding-bottom: 80px; margin-bottom: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; }
body { overflow-x: hidden; }
.job-breadcrumbs { font-size: 14px; color: #666; margin-bottom: 20px; margin-left: 5px; }
.job-breadcrumbs a { color: #d4a576; text-decoration: none; }
.job-breadcrumbs .sep { margin: 0 8px; color: #ccc; }
.job-breadcrumbs .current { color: #333; font-weight: 500; }
.single-job-header { background: #fff; padding: 25px; margin-bottom: 30px; border: 1px solid #e5e5e5; }
.job-header-inner { display: flex; align-items: center; flex-wrap: wrap; }
.sj-logo { width: 100px; height: 100px; border: 1px solid #eee; padding: 3px; margin-right: 25px; display: flex; align-items: center; justify-content: center; }
.sj-logo img { width: 100%; height: 100%; object-fit: cover; }
.sj-info { flex-grow: 1; }
.sj-title { font-size: 22px; text-transform: uppercase; font-weight: 700; margin: 0 0 5px 0; color: #333; }
.sj-date { font-size: 13px; color: #999; margin-bottom: 10px; }
.sj-meta-bar span { background: #f5f5f5; padding: 5px 12px; font-size: 12px; color: #666; margin-right: 5px; border-radius: 3px; }
.sj-actions { margin-left: auto; }
a.btn-share { display: flex; align-items: center; justify-content: center; width: 140px; height: 45px; background-color: #ffffff; border: 1px solid #000000; color: #000000 !important; text-transform: uppercase; font-weight: 700; font-size: 14px; text-decoration: none !important; transition: all 0.3s; }
a.btn-share:hover { background-color: #333; color: #fff !important; }
.single-job-body { display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px; }
.col-md-8 { width: 66.66%; padding: 0 15px; }
.col-md-4 { width: 33.33%; padding: 0 15px; }
.job-description-box { background: #fff; padding: 40px; border: 1px solid #e5e5e5; min-height: 300px; }
.news-content-styled p { margin-bottom: 20px; line-height: 1.7; color: #444; font-size: 15px; }
.news-content-styled img { max-width: 100%; height: auto; margin: 20px 0; }
.other-jobs-section { margin-top: 50px; }
.other-jobs-title { text-align: center; font-weight: 700; text-transform: uppercase; font-size: 24px; margin-bottom: 30px; color: #333; }
.blog-horizontal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; width: 100%; }
.blog-grid-item { width: 100%; }
.blog-card-horizontal { background: #fff; padding: 20px; display: flex; align-items: flex-start; height: 100%; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
.blog-card-img { width: 160px; height: 110px; flex-shrink: 0; margin-right: 20px; overflow: hidden; }
.blog-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.blog-card-horizontal:hover .blog-card-img img { transform: scale(1.05); }
.blog-card-content { flex-grow: 1; display: flex; flex-direction: column; }
.blog-card-title { font-size: 16px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.3; color: #333; }
.blog-card-title a { color: #333; text-decoration: none; }
.blog-card-title a:hover { color: #d4a576; }
.blog-card-excerpt { font-size: 13px; color: #666; line-height: 1.5; margin-bottom: 10px; }
.blog-readmore { font-size: 12px; font-weight: 700; color: #d4a576; text-transform: uppercase; text-decoration: none; margin-top: auto; }
.blog-readmore:hover { color: #b58b5f; text-decoration: underline; }

/* ==========================================================
   --- NEW NEWSLETTER STYLE (CLEAN & CENTERED) ---
   ========================================================== */




/* Mobile */
@media (max-width: 768px) {
    .col-md-8, .col-md-4 { width: 100%; }
    .blog-horizontal-grid { grid-template-columns: 1fr; }
    
    /* Mobile Newsletter */
    .cn-inner { flex-direction: column; text-align: center; }
    .cn-text h2 { margin: 0 0 20px 0; text-align: center; }
    .cn-form form { flex-direction: column; width: 100%; }
    .cn-form .input-group { width: 100%; margin-right: 0; margin-bottom: 15px; }
    .cn-form button { width: 100%; }
}
</style>