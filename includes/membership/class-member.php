<?php

namespace PJ_EA_Membership\Includes\Membership;


class Member
{
    const PJ_FAKE_EMAIL_DOMAIN = '@no-valid-email.com';

    protected $id = 0;
    protected $email = '';
    protected $username = '';


    protected $first_name = '';
    protected $last_name  = '';
    protected $middle_name = '';
    protected $firm;
    protected $user_info;
    protected $website = '';


    protected $address = '';
    protected $address2 = '';
    protected $city;
    protected $state = '';
    protected $country = '';
    protected $zip = '';
    protected $phone = '';
    protected $fax = '';
    protected $board_member = false;
    protected $lifetime_member = false;
    protected $practice_areas = [];
    protected $leadership = false;
    protected $last_ea_update = '';


    protected $dp_id;
    protected $van_id;
    protected $codes = [];

    protected $membership_level_id;
    protected $membership_level_name;
    protected $membership_status;
    protected $membership_expire_date;
    protected $membership_enrollment_type;
    protected $membership_date_last_renewed;



    public $error = '';

    function __construct($id = 0)
    {
        $this->id = $id;

        if ($this->id > 0) {
            $this->set_values();
        }
    }

    private function set_values()
    {
        $usr = get_user_by('id', $this->id);

        $this->email = $usr->user_email;
        $this->username = $usr->user_login;
        $this->first_name = \get_user_meta($this->id, 'first_name', true);

        $this->dp_id = \get_user_meta($this->id, 'profile_dp_id', true);


        $this->user_info = \get_userdata($this->id);

        if ($this->user_info->user_email && !strpos($this->email, static::PJ_FAKE_EMAIL_DOMAIN)) {
            $this->email = $this->user_info->user_email;
        }
        $this->first_name = \get_user_meta($this->id, 'first_name', true);
        $this->last_name = \get_user_meta($this->id, 'last_name', true);
        $this->middle_name = \get_user_meta($this->id, 'profile_middle', true);
        $this->firm = \get_user_meta($this->id, 'profile_firm', true);

        $this->address = \get_user_meta($this->id, 'profile_address1', true);
        $this->address2 = \get_user_meta($this->id, 'profile_address2', true);
        $this->city = \get_user_meta($this->id, 'profile_city', true);
        $this->state = \get_user_meta($this->id, 'profile_state', true);
        $this->country = \get_user_meta($this->id, 'profile_country', true);
        $this->zip = \get_user_meta($this->id, 'profile_zip', true);
        $this->phone = \get_user_meta($this->id, 'profile_phone', true);
        $this->fax = \get_user_meta($this->id, 'profile_fax', true);
    }
    private function set_membership()
    {

        $this->membership_level_id = \get_user_meta($this->id, 'membership_level_id', true);
        $this->membership_level_name = \get_user_meta($this->id, 'membership_level_name', true);
        $this->membership_status = \get_user_meta($this->id, 'membership_status', true);
        $this->membership_expire_date = \get_user_meta($this->id, 'membership_expire_date', true);
        $this->membership_enrollment_type = \get_user_meta($this->id, 'membership_enrollment_type', true);
        $this->membership_date_last_renewed = \get_user_meta($this->id, 'membership_date_last_renewed', true);
    }
    protected function generate_username($first_name, $last_name)
    {
        $un = !empty($this->first_name) ? strtolower(substr($first_name, 0, 1)) : '';
        $un .= strtolower($this->clean($last_name));
        $count = 1;
        while (username_exists($un)) {
            $un .= $count;
            $count++;
        }
        return $un;
    }

    protected function clean($string)
    {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
    }
}
