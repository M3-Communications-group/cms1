<?php

$fields_to_select = ' m3cms_access.*, m3cms_groups.name as group_name, m3cms_sitemap.name as sitemap_name';
$fields_to_show_join = "left join m3cms_groups on m3cms_access.group_id = m3cms_groups.id left join m3cms_sitemap on m3cms_access.sitemap_id = m3cms_sitemap.id";

$fields_to_show = array(
    'ID' => '<a href="' . $myLocation . '&editID=###id###&action=edit">'
    . '<img src="images/edit.gif" alt="" width="16" height="16" border="0">&nbsp;###id###</a>',
    'Group' => '###group_name###',
    'Option' => '###sitemap_name###',
    'View' => '###perm_view###',
    'Add' => '###perm_add###',
    'Edit' => '###perm_edit###',
    'Del' => '###perm_del###',
    'Action' => '
        <a href="javascript:del(\'' . $myLocation . '&editID=###id###&action=del\')">'
    . '<img src="images/delete.gif" alt="" width="16" height="16" border="0"></a>',
);

$fields_showorder = 'group_id`, `sitemap_id`, `id';

$view_additional_stuff_top = '
	<form action="main.php" method="get">
            <input type="Hidden" name="admin_option" value="' . $admin_option . '">
            <select name="group_id">
                <option value="">Select...</option>';
$myquery = "select `id`, `name` from m3cms_groups order by name";
$MyResult = query($myquery);

while ($row = mysqli_fetch_array($MyResult)) {
    $view_additional_stuff_top .= '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
}

$view_additional_stuff_top .= '
            </select>
            <input type="submit" value="search" style="width: auto;">
	</form>';

$gid = filter_input(INPUT_GET, "group_id", FILTER_VALIDATE_INT);
if ($gid) {
    $custom_where = " group_id = '" . $gid . "' ";
}

$fields_to_manage = array(
    array(
        "name" => 'sitemap_id',
        "title" => 'Option',
        "type" => 'dbselect_tree',
        "select_list" => "select id, name, level, has_children from m3cms_sitemap where pid = '0' order by id, showorder",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'int_pos_notnull',
        "check_value" => '',
    ),
    array(
        "name" => 'group_id',
        "title" => 'Group',
        "type" => 'dbselect',
        "select_list" => "select id, name from m3cms_groups order by id",
        "default_value" => '',
        "required" => 1,
        "check_type" => 'int_pos_notnull',
        "check_value" => '',
    ),
    array(
        "name" => 'perm_view',
        "title" => 'Permission to show',
        "type" => 'select',
        "select_list" => array("0" => "No", "1" => "Yes", "2" => "Own records only"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1|2)$',
    ),
    array(
        "name" => 'perm_add',
        "title" => 'Permission to add',
        "type" => 'select',
        "select_list" => array("0" => "No", "1" => "Yes"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1)$',
    ),
    array(
        "name" => 'perm_edit',
        "title" => 'Permission to edit',
        "type" => 'select',
        "select_list" => array("0" => "No", "1" => "Yes", "2" => "Own records only"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1|2)$',
    ),
    array(
        "name" => 'perm_del',
        "title" => 'Permission to del',
        "type" => 'select',
        "select_list" => array("0" => "No", "1" => "Yes", "2" => "Own records only"),
        "default_value" => '1',
        "required" => 1,
        "check_type" => '',
        "check_value" => '^(0|1|2)$',
    ),
);
