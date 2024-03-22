<?php

$fields_to_show_join = "left join m3cms_groups on m3cms_users.group_id = m3cms_groups.id ";
$fields_to_select = ' m3cms_users.*, m3cms_groups.name as group_name, if(m3cms_users.expires > now(), 1, 0) as active';

$fields_to_show = array(
    'ID' => '###id###',
    'Username' => '<a href="' . $myLocation . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###username###</a>',
    'Name' => '<a href="' . $myLocation . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###name###</a>',
    'telephone' => '###contact_phone###',
    'E-mail' => '###contact_email###',
    'Group' => '###group_name###',
    'Active' => '<img src="images/visibility###active###.gif" alt="" width="14" height="14" border="0">',
);
$custom_where = 'group_id>0';
$fields_showorder = 'active` desc, `id';

$fields_to_manage = array(
    array(
        "name" => 'username',
        "title" => 'Username',
        "type" => 'text',
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'password',
        "title" => 'Password',
        "type" => 'password',
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'name',
        "title" => 'Name',
        "type" => 'text',
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'group_id',
        "title" => 'Group',
        "type" => 'dbselect',
        "select_list" => "select id, name from m3cms_groups",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'int_pos_notnull',
        "check_value" => '',
    ),
    array(
        "name" => 'expires',
        "title" => 'Expires',
        "type" => 'text',
        "select_list" => "",
        "default_value" => date("Y-m-d H:i:s", time() + 63072000),
        "required" => 1,
        "check_type" => 'date',
        "check_value" => '',
    ),
    array(
        "name" => 'contact_email',
        "title" => 'E-mail',
        "type" => 'text',
        "default_value" => '',
        "required" => 0,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'contact_phone',
        "title" => 'telephone',
        "type" => 'text',
        "default_value" => '',
        "required" => 0,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
);
