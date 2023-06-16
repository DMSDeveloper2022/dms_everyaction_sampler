<?php

namespace   PJ_EA_Membership\Includes\Classes;

require_once PJ_EA_PLUGIN_PATH . 'includes/api/everyaction/class-people.php';

require_once PJ_EA_PLUGIN_PATH . 'includes/classes/class-person.php';
require_once PJ_EA_PLUGIN_PATH . 'includes/classes/class-source-code.php';
require_once PJ_EA_PLUGIN_PATH . 'includes/classes/class-utilities.php';

use PJ_EA_Membership\Includes\Classes\Person as Person;
use PJ_EA_Membership\Includes\Classes\Utilities as Utilities;
use PJ_EA_Membership\Includes\API\EveryAction\People as PeopleAPI;
use PJ_EA_Membership\Includes\Classes\Source_Code as Source_Code;


class People
{
    // private static $instance = null;
    const PAGINATION_COUNT = 50;
    private $params = [];
    private $people = null;


    function __construct($params = [])
    {
        $this->params = $params;
    }


    private function set_from_ea()
    {

        $this->people = PeopleAPI::get_people($this->params);
    }
    private function get_directory_listing()
    {

        $output = '';

        $this->params['$top'] = static::PAGINATION_COUNT;

        $this->set_from_ea();

        if ($this->people->count > 0) {

            foreach ($this->people->items as $person) {

                $output .= Person::get_card_from_van_id($person->vanId);
            }
        }
        return $output;
    }


    static function add_shortcodes()
    {
        add_shortcode(PJ_EA_PREFIX . 'directory', [__CLASS__, 'display_directory_shortcode']);
    }
    static function get_from_params($params)
    {
        $output = '';
        $p = new static($params);

        $p->set_from_ea();

        if ($p->people) {

            foreach ($p->people as $person) {

                $output .= Person::get_card_from_van_id($person->vanId);
            }
        }
        return $output;
    }
    private static function get_from_stateAbbreviation($stateOrProvince)
    {
        $output = '';
        $params = array();

        $params['stateOrProvince'] = $stateOrProvince;

        $params['$orderby'] = 'Name asc';


        $p = new static($params);

        return $p->get_directory_listing();
    }
    private static function get_from_code($code)
    {
        $output = '';
        $params = array();

        $params['codes'] = $code;

        $params['$orderby'] = 'Name asc';


        $p = new static($params);

        return $p->get_directory_listing();
    }
    private static function get_from_source_code($sourceCode)
    {

        $params = array();

        $params['codes'] = $sourceCode;

        $params['$orderby'] = 'Name asc';


        $params = array();

        $p = new static($params);

        return $p->get_directory_listing();
    }
    private static function set_statesOrProvinces()
    {
        $transient_key = PJ_EA_PREFIX . 'states_select';

        $data = maybe_unserialize(get_transient($transient_key));

        if (empty($data)) {

            $data = static::load_states_from_ea();

            set_transient($transient_key, maybe_serialize($data), 60 * 60 * 3);
        }


        return $data;
    }
    private static function load_states_from_ea()
    {

        $statesOrProvinces = Utilities::get_states();

        $statesOrProvincesWithRecords = [];

        foreach ($statesOrProvinces as $key => $value) {

            $params = array();

            $params['stateOrProvince'] = $key;

            $params['$top'] = '1';

            $p = new static($params);

            $p->set_from_ea();

            if (0 < $p->people->count) {

                $statesOrProvincesWithRecords[] =  $key;
            }
        }

        return $statesOrProvincesWithRecords;
    }
    private static function display_stateOrProvince_select($selected)
    {
        $output = '';

        $statesOrProvinces = static::set_statesOrProvinces();

        if (!empty($statesOrProvinces)) {

            $output .= '<select id="' . PJ_EA_PREFIX . 'state_select" name="' . PJ_EA_PREFIX . 'state_select">';

            $output .= '<option value="">Select a State or Province</option>';

            foreach ($statesOrProvinces as $key) {

                $output .= '<option value="' . $key . '"';

                if ($selected === $key) {

                    $output .= ' selected="selected"';
                }

                $output .= '>' . Utilities::get_state_name($key) . '</option>';
            }

            $output .= '</select>';
        }
        return $output;
    }

    static function display_directory_shortcode($atts)
    {
        $output = '';

        extract(
            shortcode_atts(
                array(
                    'stateOrProvince' => 'NY',
                ),
                $atts
            )
        );
        $output .= '<div class="' . PJ_EA_PREFIX . 'directory_wrapper">';
        $output .= '<div class="' . PJ_EA_PREFIX . 'membership_filters">';

        $output .= static::display_stateOrProvince_select($stateOrProvince);
        // $output .= Source_Code::get_codes_select();

        $output .= '</div>';

        $output .= '<div id="' . PJ_EA_PREFIX . 'membership_container">';

        $output .= static::display_directory($stateOrProvince);

        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    private static function display_directory($stateOrProvince = 'NY')
    {
        return static::get_from_stateAbbreviation($stateOrProvince);
    }
    private static function display_directory_from_code($stateOrProvince = 'NY')
    {
        return static::get_from_stateAbbreviation($stateOrProvince);
    }
    static function process_EA_state_filter()
    {

        if (isset($_POST['ajax_request']) && $_POST['ajax_request'] === 'true' && isset($_POST['ajax_nonce']) && wp_verify_nonce($_POST['ajax_nonce'], 'pj_ea_ajax_nonce')) {

            $stateOrProvince = Utilities::filter_post_input('stateOrProvince');

            echo static::display_directory($stateOrProvince);
        }

        wp_die();
    }
    static function process_EA_code_filter()
    {

        if (isset($_POST['ajax_request']) && $_POST['ajax_request'] === 'true' && isset($_POST['ajax_nonce']) && wp_verify_nonce($_POST['ajax_nonce'], 'pj_ea_ajax_nonce')) {

            $code = Utilities::filter_post_input('code');

            echo static::display_directory_from_code($code);
        }

        wp_die();
    }
}
