<?php
/**
 * Template Name: Blog Page
 *
 * Custom blog page template with header banner and grid layout
 *
 * @package JobScout
 */

// Tìm trang "News" và lấy ảnh đại diện của nó
$header_image = get_template_directory_uri() . '/images/banner-image.jpg'; // ảnh mặc định

// Tìm trang có slug là 'news' hoặc 'blog'
$news_page = get_page_by_path('news');
if (!$news_page) {
    $news_page = get_page_by_path('blog');
}

// Nếu tìm thấy trang và có ảnh đại diện thì dùng ảnh đó
if ($news_page && has_post_thumbnail($news_page->ID)) {
    $header_image = get_the_post_thumbnail_url($news_page->ID, 'full');
}
?>

<?php get_header(); ?>

<style>
    .blog-header-banner, .blog-section {
        max-width: none !important;
        width: 100vw !important;
        margin-left: calc(-50vw + 50%) !important;
        margin-right: calc(-50vw + 50%) !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        position: relative !important;
        left: 0 !important;
        right: 0 !important;
    }

    .blog-header-banner {
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('<?php echo esc_url($header_image); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        position: relative;
        margin-top: -49px;
        margin-bottom: 0;
    }

    .blog-header-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        z-index: 1;
    }

    .blog-header-content {
        position: relative;
        z-index: 2;
        color: #ffffff;
    }

    .blog-header-title {
        font-size: 48px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .blog-section {
        background-color: #F2F2F2;
        padding: 80px 0;
        margin: 0 -9999px;
        padding-left: 9999px;
        padding-right: 9999px;
    }

    .blog-section-title {
        text-align: center;
        font-size: 32px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #2c2c2c;
        margin-bottom: 60px;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .blog-card {
        display: grid;
        grid-template-columns: 45% 1fr;
        align-items: stretch;
        background-color: #ffffff;
        border-radius: 0;
        overflow: hidden;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        padding: 18px 20px;
        column-gap: 28px;
    }

    .blog-card:hover {
        transform: translateY(-4px);
    }

    .blog-card-image {
        margin: 0;
        height: 100%;
        overflow: hidden;
    }

    .blog-card-image a {
        display: flex;
        height: 100%;
    }

    .blog-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .blog-card:hover .blog-card-image img {
        transform: scale(1.05);
    }

    .blog-card-content {
        padding: 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        gap: 12px;
    }

    .blog-card-title {
        font-size: 20px;
        line-height: 1.4;
        margin: 0;
        color: #2f2f2f;
        font-weight: 600;
    }

    .blog-card-title a {
        color: inherit;
        text-decoration: none;
    }

    .blog-card-title a:hover,
    .blog-card-title a:focus {
        color: #d45f1f;
    }

    .blog-card-excerpt {
        margin: 0;
        color: #707070;
        line-height: 1.7;
        font-size: 15px;
    }

    .blog-card-readmore {
        margin-top: 8px;
        color: #d45f1f;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        text-decoration: none;
        font-size: 14px;
    }

    .blog-card-readmore:hover,
    .blog-card-readmore:focus {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .blog-header-title {
            font-size: 36px;
        }

        .blog-section {
            padding: 60px 0;
        }

        .blog-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 0 15px;
        }

        .blog-card {
            grid-template-columns: 1fr;
            min-height: auto;
            text-align: center;
            padding: 20px;
        }

        .blog-card-image {
            width: 100%;
            height: 180px;
            margin: 0 auto 15px auto;
        }

        .blog-card-content {
            padding: 0;
        }

        .blog-card-title {
            font-size: 18px;
        }
    }
</style>

<!-- Blog Header Banner -->
<section class="blog-header-banner">
    <div class="blog-header-content">
        <h1 class="blog-header-title">PDS NEWS</h1>
    </div>
</section>

<!-- Blog Section -->
<section class="blog-section">
    <h2 class="blog-section-title">NEWEST BLOG ENTRIES</h2>
    
    <div class="blog-grid">
            <?php
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 8,
                'ignore_sticky_posts' => true
            );

            $blog_query = new WP_Query($args);

            if ($blog_query->have_posts()) :
                while ($blog_query->have_posts()) : $blog_query->the_post();
            ?>
                    <article class="blog-card">
                        <div class="blog-card-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('medium', array('class' => 'blog-card-img'));
                                } else {
                                    echo '<img src="https://via.placeholder.com/180x200/f4f4f4/cccccc?text=No+Image" alt="' . get_the_title() . '">';
                                }
                                ?>
                            </a>
                        </div>
                        <div class="blog-card-content">
                            <h3 class="blog-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="blog-card-excerpt">
                                <?php 
                                $excerpt = get_the_excerpt();
                                echo wp_trim_words($excerpt, 20, '...');
                                ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="blog-card-readmore">Read More</a>
                        </div>
                    </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <p><?php _e('No blog posts found.', 'jobscout'); ?></p>
            <?php
            endif;
            ?>
        </div>
</section>

<?php
get_footer();
