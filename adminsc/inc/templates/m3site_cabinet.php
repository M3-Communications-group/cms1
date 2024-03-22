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
        "name" => 'text',
        "title" => 'Text',
        "type" => 'rte',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_html',
        "check_value" => '',
        "allow_images" => 1,
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
        "name" => 'photo_big',
        "title" => 'Photo (min size 484x320)',
        "type" => 'image',
        "required" => "",
        "check_type" => 'jpg',
        "select_list" => "",
        "default_value" => '',
        "check_width" => '',
        "check_height" => '',
        "check_propotion" => '',
        "check_maxheight" => '',
        "check_maxwidth" => '',
        "check_minheight" => '320',
        "check_minwidth" => '484',
        "max_size" => '', //KB
        "upload_dir" => 'uploads/cabinet',
        "check_value" => '',
        "auto_images" => array(
            "photo_big|484|320||||1",
            "photo_small|204|135||||", //  name|width|height|propotion|writesize|optional-olny-if-size-allows|/resize/crop/resize and toggle width/height if portrait
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
);

$fields_to_select = "*, if(active = 0, 1, 0) as new_status  ";

$fields_to_show = array(
    'ID' => '###id###',
    'Title' => '<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0"> ###title###</a>',
    'Active' => '<a href="javascript:change_status(\'' . (empty($CURRENT_LOCATION) ? '' : $CURRENT_LOCATION) . '&editID=###id###&action=active&active_new_status=###new_status###\')"><img src="images/visibility###active###.gif" alt="" width="14" height="14" border="0"></a>',
    'Action' => '
			<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=showorder&showordermove=-1"><img src="images/up.gif" alt="" width="16" height="16" border="0"></a>
			<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=showorder&showordermove=1"><img src="images/down.gif" alt="" width="16" height="16" border="0"></a>
			<a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
);

$fields_showorder = 'showorder';

$edit_additional_stuff_top = '';

$edit_additional_stuff_bottom = 0;
