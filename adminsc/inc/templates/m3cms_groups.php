<?php

$fields_to_show = array(
    'ID' => '###id###',
    'Name' => '<a href="' . $myLocation . '&editID=###id###&action=edit">'
    . '<img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###name###</a>',
);

$custom_where = 'id>0';
$fields_showorder = 'id';

$fields_to_manage = array(
    array(
        "name" => 'name',
        "title" => 'Name',
        "type" => 'text',
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
);
