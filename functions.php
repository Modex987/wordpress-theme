<?php


require_once(get_template_directory() . '/inc/config.php');

require_once(AP . 'inc/enqueue.php');

require_once(AP . 'inc/admin-functions.php');

require_once(AP . 'inc/theme-support.php');

require_once(AP . 'inc/custom-post-type.php');



// register_activation_hook( __FILE__, function () {
//     flush_rewrite_rules();
// });