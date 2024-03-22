<?php

if($id){
    $pid_select_query = "select id, name, level, has_children from m3site_navigation where pid = '0' AND id != '" . $id . "' order by showorder";
}else{
    $pid_select_query = "select id, name, level, has_children from m3site_navigation where pid = '0' order by showorder";
}

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
        "type" => 'dbselect_tree',
        "select_list" => $pid_select_query,
        "default_value" => '0',
        "required" => 0,
        "check_type" => 'int_pos_null',
        "check_value" => '',
    ),
    array(
        "name" => 'url',
        "title" => 'URL',
        "type" => 'text',
        "select_list" => "",
        "default_value" => '',
        "required" => 0,
        "check_type" => 'text_nohtml',
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
        "name" => 'show_inmenu',
        "title" => 'Show in menu',
        "type" => 'select',
        "select_list" => array("0" => "No", "1" => "Yes"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1)$',
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

$fields_to_select = "*, if(active = 0, 1, 0) as new_status  ";

$fields_to_show = array(
    'ID' => '###id###',
    'Name' => '<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0"> ###name###</a>',
    'URL' => '###url###',
    'Active' => '<a href="javascript:change_status(\'' . (empty($CURRENT_LOCATION) ? '' : $CURRENT_LOCATION) . '&editID=###id###&action=active&active_new_status=###new_status###\')"><img src="images/visibility###active###.gif" alt="" width="14" height="14" border="0"></a>',
    'Action' => '
			<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=showorder&showordermove=-1"><img src="images/up.gif" alt="" width="16" height="16" border="0"></a>
			<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=showorder&showordermove=1"><img src="images/down.gif" alt="" width="16" height="16" border="0"></a>
			<a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
);
$fields_showorder = 'showorder';
