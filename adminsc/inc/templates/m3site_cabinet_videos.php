<?php

$fields_to_manage = array(
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
        "name" => 'language',
        "title" => 'Language',
        "type" => 'select',
        "select_list" => array("1" => "English", /*"2" => "French",*/ "3" => "Creole"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(1|2|3)$',
    ),
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
        "name" => 'videcode',
        "title" => 'Video code - part after "v=" and before "&"',
        "type" => 'text',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'smallpath',
        "title" => 'Photo (min 330px width, 210px height)',
        "type" => 'image',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'jpg',
        "check_width" => '',
        "check_height" => '',
        "check_propotion" => '',
        "check_maxheight" => '',
        "check_maxwidth" => '',
        "check_minheight" => '210',
        "check_minwidth" => '330',
        "max_size" => '', //KB
        "upload_dir" => 'uploads/cabinet_videos',
        "check_value" => '',
        "auto_images" => array(
            "smallpath|330|210||||1", // name|width|height|propotion|writesize|optional-olny-if-size-allows|/resize/crop/resize and toggle width/height if portrait
        ),
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


$fields_to_show_join = " ";
$fields_to_select = "*, if(active = 0, 1, 0) as new_status  ";

$fields_to_show = array(
    'ID' => '###id###',
    'Title' => '<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###title###</a>',
    'Thumbnail' => '<img src="../###smallpath###" alt="" border="0" width="120" height="auto">',
    'Active' => '<a href="javascript:change_status(\'' . (empty($CURRENT_LOCATION) ? '' : $CURRENT_LOCATION) . '&editID=###id###&action=active&active_new_status=###new_status###\')"><img src="images/visibility###active###.gif" alt="" width="14" height="14" border="0"></a>',
    'Action' => '
			<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=showorder&showordermove=-1"><img src="images/down.gif" alt="" width="16" height="16" border="0"></a>
			<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=showorder&showordermove=1"><img src="images/up.gif" alt="" width="16" height="16" border="0"></a>
			<a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
);

$fields_showorder = 'showorder` desc, `id` desc, `id';
