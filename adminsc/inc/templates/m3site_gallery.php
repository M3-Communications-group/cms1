<?php

	$fields_to_manage = array(

		array(
				"name" => 'name', 
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
				"name" => 'origpath', 
				"title" => 'Photo (min 260x173px)', 
				"type" => 'image',
				"select_list" => "",
				"default_value" => '',
				"required" => 0,
				"check_type" => 'jpg',
				"check_width" => '',
				"check_height" => '',
				"check_propotion" => '',
				"check_maxheight" => '',
				"check_maxwidth" => '',
				"check_minheight" => '173',
				"check_minwidth" => '260',
				"max_size" => '', //KB
				"upload_dir" => 'uploads/galls', 
				"check_value" => '',
				"auto_images" => array(
						"smallpath|260|173|||1|1", // name|width|height|propotion|writesize|optional-olny-if-size-allows|/resize/crop/resize and toggle width/height if portrait
					),
			), 
		array(
				"name" => 'active', 
				"title" => 'Active', 
				"type" => 'select',
				"select_list" => array("0" => "No", "1" => "Yes"),
				"default_value" => '0',
				"required" => 1,
				"check_type" => '',
				"check_value" => '^(0|1)$',
			),
	);
	
	$fields_to_select = "* ";
	
	$fields_to_show = array(
		'ID' => '###id###',
		'Title' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0"> ###name###</a>', 
		'Action' => '
			<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=showorder&showordermove=-1"><img src="images/down.gif" alt="" width="16" height="16" border="0"></a>
			<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=showorder&showordermove=1"><img src="images/up.gif" alt="" width="16" height="16" border="0"></a>
			<a href="javascript:del(\''.$CURRENT_LOCATION.'&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
	);
	
	$fields_showorder = 'showorder` desc, `id';
	
	$edit_additional_stuff_top = '';
	
	$edit_additional_stuff_bottom = 0;