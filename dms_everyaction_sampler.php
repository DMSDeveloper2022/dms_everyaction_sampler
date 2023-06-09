<?php

namespace DMS_EA_Sampler;


/*
  Plugin Name: DMS EveryAction Sampler
  Plugin URI:
  Description: This is an experimental plugin to test the EveryAction API
  Version: 1.0
  Author URI: https://dukemediaservices.com
 */

/* * **************************************************************************
 * Licensing info here
 * ************************************************************************** */

if (!defined('ABSPATH')) {
  exit;
}

define('DMS_EA_PLUGIN_PATH', plugin_dir_path(__FILE__));

define('DMS_EA_PLUGIN_URL', plugin_dir_url(__FILE__));

define('DMS_EA_PLUGIN_FOLDER', dirname(__FILE__));

define('DMS_EA_PLUGIN_FILE', __FILE__);

define('DMS_EA_TEXT_DOMAIN', 'dmseasampler');

define('DMS_EA_VERSION', '1.0');

define('DMS_EA_PREFIX', 'pj_ea_');

include DMS_EA_PLUGIN_PATH . '/includes/init.php';

/*  AJAX HOOKS */

// add_action('wp_ajax_dms_ea_webhook', __NAMESPACE__ . '\\process_EA_webhook');

// add_action('wp_ajax_nopriv_dms_ea_webhook', __NAMESPACE__ . '\\process_EA_webhook');



/* END AJAX HOOKS */