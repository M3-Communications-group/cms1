<?php

	$fields_to_manage = array(
		array(
				"name" => 'pid', 
				"title" => 'Parent', 
				"type" => 'dbselect_tree',
				"select_list" => "select id, name, level, has_children from m3site_navigation where pid = '0' order by showorder",
				"default_value" => '',
				"required" => 1,
				"check_type" => 'int_pos_null',
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
			),
                array(
				"name" => 'image', 
				"title" => 'Photo max 484px width', 
				"type" => 'image',
				"select_list" => "",
				"default_value" => '',
				"required" => "",
				"check_type" => 'jpg',
				"check_width" => '',
				"check_height" => '',
				"check_propotion" => '',
				"check_maxheight" => '',
				"check_maxwidth" => '484',
				"check_minheight" => '',
				"check_minwidth" => '0',
				"max_size" => '', //KB
				"upload_dir" => 'uploads/texts', 
				"check_value" => '',
				"auto_images" => array(
					//"photo|980|360||||1", // name|width|height|propotion|writesize|optional-only-if-size-allows
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

	$fields_to_show_join = " left join m3site_navigation n1 on m3site_statictexts.pid  = n1.id left join m3site_navigation n2 on n1.pid = n2.id ";
	$fields_to_select = "m3site_statictexts.*, replace(m3site_statictexts.text, \"'\", \"\\\'\") as mytext, n1.name as name1, n2.name as name2";
	
	$fields_to_show = array(
		'ID' => '###id###',
		'Parent' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###name2###</a>', 
		'Menu' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###name1###</a>', 
		'Text' => '= \'<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;\' . substr(striphtml(\'###mytext###\'), 0, 100) . \'</a>\'', 
		'Action' => '
			<a href="javascript:del(\''.$CURRENT_LOCATION.'&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
	);

	
	
	
	$fields_showorder = 'id';