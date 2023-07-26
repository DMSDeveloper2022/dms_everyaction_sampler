<?php

namespace PJ_Membership_Directory\Includes\API\EveryAction;

require_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/api/everyaction/class-api-calls.php';

use PJ_Membership_Directory\Includes\API\EveryAction\API_Calls as API_Calls;


class People
{

    const ENDPOINT = 'people';
    private $vanId;
    private $params = [];


    function __construct($vanId = null, $params = array())
    {
        if ($vanId) {
            $this->vanId = $vanId;
        }
        if ($params) {
            $this->params = $params;
        }
    }

    private function get_person_MEM_DIR_by_van_id()
    {

        $person = API_Calls::get(self::ENDPOINT . '/' . $this->vanId, $this->params);

        return $person;
    }
    private function get_membership_ea()
    {

        return API_Calls::get(self::ENDPOINT . '/' . $this->vanId . '/membership');
    }
    private function get_people_ea()
    {

        $people = API_Calls::get(self::ENDPOINT, $this->params);

        return $people;
    }
    static function get_person($vanId, $params = [])
    {
        $p = new People($vanId, $params);


        return $p->get_person_MEM_DIR_by_van_id();
    }
    static function get_membership($vanId)
    {
        $p = new People($vanId);

        return $p->get_membership_ea();
    }
    static function get_people($params)
    {
        $p = new People(null, $params);

        return $p->get_people_ea();
    }
}
