<?php

namespace   PJ_EA_Membership\Includes\Classes;

require_once PJ_EA_PLUGIN_PATH . 'includes/api/everyaction/class-api-calls.php';

use PJ_EA_Membership\Includes\API\EveryAction\API_Calls as API_Calls;

class Source_Code
{

    const ENDPOINT = 'codes';
    const MEMBERSHIP_PARENT_CODE = '1255390';

    private $codeId;
    private $params = [];



    function __construct()
    {
        $this->params['parentCodeId'] = self::MEMBERSHIP_PARENT_CODE;
    }

    private function get_codes_from_ea()
    {

        $code = API_Calls::get(self::ENDPOINT . '/', $this->params);

        return $code;
    }
    static function get_codes_select()
    {
        $c = new Source_Code();

        $codes =  $c->get_codes_from_ea();

        $output = '';

        if ($codes->count > 0) {

            $output .= '<select name="' . PJ_EA_PREFIX . 'sourceCode_search" id="' . PJ_EA_PREFIX . 'sourceCode_search" class="form-control">';
            $output .= '<option value="">Select a Membership Type</option>';
            foreach ($codes->items as $code) {

                $output .= '<option value="' . $code->codeId . '">' . $code->name . '</option>';
            }
            $output .= '</select>';
        }

        return $output;
    }
}
