<?php

$fields_to_manage = array(
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

$fields_to_show = array(
    'ID' => '###id###',
    'Name' => '<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=edit">###name###</a>',
    'Action' => '
			<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=showorder&showordermove=-1"><img src="images/up.gif" alt="" width="16" height="16" border="0"></a>
			<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=showorder&showordermove=1"><img src="images/down.gif" alt="" width="16" height="16" border="0"></a>
			<a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		<br>',
);
$fields_showorder = 'showorder';
