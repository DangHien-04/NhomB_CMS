<?php
/**
 * Template Name: About Page
 *
 * Custom about page layout for Omotenashi company.
 *
 * @package JobScout
 */

get_header();
?>

<style>
/* Force remove all spacing before hero */
.site-content { margin-top: 0 !important; padding-top: 0 !important; }
.content-area { margin-top: 0 !important; padding-top: 0 !important; }
.site-main { margin-top: 0 !important; padding-top: 0 !important; }
#primary { margin-top: 0 !important; padding-top: 0 !important; }
#main { margin-top: 0 !important; padding-top: 0 !important; }
.about-page { margin-top: 0 !important; padding-top: 0 !important; }

/* Also target any possible wrapper elements */
header { margin-bottom: 0 !important; }
</style>

<div id="primary" class="content-area about-page">
    <main id="main" class="site-main">
        <?php
        while ( have_posts() ) : the_post();
            
            $hero_image = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            if ( ! $hero_image ) {
                $hero_image = get_template_directory_uri() . '/images/banner-image.jpg';
            }
        ?>
        <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Remove all spacing from hero and parent elements */
        .site-content,
        .content-area,
        .site-main {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .hero {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('<?php echo esc_url( $hero_image ); ?>') center/cover;
            height: 350px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            position: relative;
            left: 0;
            right: 0;
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero p {
            font-size: 1.5em;
            letter-spacing: 1px;
        }

        .about-section {
            background: #f4f4f4;
            padding: 60px 20px;
            text-align: center;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            position: relative;
            left: 0;
            right: 0;
        }

        .about-section h2 {
            font-size: 2em;
            margin-bottom: 40px;
            color: #2c3e50;
        }

        .about-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }

        .about-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .about-text {
            text-align: left;
        }

        .about-text h3 {
            color: #c17f4e;
            margin-bottom: 10px;
            font-size: 1.2em;
        }

        .about-text p {
            margin-bottom: 20px;
            color: #555;
            line-height: 1.8;
        }

        .highlight-section {
            background: white;
            padding: 40px 20px;
            text-align: center;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            position: relative;
            left: 0;
            right: 0;
        }

        .highlight-section h3 {
            color: #c17f4e;
            font-size: 1.3em;
            margin-bottom: 30px;
        }

        .highlight-text {
            max-width: 900px;
            margin: 0 auto;
            color: #555;
            line-height: 1.8;
        }

        .info-section {
            background: #f4f4f4;
            padding: 60px 20px;
            width: 100vw;
            margin-left: calc(-50vw + 50%);
            margin-right: calc(-50vw + 50%);
            position: relative;
            left: 0;
            right: 0;
        }

        .info-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }

        .info-item {
            margin-bottom: 25px;
            text-align: center;
        }

        .info-item h4 {
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 1.1em;
        }

        .info-item p {
            color: #666;
        }

        .tokyo-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2em;
            }

            .hero p {
                font-size: 1.2em;
            }

            .about-content,
            .info-container {
                grid-template-columns: 1fr;
            }
        }
        </style>
        
        <!-- Hero Section -->
        <section class="hero">
            <h1>Share "Omotenashi"</h1>
            <h1>With the World</h1>
        </section>

        <!-- About Section -->
        <section class="about-section">
            <h2>ABOUT US</h2>
            <div class="about-content">
                <div class="about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/torii gate.jpg" alt="Torii Gate">
                </div>
                <div class="about-text">
                    <h3>Our Vision</h3>
                    <p>Create brands and restaurants around the world that offer memorable experiences, enabling visitors, and sharing our passion for authentic Japanese hospitality together with our people, partners, team members and communities.</p>

                    <h3>Ours Mission</h3>
                    <p>Share "Omotenashi" with the world</p>

                    <h3>Our Core Value</h3>
                    <p>"If quoi be great"</p>
                    <p>Create an environment the hospitality you would want to receive as a guest.</p>
                </div>
            </div>
        </section>

        <!-- Highlight Section -->
        <section class="highlight-section">
            <h3>Hotels, restaurants, bespoke/In weddings management</h3>
            <div class="highlight-text">
                <p>Plan On Site developed and operates 17 properties worldwide, including 3 award-winning resorts in Japan (7 restaurants) of 8-entire-collection in cities including New York, Miami and Los Angeles, and other ventures including food delivery services.</p>
                <p>Each venue carries its own concept and design. Many of them are gradually listed landmarks that were loved by the local people.</p>
            </div>
        </section>

        <!-- Info Section -->
        <section class="info-section">
            <div class="info-container">
                <div class="company-info">
                    <div class="info-item">
                        <h4>Established since</h4>
                        <p>June 1993</p>
                    </div>
                    <div class="info-item">
                        <h4>Head Office</h4>
                        <p>Marunouchi 3-2-1, Chiyoda, Tokyo</p>
                    </div>
                    <div class="info-item">
                        <h4>Capital</h4>
                        <p>100.000.000 JPY</p>
                    </div>
                    <div class="info-item">
                        <h4>CEO</h4>
                        <p>Yunus Thule</p>
                    </div>
                    <div class="info-item">
                        <h4>Number of Employees</h4>
                        <p>Part time: 567 / Total: 1,600</p>
                    </div>
                </div>
                <div class="tokyo-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/thap tokyo.jpg" alt="Tokyo Tower">
                </div>
            </div>
        </section>
        
        <?php endwhile; ?>
    </main>
</div>

<?php
get_footer();
