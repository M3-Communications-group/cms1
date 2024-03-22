<?php
	$fields_to_manage = array(
		array(
				"name" => 'type', 
				"title" => 'Type', 
				"type" => 'select',
				"select_list" => array("1" => "News", "2" => "Speeches", "3" => "Messages"),
				"default_value" => '1',
				"required" => 1,
				"check_type" => '',
				"check_value" => '^(1|2|3|4|5)$',
			),
		array(
				"name" => 'pid', 
				"title" => 'Topic', 
				"type" => 'dbselect',
				"select_list" => "select id, name from m3site_topics order by name",
				"default_value" => '0',
				"required" => 0,
				"check_type" => 'int_pos_null',
				"check_value" => '',
			),
		array(
				"name" => 'language', 
				"title" => 'Language', 
				"type" => 'select',
				"select_list" => array("1" => "English", "2" => "French", "3" => "Creole"),
				"default_value" => '1',
				"required" => 1,
				"check_type" => '',
				"check_value" => '^(1|2|3)$',
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
				"required" => 1,
				"check_type" => 'text_nohtml',
				"check_value" => '',
			),
		array(
				"name" => 'short_title', 
				"title" => 'Short title for slider (news only)', 
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
				"type" => 'rte',
				"select_list" => "",
				"default_value" => '',
				"required" => 1,
				"check_type" => 'text_html',
				"check_value" => '',
				"allow_images" => 1,
			),
		array(
				"name" => 'photo_big_homepage', 
				"title" => 'Photo (news only) - min size 720x458', 
				"type" => 'image',
				"required" => 0,
				"check_type" => 'jpg',
				"select_list" => "", 
				"default_value" => '', 
				"check_width" => '', 
				"check_height" => '', 
				"check_propotion" => '', 
				"check_maxheight" => '', 
				"check_maxwidth" => '', 
				"check_minheight" => '458', 
				"check_minwidth" => '720', 
				"max_size" => '', //KB
				"upload_dir" => 'uploads/news/' . date("Y"), 
				"check_value" => '',
				"auto_images" => array(
                                    "photo_big_homepage|720|458|||2|1",
                                    "photo_big|524|333||||",
                                    "photo_small|330|210||||", //  name|width|height|propotion|writesize|optional-olny-if-size-allows|/resize/crop/resize and toggle width/height if portrait
				),
			), 	
		array(
				"name" => 'home_page_show', 
				"title" => 'Show on homepage slider', 
				"type" => 'select',
				"select_list" => array("0" => "No", "1" => "Yes"),
				"default_value" => '0',
				"required" => 1,
				"check_type" => '',
				"check_value" => '^(0|1)$',
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
            
//            array(
//				"name" => 'send_mail', 
//				"title" => 'Automatic News Alert', 
//				"type" => 'select',
//				"select_list" => array("0" => "No", "1" => "Yes"), //
//				"default_value" => '0',
//				"required" => 1,
//				"check_type" => '',
//				"check_value" => '^(0|1)$',
//			),
		
//		array(
//				"name" => 'newsalert_groups', 
//				"title" => 'Send to:', 
//				"type" => 'checkbox_dbmultiple',
//				"select_list" => "select id, name from newsalert_users_groups where active = 1 order by name",
//				"default_value" => '',
//				"required" => 0,
//				"check_type" => '',
//				"check_value" => '',
//			),			
		
			
	);
	
	$fields_to_select = "*, if(active = 0, 1, 0) as new_status  ";
	
	$fields_to_show = array(
		'ID' => '###id###',
		'Title' => '<a href="'.$CURRENT_LOCATION.'&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0"> ###title###</a>', 
		'Date' => '###date###', 
		'Active' => '<a href="javascript:change_status(\''.(empty($CURRENT_LOCATION)?'':$CURRENT_LOCATION).'&editID=###id###&action=active&active_new_status=###new_status###\')"><img src="images/visibility###active###.gif" alt="" width="14" height="14" border="0"></a>', 
		'Action' => '
			<a href="javascript:del(\''.$CURRENT_LOCATION.'&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
	);
	
	$fields_showorder = 'date` desc, `id` desc, `id';
	
	
	if(!empty($_GET["type"])) {
		$custom_where = " type = '" . $_GET["type"] . "'";
	}
	
	$edit_additional_stuff_top = '';
	
	$view_additional_stuff_top = '
		<br><strong>Show:</strong>&nbsp;&nbsp;<a href="main.php?admin_option=29&action=view&type=1">News</a> | <a href="main.php?admin_option=29&action=view&type=2">Speeches</a> | <a href="main.php?admin_option=29&action=view&type=3">Messages</a> | <a href="main.php?admin_option=29&action=view">All</a> <br><br><br>
	';
	
		
	
	$edit_additional_stuff_bottom = 0;
	
        function m3site_news_additional($id) {
		global $action;
                global $sqlConn;
		if($action=='add'){
			$query = 'select send_mail, newsalert_groups from m3site_news where id="'.$id.'"';
			$result = query($query);
			$arr=mysqli_fetch_array($result);
			if($arr['send_mail'==1] && !empty($arr['newsalert_groups'])){
				$tmp_group_ids = preg_replace('/\|/',',', substr($arr['newsalert_groups'], 1, -1));
				
				$query = "select * from  newsalert_users where pid in (".$tmp_group_ids.")";
				$result = query($query);
				while($arr=mysqli_fetch_array($result)){
					$q = 'insert into newsalert (email, news_id) values ("' . mysqli_real_escape_string($sqlConn, $arr["email"]) . '", "' . $id . '")';
					$r = query($q);
				}
			}
		}
	}
	
	function m3site_news_delete($id) {
		$query = 'delete from newsalert where news_id="'.$id.'"';
		$result = query($query);
	}