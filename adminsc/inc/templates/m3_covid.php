<?php

$fields_to_manage = array(
    array(
        "name" => 'date',
        "title" => 'Date',
        "type" => 'text',
        "select_list" => "",
        "default_value" => date("Y-m-d"),
        "required" => 1,
        "check_type" => 'date',
        "check_value" => '',
    ),
    
    array(
        "name" => 'image',
        "title" => 'Image',
        "type" => 'image',
        "required" => 0,
        "check_type" => 'jpg|png',
        "select_list" => "",
        "default_value" => '',
        "check_width" => '',
        "check_height" => '',
        "check_propotion" => '',
        "check_maxheight" => '',
        "check_maxwidth" => '',
        "check_minwidth" => '',
        "check_minheight" => '',
        "max_size" => '', //KB
        "upload_dir" => 'uploads/covid',
        "check_value" => '',
        "auto_images" => array(
            //"photo_big|803|492|||1|2",
            //"photo_small|300|180||||2", //  name|width|height|propotion|writesize|optional-olny-if-size-allows|/resize/crop/resize and toggle width/height if portrait
        ),
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

$fields_to_select = "*, if(active = 0, 1, 0) as new_status, date_format(date, '%d.%m.%Y') as mydate  ";

$fields_to_show = array(
    'ID' => '###id###',
    'Date' => '<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0"> ###mydate###</a>',
    'Active' => '<a href="javascript:change_status(\'' . (empty($CURRENT_LOCATION) ? '' : $CURRENT_LOCATION) . '&editID=###id###&action=active&active_new_status=###new_status###\')"><img src="images/visibility###active###.gif" alt="" width="14" height="14" border="0"></a>',
    'Action' => '
                        <a href="main.php?admin_option=37&action=view&table=&pid=###id###">[ Files ]</a>
			<a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
);
$fields_showorder = 'date` desc, `id` desc, `id';
