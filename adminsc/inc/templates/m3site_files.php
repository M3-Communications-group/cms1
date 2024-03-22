<?php
/*
$pids = array();
$myq = "SELECT id, name FROM `m3site_files_categories` ORDER BY showorder ASC";
$res = query($myq);
while ($r = mysqli_fetch_array($res)) {
    $pids[$r['id']] = $r['name'];
}
if (!isset($pid) || !array_key_exists($pid, $pids)) {
    reset($pids);
    $pid = key($pids);
}
*/
$fields_to_manage = array(
    array(
        "name" => 'pid',
        "title" => 'Category',
        "type" => 'dbselect',
        "select_list" => "SELECT id, name FROM m3site_files_categories ORDER BY showorder ASC",
        "default_value" => 0,
        "required" => 0,
        "check_type" => 'int_pos_null',
        "check_value" => '',
    ),
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
        "name" => 'filepath',
        "title" => 'File (zip|txt|pdf|rtf|gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|swf)',
        "type" => 'file',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'zip|txt|pdf|rtf|gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|swf',
        "max_size" => '', //KB
        "upload_dir" => 'uploads/files', //KB
    ),
);

$fields_to_show_join = " left join m3site_files_categories on m3site_files.pid = m3site_files_categories.id ";
$fields_to_select = "m3site_files.id, IF(m3site_files.name != '', m3site_files.name, 'No name') AS name, filepath, m3site_files_categories.name as category_name ";

$fields_to_show = array(
    'ID' => '###id###',
    'Title' => '<a href="' . $CURRENT_LOCATION . '&editID=###id###&action=edit">###name###</a>',
    'Category' => '###category_name###',
    'URL' => '###filepath###',
    'Actions' => '
            <a href="javascript:del(\'' . $CURRENT_LOCATION . '&editID=###id###&action=del\')"><img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>
            <br>',
);
$fields_showorder = 'name';
