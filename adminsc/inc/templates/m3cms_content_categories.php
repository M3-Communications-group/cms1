<?php

$fields_to_show = array(
    'ID' => '###id###',
    'Name' => '<a href="' . $myLocation . '&editID=###id###&action=edit">###name###</a>',
    'Action' => '
    <!--
        <a href="' . $CURRENT_LOCATION . '&table=###content_table###&editID=###id###&action=view">content</a> 
    -->
	<a href="' . $myLocation . '&editID=###id###&action=showorder&showordermove=-1"><img src="images/up.gif" alt="" width="16" height="16" border="0"></a>
        <a href="' . $myLocation . '&editID=###id###&action=showorder&showordermove=1"><img src="images/down.gif" alt="" width="16" height="16" border="0"></a>
        <a href="javascript:del(\'' . $myLocation . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
	<br>',
);

$fields_showorder = 'showorder';

$fields_to_manage = array(
    array(
        "name" => 'name',
        "title" => 'Name',
        "type" => 'text',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'pid',
        "title" => 'Parent',
        "type" => 'dbselect',
        "select_list" => "select id, name from admin_content_categories order by pid, showorder",
        "default_value" => '',
        "required" => 0,
        "check_type" => 'int_pos_null',
        "check_value" => '',
    ),
    array(
        "name" => 'showorder',
        "title" => '',
        "type" => 'auto',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => '',
        "check_value" => '',
    ),
    array(
        "name" => 'level',
        "title" => '',
        "type" => 'auto',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => '',
        "check_value" => '',
    ),
    array(
        "name" => 'has_children',
        "title" => '',
        "type" => 'auto',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => '',
        "check_value" => '',
    ),
    array(
        "name" => 'content_table',
        "title" => 'Content table',
        "type" => 'dbselect',
        "select_list" => "SHOW TABLES",
        "default_value" => '',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^([a-z0-9_]+)$',
    ),
);
