<?php
/**
 * Template Name: Contact Page
 *
 * Custom contact page layout that mirrors the provided design reference.
 *
 * @package JobScout
 */

global $post;

get_header();
?>

<div id="primary" class="content-area contact-page">
    <main id="main" class="site-main">
        <style>
        .contact-hero, .contact-address-block, .contact-info-grid {
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
        </style>
        <?php
        while ( have_posts() ) : the_post();
            $hero_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            if ( ! $hero_image ) {
                $hero_image = get_template_directory_uri() . '/images/banner-image.jpg';
            }

            $hq_address = get_the_content();
            if ( empty( $hq_address ) ) {
                $hq_address = __( '68 Nguyen Van Thu, Ward Da Kao, District 1, Ho Chi Minh City, Viet Nam', 'jobscout' );
            }

            $employer_hcm = get_post_meta( get_the_ID(), 'jobscout_contact_hcm', true );
            $employer_hcm = $employer_hcm ? $employer_hcm : '+84 907 440 510';

            $employer_hn = get_post_meta( get_the_ID(), 'jobscout_contact_hn', true );
            $employer_hn = $employer_hn ? $employer_hn : '+84 983 191 331';

            $support_hotline = get_post_meta( get_the_ID(), 'jobscout_contact_hotline', true );
            $support_hotline = $support_hotline ? $support_hotline : '+84 28 6281 1357';
        ?>
            <section class="contact-hero" style="background-image: url('<?php echo esc_url( $hero_image ); ?>');">
                <div class="contact-hero__overlay">
                    <div class="contact-hero__inner">
                     
                        <h1 class="contact-hero__title"><?php echo esc_html__( 'Contact Us', 'jobscout' ); ?></h1>
                    </div>
                </div>
            </section>

            <section class="contact-address-block" style="background: #fff; width: 100vw; margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%);">
                <div class="contact-section__inner">
                    <h2 class="contact-address-block__title"><?php esc_html_e( 'Our Headquarters Address', 'jobscout' ); ?></h2>
                    <p class="contact-address-block__text">
                        <?php echo esc_html( $hq_address ); ?>
                    </p>
                </div>
            </section>

            <section class="contact-info-grid" style="background: #f0edea; width: 100vw; margin-left: calc(-50vw + 50%); margin-right: calc(-50vw + 50%);">
                <div class="contact-section__inner">
                    <div class="contact-info-grid__inner">
                        <article class="contact-card contact-card--employers">
                            <h3><?php esc_html_e( 'For Employers', 'jobscout' ); ?></h3>
                            <p><?php esc_html_e( 'Call our Sales Hotline', 'jobscout' ); ?></p>
                            <div class="contact-card__city">
                                <h4><?php esc_html_e( 'Ho Chi Minh', 'jobscout' ); ?></h4>
                                <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $employer_hcm ) ); ?>"><?php echo esc_html( $employer_hcm ); ?></a>
                            </div>
                            <div class="contact-card__city">
                                <h4><?php esc_html_e( 'Ha Noi', 'jobscout' ); ?></h4>
                                <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $employer_hn ) ); ?>"><?php echo esc_html( $employer_hn ); ?></a>
                            </div>
                            <p class="contact-card__note">
                                <?php esc_html_e( "Request a call from one of our Customer Love Account Managers. We're ready to help you grow!", 'jobscout' ); ?>
                            </p>
                        </article>

                        <article class="contact-card contact-card--jobseekers">
                            <h3><?php esc_html_e( 'For Jobseekers', 'jobscout' ); ?></h3>
                            <p class="contact-card__detail">
                                <a href="https://www.facebook.com/" target="_blank" rel="noopener" style="color: #555; text-decoration: none;">
                                    <?php esc_html_e( 'Ask a question on our ', 'jobscout' ); ?>
                                    <strong style="color: #ff8c00; text-decoration: underline; text-decoration-color: #ff8c00;">Facebook</strong>
                                    <?php esc_html_e( ' page', 'jobscout' ); ?>
                                </a>
                            </p>
                            <div class="contact-card__city">
                                <h4><?php esc_html_e( 'Call us at', 'jobscout' ); ?></h4>
                                <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $support_hotline ) ); ?>"><?php echo esc_html( $support_hotline ); ?></a>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

          
        <?php endwhile; ?>
    </main>
</div>

<?php
get_footer();
