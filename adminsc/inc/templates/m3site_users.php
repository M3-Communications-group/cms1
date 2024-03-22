<?php

$fields_to_select = " `id`, `name`, `email`, `active`, IF(`active` > 0, 0, 1) as new_status";

$fields_to_show = array(
    'ID' => '###id###',
    'e-mail' => '<a href="' . $myLocation . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###email###</a>',
    'Name' => '<a href="' . $myLocation . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###name###</a>',
    'Actions' => '
        <span style="font-size:18px;">&nbsp;&nbsp;[&nbsp;&nbsp;</span>
        <a href="javascript:change_status(\'' . $CURRENT_LOCATION . 'editID=###id###&action=active&active_new_status=###new_status###\')" title="Активирай/Деактивирай">
            <img src="images/visibility###active###.gif" alt="Visibility" width="14" height="14" border="0">
        </a>
		<span style="font-size:18px;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href = "javascript:del(\'' . $myLocation . '&editID=###id###&action=del\')" title="Изтриване на новина">
            <img src = "images/delete.gif" alt = "Delete" width = "16" height = "16" border = "0">
        </a>
        <span style="font-size:18px;">&nbsp;&nbsp;]&nbsp;&nbsp;</span>',
);

$fields_showorder = 'name` asc, `email';

$fields_to_manage = array(
    array(
        "name" => 'email',
        "title" => 'email (Username)',
        "type" => 'text',
        "default_value" => '',
        "required" => 1,
        "unique" => 1,
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
        "name" => 'active',
        "title" => 'Active',
        "type" => 'select',
        "select_list" => array("0" => "No", "1" => "Yes"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1)$',
    ),
);
