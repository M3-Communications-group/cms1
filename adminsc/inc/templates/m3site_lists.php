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
				"name" => 'name', 
				"title" => 'Name', 
				"type" => 'text',
				"select_list" => "",
				"default_value" => '',
				"required" => 1,
				"check_type" => 'text_nohtml',
				"check_value" => '',
			),			
	);

	$fields_to_show_join = " left join m3site_navigation n1 on m3site_lists.pid  = n1.id ";
	$fields_to_select = "m3site_lists.*, n1.name as parent ";
	
	$fields_to_show = array(
		'ID' => '###id###',
		'Parent' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###parent###</a>', 
		'Name' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###name###</a>', 
		'Action' => '
			<a href="main.php?admin_option=23&table=m3site_lists_texts&action=view&pid=###id###"> [ Content ] </a> 
			<a href="javascript:del(\''.$CURRENT_LOCATION.'&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
	);

	$fields_showorder = 'id';