<?php

$fields_to_show = array(
    'ID' => '###id###',
    'Name' => '<a href="' . $myLocation . '&table=m3cms_sitemap&editID=###id###&action=edit">###name###</a>',
    'Action' => '
        <a href="' . $myLocation . '&table=m3cms_sitemap&editID=###id###&action=showorder&showordermove=-1"><img src="images/up.gif" alt="" width="16" height="16" border="0"></a>
        <a href="' . $myLocation . '&table=m3cms_sitemap&editID=###id###&action=showorder&showordermove=1"><img src="images/down.gif" alt="" width="16" height="16" border="0"></a>
        <a href="javascript:del(\'' . $myLocation . '&table=m3cms_sitemap&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>',
);

$fields_showorder = 'showorder';

$fields_to_manage = array(
    array(
        "name" => 'name',
        "title" => 'Name',
        "type" => 'text',
        "select_list" => "",
        "default_value" => '0',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'pid',
        "title" => 'Parent',
        "type" => 'dbselect_tree',
        "select_list" => "select id, name, level, has_children from m3cms_sitemap where pid = '0' order by showorder",
        "default_value" => '0',
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
        "name" => 'table_categories',
        "title" => 'Table Categories',
        "type" => 'dbselect',
        "select_list" => "SHOW TABLES",
        "default_value" => '',
        "required" => 0,
        "check_type" => '',
        "check_value" => '^([a-z0-9_]*)$',
    ),
    array(
        "name" => 'content_table',
        "title" => 'Content table',
        "type" => 'dbselect',
        "select_list" => "SHOW TABLES",
        "default_value" => '',
        "required" => 0,
        "check_type" => '',
        "check_value" => '^([a-z0-9_]*)$',
    ),
    array(
        "name" => 'show_inmenu',
        "title" => 'Show in menu',
        "type" => 'select',
        "select_list" => array("0" => "No", "1" => "Yes"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1)$',
    ),
);
