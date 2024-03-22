<?php

$fields_to_manage = array(
    array(
        "name" => 'title',
        "title" => 'Title',
        "type" => 'text',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'date',
        "title" => 'Date',
        "type" => 'text',
        "select_list" => "",
        "default_value" => date("Y-m-d"),
        "required" => 0,
        "check_type" => 'date',
        "check_value" => '',
    ),
    array(
        "name" => 'filepath',
        "title" => 'File (pdf|ppt|pptx|doc|docx|xls|xlsx|jpg)',
        "type" => 'file',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'pdf|ppt|pptx|doc|docx|xls|xlsx|jpg',
        "max_size" => '', //KB
        "upload_dir" => 'uploads/cabinet_downloads', //KB
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
);

$fields_to_select = "*, if(active = 0, 1, 0) as new_status  ";

$fields_to_show = array(
    'ID' => '###id###',
    'Title' => '<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0"> ###title###</a>',
    'Active' => '<a href="javascript:change_status(\'' . (empty($CURRENT_LOCATION) ? '' : $CURRENT_LOCATION) . '&editID=###id###&action=active&active_new_status=###new_status###\')"><img src="images/visibility###active###.gif" alt="" width="14" height="14" border="0"></a>',
    'Actions' => '
			<a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
);

$fields_showorder = 'date` desc, `id` desc, `id';

$edit_additional_stuff_top = '';

$edit_additional_stuff_bottom = 0;
