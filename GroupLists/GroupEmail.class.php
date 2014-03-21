<?php

require('GroupList.class.php');

/**
 * undocumented class
 *
 * @package default
 * @author Michael Ventimiglia Jr.
 **/
class GroupEmail
{
    public  $config;
    public $recipients = array();

    public function __construct($config)
    {
        if (is_array($config)) {
            $this->config = array(
                'group'     =>  $config['group'],
                'queue'     =>  false
                );
        }
    }

    public function prepare()
    {
        $list           = new GroupList();
        $listid         = $list->getListIdByName($this->config['group']);
        $members        = $list->getListUsers($listid);
        while($roster = $members->fetch_object()) {
            array_push($this->recipients, $roster->email);
        }
        return;
    }


} // END class GroupEmail