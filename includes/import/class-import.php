<?php

namespace   PJ_EA_Membership\Includes\Import;

require_once PJ_EA_PLUGIN_PATH . 'includes/import/class-reconciliation-table.php';
require_once PJ_EA_PLUGIN_PATH . 'includes/import/class-updates-table.php';

use PJ_EA_Membership\Includes\Import\Reconciliation_Table as Reconciliation_Table;
use PJ_EA_Membership\Includes\Import\Update_Contacts_Table as Update_Contacts_Table;

class Import
{
    private $which;
    function __construct($which = 'members')
    {
        $this->which = $which;

        switch ($which) {
            case 'members':
                $this->import_members();
                break;
            case 'updates':
                $this->import_updates();
                break;

            default:
                # code...
                break;
        }
    }


    private function import_members()
    {

        $reconciliation_table = new Reconciliation_Table();
        $reconciliation_table->clear();
    }
    private function import_updates()
    {

        $update_contacts_table = new Update_Contacts_Table();

        $update_contacts_table->clear();
    }


    static function run_import($which = 'members')
    {
        $import = new Import($which);
    }
}
