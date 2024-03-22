<?php

$fields_to_show = array(
    'ID' => '###id###',
    'IP' => '<a href="' . $myLocation . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###remote_addr###</a>',
    'Action' => '
			<a href="javascript:del(\'' . $myLocation . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
		',
);

$fields_showorder = 'id';

$fields_to_manage = array(
    array(
        "name" => 'remote_addr',
        "title" => 'IP',
        "type" => 'text',
        "default_value" => '',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
);
