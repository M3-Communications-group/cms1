<?php

//ini_set("memory_limit", "32M");
require "mysql_connect.php";
$error_reporting = SITE_ERRORS;

require "functions_site.php";
require "functions_cms.php";
require "setup.php";
require "session.php";

trimvars($_POST);
trimvars($_GET);

if (empty($html_encoding)) {
    $html_encoding = "windows-1251";
}
header("Content-type: text/html; charset=UTF-8");

if (!empty($lang_admin) && preg_match("/^(bg|en)$/", $lang_admin)) {
    $lang = $lang_admin;
} else {
    $lang = 'en';
}

$intPosOpt = [
    'options' => [
        'min_range' => 0,
        'default' => 0
    ],
];

$actOpt = [
    'options' => [
        'default' => 'view',
        'regexp' => '/^(add|edit|del|categories|showorder|active)$/',
    ],
];
$id = (int) filter_input(INPUT_GET, "editID", FILTER_SANITIZE_NUMBER_INT);
$editID = ($id > 0) ? $id : 0;
$action = filter_input(INPUT_GET, "action", FILTER_VALIDATE_REGEXP, $actOpt);
$admin_option = filter_input(INPUT_GET, "admin_option", FILTER_VALIDATE_INT, $intPosOpt);
$localfile = basename(filter_input(INPUT_SERVER, 'PHP_SELF'));
$myLocation = $localfile . '?admin_option=' . $admin_option;

