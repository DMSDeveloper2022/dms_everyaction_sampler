<?php

namespace PJ_Membership_Directory\Includes\Membership;

require_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/membership/class-member.php';

use PJ_MEM_DIR_Membership\Includes\Membership\Member as Member;

require_once PJ_MEM_DIR_PLUGIN_PATH . 'includes/api/everyaction/class-people.php';

use PJ_MEM_DIR_Membership\Includes\API\EveryAction\People as PeopleAPI;

class Member_EA extends Member
{

    /**MEMBERSHIP JSON SAMPLE From EA
     * {
    "levelId": 422,
    "levelName": "Associate",
    "status": "Active",
    "dateExpireMembership": "2024-04-01T00:00:00Z",
    "enrollmentType": "New",
    "changeType": "NoChange",
    "duesPaid": {
        "currencyType": null,
        "amount": 0.0
    },
    "duesEntityType": null,
    "duesAttributionType": null,
    "dateCardsSent": null,
    "numberOfCards": 0,
    "dateStartMembership": "2023-04-01T00:00:00Z",
    "firstMembershipSourceCode": null,
    "numberTimesRenewed": 0,
    "numberConsecutiveYears": 0,
    "dateLastRenewed": null,
    "totalDuesPaid": {
        "currencyType": null,
        "amount": 0.00
    }
} */
    private $membership;
    function __construct($van_id = null)
    {
        if ($van_id) {
            $this->van_id = $van_id;
            $this->set_from_van_id();
        }
    }


    private function set_from_van_id()
    {
        $params = [];

        $params['$expand'] = 'phones,emails,addresses,codes';

        $person = PeopleAPI::get_person($this->van_id, $params);

        $this->id = $this->user_in_wp();

        $this->first_name = $person->firstName;

        $this->last_name = $person->lastName;

        $this->middle_name = $person->middleName;

        $this->email = $person->emails[0]->email;

        $this->address = $person->addresses[0]->addressLine1;

        $this->address2 = $person->addresses[0]->addressLine2;

        $this->city = $person->addresses[0]->city;

        $this->state = $person->addresses[0]->stateOrProvince;

        $this->zip = $person->addresses[0]->zipOrPostalCode;

        $this->phone = $person->phones[0]->phone;

        $this->dp_id = $person->externalIds[0]->externalId;

        $this->codes = $person->codes;

        $this->set_membership();
    }
    private function set_membership()
    {

        $membership = PeopleAPI::get_membership($this->van_id);

        $this->membership_level_id = $membership->membershipLevelId;

        $this->membership_level_name = $membership->membershipLevelName;

        $this->membership_status = $membership->status;

        $this->membership_expire_date = $membership->expireDate;

        $this->membership_enrollment_type = $membership->enrollmentType;
    }

    private function user_in_wp()
    {

        $user_id = null;
        $args = array(
            'meta_query' => array(
                array(
                    'key' => 'van_id',
                    'value' => $this->van_id,
                    'compare' => '='
                )
            )
        );

        $member_arr = get_users($args);

        if ($member_arr) {  // any users found?

            return $member_arr[0]->ID;  // just get the first one

        }
        return 0;
    }
    private function create_or_update_member()
    {
        if ($this->id > 0) {
            $this->update_member();
        } else {
            $this->create_member();
        }
    }
    private function user_args()
    {
        $args =  array(
            'user_login' => $this->email,
            'user_pass' => \wp_generate_password(),
            'user_email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'display_name' => $this->first_name . ' ' . $this->last_name,
            'nickname' => $this->first_name . ' ' . $this->last_name
        );

        if ($this->id > 0) {
            $args['ID'] = $this->id;
        } else {
            $args['role'] = 'subscriber';
        }

        return $args;
    }
    private function create_member()
    {

        $user_id = wp_insert_user($this->user_args());

        if (\is_wp_error($user_id)) {
            $this->error = $user_id->get_error_message();
        } else {
            $this->id = $user_id;
            $this->update_member_meta();
        }
    }
    private function update_member()
    {

        $user_id = wp_update_user($this->user_args());

        if (is_wp_error($user_id)) {
            $this->error = $user_id->get_error_message();
        } else {

            $this->update_member_meta();
        }
    }
    private function update_member_meta()
    {
        update_user_meta($this->id, 'van_id', $this->van_id);
        update_user_meta($this->id, 'middle_name', $this->middle_name);
        update_user_meta($this->id, 'address', $this->address);
        update_user_meta($this->id, 'address2', $this->address2);
        update_user_meta($this->id, 'city', $this->city);
        update_user_meta($this->id, 'state', $this->state);
        update_user_meta($this->id, 'zip', $this->zip);
        update_user_meta($this->id, 'phone', $this->phone);
        update_user_meta($this->id, 'membership_level_id', $this->membership->levelId);
        update_user_meta($this->id, 'membership_level_name', $this->membership->levelName);
        update_user_meta($this->id, 'membership_status', $this->membership->status);
        update_user_meta($this->id, 'membership_expire_date', $this->membership->dateExpireMembership);
        update_user_meta($this->id, 'membership_enrollment_type', $this->membership->enrollmentType);
        update_user_meta($this->id, 'membership_date_last_renewed', $this->membership->dateLastRenewed);
    }




    static function set_membership_from_van_id($van_id)
    {
        $member = new Member_EA($van_id);
        $member->create_or_update_member();

        //TODO: add to membership groups based on EA membership
        return $member;
    }
}
