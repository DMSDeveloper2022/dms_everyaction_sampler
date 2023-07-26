<?php

namespace   PJ_Membership_Directory\Includes\Import;

require_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/Import/class-sync-table.php';


class Reconciliation_Table extends Sync_Table
{

    const TABLE_NAME = 'ea_reconciliation_table';

    function __construct()
    {
        parent::__construct(static::TABLE_NAME);
    }
    static function init()
    {
        $reconciliation_table = new static();
        $reconciliation_table->create_table();
    }
    static function clear()
    {
        $reconciliation_table = new static();
        $reconciliation_table->clear_table();
    }
    static function delete_the_table()
    {
        $reconciliation_table = new static();
        $reconciliation_table->delete_table();
    }
    static function create_the_table()
    {
        $reconciliation_table = new static();
        $reconciliation_table->create_table();
    }
    private static function insert_van_id($van_id)
    {
        //inserts a row into the table with the van_id and a status of 'unreconciled'
        $reconciliation_table = new static();
        $reconciliation_table->add_van_id_to_table($van_id);
    }
    static function update_status_for_van_id($van_id, $status)
    {
        //updates the status for a row where van_id = $van_id
        $reconciliation_table = new static();
        $reconciliation_table->update_status($van_id, $status);
    }
    static function get_unreconciled()
    {
        //returns an array of van_ids where status = 'unreconciled'
        $reconciliation_table = new static();
        return $reconciliation_table->get_unreconciled_van_ids();
    }
    static function insert($data)
    {
        static::clear();
        foreach ($data as $row) {
            static::insert_van_id($row['vanId']);
        }
    }
}
namespace\Reconciliation_Table::init();
