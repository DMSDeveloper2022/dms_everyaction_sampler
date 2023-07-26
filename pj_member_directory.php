<?php

namespace PJ_Membership_Directory;


/*
  Plugin Name: PJ Membership Directory
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

define('PJ_MEM_DIR_PLUGIN_PATH', plugin_dir_path(__FILE__));

define('PJ_MEM_DIR_PLUGIN_URL', plugin_dir_url(__FILE__));

define('PJ_MEM_DIR_PLUGIN_FOLDER', dirname(__FILE__));

define('PJ_MEM_DIR_PLUGIN_FILE', __FILE__);

define('PJ_MEM_DIR_TEXT_DOMAIN', 'PJ_Membership_Directory');

define('PJ_MEM_DIR_VERSION', '1.0');

define('PJ_MEM_DIR_PREFIX', 'pj_MEM_DIR_');

include PJ_MEM_DIR_PLUGIN_PATH . '/includes/init.php';

include_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/import/class-reconciliation-table.php';
include_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/import/class-updates-table.php';

/*  REGISTER ACTIVATION HOOK */

register_activation_hook(__FILE__, __NAMESPACE__ . '\\activate_PJ_Membership_Directory');

function activate_PJ_Membership_Directory()
{
  \PJ_Membership_Directory\Includes\Import\Reconciliation_Table::create_the_table();
  \PJ_Membership_Directory\Includes\Import\Update_Contacts_Table::create_the_table();
}
/*  REGISTER DEACTIVATION HOOK */
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\\deactivate_PJ_Membership_Directory');
function deactivate_PJ_Membership_Directory()
{
  // \PJ_Membership_Directory\Includes\Import\Reconciliation_Table::delete_the_table();
  // \PJ_Membership_Directory\Includes\Import\Update_Contacts_Table::delete_the_table();
}




add_action('wp_ajax_pj_MEM_DIR_state_filter', __NAMESPACE__ . '\\process_MEM_DIR_state_selection');

add_action('wp_ajax_nopriv_pj_MEM_DIR_state_filter', __NAMESPACE__ . '\\process_MEM_DIR_state_selection');

function process_MEM_DIR_state_selection()
{

  \PJ_Membership_Directory\Includes\Classes\People::process_MEM_DIR_state_filter();
}
add_action('wp_ajax_pj_MEM_DIR_code_filter', __NAMESPACE__ . '\\process_MEM_DIR_code_selection');

add_action('wp_ajax_nopriv_pj_MEM_DIR_code_filter', __NAMESPACE__ . '\\process_MEM_DIR_code_selection');

function process_MEM_DIR_code_selection()
{

  \PJ_Membership_Directory\Includes\Classes\People::process_MEM_DIR_code_filter();
}

/* END AJAX HOOKS */