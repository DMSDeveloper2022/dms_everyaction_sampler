<?php

namespace   DMS_EA_Sampler\Includes\Classes;

require_once DMS_EA_PLUGIN_PATH . 'includes/api/everyaction/class-people.php';

require_once DMS_EA_PLUGIN_PATH . 'includes/classes/class-person.php';
require_once DMS_EA_PLUGIN_PATH . 'includes/classes/class-utilities.php';

use DMS_EA_Sampler\Includes\Classes\Person as Person;
use DMS_EA_Sampler\Includes\Classes\Utilities as Utilities;
use DMS_EA_Sampler\Includes\API\EveryAction\People as PeopleAPI;


class People
{
    // private static $instance = null;

    private $params = [];
    private $people = [];
    function __construct($params = [])
    {
        $this->params = $params;
    }


    private function set_from_ea()
    {

        $this->people = PeopleAPI::get_people($this->params, true);
    }
    static function add_shortcodes()
    {
        add_shortcode(DMS_EA_PREFIX . 'directory', [__CLASS__, 'display_directory']);
    }
    static function get_from_params($params)
    {
        $output = '';
        $p = new static($params);

        $p->set_from_ea();

        if ($p->people) {

            foreach ($p->people as $person) {

                $output .= Person::get_card_from_person($person);
            }
        }
        return $output;
    }
    static function get_from_stateAbbreviation($stateOrProvince)
    {
        $output = '';

        $p = new static(['stateOrProvince' => $stateOrProvince]);

        $p->set_from_ea();

        if ($p->people->items) {


            foreach ($p->people->items as $person) {
                $output .= Person::get_card_from_person($person);
            }
        }
        return $output;
    }
    static function display_directory()
    {
        $output = '';
        $output .= Utilities::get_state_select('stateOrProvince', 'TN');

        $output .= self::get_from_stateAbbreviation('TN');
        return $output;
    }
}
