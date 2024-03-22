<?php

function make_menu($pid)
{
    global $menu, $menu_html, $table, $admin_option;
    if ($_SESSION['m3cms']["group_id"] == 0) {
        $myquery = "select *, '1' as perm_view, '1' as perm_add, '1' as perm_edit, '1' as perm_del from m3cms_sitemap where pid = '$pid' and show_inmenu = '1' order by showorder";
    } else {
        $myquery = "select m3cms_sitemap.*, m3cms_access.perm_view, m3cms_access.perm_add, m3cms_access.perm_edit, m3cms_access.perm_del from m3cms_sitemap left join m3cms_access on m3cms_sitemap.id = m3cms_access.sitemap_id where m3cms_access.group_id = '" . $_SESSION['m3cms']["group_id"] . "' and pid = '$pid' and perm_view in ('1', '2') and show_inmenu = '1' order by showorder";
    }
    $MyResult = query($myquery);
    while ($row = mysqli_fetch_array($MyResult)) {
        $is_active = "";
        if ($row["id"] == $menu[$row["level"]]) {
            $is_active = "_active";
            if ($row["has_children"]) {
                make_menu($row["id"]);
            }
        }
        $menu_html[$row["level"]] .= '<div class="menu-text menu_lvl' . $row["level"] . $is_active . '"><a href="' . $row["filename"] . '?admin_option=' . $row["id"] . (!empty($_GET["common_sense"]) ? "&common_sense=1" : "") . '">' . $row["name"] . '</a></div>';
    }
}

function locate_position($sitemap_id)
{
    /*
      Sazdava array $menu, v kojto se sadarja izbrano ID ot menuto za vseki level ot navigaciata.
      Selectva izbranoto ID, proveriava dali ima parent...

     */
    global $menu, $menu_html, $table, $admin_option, $table_name, $table_categories, $menu_viewadd, $pid, $additional, $action, $admin_texts, $lang;
    if (!empty($sitemap_id)) { //Ako e izbrano neshto v menu
        if ($_SESSION['m3cms']["group_id"] == 0) {
            $myquery = "select m3cms_sitemap.*, '1' as perm_view, '1' as perm_add, '1' as perm_edit, '1' as perm_del from m3cms_sitemap where m3cms_sitemap.id = '$sitemap_id'";
        } else {
            $myquery = "select m3cms_sitemap.*, m3cms_access.perm_view, m3cms_access.perm_add, m3cms_access.perm_edit, m3cms_access.perm_del from m3cms_sitemap left join m3cms_access on m3cms_sitemap.id = m3cms_access.sitemap_id where m3cms_access.group_id = '" . $_SESSION['m3cms']["group_id"] . "' and m3cms_sitemap.id = '$sitemap_id' and perm_view in ('1', '2')";
        }
        $MyResult = query($myquery);
        if (mysqli_num_rows($MyResult) == 0) {
            locate_position(0);
        } else {
            while ($row = mysqli_fetch_array($MyResult)) {

                if ($row["id"] == $sitemap_id) { // ako sme v tova menu
                    $menu[$row["level"]] = $row["id"];
                }

                if (!empty($row["pid"])) { // izbira aktivnite menuta nagore po verigata
                    locate_position($row["pid"]);
                }

                if (empty($row["content_table"]) && $row["id"] == $admin_option) { // ako tova e izbranoto, no triabva da izbere niakoj ot children
                    if ($_SESSION['m3cms']["group_id"] == 0) {
                        $mysecquery = "select m3cms_sitemap.*, '1' as perm_view, '1' as perm_add, '1' as perm_edit, '1' as perm_del from m3cms_sitemap left join m3cms_access on m3cms_sitemap.id = m3cms_access.sitemap_id where pid = '" . $row["id"] . "' ORDER BY showorder ASC, id ASC limit 1";
                    } else {
                        $mysecquery = "select m3cms_sitemap.*, m3cms_access.perm_view, m3cms_access.perm_add, m3cms_access.perm_edit, m3cms_access.perm_del from m3cms_sitemap left join m3cms_access on m3cms_sitemap.id = m3cms_access.sitemap_id where m3cms_access.group_id = '" . $_SESSION['m3cms']["group_id"] . "' and m3cms_sitemap.pid = '$sitemap_id' and perm_view in ('1', '2')  ORDER BY showorder ASC, id ASC ";
                    }
                    $MySecResult = query($mysecquery);
                    if (mysqli_num_rows($MySecResult) == 0) {
                        die("No subitems or content_table");
                    } else {
                        $secrow = mysqli_fetch_array($MySecResult);
                        $admin_option = $secrow["id"];
                        locate_position($secrow["id"]);
                    }
                }

                if (!empty($row["content_table"]) && $row["id"] == $admin_option) { // ako tova e izbranoto 
                    $menu_viewadd .= '<div class="menu_lvl_viewadd' . (($action == 'view') ? "_active" : "") . '"><a href="' . $row["filename"] . '?admin_option=' . $admin_option . '&action=view&table=' . $table_categories . '&pid=' . $pid . (!empty($_GET["hide_nav"]) ? "&hide_nav=1" : "") . (!empty($_GET["common_sense"]) ? "&common_sense=1" : "") . '">' . $admin_texts[$lang]["list"] . '</a></div>';
                    if ($row["perm_add"] > 0) {
                        $menu_viewadd .= '<div class="menu_lvl_viewadd' . (($action == 'add') ? "_active" : "") . '"><a data-bs-toggle="modal" data-bs-target="#Modal" href="' . $row["filename"] . '?admin_option=' . $admin_option . '&action=add&table=' . $table_categories . '&pid=' . $pid . (!empty($_GET["hide_nav"]) ? "&hide_nav=1" : "") . (!empty($_GET["common_sense"]) ? "&common_sense=1" : "") . '">' . $admin_texts[$lang]["add"] . '</a></div>';
                    }
                    $table = $row["content_table"];
                    $table_categories = $row["table_categories"];
                    $table_name = $row["name"];
                    $_SESSION['m3cms']["perm_view"] = $row["perm_view"];
                    $_SESSION['m3cms']["perm_add"] = $row["perm_add"];
                    $_SESSION['m3cms']["perm_edit"] = $row["perm_edit"];
                    $_SESSION['m3cms']["perm_del"] = $row["perm_del"];
                }
            }
        }
    } else {
        if ($_SESSION['m3cms']["group_id"] == 0) {
            $myquery = "select * from m3cms_sitemap where level = 0 and show_inmenu = '1' order by showorder limit 1";
        } else {
            $myquery = "select m3cms_sitemap.* from m3cms_sitemap left join m3cms_access on m3cms_sitemap.id = m3cms_access.sitemap_id where m3cms_access.group_id = '" . $_SESSION['m3cms']["group_id"] . "' and level = 0 and show_inmenu = '1' and perm_view in ('1', '2') order by showorder limit 1";
        }
        $MyResult = query($myquery);
        if (mysqli_num_rows($MyResult) == 0) {
            if ($_SESSION['m3cms']["group_id"] == 0) {
                header("Location: main.php?table=m3cms_sitemap");
                return false;
            } else {
                die("No navigation options found.");
            }
        } else {
            $row = mysqli_fetch_array($MyResult);
            $admin_option = $row["id"];
            locate_position($row["id"]);
        }
    }
}

function sitemap_fancy($table, $pid, $level, $fields, $showorder, $parent_is_last, $custom_query = '')
{
    $where = '';
    if (check_field_exists($table, "pid")) {
        $where .= " pid = '$pid' ";
    }
    if (!check_field_exists($table, $showorder)) {
        $showorder = 'id';
    }
    /*
      if(check_field_exists($table, "active")) {
      if(!empty($where)) {
      $where .= 'and ';
      }
      $where .= " active = '1'";
      }
     */
    if (!empty($where)) {
        $where = " where $where ";
    }

    if (!empty($custom_query)) {
        $myquery = $custom_query;
    } else {
        $myquery = "select * from `$table` $where order by `$showorder`";
    }
    $MyResult = query($myquery);
    $i = 1;
    $num = mysqli_num_rows($MyResult);
    if ($parent_is_last) {
        $img_fst = 'spacer.gif';
    } else {
        $img_fst = 'line.gif';
    }
    $this_is_last = 0;
    while ($row = mysqli_fetch_array($MyResult)) {
        if ($i == $num) {
            if (!empty($row["has_children"])) {
                $img = 'minusbottom.gif';
            } else {
                $img = 'joinbottom.gif';
            }
            if ($parent_is_last) {
                $this_is_last = 1;
            }
        } else {
            if (!empty($row["has_children"])) {
                $img = 'minus.gif';
            } else {
                $img = 'join.gif';
            }
        }
        show_table_row_fancy($row, $fields, $level, $img, $img_fst);
        if (!empty($row["has_children"])) {
            sitemap_fancy($table, $row["id"], $level + 1, $fields, $showorder, $this_is_last);
        }
        $i++;
    }
}

