<?php

/**
 * @package     RegGroupFilter.Plugin
 *
 * @copyright   Copyright (C) 2013 Ray Lawlor. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('');

class plgUserRegGroupFilter extends JPlugin {

    /**
     * Constructor - note in Joomla 2.5 PHP4.x is no longer supported so we can use this.
     *
     * @access      protected
     * @param       object  $subject The object to observe
     * @param       array   $config  An array that holds the plugin configuration
     */
    public function __construct(& $subject, $config) {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    /**
     * Plugin method with the same name as the event will be called automatically.
     */
    public function onUserAfterSave($user, $isnew, $success, $msg) {

        //On new users only - this allows the admin to reset a users group after reg if needed.
        if ($isnew) {

            //set variables
            
            //get the user from the function argument
            $email = $user['email'];
            $email = strstr($email, '@');

            //get entered email addresses from Params
            $email1 = $this->params->get('email_1');
            $email2 = $this->params->get('email_2');
            $email3 = $this->params->get('email_3');
            $email4 = $this->params->get('email_4');
            $email5 = $this->params->get('email_5');
            $email6 = $this->params->get('email_6');
            $email7 = $this->params->get('email_7');
            $email8 = $this->params->get('email_8');
            $email9 = $this->params->get('email_9');
            $email10 = $this->params->get('email_10');


            //get entered groups from Params
            $group1 = $this->params->get('group_1');
            $group2 = $this->params->get('group_2');
            $group3 = $this->params->get('group_3');
            $group4 = $this->params->get('group_4');
            $group5 = $this->params->get('group_5');
            $group6 = $this->params->get('group_6');
            $group7 = $this->params->get('group_7');
            $group8 = $this->params->get('group_8');
            $group9 = $this->params->get('group_9');
            $group10 = $this->params->get('group_10');

            //Make ass-array, that ties emails with groups
            $list = array(
                "$email1" => "$group1",
                "$email2" => "$group2",
                "$email3" => "$group3",
                "$email4" => "$group4",
                "$email5" => "$group5",
                "$email6" => "$group6",
                "$email7" => "$group7",
                "$email8" => "$group8",
                "$email9" => "$group9",
                "$email10" => "$group10",
            );

            //get id from the function argument
            $user_id = $user['id'];
            //get the right group from the ass-array based on the email entered
            $group = $list["$email"];

            //connect to DB object
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            //set the fields for the UPDATE query
            $fields = array(
                "user_id = $user_id",
                "group_id = $group"
            );
            //set the overall query
            $query->update($db->quoteName('#__user_usergroup_map'))->set($fields)->where("user_id=$user_id");
            $db->setQuery($query);

            //execute the query
            $db->execute();
        }
    }

}
?>

