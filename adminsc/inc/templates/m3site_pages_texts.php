<?php

$pids = array();
$myq = "SELECT id, name FROM `m3site_pages` ORDER BY pid, showorder ASC";
$res = query($myq);

while ($r = mysqli_fetch_array($res)) {
    $pids[$r['id']] = $r['name'];
}

if (!isset($pid) || !array_key_exists($pid, $pids)) {
    reset($pids);
    $pid = key($pids);
}


$fields_to_show_join = " LEFT JOIN m3site_pages nav ON m3site_pages_texts.pid  = nav.id ";
$fields_to_select = "m3site_pages_texts.id, m3site_pages_texts.active, nav.name, "
        . " IF(m3site_pages_texts.title != '', m3site_pages_texts.title, '--- Няма заглавие ---') AS title, "
        . " IF(m3site_pages_texts.active = 0, 1, 0) AS new_status ";

$fields_to_show = array(
    'ID' => '###id###',
    'Title' => '<a href="' . $myLocation . '&pid=' . $pid . '&editID=###id###&action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###title###</a>',
    'Action' => '
        <span style="font-size:18px;">&nbsp;&nbsp;[&nbsp;&nbsp;</span>
        <a href="javascript:change_status(\'' . $myLocation . '&pid=' . $pid . '&editID=###id###&action=active&active_new_status=###new_status###\')" title="Покажи/Скрий">
            <img src="images/visibility###active###.gif" alt="Visibility" width="14" height="14" border="0">
        </a>
        <span style="font-size:18px;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href = "' . $myLocation . '&pid=' . $pid . '&editID=###id###&action=showorder&showordermove=-1" title="Премести нагоре">
            <img src = "images/up.gif" alt = "Move up" width = "16" height = "16" border = "0">
        </a>
        <a href = "' . $myLocation . '&pid=' . $pid . '&editID=###id###&action=showorder&showordermove=1" title="Премести надолу">
            <img src = "images/down.gif" alt = "Move down" width = "16" height = "16" border = "0">
        </a>
        <span style="font-size:18px;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
        <a href = "javascript:del(\'' . $myLocation . '&pid=' . $pid . '&editID=###id###&action=del\')" title="Изтриване на секция">
            <img src = "images/delete.gif" alt = "Delete" width = "16" height = "16" border = "0">
        </a>
        <span style="font-size:18px;">&nbsp;&nbsp;]&nbsp;&nbsp;</span>',
);

$custom_where = " m3site_pages_texts.pid='" . $pid . "'";

$fields_showorder = 'nav`.`showorder` ASC, `m3site_pages_texts`.`showorder';

$fields_to_manage = array(
    array(
        "name" => 'pid',
        "title" => 'Page',
        "type" => 'dbselect_tree',
        "select_list" => "SELECT id, name, level, has_children FROM m3site_pages WHERE pid = '0' ORDER BY pid, showorder",
        "default_value" => 0,
        "required" => 1,
        "check_type" => 'int_pos_notnull',
        "check_value" => '',
    ),
    array(
        "name" => 'title',
        "title" => 'Title',
        "type" => 'text',
        "select_list" => "",
        "default_value" => null,
        "null_if_empty" => true,
        "required" => 0,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'content',
        "title" => 'Content',
        "type" => 'rte',
        "select_list" => "",
        "default_value" => null,
        "null_if_empty" => true,
        "required" => 0,
        "check_type" => 'text_html',
        "check_value" => '',
    ),
    array(
        "name" => 'image_original',
        "title" => 'Image.',
        "type" => 'image',
        "required" => 0,
        "check_type" => 'gif|jpg|jpeg|png',
        "select_list" => "",
        "default_value" => null,
        "null_if_empty" => true,
        "check_value" => '',
        "check_width" => '',
        "check_height" => '',
        "check_propotion" => '',
        "check_maxheight" => '4000',
        "check_maxwidth" => '4000',
        "check_minheight" => '',
        "check_minwidth" => '',
        "max_size" => '8192', //KB
        "upload_dir" => 'uploads/pages/' . $pid,
        "auto_images" => array(
            "image_large|1024|||||", // name|width|height|propotion|writesize
            "image_medium|640|||||", // name|width|height|propotion|writesize
            "image_small|480|||||", // name|width|height|propotion|writesize
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
    array(
        "name" => 'showorder',
        "title" => '',
        "type" => 'auto',
        "reverse" => false,
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => '',
        "check_value" => '',
    ),
);