function show_table_row_fancy($row, $fields, $level, $img = 'spacer.gif', $img_fst = 'spacer.gif')
{
    global $pname, $pid, $lang;
    if ($pid == $row["id"]) {
        if (isset($row["name"])) {
            $fieldname = "name";
        } elseif (isset($row[$lang . "_name"])) {
            $fieldname = $lang . "_name";
        } elseif (isset($row["title"])) {
            $fieldname = "title";
        } elseif (isset($row[$lang . "_title"])) {
            $fieldname = $lang . "_title";
        } elseif (isset($row["title_" . $lang])) {
            $fieldname = "title_" . $lang;
        } elseif (isset($row["name_" . $lang])) {
            $fieldname = "name_" . $lang;
        } else {
            $fieldname = "id";
        }
        $pname .= " &raquo; " . $row[$fieldname];
        $row["name"] = '<b>' . $row[$fieldname] . '</b>';
    }

    reset($fields);
    echo '<tr>';
    foreach ($fields as $key => $val) {
        echo '<td nowrap>' . (($key == 'Name') ? str_repeat('<img src="images/' . $img_fst . '" alt="" width="18" height="16" border="0" align="absmiddle">', ($level)) . str_repeat('<img src="images/' . $img . '" alt="" width="18" height="16" border="0" align="absmiddle">', 1) . '<img src="images/pages.gif" alt="" width="18" height="16" border="0" align="absmiddle">' : '');
        echo search_replace($val, $row);
        echo '<br></td>';
    }
    echo '</td></tr>';
}

function sitemap($table, $fields_to_show, $pid, $level, $fields, $showorder, $start = 0, $limit = 50, $sub_pid = 0, $fields_to_show_join = '', $fields_to_select = '', $custom_where = '', $group_by = '', $show_sum = '')
{
    global $admin_texts, $lang;

    if (!empty($group_by)) {
        $group = "group by $group_by";
    } else {
        $group = "";
    }

    if (!empty($custom_where)) {
        $where = "and " . $custom_where;
    } else {
        $where = '';
        if (check_field_exists($table, "pid") && ((!empty($pid) || !empty($sub_pid) || check_field_exists($table, "level")))) {
            //if(check_field_exists($table, "pid")) {
            if (!empty($sub_pid)) {
                $where .= " and `$table`.pid = '$sub_pid' ";
            } else {
                $where .= " and `$table`.pid = '$pid' ";
            }
        }
        if (!empty($pid) && check_field_exists($table, "category_id")) {
            $where .= "and `$table`.category_id = '$pid'";
        } elseif (!empty($pid) && check_field_exists($table, "article_id")) {
            $where .= " and `$table`.article_id = '$pid' ";
        }
    }

    if ($_SESSION['m3cms']["perm_view"] == '2' && check_field_exists($table, "user_id")) {
        $where .= " and `$table`.user_id = '" . $_SESSION['m3cms']["user_id"] . "' ";
    }

    if ($_SESSION['m3cms']["perm_edit"] == '2' && check_field_exists($table, "user_id")) {
        $where .= " and `$table`.user_id = '" . $_SESSION['m3cms']["user_id"] . "' ";
    }

    if (!empty($where)) {
        $where = " where " . substr($where, 4) . " ";
    }

    $myquery = "select count(*) from `$table` $fields_to_show_join $where $group";
    $MyResult = query($myquery);
    while ($row = mysqli_fetch_array($MyResult)) {
        $count = $row["count(*)"];
    }

    if ($level == 0) {
        echo '<div id="main_list">';
        if (count($fields_to_show) > 0) {
            echo make_pages_list($count, $start, $limit);
        }
        echo '<div style="clear: both;"></div><div style="clear: both;"></div><br><div style="clear: both;"></div><table class="table table-centered table-striped table-bordered mb-0 toggle-circle footable-loaded footable tablet breakpoint" border="0" cellpadding="0" cellspacing="0" class="viewlist">';
        show_table_header($fields_to_show);
    }
    if (empty($fields_to_select)) {
        $fields_to_select = '*';
    }

    if (check_field_exists($table, $showorder)) {
        $order_clause = "`$table`.`$showorder`";
    } else {
        $order_clause = "`$showorder`";
    }

    $myquery = "select $fields_to_select from `$table` $fields_to_show_join $where $group order by $order_clause limit $start, $limit";
    //debugme($myquery);
    //echo $myquery;
    $MyResult = query($myquery);
    while ($row = mysqli_fetch_array($MyResult)) {
        show_table_row($row, $fields, $level);
        if (!empty($row["has_children"])) {
            sitemap($table, $fields_to_show, $row["id"], $level + 1, $fields, $showorder, $start, $limit, $sub_pid, $fields_to_show_join, $fields_to_select, $custom_where, $group_by);
        }
    }
    if ($level == 0) {
        echo '</table>';
        if (!empty($show_sum)) {
            $myquery = "select sum($show_sum) from `$table` $fields_to_show_join $where $group";
            $MyResult = query($myquery);
            while ($row = mysqli_fetch_row($MyResult)) {
                echo '<div style="margin: 7px;"><b>' . $admin_texts[$lang]['total'] . ': ' . $row[0] . '</b><br></div>';
            }
        }
        if (count($fields_to_show) > 0) {
            echo make_pages_list($count, $start, $limit);
        }
        echo '</div><!-- main_list -->';
    }
}

function show_table_header($headers)
{
    reset($headers);
    echo '<tr>';
    foreach ($headers as $key => $val) {
        echo '<th>' . $key . '</th>';
    }
    echo '</tr>';
}

function show_table_row($row, $fields, $level, $img = 'spacer.gif')
{
    reset($fields);
    echo '<tr onclick="toggle_color(this)">';
    foreach ($fields as $key => $val) {
        echo '<td>' . (($key == 'Name' || $key == 'Име' || $key == 'Страница') ? str_repeat('<img src="images/' . $img . '" alt="" width="18" height="16" border="0" align="absmiddle">', $level) : '');
        echo search_replace($val, $row);
        echo '</td>';
    }
    echo '</td></tr>';
}

function make_pages_list($all_count, $start, $limit)
{
    global $CURRENT_LOCATION2, $admin_texts, $lang;

    $retval = '<div style="float: left; padding: 7px 5px 7px 5px;"><div style="float: left; ">';

    $this_page = ceil(($start + 1) / $limit);

    $all_pages = ceil($all_count / $limit);

    if ($all_pages > 30) {
        $p_end = 30;
        $p_start = ($this_page - 14);
        if ($p_start <= 0) {
            $p_start = 1;
        } else {
            $p_end = 29 + $p_start;
            if ($p_end > $all_pages) {
                $p_end = $all_pages;
            }
        }
    } else {
        $p_end = $all_pages;
        $p_start = 1;
    }
    if ($p_start > 1) {
        $retval .= '<a href="' . $CURRENT_LOCATION2 . '&start=0">&laquo;</a> | ';
    }
    for ($i = $p_start; $i <= $p_end; $i++) {
        if ($i == $this_page) {
            $retval .= '<b>' . $i . '</b> | ';
        } else {
            $retval .= '<a href="' . $CURRENT_LOCATION2 . '&start=' . (($i - 1) * $limit) . '">' . $i . '</a> | ';
        }
    }
    if ($this_page <> $all_pages) {
        $retval = substr($retval, 0, -3);
        $retval .= '<a href="' . $CURRENT_LOCATION2 . '&start=' . (($all_pages - 1) * $limit) . '">&raquo;</a>';
    }
    $retval .= '
		</div>
		<div align="right" style="float: right; padding: 0px 50px 0px; ">' . $admin_texts[$lang]['total'] . ': <b>' . $all_count . '</b></div>
	</div><div style="clear: both;"></div>';
    return $retval;
}

function array_wrap_values(&$item1, $key, $str)
{
    $item1 = "$str$item1$str";
}

function array_change_values(&$item2, $key, $row)
{
    $item2 = $row[$item2];
}

function search_replace($items, $values)
{
    if (is_array($items)) {
        preg_match_all("/(###([-_a-zA-Z0-9]+)###)+/", $items[0], $regs);
        // echo $values[$regs[2][0]];
        $values[$regs[2][0]] = $items[1][$values[$regs[2][0]]];
    } else {
        preg_match_all("/(###([-_a-zA-Z0-9]+)###)+/", $items, $regs);
    }
    $search = array_unique($regs[1]);
    $replace = array_unique($regs[2]);
    array_walk($search, 'array_wrap_values', '/');
    array_walk($replace, 'array_change_values', $values);
    if (is_array($items)) {
        return preg_replace($search, $replace, $items[0]);
    } else {
        $items = preg_replace($search, $replace, $items);
        if (preg_match("/^\=/", $items)) {
            //echo "\$items = " . substr($items, 1) . ";";
            eval("\$items = " . substr($items, 1) . ";");
            //echo $items;
        }
        return $items;
    }
}

function showordermove($id, $table, $move, $showorderfield = 'showorder')
{
    if (!check_field_exists($table, $showorderfield)) {
        if (check_field_exists($table, "showorder")) {
            $showorderfield = 'showorder';
        } else {
            return false;
        }
    }
    $myquery = "select * from `$table` where id = '$id'";
    $MyResult = query($myquery);
    if (mysqli_num_rows($MyResult) == 0) {
        return false;
    }
    $myquery = "select * from `$table` where id = '$id'";
    $MyResult = query($myquery);
    if (mysqli_num_rows($MyResult) == 0) {
        return false;
    }
    $item = mysqli_fetch_array($MyResult);
    if (array_key_exists('pid', $item)) {
        $where = " pid = '" . $item["pid"] . "' and ";
        $nopid = false;
    } else if (array_key_exists('parent_id', $item)) {
        $where = " parent_id = '" . $item["parent_id"] . "' and ";
        $nopid = false;
    } else {
        $where = "";
        $nopid = true;
    }

    if ($move < 0) {
        $myquery = "select count(*) from `$table` where $where `$showorderfield` < '" . $item["$showorderfield"] . "'";
    } else {
        $myquery = "select count(*) from `$table` where $where `$showorderfield` > '" . $item["$showorderfield"] . "'";
    }
    $MyResult = query($myquery);
    $row = mysqli_fetch_array($MyResult);
    if ($row[0] > 0) {
        $myquery = "update `$table` set `$showorderfield` = `$showorderfield` - $move where $where `$showorderfield` = '" . ($item["$showorderfield"] + $move) . "'";
        $MyResult = query($myquery);
        $myquery = "update `$table` set `$showorderfield` = `$showorderfield` + $move where id = '" . $item["id"] . "'";
        $MyResult = query($myquery);
        $myq = "SELECT COUNT(*) AS `cnt` FROM `$table` GROUP BY `showorder` ORDER BY cnt DESC LIMIT 0,1";
        $res = query($myq);
        $row = mysqli_fetch_array($res);
        if ($row[0] > 1) {
            content_fix_showorder($table, ($nopid === true) ? 0 : $item["pid"]);
        }
    }
    return true;
}