if ($_SESSION['m3cms']['user_id'] > 0) {

    $pid = filter_input(INPUT_GET, "pid", FILTER_VALIDATE_INT, $intPosOpt);
    $sub_pid = filter_input(INPUT_GET, "sub_pid", FILTER_VALIDATE_INT, $intPosOpt);
    $_GET["start"] = filter_input(INPUT_GET, "start", FILTER_VALIDATE_REGEXP, $actOpt);

    $fields_to_show_join = '';
    $fields_to_select = '';
    $fields_to_manage = array();
    $custom_where = '';
    $custom_limit = 50;

    $table = filter_input(INPUT_GET, "table", FILTER_SANITIZE_STRING);
    $table_name = '';
    $table_categories = '';
    $table_categories_query = '';
    $table_categories_title_field = '';

    $menu_html = array(0 => '', 1 => '');
    $menu = array(0 => '', 1 => '');
    $menu_viewadd = '';

    if ($admin_option == 0 && $table === 'm3cms_sitemap' && $_SESSION['m3cms']["group_id"] == 0) {

        $table_name = 'CMS';
        $table_categories = '';
        $_SESSION['m3cms']["perm_view"] = 1;
        $_SESSION['m3cms']["perm_add"] = 1;
        $_SESSION['m3cms']["perm_edit"] = 1;
        $_SESSION['m3cms']["perm_del"] = 1;
    } else {
        locate_position($admin_option);
    }

    make_menu(0);
    $additional = '';

    // Adding Navigation FUnctions to menu
    if ($_SESSION['m3cms']["group_id"] == 0) {

        $menu_html .= '<li class="menu-title">Navigation</li>';
        $menu_html .= '<li class="menu-item" style=" padding-left: 0px;">';
        $menu_html .=    '<a class="menu-link" href="#menuCms" data-bs-toggle="collapse">';
        $menu_html .=        '<span><img src="images\icons\Cms.svg"></span>';
        $menu_html .=        '<span style="margin-left:-27px" class="menu-text">CMS</span><i class="bi bi-caret-down"></i>';

        $menu_html .=    '</a>';
        $menu_html .=    '<div class="collapse" id="menuCms">';
        $menu_html .=        '<ul class="sub-menu">';
        $menu_html .=            '<li class="menu-item ms-3" style="padding-left:1px">
                                        <a href="modal.php?admin_option=0&action=add&table=m3cms_sitemap" class="menu-link" data-bs-toggle="modal" data-bs-target="#Modal">
                                            <span class="menu-text" style="margin-left:-19px">Add</span>
                                        </a>
                                    </li>';
        $menu_html .=        '</ul>';
        $menu_html .=    '</div>';
        $menu_html .= '</li>';
    };

    $exclude_vars = array('delID', 'showordermove', 'showorderfield', 'active_new_status', 'active_field');
    $exclude_vars2 = array('delID', 'showordermove', 'showorderfield', 'active_new_status', 'active_field', 'start');

    $CURRENT_LOCATION = '?';
    $CURRENT_LOCATION2 = '?';
    foreach ($_GET as $key => $val) {
        if (!in_array($key, $exclude_vars)) {
            if (is_array($val)) {

                foreach ($val as $key1 => $val1) {
                    $CURRENT_LOCATION .= $key . "[" . $key1 . "]" . '=' . urlencode($val1) . '&';
                }
            } else {
                if ($key == 'action' && $val == 'del') {
                    $val = 'view';
                }
                $CURRENT_LOCATION .= $key . '=' . urlencode($val) . '&';
            }
        }
        if (!in_array($key, $exclude_vars2)) {
            if (is_array($val)) {
                foreach ($val as $key1 => $val1) {
                    $CURRENT_LOCATION2 .= $key . '[' . $key1 . ']' . '=' . urlencode($val1) . '&';
                }
            } else {
                if ($key == 'action' && $val == 'del') {
                    $val = 'view';
                }
                $CURRENT_LOCATION2 .= $key . '=' . urlencode($val) . '&';
            }
        }
    }

    foreach ($_POST as $key => $val) {
        if (!in_array($key, $exclude_vars2)) {
            if (is_array($val)) {

                foreach ($val as $key1 => $val1) {
                    if (!is_array($val1)) {
                        $CURRENT_LOCATION2 .= $key . '[' . $key1 . ']' . '=' . urlencode($val1) . '&';
                    }
                }
            } else {
                if ($key != 'action') {
                    $CURRENT_LOCATION2 .= $key . '=' . urlencode($val) . '&';
                }
            }
        }
    }

    if (file_exists("inc/templates/$table.php")) {
        include("inc/templates/$table.php");
    } else {
        die("No template! (" . $table . ")");
    }

    if ($_SERVER["REQUEST_METHOD"] == 'POST' && !preg_match("/^(change_password|memcached)\.php$/i", $localfile) && preg_match("/^(edit|add)$/", $action)) {
       
    } $commit_result = commit($fields_to_manage, $table);

    if ($_SERVER["REQUEST_METHOD"] == 'POST' && !$commit_result[0] && preg_match("/^(edit|add)$/", $action)) {
        $current_item = $_POST;
    } else {
        $current_item = array();
        if ((preg_match("/edit|showorder|active/", $action) && $editID > 0 && ($_SESSION['m3cms']["perm_edit"] == '1' or $_SESSION['m3cms']["perm_edit"] == '2')) || ($action == 'del' && $editID > 0 && ($_SESSION['m3cms']["perm_del"] == '1' or $_SESSION['m3cms']["perm_del"] == '2'))) {

            $where = '';
            if ($_SESSION['m3cms']["perm_edit"] == '2' && check_field_exists($table, "user_id")) {
                $where .= "and `$table`.user_id = '" . $_SESSION['m3cms']["user_id"] . "'";
            }

            $myquery = "select * from `$table` where id = '" . mysqli_real_escape_string($sqlConn, $editID) . "' $where";
            $MyResult = query($myquery);
            if (mysqli_num_rows($MyResult) > 0) {
                $current_item = mysqli_fetch_array($MyResult);
                reset($fields_to_manage);
                foreach ($fields_to_manage as $key => $val) {
                    if (!empty($val["external_table"])) {
                        $myquery = "select * from `" . $val["external_table"] . "` where id = '" . $current_item["id"] . "'";
                        $MyResult = query($myquery);
                        while ($row = mysqli_fetch_array($MyResult)) {
                            $current_item[$val["name"]] = $row[$val["name"]];
                        }
                    }
                }
            } else {
                //die("No rights");

                $orig_edit_id = intval($editID);
                $editID = '';
                $current_item = array();

                $action = 'view';
            }

            if (!empty($current_item["id"])) {
                if ($action == 'showorder' && !empty($_GET["showordermove"]) && preg_match("/^(1|-1)$/", $_GET["showordermove"])) {
                    showordermove($editID, $table, $_GET["showordermove"], (!empty($_GET["showorderfield"]) ? $_GET["showorderfield"] : $fields_showorder));
                    if (function_exists($table . "_additional")) {
                        eval($table . "_additional(" . intval($editID) . ");");
                    }
                    $action = 'view';
                } elseif ($action == 'del') {
                    if ($_SESSION['m3cms']["perm_del"]) {
                        if ($_SESSION['m3cms']["perm_del"] == '2' && check_field_exists($table, "user_id")) {
                            $tmp = " and `$table`.user_id = '" . $_SESSION['m3cms']["user_id"] . "' ";
                        } else {
                            $tmp = " ";
                        }

                        $myquery = "delete from `$table` where id = '" . mysqli_real_escape_string($sqlConn, $editID) . "' $tmp";
                        $MyResult = query($myquery);

                        if (mysqli_affected_rows($sqlConn) > 0) {

                            foreach ($fields_to_manage as $key => $val) {
                                if (($val["type"] == 'image' or $val["type"] == 'file') && !empty($current_item[$val["name"]])) {
                                    unlink("../" . $current_item[$val["name"]]);
                                    if ($val["type"] == 'image' && isset($val["auto_images"]) && count($val["auto_images"]) > 0) {

                                        foreach ($val["auto_images"] as $not_important => $auto_image) {
                                            $img_params = explode("|", $auto_image);
                                            unlink("../" . $current_item[$img_params[0]]);
                                        }
                                    }
                                }
                            }
                            if (!empty($val["external_table"])) {
                                $myquery = "delete from `" . $val["external_table"] . "` where id = '" . mysqli_real_escape_string($sqlConn, $editID) . "'";
                                $MyResult = query($myquery);
                            }
                            if (function_exists($table . "_additional")) {
                                eval($table . "_additional(" . intval($editID) . ");");
                            }
                            if (check_field_exists($table, "showorder")) {
                                content_fix_showorder($table, 0);
                            }
                        }
                    }
                    $action = 'view';
                } elseif ($action == 'active' && isset($_GET["active_new_status"])) {
                    if ($_SESSION['m3cms']["perm_edit"]) {

                        if ($_SESSION['m3cms']["perm_edit"] == '2' && check_field_exists($table, "user_id")) {
                            $tmp = " and `$table`.user_id = '" . $_SESSION['m3cms']["user_id"] . "' ";
                        } else {
                            $tmp = " ";
                        }

                        if (isset($_GET["active_field"]) && check_field_exists($table, $_GET["active_field"])) {
                            $active_field = $_GET["active_field"];
                        } else {
                            $active_field = 'active';
                        }

                        $myquery = "update `$table` set `$active_field` = '" . mysqli_real_escape_string($sqlConn, $_GET["active_new_status"]) . "' where id = '" . mysqli_real_escape_string($sqlConn, $editID) . "' $tmp";
                        $MyResult = query($myquery);

                        if (function_exists($table . "_additional")) {
                            eval($table . "_additional(" . intval($editID) . ");");
                        }
                    }
                    $action = 'view';
                }
                content_fix_showorder($table, ((array_key_exists('pid', $current_item)) ? $current_item["pid"] : ''));
            }
        } elseif ($editID > 0 && !$_SESSION['m3cms']["perm_edit"]) {
            die("No rights");
        } elseif (!$_SESSION['m3cms']["perm_add"] && $action == 'add') {
            die("No rights");
        }
    }

    if ($action == 'active') {
        $action = 'view';
    }

    if (file_exists("inc/templates/$table" . "_more.php")) {
        include("inc/templates/$table" . "_more.php");
    }
} else if ($localfile != 'index.php') {
    mysqli_close();
    header("Location: index.php");
    die();
}

if (!isset($show_more)) {
    $show_more = (isset($_GET["hide_more"])) ? FALSE : TRUE;
}

if (!isset($show_viewadd)) {
    $show_viewadd = (isset($_GET["hide_viewadd"])) ? FALSE : TRUE;
}
