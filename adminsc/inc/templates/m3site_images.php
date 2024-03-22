<?php

$fields_to_manage = array(
    array(
        "name" => 'title',
        "title" => 'Title',
        "type" => 'text',
        "select_list" => "",
        "default_value" => null,
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'picpath',
        "title" => 'Photo',
        "type" => 'image',
        "required" => 1,
        "check_type" => 'gif|jpg|jpeg|png',
        "select_list" => "",
        "default_value" => null,
        "check_value" => '',
        "check_width" => '',
        "check_height" => '',
        "check_propotion" => '',
        "check_maxheight" => '',
        "check_maxwidth" => '',
        "check_minheight" => '',
        "check_minwidth" => '',
        "max_size" => '', //KB
        "upload_dir" => 'uploads/images',
        "auto_images" => array(
        ),
    ),
);

$fields_to_select = "id, title, picpath ";

$fields_to_show = array(
    'ID' => '###id###',
    'Title' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">  ###title###</a>', 
	'Photo' => '<img src="../###picpath###" alt="" border="0">', 
	'URL' => '###picpath###', 
	'Actions' => '
            <a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
            <br>',
);

$fields_showorder = 'id` DESC, `title';



