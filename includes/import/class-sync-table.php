<?php

namespace   PJ_Membership_Directory\Includes\Import;

class Sync_Table
{

    private $table_name = '';

    function __construct($table_name)
    {
        global $wpdb;

        $this->table_name = $wpdb->prefix . $table_name;
    }

    protected function create_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $this->table_name (
  van_id int NOT NULL ,
  status tinytext NOT NULL,
  PRIMARY KEY  (van_id)
) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        maybe_create_table($this->table_name, $sql);
    }
    protected function delete_table()
    {
        global $wpdb;

        $wpdb->query("DROP TABLE IF EXISTS $this->table_name");
    }
    protected function clear_table()
    {
        //Delete all rows from your table
        global $wpdb;
        $wpdb->query("TRUNCATE TABLE $this->table_name");
    }
    protected function add_van_id_to_table($van_id)
    {
        //inserts a row into the table with the van_id and a status of 'unreconciled'
        global $wpdb;
        $wpdb->insert(
            $this->table_name,
            array(
                'van_id' => $van_id,
                'status' => 'unreconciled'
            )
        );
    }
    protected function update_status($van_id, $status)
    {
        //updates the status for a row where van_id = $van_id
        global $wpdb;
        $wpdb->update(
            $this->table_name,
            array(
                'status' => $status
            ),
            array(
                'van_id' => $van_id
            )
        );
    }
    protected function get_unreconciled_van_ids()
    {
        //returns an array of van_ids where status = 'unreconciled'
        global $wpdb;
        $van_ids = $wpdb->get_results("SELECT Top 25 van_id FROM $this->table_name WHERE status = 'unreconciled'");
        return $van_ids;
    }
}
