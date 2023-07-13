<?php

namespace PJ_EA_Membership;


/*
  Plugin Name: PJ EveryAction Membership
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

define('PJ_EA_PLUGIN_PATH', plugin_dir_path(__FILE__));

define('PJ_EA_PLUGIN_URL', plugin_dir_url(__FILE__));

define('PJ_EA_PLUGIN_FOLDER', dirname(__FILE__));

define('PJ_EA_PLUGIN_FILE', __FILE__);

define('PJ_EA_TEXT_DOMAIN', 'pj_ea_membership');

define('PJ_EA_VERSION', '1.0');

define('PJ_EA_PREFIX', 'pj_ea_');

include PJ_EA_PLUGIN_PATH . '/includes/init.php';


/*  REGISTER ACTIVATION HOOK */

register_activation_hook(__FILE__, __NAMESPACE__ . '\\activate_pj_ea_membership');

function activate_pj_ea_membership()
{
  \PJ_EA_Membership\Includes\Import\Reconciliation_Table::create_the_table();
  \PJ_EA_Membership\Includes\Import\Update_Contacts_Table::create_the_table();
}
/*  REGISTER DEACTIVATION HOOK */
register_deactivation_hook(__FILE__, __NAMESPACE__ . '\\deactivate_pj_ea_membership');
function deactivate_pj_ea_membership()
{
  // \PJ_EA_Membership\Includes\Import\Reconciliation_Table::delete_the_table();
  // \PJ_EA_Membership\Includes\Import\Update_Contacts_Table::delete_the_table();
}




add_action('wp_ajax_pj_ea_state_filter', __NAMESPACE__ . '\\process_EA_state_selection');

add_action('wp_ajax_nopriv_pj_ea_state_filter', __NAMESPACE__ . '\\process_EA_state_selection');

function process_EA_state_selection()
{

  \PJ_EA_Membership\Includes\Classes\People::process_EA_state_filter();
}
add_action('wp_ajax_pj_ea_code_filter', __NAMESPACE__ . '\\process_EA_code_selection');

add_action('wp_ajax_nopriv_pj_ea_code_filter', __NAMESPACE__ . '\\process_EA_code_selection');

function process_EA_code_selection()
{

  \PJ_EA_Membership\Includes\Classes\People::process_EA_code_filter();
}

/* END AJAX HOOKS */