function delid($id, $table)
{
    
}

function make_form_item($item, $values)
{
    global $pid, $sub_pid, $doonsubmit, $table, $site_path, $admin_texts, $lang, $site_encoding;
    $retval = '';
    if (!empty($item["title"]) && $item["type"] <> 'hidden' && $item["type"] <> 'timestamp' && empty($item["hidetitle"])) {
        $retval .= '<label>' . (!empty($item["required"]) ? "* " : "") . $item["title"] . '</label><br>';
    }
    switch ($item["type"]) {
        case "hidden":
            $retval .= '<input type="Hidden" name="' . $item["name"] . '" ';
            if (isset($values[$item["name"]])) {
                $retval .= ' value="' . htmlspecialchars(stripslashes($values[$item["name"]]), ENT_QUOTES, $site_encoding) . '"';
            } else {
                $retval .= ' value="' . htmlspecialchars(stripslashes($item["default_value"]), ENT_QUOTES, $site_encoding) . '"';
            }
            $retval .= '>';
            break;

        case "text":
            $retval .= '<input type="Text" name="' . $item["name"] . '" ';
            if (isset($values[$item["name"]])) {
                $retval .= ' value="' . htmlspecialchars(stripslashes($values[$item["name"]]), ENT_QUOTES, $site_encoding) . '"';
            } else {
                $retval .= ' value="' . htmlspecialchars(stripslashes($item["default_value"]), ENT_QUOTES, $site_encoding) . '"';
            }
            $retval .= '><br>';
            break;

        case "password":
            $retval .= '<input type="Password" name="' . $item["name"] . '" ';
            if (isset($values[$item["name"]])) {
                $retval .= ' value="' . htmlspecialchars(stripslashes($values[$item["name"]]), ENT_QUOTES, $site_encoding) . '"';
            } else {
                $retval .= ' value="' . htmlspecialchars(stripslashes($item["default_value"]), ENT_QUOTES, $site_encoding) . '"';
            }
            $retval .= '><br>';
            break;

        case "textarea":
            $retval .= '<textarea name="' . $item["name"] . '" cols="20" rows="10">';
            if (isset($values[$item["name"]])) {
                $retval .= htmlspecialchars(stripslashes($values[$item["name"]]), ENT_QUOTES, $site_encoding);
            } else {
                $retval .= htmlspecialchars(stripslashes($item["default_value"]), ENT_QUOTES, $site_encoding);
            }
            $retval .= '</textarea><br>';
            break;

        case "timestamp":
            $retval .= '<input type="Hidden" name="' . $item["name"] . '" value="' . date("Y-m-d H:i:s") . '">';
            break;

        case "date":
            if (isset($values[$item["name"]])) {
                if (preg_match("/0000/", $values[$item["name"]])) {
                    $tmp_val = 0;
                } else {
                    $tmp_val = make_timestamp(stripslashes($values[$item["name"]]));
                }
            } else {
                $tmp_val = make_timestamp(stripslashes($item["default_value"]));
            }
            $tmp_inputs = select_date_fields($tmp_val, $item["name"], "F", (!$item["required"] ? true : false), '', "date");
            $retval .= $tmp_inputs["day"] . $tmp_inputs["month"] . $tmp_inputs["year"] . '<br>';
            break;

        case "datemonth":
            if (isset($values[$item["name"]])) {
                if (preg_match("/0000/", $values[$item["name"]])) {
                    $tmp_val = 0;
                } else {
                    $tmp_val = make_timestamp(stripslashes($values[$item["name"]]));
                }
            } else {
                $tmp_val = make_timestamp(stripslashes($item["default_value"]));
            }
            $tmp_inputs = select_date_fields($tmp_val, $item["name"], "F", (!$item["required"] ? true : false), '', "date");
            $retval .= $tmp_inputs["month"] . $tmp_inputs["year"] . '<br>';
            break;

        case "datetime":
            if (isset($values[$item["name"]])) {
                if (preg_match("/0000/", $values[$item["name"]])) {
                    $tmp_val = 0;
                } else {
                    $tmp_val = make_timestamp(stripslashes($values[$item["name"]]));
                }
            } else {
                $tmp_val = make_timestamp(stripslashes($item["default_value"]));
            }
            $tmp_inputs = select_date_fields($tmp_val, $item["name"], "F", (!$item["required"] ? true : false), '', "date");
            $retval .= $tmp_inputs["day"] . bgdate($tmp_inputs["month"]) . $tmp_inputs["year"] . ' H ' . $tmp_inputs["hour"] . ':' . $tmp_inputs["minute"] . '<br>';
            break;

        case "rte_small":
            $retval .= preg_replace(array("/###vars###/", "/###content###/", "/###site_path###/", "/###site_path###/", "/###article_id###/"), array($item["name"], str_replace("$", "\\$", stripslashes($values[$item["name"]])), $site_path, $values["id"]), implode('', file("inc/templates/rte_small.php")));
            break;
        case "rte":

            if (!array_key_exists('id', $values)) {
                $values['id'] = null;
            }

            if (!array_key_exists($item["name"], $values)) {
                $values[$item["name"]] = $item["default_value"];
            }

            $retval .= preg_replace(array("/###vars###/", "/###content###/", "/###site_path###/", "/###site_path###/", "/###article_id###/"), array($item["name"], str_replace("$", "\\$", stripslashes($values[$item["name"]])), $site_path, $values["id"]), implode('', file("inc/templates/rte.php")));
            //$retval .= preg_replace(array("/###vars###/", "/###content###/", "/###site_path###/", "/###lang###/"), array($item["name"], stripslashes($values[$item["name"]]), $site_path, $lang), implode('', file("inc/templates/rte_ckeditor.php")));
            break;
        case "rte_full":
            if (preg_match("/IE/", $_SERVER["HTTP_USER_AGENT"])) {
                $retval .= preg_replace(array("/###vars###/", "/###content###/"), array($item["name"], stripslashes($values[$item["name"]])), implode('', file("inc/templates/rte_full.php")));
            } else {
                $item["title"] = '';
                $item["type"] = 'textarea';
                $retval .= make_form_item($item, $values);
            }
            break;

        case "select":
            $retval .= '<select name="' . $item["name"] . '">';
            if ($item["required"] <> 1) {
                $retval .= '<option value="' . $item["default_value"] . '">Select...</option>';
            }
            reset($item["select_list"]);
            $tmp = 0;
            foreach ($item["select_list"] as $key => $val) {
                $retval .= '<option value="' . htmlspecialchars(stripslashes($key), ENT_QUOTES, $site_encoding) . '" ';
                if (isset($values[$item["name"]]) && $values[$item["name"]] == $key) {
                    $retval .= "selected";
                    $tmp = 1;
                } elseif ($item["default_value"] == $key && !$tmp) {
                    $retval .= "selected";
                }
                $retval .= '>' . htmlspecialchars(stripslashes($val), ENT_QUOTES, $site_encoding) . '</option>';
            }
            $retval .= '</select><br>';
            break;
        case "select_tree":
            $retval .= '<select name="' . $item["name"] . '"' . ((isset($item["dependency"])) ? ' onchange="make_dependency(this[this.selectedIndex], \'' . $item["dependency"]["name"] . '\')"' : '') . '>';
            if ($item["required"] <> 1) {
                $retval .= '<option value="' . $item["default_value"] . '">Select...</option>';
            }
            reset($item["select_list"]);
            $tmp = 0;
            $dependencies = '';
            foreach ($item["select_list"] as $key => $val) {
                $retval .= '<option value="' . htmlspecialchars(stripslashes($key), ENT_QUOTES, $site_encoding) . '" ';
                if (isset($values[$item["name"]]) && $values[$item["name"]] == $key) {
                    $retval .= "selected";
                    $tmp = 1;
                } elseif ($item["default_value"] == $key && !$tmp) {
                    $retval .= "selected";
                }
                $retval .= '>' . htmlspecialchars(stripslashes($val["name"]), ENT_QUOTES, $site_encoding) . '</option>';
                if (isset($item["dependency"])) {
                    $dependencies .= '
						var dep_' . $item["dependency"]["name"] . '_' . $key . ' = ';
                    if (count($val["types"]) > 0) {
                        $dependencies .= '\'<b>' . $item["dependency"]["title"] . '</b><br><select name="' . $item["dependency"]["name"] . '">';

                        foreach ($val["types"] as $key1 => $val1) {
                            $dependencies .= '<option value="' . $key1 . '">' . $val1 . '</option>';
                        }
                        $dependencies .= '</select>\';
						';
                    } else {
                        $dependencies .= '\'\';
						';
                    }
                }
            }
            $retval .= '</select><br>';
            if (!empty($dependencies)) {
                $retval .= '
				<script language="JavaScript">
					' . $dependencies . '
				</script>';
            }
            break;
        case "dbselect":
            $retval .= '<select name="' . $item["name"] . '" id="' . $item["name"] . '" ' . (!empty($item["add_html"]) ? $item["add_html"] : '') . '>';
            if ($item["required"] <> 1) {
                $retval .= '<option value="' . $item["default_value"] . '">' . $admin_texts[$lang]['select'] . '...</option>';
            }
            $MyResult = query($item["select_list"]);
            $tmp = 0;
            while ($row = mysqli_fetch_row($MyResult)) {
                $retval .= '<option value="' . htmlspecialchars($row[0], ENT_QUOTES, $site_encoding) . '" ';
                if (isset($values[$item["name"]]) && $values[$item["name"]] == $row[0]) {
                    $retval .= "selected";
                    $tmp = 1;
                } elseif (($item["name"] == 'category_id' || $item["name"] == 'pid') && !empty($sub_pid) && $sub_pid == $row[0] && !$tmp) {
                    $retval .= "selected";
                    $tmp = 1;
                } elseif (($item["name"] == 'category_id' || $item["name"] == 'pid') && empty($sub_pid) && $pid == $row[0] && !$tmp) {
                    $retval .= "selected";
                    $tmp = 1;
                } elseif ($item["default_value"] == $row[0] && !$tmp) {
                    $retval .= "selected";
                    $tmp = 1;
                }
                $retval .= '>' . htmlspecialchars((empty($row[1]) ? $row[0] : $row[1]), ENT_QUOTES, $site_encoding) . '</option>';
            }
            $retval .= '</select><br>';
            break;
        case "dbselect_tree":
            $retval .= '<select name="' . $item["name"] . '">';
            if ($item["required"] <> 1) {
                $retval .= '<option value="' . $item["default_value"] . '">' . $admin_texts[$lang]['select'] . '...</option>';
            }
            $retval .= dbselect_tree_options($item["select_list"], $item, $values, $sub_pid, $pid, $tmp);
            $retval .= '</select><br>';
            break;
        case "checkbox":
            // get ids and corresponding values
            $myvalues = array();
            $myvalues = $item["select_list"];
            //selected values
            if (isset($values[$item["name"]])) {
                $select_options = explode("|", $values[$item["name"]]);
            } else {
                $select_options = array();
            }

            // loop all the values, check against selected
            reset($myvalues);
            $tmp = 0;
            foreach ($myvalues as $key => $val) {
                $retval .= '<input type="Checkbox" name="' . $item["name"] . '[]" value="' . htmlspecialchars(stripslashes($key), ENT_QUOTES, $site_encoding) . '" ';
                if (in_array($key, $select_options)) {
                    $retval .= "checked";
                    $tmp = 1;
                } elseif ($item["default_value"] == $key && !$tmp) {
                    $retval .= "checked";
                }
                $retval .= ' id="' . $item["name"] . $key . '" style="width: auto;"><label for="' . $item["name"] . $key . '"> ' . htmlspecialchars(stripslashes($val), ENT_QUOTES, $site_encoding) . '</label> &nbsp;&nbsp;';
            }
            $retval .= '<br>';
            break;
        case "checkbox_dbmultiple":
            // get ids and corresponding values
            $myvalues = array();
            $MyResult = query($item["select_list"]);
            while ($row = mysqli_fetch_row($MyResult)) {
                $myvalues[$row[0]] = $row[1];
            }
            //selected values
            if (isset($values[$item["name"]])) {
                $select_options = explode("|", $values[$item["name"]]);
            } else {
                $select_options = array();
            }

            // loop all the values, check against selected
            reset($myvalues);
            $tmp = 0;
            foreach ($myvalues as $key => $val) {
                $retval .= '<input type="Checkbox" name="' . $item["name"] . '[]" value="' . htmlspecialchars(stripslashes($key), ENT_QUOTES, $site_encoding) . '" ';
                if (in_array($key, $select_options)) {
                    $retval .= "checked";
                    $tmp = 1;
                } elseif ($item["default_value"] == $key && !$tmp) {
                    $retval .= "checked";
                }
                $retval .= ' id="' . $item["name"] . $key . '" style="width: auto;"><label for="' . $item["name"] . $key . '"> ' . htmlspecialchars(stripslashes($val), ENT_QUOTES, $site_encoding) . '</label> &nbsp;&nbsp;';
            }
            $retval .= '<br>';
            break;
        case "select_dbmultiple":
            // get ids and corresponding values
            $retval .= '<select name="' . $item["name"] . '[]" multiple size="5">';

            $myvalues = array();
            $MyResult = query($item["select_list"]);
            while ($row = mysqli_fetch_row($MyResult)) {
                $myvalues[$row[0]] = $row[1];
            }
            //selected values
            if (isset($values[$item["name"]])) {
                $select_options = explode("|", $values[$item["name"]]);
            } else {
                $select_options = array();
            }

            // loop all the values, check against selected
            reset($myvalues);
            $tmp = 0;
            foreach ($myvalues as $key => $val) {
                $retval .= '<option value="' . htmlspecialchars(stripslashes($key), ENT_QUOTES, $site_encoding) . '" ';
                if (in_array($key, $select_options)) {
                    $retval .= "selected";
                    $tmp = 1;
                } elseif ($item["default_value"] == $key && !$tmp) {
                    $retval .= "selected";
                }
                $retval .= '>' . htmlspecialchars(stripslashes($val), ENT_QUOTES, $site_encoding) . '</option>';
            }
            $retval .= '</select><br>';
            break;
        case "checkbox_dbmultiple_ext_table":
            // get ids and corresponding values
            $myvalues = array();
            $MyResult = query($item["select_list"]);
            while ($row = mysqli_fetch_row($MyResult)) {
                $myvalues[$row[0]] = $row[1];
            }
            //selected values
            $select_options = array();
            $MyResult = query("select `" . $item["select_relations"]["relation_column_name"] . "` from `" . $item["select_relations"]["table"] . "` where `" . $item["select_relations"]["this_column_name"] . "` = '" . $values["id"] . "'");
            while ($row = mysqli_fetch_row($MyResult)) {

                $select_options[] = $row[0];
            }

            // loop all the values, check against selected
            reset($myvalues);
            $tmp = 0;
            foreach ($myvalues as $key => $val) {
                $retval .= '<input type="Checkbox" name="' . $item["name"] . '[]" value="' . htmlspecialchars(stripslashes($key), ENT_QUOTES, $site_encoding) . '" ';
                if (in_array($key, $select_options)) {
                    $retval .= "checked";
                    $tmp = 1;
                } elseif ($item["default_value"] == $key && !$tmp) {
                    $retval .= "checked";
                }
                $retval .= ' id="' . $item["name"] . $key . '" style="width: auto;"><label for="' . $item["name"] . $key . '"> ' . htmlspecialchars(stripslashes($val), ENT_QUOTES, $site_encoding) . '</label> &nbsp;&nbsp;';
            }
            $retval .= '<br>';
            break;
        case "select_dbmultiple_ext_table":
            // get ids and corresponding values
            $retval .= '<select name="' . $item["name"] . '[]" multiple size="5">';

            $myvalues = array();
            $MyResult = query($item["select_list"]);
            while ($row = mysqli_fetch_row($MyResult)) {
                $myvalues[$row[0]] = $row[1];
            }
            //selected values
            $select_options = array();
            $MyResult = query("select `" . $item["select_relations"]["relation_column_name"] . "` from `" . $item["select_relations"]["table"] . "` where `" . $item["select_relations"]["this_column_name"] . "` = '" . $item["name"] . "'");
            while ($row = mysqli_fetch_row($MyResult)) {
                $select_options[] = $row[0];
            }

            // loop all the values, check against selected
            reset($myvalues);
            $tmp = 0;
            foreach ($myvalues as $key => $val) {
                $retval .= '<option value="' . htmlspecialchars(stripslashes($key), ENT_QUOTES, $site_encoding) . '" ';
                if (in_array($key, $select_options)) {
                    $retval .= "selected";
                    $tmp = 1;
                } elseif ($item["default_value"] == $key && !$tmp) {
                    $retval .= "selected";
                }
                $retval .= '>' . htmlspecialchars(stripslashes($val), ENT_QUOTES, $site_encoding) . '</option>';
            }
            $retval .= '</select><br>';
            break;
        case "image":
//			echo $values[$item["name"]];
            if (!empty($values[$item["name"]])) {
                $img_path = $values[$item["name"]];
                //if($item["name"] == 'photo_orig' and file_exists('../' . $values["photo_big"])) {
                //	$img_path = $values["photo_big"];
                //}
                echo '<br><img style="width:auto; max-width:300px" src="' . (isset($item["path"]) ? $item["path"] : "../") . $img_path . '" border="0" alt="" style="border: 1px solid #000000;"><input type="Checkbox" name="files_delete[' . $item["name"] . ']" value="1" style="width: auto;" id="check_' . $item["name"] . '"><label for="check_' . $item["name"] . '"> ' . $admin_texts[$lang]['delete_image'] . '</label><br>';
            }
            $retval .= '<input type="File" name="' . $item["name"] . '">';
            if (!empty($values[$item["name"]])) {
//				$retval .= $values[$item["name"]];
            }
            $retval .= '<br>';
            break;
        case "file":
            if (!empty($values[$item["name"]])) {
                $retval .= '<a href="' . (isset($item["path"]) ? $item["path"] : "../") . $values[$item["name"]] . '" target="_blank">' . round(filesize((isset($item["path"]) ? $item["path"] : "../") . $values[$item["name"]]) / 1024) . ' KB</a><input type="Checkbox" name="files_delete[' . $item["name"] . ']" value="1" style="width: auto;"> ' . $admin_texts[$lang]['delete'] . '<br>';
                $retval .= $values[$item["name"]] . "<br>";
            }
            $retval .= '<input type="File" name="' . $item["name"] . '">';
            $retval .= '<br>';
            break;

        case "div":
            $retval .= '<div id="' . $item["name"] . '">';

            if (!empty($values[$item["name"]]) && $item["name"] == 'model') {
                $retval .= implode('', file($site_path . '/ajax.php?req=modeli&marka_id=' . $values["marka"] . '&selected=' . $values['model']));
            }

            $retval .= '</div>';
            break;

        default: break;
    }

    return $retval;
}

