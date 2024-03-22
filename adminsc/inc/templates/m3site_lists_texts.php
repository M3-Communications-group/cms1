<?php

	$fields_to_manage = array(
		array(
				"name" => 'pid', 
				"title" => 'Parent', 
				"type" => 'dbselect',
				"select_list" => "select id, name from m3site_lists order by id",
				"default_value" => '',
				"required" => 1,
				"check_type" => 'int_pos_null',
				"check_value" => '',
			),
		array(
				"name" => 'title', 
				"title" => 'Title', 
				"type" => 'text',
				"select_list" => "",
				"default_value" => '',
				"required" => 0,
				"check_type" => 'text_nohtml',
				"check_value" => '',
			),		
		array(
				"name" => 'text', 
				"title" => 'Text', 
				"type" => 'textarea',
				"default_value" => '',
				"required" => 0,
				"check_type" => 'text_nohtml',
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
		array(
				"name" => 'image', 
				"title" => 'Image: width 85px', 
				"type" => 'image',
				"select_list" => "",
				"default_value" => '',
				"required" => 0,
				"check_type" => 'jpg',
				"check_width" => '85',
				"check_height" => '',
				"check_propotion" => '',
				"check_maxheight" => '160',
				"check_maxwidth" => '',
				"check_minheight" => '',
				"check_minwidth" => '',
				"max_size" => '', //KB
				"upload_dir" => 'uploads/lists', 
				"check_value" => '',
				"auto_images" => array(
						//"photo|980|360||||1", // name|width|height|propotion|writesize|optional-only-if-size-allows
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

	$fields_to_show_join = " left join m3site_lists  on m3site_lists_texts.pid  = m3site_lists.id ";
	$fields_to_select = "m3site_lists_texts.*, replace(m3site_lists_texts.text, \"'\", \"\\\'\") as mytext, m3site_lists.name as name1 ";
	
	$fields_to_show = array(
		'ID' => '###id###',
		'Parent' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###name1###</a>', 
		'Title' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###title###</a>', 
		'Text' => '= \'<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;\' . substr(striphtml(\'###mytext###\'), 0, 100) . \'</a>\'', 
		'Action' => '
			<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=showorder&showordermove=-1"><img src="images/up.gif" alt="" width="16" height="16" border="0"></a>
			<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=showorder&showordermove=1"><img src="images/down.gif" alt="" width="16" height="16" border="0"></a>
			<a href="javascript:del(\''.$CURRENT_LOCATION.'&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
	);

	$fields_showorder = 'showorder';