<?php

$fields_to_manage = array(
    array(
        "name" => 'pid',
        "title" => 'Gallery',
        "type" => 'dbselect',
        "select_list" => "select id, name from m3site_gallery order by showorder",
        "default_value" => '0',
        "required" => 1,
        "check_type" => 'int_pos_null',
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
        "name" => 'title',
        "title" => 'Title',
        "type" => 'text',
        "select_list" => "",
        "default_value" => '',
        "required" => "",
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'origpath',
        "title" => 'Photo - min 260x173px',
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
        "check_minheight" => '173',
        "check_minwidth" => '260',
        "max_size" => '', //KB
        "upload_dir" => 'uploads/galls_photos',
        "check_value" => '',
        "auto_images" => array(
            "bigpath|800||||1|", // name|width|height|propotion|writesize|optional-olny-if-size-allows|/resize/crop/resize and toggle width/height if portrait
            "smallpath|260|173|||1|1", // name|width|height|propotion|writesize|optional-olny-if-size-allows|/resize/crop/resize and toggle width/height if portrait
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

$fields_to_show = array(
    'ID' => '###id###',
    'Gallery' => '###gname###',
    'Title' => '###title###',
    'Date' => '###mydate###',
    'Preview' => '<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0"><img src="../###smallpath###" border="0"></a>',
    'Action' => '
			<a href="javascript:change_status(\'' . (empty($CURRENT_LOCATION) ? '' : $CURRENT_LOCATION) . '&editID=###id###&action=active&active_new_status=###new_status###\')"><img src="images/visibility###active###.gif" alt="" width="14" height="14" border="0"></a>
			<a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
);

$fields_to_show_join = "left join m3site_gallery on m3site_photos.pid = m3site_gallery.id ";
$fields_to_select = 'm3site_photos.*,  m3site_gallery.name as gname, if(m3site_photos.active = 0, 1, 0) as new_status, date_format(m3site_photos.date, "%d %M %Y") as mydate ';

$pid_table = 'gallery';

$fields_showorder = 'date` desc, `title';