function commit($fields_to_manage, $table)
{
    global $arr_allow_file_types, $admin_texts, $lang;

    $err = '';

    $myquery = '';
    $myquery_exec_later = array();
    $myquery_exec_later_more = array();

    $auto = array();
    $id = filter_input(INPUT_POST, "editID", FILTER_VALIDATE_INT, ['options' => ['default' => 0, 'min_range' => 1]]);

    foreach ($fields_to_manage as $key => $item) {
        if ($item["type"] <> 'auto' and $item["type"] <> 'image' and $item["type"] <> 'file') {
            if ($item["type"] == "date" || $item["type"] == "datetime" || $item["type"] == "datemonth") {
                if ($item["type"] == "datemonth") {
                    $_POST[$item["name"] . "day"] = '01';
                }
                $_POST[$item["name"]] = $_POST[$item["name"] . "year"] . "-" . $_POST[$item["name"] . "month"] . "-" . $_POST[$item["name"] . "day"] . "";
                if ($item["type"] == "datetime") {
                    $_POST[$item["name"]] .= " " . $_POST[$item["name"] . "hour"] . ":" . $_POST[$item["name"] . "minute"] . ":00";
                }
                //echo $_POST[$item["name"]];
            }
            if ($item["type"] == "password" && !preg_match('/^\$2y\$10\$.{53,248}$/', $_POST[$item["name"]])) {
                $_POST[$item["name"]] = password_hash($_POST[$item["name"]], PASSWORD_DEFAULT);
            }
            if ($item["required"] == 1) {
                if (!isset($_POST[$item["name"]]) || (isset($_POST[$item["name"]]) && $_POST[$item["name"]] == '')) {
                    $err .= "" . $item["title"] . "" . $admin_texts[$lang]["is_required"] . ".<br>";
                }
            }
            if (empty($_POST[$item["name"]]) && isset($item["null_if_empty"]) && $item["null_if_empty"]) {
                $_POST[$item["name"]] = "NULL";
            }
            if (!empty($item["unique"])) {
                if (!empty($_POST[$item["name"]])) {
                    $mysexquery = "select count(*) from `$table` where `" . $item["name"] . "` = '" . $_POST[$item["name"]] . "' " . (!empty($id) ? " and id != '$id'" : '');
                    $MySexResult = query($mysexquery);
                    $sexrow = mysqli_fetch_row($MySexResult);
                    if ($sexrow[0] > 0) {
                        $err .= "" . $item["title"] . " " . $admin_texts[$lang]["is_unique"] . " '" . $_POST[$item["name"]] . "'.<br>";
                    }
                }
            }
            switch ($item["check_type"]) {
                case "text_nohtml":
                    if (preg_match("/(<\/?)(\w+)([^>]*>)/", $_POST[$item["name"]])) {
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                    break;
                case "text_html":
                    if (preg_match("/(\<object|\<embed|\<style|\<script|\<\!\-\-|\-\-\>)/", $_POST[$item["name"]])) {
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                    break;
                case "email":
                    if (!validate_email($_POST[$item["name"]])) {
                        $err .= "" . $admin_texts[$lang]["is_invalid_email"] . " " . $item["title"] . "<br>";
                    }
                    break;
                case "date":
                    if (!empty($_POST[$item["name"]]) && $_POST[$item["name"]] <> '0000-00-00' && $_POST[$item["name"]] <> '0000-00-00 00:00:00' && !check_date($_POST[$item["name"]])) {
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                    break;
                case "datetime_blank":
                    if (!empty($_POST[$item["name"]]) && !check_date($_POST[$item["name"]])) {
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                    break;
                case "int_pos_null":
                    if (!empty($_POST[$item["name"]]) && !preg_match("/^([0-9]+)|NULL$/", $_POST[$item["name"]])) {
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                    break;
                case "int_pos_notnull":
                    if (empty($_POST[$item["name"]]) || !preg_match("/^([0-9]+)$/", $_POST[$item["name"]])) {
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                    break;
                case "float_pos_notnull":
                    $_POST[$item["name"]] = str_replace(',', '.', $_POST[$item["name"]]);
                    if (empty($_POST[$item["name"]]) || !preg_match("/^[0-9]+(\.[0-9]+)?$/", $_POST[$item["name"]])) {
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                    break;
            }
            if (!empty($item["check_value"]) && !empty($_POST[$item["name"]])) {
                if (substr($item["check_value"], 0, 1) == '/') {
                    if (!preg_match('/' . preg_replace("'", "\'", $item["check_value"]) . '/', $_POST[$item["name"]])) {
                        //echo $item["check_value"] . '<br>' . $_POST[$item["name"]] . '<br>';
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                } else {
                    $pattern = '/^' . $item["check_value"] . '$/';
                    if (!preg_match($pattern, $_POST[$item["name"]])) {
                        //echo $item["check_value"] . '<br>' . $_POST[$item["name"]] . '<br>';
                        $err .= "" . $admin_texts[$lang]["is_invalid"] . " " . $item["title"] . "<br>";
                    }
                }
            }

            if (is_array($_POST[$item["name"]])) {

                $tmp3 = '';
                foreach ($_POST[$item["name"]] as $tmp1 => $tmp2) {
                    $tmp3 .= $tmp2 . "|";
                }
//				$tmp3 = substr($tmp3, 0, -1);
                if (!empty($tmp3)) {
                    $tmp3 = "|" . $tmp3;
                }

                if (!empty($item["external_table"])) {
                    if (empty($myquery_exec_later[$item["external_table"]])) {
                        $myquery_exec_later[$item["external_table"]] = "`" . $item["external_table"] . "` set `" . $item["name"] . "` = '" . $tmp3 . "'";
                    } else {
                        $myquery_exec_later[$item["external_table"]] .= ", `" . $item["name"] . "` = '" . $tmp3 . "'";
                    }
                } elseif (!empty($item["select_relations"]["table"])) { // za relations
                    $myquery_exec_later_more[] = "delete from `" . $item["select_relations"]["table"] . "` where `" . $item["select_relations"]["this_column_name"] . "` = '###id###'";

                    foreach ($_POST[$item["name"]] as $tmp1 => $tmp2) {
                        $myquery_exec_later_more[] = "insert into `" . $item["select_relations"]["table"] . "` (`" . $item["select_relations"]["this_column_name"] . "`, `" . $item["select_relations"]["relation_column_name"] . "`) values ('###id###', '$tmp2')";
                    }
                } else {
                    $myquery .= "`" . $item["name"] . "` = '" . $tmp3 . "', ";
                }
            } else {
                if (!empty($item["external_table"])) {
                    if (empty($myquery_exec_later[$item["external_table"]])) {
                        $myquery_exec_later[$item["external_table"]] = "`" . $item["external_table"] . "` set `" . $item["name"] . "` = '" . $_POST[$item["name"]] . "'";
                    } else {
                        $myquery_exec_later[$item["external_table"]] .= ", `" . $item["name"] . "` = '" . $_POST[$item["name"]] . "'";
                    }
                } else {
                    $myquery .= "`" . $item["name"] . "` = " . (($_POST[$item["name"]] === 'NULL') ? "NULL" : "'" . $_POST[$item["name"]] . "'") . ", ";
                }
            }
        } elseif ($item["type"] == 'auto') {
            $auto[$item["name"]] = (array_key_exists("reverse", $item) && $item['reverse']) ? true : false;
        } elseif ($item["type"] == 'image' or $item["type"] == 'file') {
            if (!empty($_FILES[$item["name"]]["tmp_name"]) && is_uploaded_file($_FILES[$item["name"]]["tmp_name"])) {
                $pic_expl = explode(".", $_FILES[$item["name"]]["name"]);
                $extension = strtolower(array_pop($pic_expl));

                $err .= check_file_extension($_FILES[$item["name"]]["name"], $item);

                if ($extension == 'zip') {
                    $zip = zip_open($_FILES[$item["name"]]["tmp_name"]);

                    if (is_resource($zip)) {
                        while ($zip_entry = zip_read($zip)) {
                            $err .= check_file_extension(zip_entry_name($zip_entry), $item, strtoupper($extension) . ' ERROR: ');
                        }
                        zip_close($zip);
                    } else {
                        $err .= strtoupper($extension) . ' ' . $admin_texts[$lang]["archive_open_failed"];
                    }
                } elseif ($extension == 'rar') {
                    $err .= 'Error rar file!';
                }
                $copyDIR = (isset($item["path"]) ? $item["path"] : "../") . $item["upload_dir"];
                if (!is_dir($copyDIR)) {
                    $tmp_res = mkdir($copyDIR, 0777);
                    if (!$tmp_res) {
                        $err .= "" . $admin_texts[$lang]["is_mkdir"] . " " . $copyDIR . ".<br>";
                    }
                }
                if (!empty($item["max_size"])) {
                    if (filesize($_FILES[$item["name"]]["tmp_name"]) > ($item["max_size"] * 1024)) {
                        $err .= '' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') , ' . $admin_texts[$lang]["is_big"] . ' ' . $item["max_size"] . ' KB<br>';
                    }
                }

                if (!empty($item["keep_orig_name"])) {
                    $copyURL = $item["upload_dir"] . "/" . $_FILES[$item["name"]]["name"];

                    $mysexquery = "select count(*) from `$table` where `" . $item["name"] . "` = '" . mysqli_real_escape_string($sqlConn, $copyURL) . "' " . (!empty($id) ? " and id != '$id'" : '');
                    $MySexResult = query($mysexquery);
                    $sexrow = mysqli_fetch_row($MySexResult);
                    if ($sexrow[0] > 0) {
                        $err .= "" . $item["title"] . " " . $admin_texts[$lang]["is_unique"] . " '" . $_FILES[$item["name"]]["name"] . "'.<br>";
                    }
                }

                if ($item["type"] == 'image') {
                    if (!empty($item["check_width"]) or ! empty($item["check_height"]) or ! empty($item["check_maxwidth"]) or ! empty($item["check_minwidth"]) or ! empty($item["check_maxheight"]) or ! empty($item["check_propotion"])) {
                        $img_size = getimagesize($_FILES[$item["name"]]["tmp_name"]);
                        if (!empty($item["check_width"]) && $img_size[0] <> $item["check_width"]) {
                            $err .= '' . $admin_texts[$lang]["width_of"] . ' ' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $item["check_width"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[0] . 'px.<br>';
                        } elseif (!empty($item["check_maxwidth"]) && $img_size[0] > $item["check_maxwidth"]) {
                            $err .= '' . $admin_texts[$lang]["width_of"] . ' ' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $admin_texts[$lang]["maximum"] . ' ' . $item["check_maxwidth"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[0] . 'px.<br>';
                        } elseif (!empty($item["check_minwidth"]) && $img_size[0] < $item["check_minwidth"]) {
                            $err .= '' . $admin_texts[$lang]["width_of"] . ' ' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $admin_texts[$lang]["minimum"] . ' ' . $item["check_minwidth"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[0] . 'px.<br>';
                        }
                        if (!empty($item["check_height"]) && $img_size[1] <> $item["check_height"]) {
                            $err .= '' . $admin_texts[$lang]["height_of"] . ' ' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $item["check_height"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[1] . 'px.<br>';
                        } elseif (!empty($item["check_maxheight"]) && $img_size[1] > $item["check_maxheight"]) {
                            $err .= '' . $admin_texts[$lang]["height_of"] . ' ' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $admin_texts[$lang]["maximum"] . ' ' . $item["check_maxheight"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[1] . 'px.<br>';
                        } elseif (!empty($item["check_minheight"]) && $img_size[1] < $item["check_minheight"]) {
                            $err .= '' . $admin_texts[$lang]["height_of"] . ' ' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $admin_texts[$lang]["minimum"] . ' ' . $item["check_minheight"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[1] . 'px.<br>';
                        }
                        if (!empty($item["check_propotion"]) && ($img_size[0] / $img_size[1] <> $item["check_propotion"])) {
                            $err .= '' . $admin_texts[$lang]["propotion_of"] . ' ' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $item["check_propotion"] . '.<br>';
                        }
                    }
                }
            } else {
                if ($item["required"] == 1) {
                    if (!$id || !empty($_POST["files_delete"][$item["name"]])) {
                        $err .= "" . $item["title"] . "" . $admin_texts[$lang]["is_required"] . ".<br>";
                    }
                }
            }
        }
    }

    if (array_key_exists('showorder', $auto)) {
        if (!$id) {
            if ($auto['showorder'] !== true) { //ако не сме сетанли reverse = true
                $myquery1 = "select max(showorder) from `$table` ";
                //if(in_array('level', $auto)) {
                if (check_field_exists($table, 'pid')) {
                    $myquery1 .= " where pid = '" . $_POST["pid"] . "'";
                }
                $MyResult1 = query($myquery1);
                $row1 = mysqli_fetch_row($MyResult1);
                $showorder = $row1[0];
                $showorder++;
            } else {
                $showorder = 0;
            }
            $myquery .= "showorder = '$showorder', ";
        }
    }
    if (array_key_exists('novinite_order', $auto)) {
        if (!$id) {
            $novinite_order = 0;
            $myquery1 = "select max(novinite_order) from `$table` ";
            if (in_array('level', $auto)) {
                $myquery1 .= " where pid = '" . $_POST["pid"] . "'";
            }
            $MyResult1 = query($myquery1);
            while ($row1 = mysqli_fetch_row($MyResult1)) {
                $novinite_order = $row1[0];
            }
            $novinite_order++;
            $myquery .= "novinite_order = '$novinite_order', ";
        }
    }


    if (!empty($err)) {
        return(array(false, $err));
    }

    if (!empty($myquery)) {
        $myquery = substr($myquery, 0, -2);

        if ($id) {
            $myquery = "update `$table` set $myquery where id = '$id'";
            reset($myquery_exec_later);
            foreach ($myquery_exec_later as $key => $val) {
                $myquery_exec_later[$key] = "update " . $val . " where id = '$id'";
            }
        } else {
            $myquery = "insert into `$table` set $myquery";
        }
        //echo $myquery . "<br>";

        $MyResult = query($myquery);

        if (!$id) {
            $mysecquery = "select last_insert_id()";
            $MySecResult = query($mysecquery);
            while ($row = mysqli_fetch_row($MySecResult)) {
                $id = $row[0];
            }
            reset($myquery_exec_later);
            foreach ($myquery_exec_later as $key => $val) {
                $myquery_exec_later[$key] = "insert into " . $val . ", id = '$id'";
            }
        }

        foreach ($myquery_exec_later as $key => $val) {
            query($val);
        }

        foreach ($myquery_exec_later_more as $key => $val) {
            $val = str_replace("###id###", $id, $val);
            query($val);
        }

        if (array_key_exists('has_children', $auto)) {
            content_fix_children($table);
        }
        if (array_key_exists('showorder', $auto)) {
            if (check_field_exists($table, 'pid')) {
                $myq = " SELECT pid FROM `" . $table . "` WHERE id='" . $id . "'";
                $row = mysqli_fetch_row(query($myq));
                $pid = $row[0];
            } else if (check_field_exists($table, 'parent_id')) {
                $myq = " SELECT parent_id FROM `" . $table . "` WHERE id='" . $id . "'";
                $row = mysqli_fetch_row(query($myq));
                $pid = $row[0];
            } else {
                $pid = 0;
            }
            content_fix_showorder($table, $pid);
        }
    }
    // Upload images and files
    //print_r($fields_to_manage);
    reset($fields_to_manage);
    foreach ($fields_to_manage as $key => $item) {
        if ($item["type"] == 'image' or $item["type"] == 'file') {
            // Delete file if needed
            if ($id && !empty($_POST["files_delete"][$item["name"]])) {
                $mysecquery = "select `" . $item["name"] . "` from `$table` where id = '$id'";
                $MySecResult = query($mysecquery);
                $row = mysqli_fetch_row($MySecResult);
                $oldfile = (isset($item["path"]) ? $item["path"] : "../") . $row[0];
                if (file_exists($oldfile)) {
                    unlink($oldfile);
                }
                $my3query = "update `$table` set `" . $item["name"] . "` = '' where id = '$id'";
                $My3Result = query($my3query);

                if (!empty($item["auto_images"]) && count($item["auto_images"]) > 0) {

                    foreach ($item["auto_images"] as $auto_key => $auto_val) {
                        $auto_tmp = explode("|", $auto_val);
                        if (!empty($auto_tmp[0])) {
                            $mysecquery = "select `" . $auto_tmp[0] . "` from `$table` where id = '$id'";
                            $MySecResult = query($mysecquery);
                            $row = mysqli_fetch_row($MySecResult);
                            $oldfile = (isset($item["path"]) ? $item["path"] : "../") . $row[0];
                            if (file_exists($oldfile)) {
                                unlink($oldfile);
                            }
                            $my3query = "update `$table` set `" . $auto_tmp[0] . "` = '' where id = '$id'";
                            $My3Result = query($my3query);
                        }
                    }
                }
            }
            // Upload
            if (!empty($_FILES[$item["name"]]["tmp_name"]) && is_uploaded_file($_FILES[$item["name"]]["tmp_name"])) {
                $pic_expl = explode(".", $_FILES[$item["name"]]["name"]);
                $extension = strtolower(array_pop($pic_expl));
                $copyDIR = (isset($item["path"]) ? $item["path"] : "../");

                if (!empty($item["keep_orig_name"])) {
                    $copyURL = $item["upload_dir"] . "/" . $_FILES[$item["name"]]["name"];
                } else {
                    //$copyURL = $item["upload_dir"] . "/" . $item["name"] . "_$id.$extension";
                    $copyURL = $item["upload_dir"] . "/" . $id . '_' . getRandomString(8) . "." . $extension;
                }

                if ($id) {
                    $my3query = "select `" . $item["name"] . "` from `$table` where id = '$id'";
                    $My3Result = query($my3query);
                    while ($row3 = mysqli_fetch_row($My3Result)) {
                        $oldfile = $copyDIR . $row3[0];
                        if (file_exists($oldfile)) {
                            @unlink($$oldfile);
                        }
                    }
                }
                $tmp_res = copy($_FILES[$item["name"]]["tmp_name"], $copyDIR . $copyURL);
                if (!$tmp_res) {
                    $err .= 'Cannot copy file ' . $item["title"] . '(' . $_FILES[$item["name"]]["name"] . ') into ' . $copyURL . '. Please call webmaster.<br>';
                    return(array(false, $err));
                } else {
                    $my3query = "update `$table` set `" . $item["name"] . "` = '" . $copyURL . "'";
                    if ($item["type"] == 'image' && !empty($item["writesize"])) {
                        $img_size = getimagesize($copyDIR . $copyURL);
                        $my3query .= "`" . $item["name"] . "x` = '" . $img_size[0] . "', `" . $item["name"] . "y` = '" . $img_size[1] . "'";
                    }
                    $my3query .= " where id = '$id'";
                    $My3Result = query($my3query);
                }

                //  + auto images
                if ($item["type"] == 'image' && isset($item["auto_images"])) {
                    reset($item["auto_images"]);

                    foreach ($item["auto_images"] as $not_important => $auto_image) {
                        /*
                         * ако искаме името да е едно тук трябва да го правим
                         */
                        //$newfilename = $id . '_' . getRandomString(8);
                        //if (preg_match('/[0-9]+/', $img_params[0], $m)) {
                        //    $newfilename .= '_' . $m[0];
                        //}
                        if ($extension == 'jpg' || $extension == 'jpeg') {
                            $im_src = imagecreatefromjpeg($copyDIR . $copyURL);
                        } elseif ($extension == 'gif') {
                            $im_src = imagecreatefromgif($copyDIR . $copyURL);
                        } elseif ($extension == 'png') {
                            $im_src = imagecreatefrompng($copyDIR . $copyURL);
                        } else {
                            break;
                        }
                        $img_src_size = getimagesize($copyDIR . $copyURL);
                        // [0] -> name, [1] -> width, [2] -> height, [3] -> propotion, [4] -> writesize, [5] -> optional-olny-if-size-allows, [6] -> 0: just resize; 1: crop; 2: resize and toggle width/height if portrait; 3: crop bez riazane a chrez dobaviane na prazno mqsto; 4: resize without messing up the propotion - width and height are maximum values, [7] -> watermark
                        $img_params = explode("|", $auto_image);
                        $src_propotion = $img_src_size[0] / $img_src_size[1];

                        if ($img_params[6] == 2) { // desired width becomes desired height
                            if ($img_src_size[0] < $img_src_size[1]) { // only if img orientation is portrait
                                $tmp = $img_params[2];
                                $img_params[2] = $img_params[1];
                                $img_params[1] = $tmp;
                            }
                        }
                        if ($img_params[6] == 4) { // resize without messing up the propotion - width and height are maximum values
                            $tmp_height = round($img_src_size[1] * ($img_params[1] / $img_src_size[0])); // height if resized by fixed width: round(original_height*(desired_width/original_width))
                            $tmp_width = round($img_src_size[0] * ($img_params[2] / $img_src_size[1])); // width if resized by fixed height: round(original_width*(desired_height/original_height))
                            //echo '<br>If Height: ' . $tmp_height . '<br>If width: ' . $tmp_width . '<br>';
                            if ($tmp_height <= $img_params[2]) {
                                $img_params[2] = '';
                            } else {
                                $img_params[1] = '';
                            }
                        }
                        // width
                        if (!empty($img_params[1])) {
                            $new_width = $img_params[1];
                        } elseif (!empty($img_params[3])) {
                            $new_width = $img_src_size[0] * $img_params[1];
                        } elseif (!empty($img_params[2])) {
                            $new_width = round($img_src_size[0] * ($img_params[2] / $img_src_size[1]));
                        } else {
                            $err .= 'Invalid parameters: no width defined for auto image ' . $item["title"] . ' - ' . $not_important . '(' . $_FILES[$item["name"]]["name"] . '). Please call webmaster.<br>';
                            return(array(false, $err));
                        }
                        // height
                        if (!empty($img_params[2])) {
                            $new_height = $img_params[2];
                        } elseif (!empty($img_params[3])) {
                            $new_height = $img_src_size[1] * $img_params[2];
                        } elseif (!empty($img_params[1])) {
                            $new_height = round($img_src_size[1] * ($img_params[1] / $img_src_size[0]));
                        } else {
                            $err .= 'Invalid parameters: no height defined for auto image ' . $item["title"] . ' - ' . $not_important . '(' . $_FILES[$item["name"]]["name"] . '). Please call webmaster.<br>';
                            return(array(false, $err));
                        }
                        if (empty($img_params[5]) || (!empty($img_params[5]) && $new_width <= $img_src_size[0] && $new_height <= $img_src_size[1])) { // if not optional || optional and new_width <= orig_width and new_height <= orig_height
                            $im_dst = imagecreatetruecolor($new_width, $new_height);
                            // echo $new_width . ' ' . $new_height . ' ' . $img_params[1] . ' ' . $img_params[2] . "<br>";
                            if (empty($img_params[6]) || $img_params[6] == 2) { // simple resize
                                imagecopyresampled($im_dst, $im_src, 0, 0, 0, 0, $new_width, $new_height, $img_src_size[0], $img_src_size[1]);
                            } elseif ($img_params[6] == 1) { // crop, not simple resize
                                // default values
                                $desired_width = $img_params[1];
                                $desired_height = $img_params[2];
                                $cropped_x = 0;
                                $cropped_y = 0;
                                // ako nishto ne stane, neka se namachka, pa kfoto shte da stava
                                $cropped_width = $img_src_size[0];
                                $cropped_height = $img_src_size[1];
                                // start
                                $desired_propotion = $new_width / $new_height;
                                //echo 'D: ' . $desired_propotion . " O: " . $src_propotion . " ";
                                if ($src_propotion < $desired_propotion) { // shte se crop-va po shirochina
                                    $cropped_height = round($img_src_size[0] / $desired_propotion); // novata visochina = shirochina / iskana proporcia
                                    $cropped_y = ($img_src_size[1] - $cropped_height) / 2; // da hvane sredata
                                } else { // shte crop-vam po visochina
                                    $cropped_width = round($img_src_size[1] * $desired_propotion); // novata shirochina = visochina * iskana proporcia
                                    $cropped_x = ($img_src_size[0] - $cropped_width) / 2; // da hvane sredata
                                }
                                //echo 'W: ' . $cropped_width . " H: " . $cropped_height . ' X: ' . $cropped_x . " Y: " . $cropped_y;
                                $im_cropped = imagecreatetruecolor($cropped_width, $cropped_height);
                                imagecopy($im_cropped, $im_src, 0, 0, $cropped_x, $cropped_y, $cropped_width, $cropped_height);
                                imagecopyresampled($im_dst, $im_cropped, 0, 0, 0, 0, $new_width, $new_height, $cropped_width, $cropped_height);
                            } elseif ($img_params[6] == 3) { // crop, but without cutting part of image
                                // default values
                                $cropped_x = 0;
                                $cropped_y = 0;
                                // ako nishto ne stane, neka se namachka, pa kfoto shte da stava
                                $cropped_width = $img_src_size[0];
                                $cropped_height = $img_src_size[1];
                                // start
                                $desired_propotion = $new_width / $new_height;
                                //echo "new_width/new_height: $new_width/$new_height <br>";
                                //echo 'D: ' . $desired_propotion . " O: " . $src_propotion . " ";
                                if ($src_propotion < $desired_propotion) { // shte se resizene po shirochina i shte se dobavi space na visochnina // vmesto da: crop-va po shirochina
                                    $cropped_width = round($img_src_size[1] * $desired_propotion); // novata shirochina = visochina * iskana proporcia
                                    $cropped_x = ($cropped_width - $img_src_size[0]) / 2; // da hvane sredata
                                } else { // 
                                    $cropped_height = round($img_src_size[0] / $desired_propotion); // novata visochina = shirochina / iskana proporcia
                                    $cropped_y = ($cropped_height - $img_src_size[1]) / 2; // da hvane sredata
                                }
                                //echo 'W: ' . $cropped_width . " H: " . $cropped_height . ' X: ' . $cropped_x . " Y: " . $cropped_y . "<br>";
                                $im_cropped = imagecreatetruecolor($cropped_width, $cropped_height);
                                $bgcolor = imagecolorat($im_src, 1, 1);
                                imagefilledrectangle($im_cropped, 0, 0, $cropped_width, $cropped_height, $bgcolor);
                                imagecopy($im_cropped, $im_src, $cropped_x, $cropped_y, 0, 0, $img_src_size[0], $img_src_size[1]);
                                imagecopyresampled($im_dst, $im_cropped, 0, 0, 0, 0, $new_width, $new_height, $cropped_width, $cropped_height);
                            }
                            imagedestroy($im_src);
                            if (isset($im_cropped)) {
                                imagedestroy($im_cropped);
                            }
                            if (!empty($img_params[7]) && file_exists($img_params[7])) {
                                $pic_expl1 = explode(".", $img_params[7]);
                                $wm_extension = strtolower(array_pop($pic_expl1));
                                if ($wm_extension == 'png') {
                                    $im_wm = imagecreatefrompng($img_params[7]);
                                    imageAlphaBlending($im_wm, true);
                                    imageSaveAlpha($im_wm, true);
                                } else {
                                    $im_wm = false;
                                }
                                if ($im_wm) {
                                    $wm_x = imagesx($im_wm);
                                    $wm_y = imagesy($im_wm);
                                    $dst_x = $new_width - $wm_x - 0;
                                    $dst_y = $new_height - $wm_y - 0;
                                    imagecopy($im_dst, $im_wm, $dst_x, $dst_y, 0, 0, $wm_x, $wm_y);
                                    imagedestroy($im_wm);
                                } else {
                                    echo 'Failed WM';
                                }
                            }

                            /*
                             * ако искаме името да е различно за всяка картинка
                             */
                            $newfilename = $id . '_' . getRandomString(8);
                            if (preg_match('/[0-9]+/', $img_params[0], $m)) {
                                $newfilename .= '_' . $m[0];
                            }
                            if (preg_match('/[0-9]+/', $img_params[1], $m)) {
                                $newfilename .= 'x' . $m[1];
                            }
                            $autocopyDIR = (isset($item["path"]) ? $item["path"] : "../");
                            $autocopyURL = $item["upload_dir"] . "/" . $newfilename . ".jpg";
                            imagejpeg($im_dst, $autocopyDIR . $autocopyURL, 95);
                            imagedestroy($im_dst);
                            $my3query = "update `$table` set `" . $img_params[0] . "` = '" . $autocopyURL . "'";
                            if ($item["type"] == 'image' && $img_params[4] == '1') {
                                $img_size = getimagesize($copyDIR . $copyURL);
                                $my3query .= "`" . $img_params[0] . "x` = '" . $new_width . "', `" . $img_params[0] . "y` = '" . $new_height . "'";
                            }
                            $my3query .= " where id = '$id'";
                            //echo $my3query;
                            $My3Result = query($my3query);
                        }
                    }
                }
            } else {
                if (!empty($_FILES[$item["name"]]["error"])) {
                    switch ($_FILES[$item["name"]]["error"]) {
                        case 0: //no error; possible file attack!
                            //$err .= "������� � ��������� �� �����";
                            break;
                        case 1: //
                            //$err .= "uploaded file exceeds the upload_max_filesize directive in php.ini";
                            break;
                        case 2: //
                            //$err .= "uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form";
                            break;
                        case 3: //
                            //$err .= "uploaded file was only partially uploaded";
                            break;
                        case 4: //
                            // echo "no file was uploaded";
                            break;
                        default: //a default error, just in case!  :)
                            // $err .= "There was a problem with your upload.";
                            break;
                    }
                }
            }
        }
    }
    if (empty($err)) {
        return(array(true, $id));
    } else {
        return(array(false, $err));
    }
}

function content_fix_children($table)
{
    $myquery = "update `$table` set has_children = '0', level = '0'";
    $MyResult = query($myquery);
    content_fix_lvl_chld($table, 0, -1);
}

function content_fix_lvl_chld($table, $pid, $level)
{
    $myquery = "select * from `$table` where pid = '$pid' order by showorder";
    $MyResult = query($myquery);
    $myquery = "update `$table` set level = '$level'";
    if (mysqli_num_rows($MyResult) > 0) {
        $myquery .= ", has_children = '1' ";
    }
    $myquery .= " where id = '$pid'";
//	echo $myquery . "<br>";
    query($myquery);
    while ($row = mysqli_fetch_array($MyResult)) {
        content_fix_lvl_chld($table, $row["id"], $level + 1);
    }
}

function content_fix_showorder($table, $pid)
{
    if (check_field_exists($table, "showorder")) {
        if (check_field_exists($table, "pid")) {
            $myquery = "select id from `$table` where pid = '" . $pid . "' order by showorder ASC, id DESC";
        } elseif (check_field_exists($table, "parent_id")) {
            $myquery = "select id from `$table` where parent_id = '" . $pid . "' order by showorder ASC, id DESC";
        } else {
            $myquery = "select id from `$table` order by showorder ASC, id DESC";
        }
        $MyResult = query($myquery);
        if (mysqli_num_rows($MyResult) > 0) {
            $i = 1;
            while ($row = mysqli_fetch_array($MyResult)) {
                $myquery = "update `$table` set showorder = '$i' where id = '" . $row["id"] . "'";
                // echo $myquery . "<br>";
                query($myquery);
                $i++;
            }
        }
    }
}

function fixShoworderById($table, $id = null)
{
    if (check_field_exists($table, "showorder")) {
        if (check_field_exists($table, "pid")) {
            $myquery = "SELECT id, showorder "
                    . "FROM `$table` "
                    . "WHERE pid = (SELECT pid FROM `$table` WHERE id='" . mysqli_real_escape_string($sqlConn, $id) . "') "
                    . "ORDER BY showorder ASC, id DEC";
        } else {
            $myquery = "select * from `$table` order by showorder, id";
        }
        $MyResult = query($myquery);
        $i = 1;
        while ($row = mysqli_fetch_array($MyResult)) {
            $myquery = "update `$table` set showorder = '$i' where id = '" . $row["id"] . "'";
            query($myquery);
            $i++;
        }
    }
}

function dbselect_tree_options($myquery, $item, $values, $sub_pid, $pid, &$tmp)
{
    global $site_encoding;
    $retval = '';
    $MyResult = query($myquery);
    while ($row = mysqli_fetch_array($MyResult)) {
        $retval .= '<option value="' . htmlspecialchars($row[0], ENT_QUOTES, $site_encoding) . '" ';

        if (isset($row["active"]) && $row["active"] == 0) {
            $retval .= ' style="color: #C1C1C1" ';
        }

        if (isset($values[$item["name"]]) && $values[$item["name"]] == $row[0]) {
            $retval .= "selected";
            $tmp = 1;
        } elseif (($item["name"] == 'category_id' || $item["name"] == 'pid') && !empty($sub_pid) && $sub_pid == $row[0] && !$tmp) {
            $retval .= "selected";
            $tmp = 1;
        } elseif (($item["name"] == 'category_id' || $item["name"] == 'pid') && empty($sub_pid) && $pid == $row[0] && !$tmp) {
            $retval .= "selected";
            $tmp = 1;
        } elseif ($item["default_value"] == $row[0] && !$tmp) {
            $retval .= "selected";
            $tmp = 1;
        }

        $retval .= '>' . str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $row["level"]) . htmlspecialchars((empty($row[1]) ? $row[0] : $row[1]), ENT_QUOTES, $site_encoding) . '</option>';
        if ($row["has_children"] > 0 && preg_match("/(pid)( ?)(=)( ?)(')([0-9]+)(')/", $myquery, $regs)) {
            $myquery = preg_replace("/(pid)( ?)(=)( ?)(')([0-9]+)(')/", $regs[1] . $regs[2] . $regs[3] . $regs[4] . $regs[5] . $row["id"] . $regs[7], $myquery);
            //$retval .= '<option value="">' . $myquery . '</option>';
            $retval .= dbselect_tree_options($myquery, $item, $values, $sub_pid, $pid, $tmp);
        }
    }
    return($retval);
}

function write_fcontent($key, $fcontent, $ext = "html")
{
    $filename = "../static/auto_hp_" . $key . ".$ext";
    $fp = fopen($filename, "w");
    fwrite($fp, $fcontent);
    fclose($fp);
}

function generate_static_html()
{
    
}

function update_related($article_id)
{
    $myquery = "select * from articles where id = '$article_id'";
    $MyResult = query($myquery);
    while ($row = mysqli_fetch_array($MyResult)) {
        $mysexquery = "update articles_related set title1 = '" . addslashes($row["title"]) . "' where article_id1 = '$article_id'";
        $MySexResult = query($mysexquery);
        $mysexquery = "update articles_related set title2 = '" . addslashes($row["title"]) . "' where article_id2 = '$article_id'";
        $MySexResult = query($mysexquery);
    }
}

function check_user_permission($category_id, $type)
{
    if (!isset($_SESSION['m3cms']["group_id"])) {
        return 0;
    } elseif ($_SESSION['m3cms']["group_id"] == '0') {
        return 1;
    }

    $myquery = "select * from m3cms_access left join m3cms_sitemap on m3cms_access.sitemap_id = m3cms_sitemap.id where m3cms_access.group_id = '" . $_SESSION['m3cms']["group_id"] . "' and m3cms_sitemap.id = '$category_id'";
    $MyResult = query($myquery);
    while ($row = mysqli_fetch_array($MyResult)) {
        return($row[$type]);
    }

    return 0;
}

function find_rte($fields_to_manage)
{
    reset($fields_to_manage);
    foreach ($fields_to_manage as $key => $val) {
        if ($val["type"] == 'rte_full') {
            return true;
        }
    }
    return false;
}

function check_file_extension($filename, $item, $additional_text = '')
{
    global $admin_texts, $arr_allow_file_types, $lang;

    $err = '';

    $pic_expl = explode(".", $filename);
    if (count($pic_expl) <= 1) {
        $err .= $additional_text . '' . $admin_texts[$lang]["is_invalid_format"] . ' <!-- ' . $item["title"] . '( -->' . $filename . '<br>';
    }
    $extension = strtolower(array_pop($pic_expl));
    if (!isset($arr_allow_file_types[$extension])) {
        $err .= $additional_text . '' . $admin_texts[$lang]["is_invalid_format"] . ' <!-- ' . $item["title"] . '( -->' . $filename . '<br>';
    } elseif (!preg_match("/^(" . $item["check_type"] . ")$/i", $extension)) {
        $err .= $additional_text . '' . $admin_texts[$lang]["is_invalid_format"] . ' <!-- ' . $item["title"] . '( -->' . $filename . '<br>';
    }

    return $err;
}

function getRandomString($lenght = NULL, $api = FALSE)
{
    if ($api === TRUE) {
        $characters = '23456789ACDEFHJKMNPRSTWXYZ';
    } else {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    //$pool = str_split($characters);
    $string = '';
    $options = [
        "options" => [
            'default' => 6,
            "min_range" => 1,
            "max_range" => 100,
        ],
    ];
    $limit = filter_var($lenght, FILTER_VALIDATE_INT, $options);
    for ($i = 0; $i < $limit; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}
