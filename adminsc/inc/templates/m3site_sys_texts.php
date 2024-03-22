<?php

	$fields_to_manage = array(
		array(
				"name" => 'code', 
				"title" => 'Code', 
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
			),
	);
	
	$fields_to_select = "m3site_sys_texts.*, replace(m3site_sys_texts.text, \"'\", \"\\\'\") as mytext";
	
	$fields_to_show = array(
		'ID' => '###id###',
		'Code' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit">###code###</a>', 
		'Text' => '= \'<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;\' . substr(striphtml(\'###mytext###\'), 0, 100) . \'</a>\'',
		'Action' => '
			<a href="javascript:del(\''.$CURRENT_LOCATION.'&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
	);
	$fields_showorder = 'id';