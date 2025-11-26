<?php

/**
 *
 * Creating a custom job search form for homepage
 * The [jobs] shortcode is will use search_location and search_keywords variables from the query string.
 *
 * @link https://wpjobmanager.com/document/tutorial-creating-custom-job-search-form/
 *
 * @package JobScout
 */
$find_a_job_link = get_option('job_manager_jobs_page_id', 0);
$post_slug       = get_post_field('post_name', $find_a_job_link);
$ed_job_category = get_option('job_manager_enable_categories');

if ($find_a_job_link) {
  $action_page = get_permalink($find_a_job_link); // Ví dụ: http://wordpress.local/jobs-3/
} else {
  $action_page = home_url('/');
}
?>

<?php

/**
 * ... (các khai báo biến PHP như trước) ...
 */
$find_a_job_link = get_option('job_manager_jobs_page_id', 0);
$ed_job_category = get_option('job_manager_enable_categories');
?>

<div class="jobscout-search-wrapper">
  <div class="job_listings">

    <form class="jobscout_job_filters" method="GET" action="<?php echo esc_url(home_url('/')); ?>">
      <input type="hidden" name="page_id" value="<?php echo absint($find_a_job_link); ?>" />

      <div class="search_jobs">

        <div class="search_keywords">
          <label for="search_keywords"><?php esc_html_e('Keywords', 'jobscout'); ?></label>
          <input type="text" id="search_keywords" name="search_keywords" placeholder="<?php esc_attr_e('Keywords', 'jobscout'); ?>">
        </div>

        <div class="search_location">
          <?php
          // Lấy dữ liệu từ CSDL
          global $wpdb;
          $table = $wpdb->postmeta;
          $meta_key_like = '%location%';

          $sql = $wpdb->prepare("
            SELECT DISTINCT SUBSTRING_INDEX(meta_value, ',', -1) as location 
            FROM {$table} 
            WHERE meta_key LIKE %s
            ORDER BY location
          ", $meta_key_like);

          $data = $wpdb->get_results($sql);
          ?>
          <label for="search_location"><?php esc_html_e('Location', 'jobscout'); ?></label>
          <select id="search_location" name="search_location" class="location-dropdown">
            <option value=""><?php esc_html_e('Khu vực', 'jobscout'); ?></option>
            <?php
            if ($data) {
              foreach ($data as $value) :
                $trimmed_location = trim($value->location);
                if (!empty($trimmed_location)) {
            ?>
                  <option value="<?php echo esc_attr($trimmed_location); ?>"><?php echo esc_html($trimmed_location); ?></option>
            <?php
                }
              endforeach;
            }
            ?>
          </select>
        </div>

        <?php if ($ed_job_category) { ?>
          <div class="search_categories custom_search_categories">
            <label for="search_category"><?php esc_html_e('Job Category', 'jobscout'); ?></label>
            <select id="search_category" class="robo-search-category" name="search_category">
              <option value=""><?php _e('Select Job Category', 'jobscout'); ?></option>
              <?php foreach (get_job_listing_categories() as $jobcat) : ?>
                <option value="<?php echo esc_attr($jobcat->term_id); ?>"><?php echo esc_html($jobcat->name); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        <?php } ?>

        <div class="search_submit">
          <input type="submit" value="Search Job" />
        </div>
      </div>
    </form>

  </div>
</div>
<style>
  /* 1. Thiết lập Lớp Bao bọc (Search Wrapper) */
  .jobscout-search-wrapper {
    background-color: rgba(0, 0, 0, 0.3);
    padding: 3px 20px;

    /* SỬA CHIỀU RỘNG VÀ CĂN LỀ */
    width: 1140px !important;

    /* Thay đổi ở đây: Bỏ 'auto' để không căn giữa nữa */
    /* Cú pháp: margin: [trên] [phải] [dưới] [trái] */
    margin: 20px auto 20px -15% !important;
    /* Số 0 ở cuối nghĩa là dính sát lề trái */

    /* Nếu bạn muốn cách lề trái một khoảng (ví dụ 50px), hãy sửa thành:
       margin: 20px auto 20px 50px !important; 
    */

    border-radius: 0 !important;
  }

  /* 2. Khối Form Chính */
  .jobscout_job_filters .search_jobs {
    display: flex;
    align-items: stretch;
    gap: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    background-color: transparent !important;
    height: 55px;

    /* SỬA: Đảm bảo khối con cũng dính theo khối cha */
    width: 1100px !important;
    margin: 0 !important;
    /* Xóa auto để nó nằm gọn bên trái trong wrapper */
  }

  .jobscout_job_filters {
    padding: 0 !important;
    /* SỬA: Xóa auto ở đây luôn */
    margin: 20px 0 !important;
  }

  /* --- CÁC PHẦN DƯỚI GIỮ NGUYÊN --- */

  /* Keywords */
  .jobscout_job_filters .search_keywords {
    flex: 5 1 0% !important;
    position: relative;
    background-color: white;
    margin-right: 10px !important;
    border-radius: 0 !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-right: none !important;
    border: none !important;
    background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="%23ff8c00" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    background-repeat: no-repeat;
    background-size: 20px;
    background-position: 15px center;
  }

  .jobscout_job_filters .search_keywords input[type="text"] {
    height: 100%;
    width: 100%;
    padding: 0 15px 0 45px !important;
    background: transparent !important;
    border: none !important;
    font-size: 16px;
    color: #333;
  }

  /* Location */
  .jobscout_job_filters .search_location {
    flex: 3 1 0% !important;
    position: relative;
    background-color: white;
    margin-right: 10px !important;
    border-radius: 0 !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-right: none !important;
    border: none !important;
    background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="%23ff8c00" d="M172.268 501.67C26.463 369.103 0 286.995 0 192C0 86 85.95 0 192 0s192 86 192 192c0 94.995-26.463 177.103-172.268 309.67l-3.344 3.149a3.872 3.872 0 0 1-5.751 0zM192 256c35.346 0 64-28.654 64-64 0-35.346-28.654-64-64-64s-64 28.654-64 64c0 35.346 28.654 64 64 64z"/></svg>');
    background-repeat: no-repeat;
    background-size: 20px;
    background-position: 15px center;
  }

  .jobscout_job_filters .search_location select {
    width: 100%;
    height: 100%;
    background: transparent !important;
    padding: 0 40px 0 45px !important;
    -webkit-appearance: menulist-button !important;
    appearance: menulist-button !important;
    cursor: pointer;
    font-size: 16px;
    border: none !important;
  }

  /* Submit: 20% không gian */
  .jobscout_job_filters .search_submit {
    flex: 2 0 0% !important;
    width: auto !important;
    text-align: center;
    background-color: #ff8c00;
    border-radius: 0 !important;
  }

  .jobscout_job_filters .search_submit input[type="submit"] {
    height: 100% !important;
    width: 100% !important;
    background-color: transparent !important;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 16px;

    /* --- CĂN GIỮA CHỮ --- */
    text-align: center !important;
    padding: 0 !important;
    /* Xóa padding 2 bên để text tự động vào giữa */
    text-indent: 0 !important;
    /* QUAN TRỌNG: Reset lại thụt đầu dòng từ code icon cũ */

    /* Xóa các thuộc tính thừa */
    background-image: none !important;
    border-radius: 0 !important;
    border: none !important;
    box-shadow: none !important;
  
  }
</style>