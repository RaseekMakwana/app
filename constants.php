<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

if($_SERVER['SERVER_NAME'] == 'localhost') {
    define('SITE_ABS_PATH', $protocol . $_SERVER['SERVER_NAME'] . '/app/'); 
} else if($_SERVER['SERVER_NAME'] == 'app.gujaratparixa.com') {
    define('SITE_ABS_PATH', $protocol . $_SERVER['SERVER_NAME'] . '/'); 
} else {
    define('SITE_ABS_PATH', $protocol . $_SERVER['SERVER_NAME'] . '/');
}

define('SITE_ABS_UPLOAD_PATH', SITE_ABS_PATH . 'uploads/');
define('SITE_REL_PATH', dirname(__FILE__) . '/');
define('UPLOAD_DIR_PATH', SITE_REL_PATH . 'uploads/');

define('THUMB_IMAGE_WIDTH', '600');
define('THUMB_IMAGE_HEIGHT', '315');
define('THUMB_THUMB_IMAGE_NAME_APPEND', '215x215_');



//User profile pictures path
define('TEMP_PICTURE_ABS_SAVE', UPLOAD_DIR_PATH . 'share_image/');
define('TEMP_PICTURE_URL', SITE_ABS_PATH . 'uploads/share_image/');

//Posts pictures path
define('POSTS_PICTURE_ABS_ORIGINAL', UPLOAD_DIR_PATH . 'posts/original/');
define('POSTS_PICTURE_URL_ORIGINAL', SITE_ABS_PATH . 'uploads/posts/original/');


define('POSTS_PICTURE_ABS_THUMBNAIL', UPLOAD_DIR_PATH . 'posts/thumbnails/');
define('POSTS_PICTURE_URL_THUMBNAIL', SITE_ABS_PATH . 'uploads/posts/thumbnails/');


//page limit
define('ADMIN_PAGE_LIMIT', 10);

// ENCRYPTION_KEY
define("ENCRYPTION_KEY", "silicon!@^#%it%&*hub");