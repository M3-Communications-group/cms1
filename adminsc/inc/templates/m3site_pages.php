<?php

$fields_to_select = "*, IF(`active` > 0, 0, 1) as new_status ";
$fields_to_show = array(
    'ID' => '###id###',
    'Страница' => '<a href="' . $myLocation . '&editID=###id###&action=edit">###name###</a>',
    'URL' => '<a href="' . $myLocation . '&editID=###id###&action=edit">###url###</a>',
    'Tекстове' => '<a href="main.php?admin_option=8&pid=###id###"  title="Статични текстове в страницата">
        <img src="images/edit.gif" alt="Edit" width="16" height="16" border="0">&nbsp;Текстове
    </a>',
//    'Показва се в меню' => '<a href="' . $myLocation . '&editID=###id###&action=edit">###shown###</a>',
//    'URL' => '<a href="' . $myLocation . '&editID=###id###&action=edit">###url###</a>',
//    'Текстове' => '<a href="main.php?admin_option=11&pid=###id###"  title="Редакция на съдържание">###content###</a>',
);
$fields_to_show['Действия'] = '
    <span style="font-size:18px;">&nbsp;&nbsp;[&nbsp;&nbsp;</span>
    <a href="javascript:change_status(\'' . $myLocation . '&editID=###id###&action=active&active_new_status=###new_status###\')" title="Покажи/Скрий">
        <img src="images/visibility###active###.gif" alt="Visibility" width="14" height="14" border="0">
    </a>
    <span style="font-size:18px;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
    <a href = "' . $myLocation . '&editID=###id###&action=showorder&showordermove=-1" title="Премести нагоре">
        <img src = "images/up.gif" alt = "Move up" width = "16" height = "16" border = "0">
    </a>
    <a href = "' . $myLocation . '&editID=###id###&action=showorder&showordermove=1" title="Премести надолу">
        <img src = "images/down.gif" alt = "Move down" width = "16" height = "16" border = "0">
    </a>';
if ($_SESSION['m3cms']["group_id"] == 0) {
    $fields_to_show['Действия'] .= '
    <span style="font-size:18px;">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
    <a href = "javascript:del(\'' . $myLocation . '&editID=###id###&action=del\')" title="Изтрий">
        <img src = "images/delete.gif" alt = "Delete" width = "16" height = "16" border = "0">
    </a>';
}
$fields_to_show['Действия'] .= '
    <span style="font-size:18px;">&nbsp;&nbsp;]&nbsp;&nbsp;</span>';

$fields_showorder = 'pid`, `showorder';

$fields_to_manage = array(
    array(
        "name" => 'name',
        "title" => 'Име за меню',
        "type" => 'text',
        "select_list" => "",
        "default_value" => null,
        "null_if_empty" => true,
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'title',
        "title" => 'Заглавие в страница',
        "type" => 'text',
        "select_list" => "",
        "default_value" => null,
        "null_if_empty" => true,
        "required" => 0,
        "check_type" => 'text_nohtml',
        "check_value" => '',
    ),
    array(
        "name" => 'pid',
        "title" => 'Родител',
        "type" => 'dbselect_tree',
        "select_list" => "SELECT id, name, level, has_children FROM `m3site_pages` WHERE pid = '0' ORDER BY  showorder",
        "default_value" => 0,
        "required" => 0,
        "check_type" => 'int_pos_null',
        "check_value" => '',
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
    array(
        "name" => 'level',
        "title" => '',
        "type" => 'auto',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => '',
        "check_value" => '',
    ),
    array(
        "name" => 'has_children',
        "title" => '',
        "type" => 'auto',
        "select_list" => "",
        "default_value" => '',
        "required" => 1,
        "check_type" => '',
        "check_value" => '',
    ),
    array(
        "name" => 'show_inmenu',
        "title" => 'Да се показва в менюто?',
        "type" => 'select',
        "select_list" => array("0" => "Не", "1" => "Да"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1)$',
    ),
    array(
        "name" => 'active',
        "title" => 'Активна',
        "type" => 'select',
        "select_list" => array("0" => "Не", "1" => "Да"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1)$',
    ),
);
if ($_SESSION['m3cms']["group_id"] == 0) {
    $fields_to_manage[] = array(
        "name" => 'url',
        "title" => 'URL',
        "type" => 'text',
        "select_list" => "",
        "default_value" => null,
        "null_if_empty" => true,
        "required" => 0,
        "unique" => true,
        "check_type" => 'text_nohtml',
        "check_value" => '^[0-9a-zA-Z_\'"`\s\/\-]+$',
    );
    $fields_to_manage[] = array(
        "name" => 'script',
        "title" => 'Script',
        "type" => 'text',
        "select_list" => "",
        "default_value" => 'static',
        "required" => 1,
        "check_type" => 'text_nohtml',
        "check_value" => '^[a-zA-Z_]+$',
    );
}
