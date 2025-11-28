<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package JobScout
 */

/**
 * After Content
 * 
 * @hooked jobscout_content_end - 20
 */
do_action('jobscout_before_footer');
?>

<!-- Custom Footer -->
<footer class="custom-footer">
    <!-- Newsletter Section -->
    <div class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h3 class="newsletter-heading">Subscribe To<br>Our Newsletter</h3>

                <div class="input-group">
                    <span class="email-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </span>
                    <input type="email" placeholder="Input your email address" class="newsletter-input">
                </div>
                <button type="submit" class="newsletter-button">SUBSCRIBE</button>


            </div>
        </div>
    </div>



    <!-- Navigation and Social Section -->
    <div class="nav-social-section">
        <div class="container">
             <div class="company-logo">
                <h2>NhómB_CMS</h2>
            </div>
            <div class="footer-content">
                <!-- Navigation Menu -->
                <nav class="footer-nav">
                    <?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
                        <?php dynamic_sidebar( 'footer-one' ); ?>
                    <?php else : ?>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/jobs')); ?>">JOBS</a></li>
                            <li><a href="<?php echo esc_url(home_url('/companies')); ?>">COMPANIES</a></li>
                            <li><a href="<?php echo esc_url(home_url('/blog')); ?>">BLOG</a></li>
                            <li><a href="<?php echo esc_url(home_url('/about')); ?>">ABOUT</a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>">CONTACT</a></li>
                        </ul>
                    <?php endif; ?>
                </nav>

                <!-- Social Media Icons -->
                <div class="social-icons">
                    <a href="#" class="social-icon facebook">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="#" class="social-icon google">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                fill="#4285F4" />
                            <path
                                d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                fill="#34A853" />
                            <path
                                d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                fill="#FBBC05" />
                            <path
                                d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                fill="#EA4335" />
                        </svg>
                    </a>
                    <a href="#" class="social-icon line">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 2.98.97 4.29L1 23l6.71-1.97C9.02 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.19 0-2.34-.21-3.41-.6l-4.29 1.26 1.26-4.29c-.39-1.07-.6-2.22-.6-3.41 0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                            <text x="12" y="13.5" text-anchor="middle" font-family="Arial, sans-serif" font-size="4.5" font-weight="900" fill="currentColor">LINE</text>
                        </svg>
                    </a>
                    <a href="#" class="social-icon twitter">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
                                fill="currentColor" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .custom-footer {
        font-family: Arial, sans-serif;
        color: #333;
    }

    .newsletter-section {
        background-color: #EA7621;
        padding: 40px 0;
    }

    .newsletter-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1000px;
        margin: 0 auto;
        gap: 30px;
    }

    .newsletter-heading {
        color: white;
        font-size: 24px;
        font-weight: 600;
        margin: 0;
        text-align: left;
        line-height: 1.2;
        white-space: nowrap;
    }

    .newsletter-heading br {
        display: block;
    }

    .newsletter-form {
        display: flex;
        gap: 0;
        flex: 1;
        max-width: 500px;
        align-items: stretch;
    }

    .input-group {
        position: relative;
        flex: 1;
    }

    /* đảm bảo wrapper là relative */
    .input-group {
        position: relative;
        display: block;
        /* giữ cấu trúc */
    }

    /* icon luôn trên input, kích thước và căn giữa */
    .email-icon {
        position: absolute;
        left: 16px;
        /* khoảng cách từ trái (chỉnh nếu cần) */
        top: 50%;
        transform: translateY(-50%);
        color: #EA7621 !important;
        /* ép màu cam */
        z-index: 9999;
        /* cho chắc luôn nằm trên input */
        pointer-events: none;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* đảm bảo SVG nhỏ gọn, không có nền, dùng màu currentColor */
    .email-icon svg {
        width: 20px;
        height: 20px;
        display: block;
    }

    /* Ghi đè mọi fill/stroke cố định bên trong SVG để dùng currentColor.
   DÙNG CẨN THẬN với SVG đa-màu; ở trường hợp envelope chúng ta muốn stroke=cam */
    .email-icon svg * {
        stroke: currentColor !important;
        fill: none !important;
    }

    /* Đẩy text khỏi icon: padding-left lớn hơn left + width của icon */
    .newsletter-input {
        position: relative;
        z-index: 1;
        width: 100%;
        padding: 14px 20px 14px 50px !important;
        /* đảm bảo text không chồng lên icon */
        border: none;
        border-radius: 0 !important;
        font-size: 14px;
        background-color: #ffffff;
        outline: none;
        height: 48px;
        box-sizing: border-box;
        color: #333;
    }

    /* Placeholder màu nhạt */
    .newsletter-input::placeholder {
        color: #b5b5b5;
    }


    .newsletter-button {
        background-color: transparent;
        color: white;
        border: 2px solid white;
        padding: 0 25px;
        border-radius: 0;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        white-space: nowrap;
        height: 48px;
        box-sizing: border-box;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .newsletter-button:hover {
        background-color: white;
        color: #EA7621;
    }

    .company-section {
        padding: 30px 0;
    }

    .company-logo h2 {  
        color: black;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin: 0;
        padding-top: 50px;
    }

    .nav-social-section {
        background-color: #F2F2F2;
        padding: 30px 0;
    }

    .footer-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .footer-content > div:first-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        gap: 20px;
    }

    .footer-nav {
        flex: 1;
        text-align: left;
        padding: 20px 0;
    }

    .footer-nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 30px;
    }

    .footer-nav a {
        text-decoration: none;
        color: black;
        font-weight: bold;
        font-size: 16px;
        transition: color 0.3s;
    }

    .footer-nav a:hover {
        color: #FF6B35;
    }

    .social-icons {
        flex: 1;
        display: flex !important;
        justify-content: flex-end;
        gap: 15px;
        padding-bottom: 80px;
        min-height: 40px;
    }

    .social-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex !important;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: transform 0.3s;
        opacity: 1;
        visibility: visible;
    }

    .social-icon:hover {
        transform: scale(1.1);
    }

    .social-icon.facebook {
        background-color: #1877f2;
        color: white;
    }

    .social-icon.google {
        background-color: white;
        border: 1px solid #ddd;
    }

    .social-icon.line {
        background-color: #00C300;
        color: white;
    }

    .social-icon.twitter {
        background-color: #1DA1F2;
        color: white;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .widget {
        margin: 0 !important;
    }

    /* Remove white gap between main content and footer */
    .site-content {
        margin-bottom: 0 !important;
    }

    @media (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            text-align: center;
        }

        .footer-nav ul {
            flex-direction: column;
            gap: 15px;
        }

        .newsletter-content {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .newsletter-heading {
            text-align: center;
            white-space: normal;
        }

        .newsletter-form {
            max-width: 100%;
        }

        .newsletter-button {
            width: auto;
        }
    }
</style>

<?php
/**
 * After Footer
 * 
 * @hooked jobscout_page_end    - 20
 */
do_action('jobscout_after_footer');

wp_footer(); ?>

</body>

</html>