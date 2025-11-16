<?php
/**
 * Blog Section
 * 
 * @package JobScout
 */

$blog_heading = get_theme_mod( 'blog_section_title', __( 'Newest Blog Entries', 'jobscout' ) );
$sub_title    = get_theme_mod( 'blog_section_subtitle', __( 'We will help you find it. We are your first step to becoming everything you want to be.', 'jobscout' ) );
$blog         = get_option( 'page_for_posts' );
$hide_author  = get_theme_mod( 'ed_post_author', false );
$hide_date    = get_theme_mod( 'ed_post_date', false );
$ed_blog      = get_theme_mod( 'ed_blog', true );

$args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 4,
    'ignore_sticky_posts' => true
);

$qry = new WP_Query( $args );

if( $ed_blog && ( $blog_heading || $sub_title || $qry->have_posts() ) ){
    static $blog_grid_styles_added = false;

    if ( ! $blog_grid_styles_added ) {
        $blog_grid_styles_added = true;
        ?>
        <style>
            #blog-section.blog-grid-section {
                background-color: #f4efea;
                padding: 72px 0 88px;
            }

            .blog-grid-section .section-title {
                text-transform: uppercase;
                text-align: center;
                margin-bottom: 56px;
                letter-spacing: 0.18em;
                font-weight: 700;
                color: #2c2c2c;
            }

            .blog-grid-section .section-desc,
            .blog-grid-section .btn-wrap {
                display: none;
            }

            .blog-grid-section .article-wrap {
                display: grid;
                gap: 40px 36px;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .blog-entry-card {
                display: grid;
                grid-template-columns: 40% 1fr;
                align-items: stretch;
                background-color: #ffffff;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid #e7ded7;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                padding: 18px 20px;
                column-gap: 28px;
            }

            .blog-entry-card:hover {
                transform: translateY(-4px);
            }

            .blog-entry-thumb {
                margin: 0;
                height: 100%;
                overflow: hidden;
            }

            .blog-entry-thumb a {
                display: flex;
                height: 100%;
            }

            .blog-entry-thumb img,
            .blog-entry-thumb svg {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .blog-entry-content {
                padding: 0;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                gap: 12px;
            }

            .blog-entry-title {
                font-size: 20px;
                line-height: 1.4;
                margin: 0;
                color: #2f2f2f;
                font-weight: 600;
            }

            .blog-entry-title a {
                color: inherit;
                text-decoration: none;
            }

            .blog-entry-title a:hover,
            .blog-entry-title a:focus {
                color: #d45f1f;
            }

            .blog-entry-excerpt {
                margin: 0;
                color: #707070;
                line-height: 1.7;
                font-size: 15px;
            }

            .blog-entry-readmore {
                margin-top: 8px;
                color: #d45f1f;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                text-decoration: none;
                font-size: 14px;
            }

            .blog-entry-readmore:hover,
            .blog-entry-readmore:focus {
                text-decoration: underline;
            }

            @media (max-width: 1024px) {
                .blog-grid-section .article-wrap {
                    gap: 32px;
                }
            }

            @media (max-width: 900px) {
                .blog-grid-section .article-wrap {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 767px) {
                #blog-section.blog-grid-section {
                    padding: 56px 0 64px;
                }

                .blog-entry-card {
                    grid-template-columns: 1fr;
                    padding: 24px;
                    row-gap: 20px;
                }

                .blog-entry-thumb a {
                    height: 220px;
                }

                .blog-entry-content {
                    gap: 10px;
                }
            }
        </style>
        <?php
    }
    ?>
<section id="blog-section" class="article-section blog-grid-section">
	<div class="container">
        <?php 
            if( $blog_heading ) echo '<h2 class="section-title">' . esc_html( $blog_heading ) . '</h2>';
        ?>
        
        <?php if( $qry->have_posts() ){ ?>
           <div class="article-wrap">
     		<?php 
                while( $qry->have_posts() ){
                    $qry->the_post(); ?>
					<article class="post blog-entry-card">
						<figure class="post-thumbnail blog-entry-thumb">
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                            <?php 
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( 'jobscout-blog', array( 'itemprop' => 'image' ) );
                                }else{ 
                                    jobscout_fallback_svg_image( 'jobscout-blog' ); 
                                }                            
                            ?>                        
                            </a>
                        </figure>
                        <div class="blog-entry-content">
                            <h3 class="blog-entry-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <?php if ( has_excerpt() || get_the_content() ) { ?>
                                <p class="blog-entry-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22, '...' ) ); ?></p>
                            <?php } ?>
                            <a class="blog-entry-readmore" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'jobscout' ); ?></a>
                        </div>
                    </article>			
				<?php 
                }
                wp_reset_postdata();
                ?>
		</div><!-- .article-wrap -->
        
        <?php } ?>
	</div>
</section>
<?php 
}