<?php

ini_set("register_globals", "off");
if (empty($table)) {
    die();
}

$CURRENT_LOCATION = '';

require __DIR__ . "/templates/$table.php";

echo '<table border="0" cellpadding="0" cellspacing="0"><tr><td>
	<form id="main" name="main" action="' . $myLocation . '" method="post" enctype="multipart/form-data" onsubmit="content_doonsubmit();">';

reset($fields_to_manage);
while (list($key, $val) = each($fields_to_manage)) {
    echo make_form_item($val, $current_item);
}

if ($editID) {
    echo '<input type="Hidden" value="' . $editID . '" name="editID">';
}

echo '<input type="Submit" value="Save" id="submitit">';
echo '</form></td></tr></table>';

