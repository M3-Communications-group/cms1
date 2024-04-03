<?php

function query($query)
{
    global $sqlConn;
    $result = mysqli_query($sqlConn, $query);
    if (!$result) {
        $mymailcontent = $query . "\n\n";
        $mymailcontent .= "ERROR: " . mysqli_error($sqlConn) . "\n";
        $get = filter_input_array(INPUT_GET);

        if (!is_null($get) && count($get) > 0) {
            $mymailcontent .= "\nGET\n";
            foreach ($get as $key => $val) {
                $mymailcontent .= $key . ' -> "' . $val . "\"\n";
            }
        }

        $post = filter_input_array(INPUT_POST);


        if (!is_null($post) && count($post) > 0) {
            $mymailcontent .= "\nPOST\n";
            foreach ($post as $key => $val) {
                $mymailcontent .= $key . ' -> "' . $val . "\"\n";
            }
        }
        $mymailcontent .= "URL: " . filter_input(INPUT_SERVER, "HTTP_HOST") . filter_input(INPUT_SERVER, "REQUEST_URI") . "\n"
            . "REMOTE_ADDR: " . filter_input(INPUT_SERVER, "REMOTE_ADDR", FILTER_VALIDATE_IP) . "\n"
            . "X_FORWARDED_FOR: " . filter_input(INPUT_SERVER, "HTTP_X_FORWARDED_FOR", FILTER_VALIDATE_IP) . "\n"
            . "HTTP_REFERER: " . filter_input(INPUT_SERVER, "HTTP_REFERER") . "\n"
            . "\n";

        mail("martin@m3bg.com", "statehouse.gov.sc error", $mymailcontent);

        die();
    }
    return $result;
}

function get_url($current_location, $array_key, $values)
{
    foreach ($values as $key => $val) {
        if (!is_array($val)) {
            if (!empty($array_key)) {
                $current_location .= $array_key . '[' . $key . ']' . '=' . urlencode($val) . '&';
            } else {
                $current_location .= urlencode($key) . '=' . urlencode($val) . '&';
            }
        } else {
            if (!empty($array_key)) {
                $current_location .= get_url('', $array_key . '[' . $key . ']', $val);
            } else {
                $current_location .= get_url('', $key, $val);
            }
        }
    }
    return ($current_location);
}

function get_content_element($id, $table_nav, $table_content)
{
    global $sqlConn;

    $retval['rootline'] = array();
    get_content_rootline($id, $table_nav, $retval['rootline']);

    $retval['content'] = '';
    $myquery = "SELECT `$table_content`.* FROM `$table_content` LEFT JOIN `$table_nav` ON `$table_content`.pid = `$table_nav`.id WHERE `$table_content`.pid = ? AND `$table_nav`.active = '1' ORDER BY `$table_content`.id";
    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $retval['content'] .= $row["text"];
        }
    }

    return $retval;
}

function get_content_rootline($id, $table, &$retval_rootline)
{
    $retval = false;
    global $sqlConn;

    $myquery = "SELECT * FROM `$table` WHERE id = ? AND active = '1'";
    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $retval_rootline[] = array(
                "id" => $row["id"],
                "name" => $row["name"],
                "html" => '<a href="' . (!empty($row["url"]) ? $row["url"] : 'static.php') . '?content_id=' . $row["id"] . '">' . htmlspecialchars($row["name"]) . '</a>',
            );
            if ($row["pid"] > 0) {
                $tmp = get_content_rootline($row["pid"], $table, $retval_rootline);
                if ($tmp == false) {
                    return false;
                } else {
                    $retval_rootline[] = $tmp;
                }
            }
        }
    }

    return $retval;
}


function get_content_element_by_id($id)
{
    $retval = '';
    global $sqlConn;


    $myquery = "SELECT * FROM content LEFT JOIN content_main ON content.id = content_main.pid WHERE content.id = ? AND content_main.active = '1'";
    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $i = 0;
    while ($row = mysqli_fetch_array($result)) {
        if ($i == 0) {
            $retval .= '<div class="headgreen head">
						<a><img class="pic_l" src="images/head1green.gif" alt="" width="15" height="22" border="0" hspace="0" vspace="0">
							' . htmlspecialchars(uppercase($row["name"])) . '
						</a>
					</div>
					<div class="shadow shadowgreengray">&nbsp;</div><br>
					';
        }
        $retval .= $row["content"] . "<p><br></p>";
        $i++;
    }
    return $retval;
}

function get_content_element_by_id_arr($id)
{
    global $sqlConn;
    $myquery = "SELECT * FROM content where id = '$id' and active = '1'";
    
    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($result)) {
        return ($row);
    }
    return false;
}

function get_content_element_by_parent_id($parent_id, $showorder)
{
    global $sqlConn;
    $myquery = "SELECT * FROM content where parent_id = '$parent_id' and showorder = '$showorder' and active = '1'";

    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($result)) {
        return ($row["text"]);
    }
    return false;
}

function get_children($parent_id)
{
    global $sqlConn;

    $retval = array();
    $myquery = "SELECT * FROM content where parent_id = '$parent_id' and active = '1' order by showorder";
    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($result)) {
        $retval[$row["id"]]["name"] = $row["name"];
        $retval[$row["id"]]["text"] = $row["text"];
    }
    return $retval;
}

function get_children_index($children)
{
    $retval = '';
    foreach ($children as $key => $val) {
        $retval .= '<a href="#' . $key . '">' . $val["name"] . '</a> | ';
    }
    $retval = substr($retval, 0, -3);
    return $retval;
}

function get_children_content($children)
{
    $retval = '';
    $i = 0;
    foreach ($children as $key => $val) {
        $retval .= '<p><span class="introcopy"><a name="' . $key . '"></a>' . $val["name"] . '</span><br>' . $val["text"] . '<br><br></p>';
        if ($i % 2) {
            $retval .= '<p><a href="#top">Back to top</a><br><br></p>';
        }
        $i++;
    }
    return $retval;
}

function check_date($date = "", $dday = "", $dmonth = "", $dyear = "")
{
    $retval = false;
    $date_format = 1;
    $month_format = 'm';
    $day_format = 'd';
    if (!empty($date)) {
        if (preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})( ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}))?$/", $date, $regs)) {
            //			$date_spit = explode("-", $date);
            $tmp = mktime(@$regs[5], @$regs[6], @$regs[7], $regs[2], $regs[3], $regs[1]);
            if (!empty($regs[5])) {
                $date_format = 2;
            }
            if (strlen($regs[2]) == 1) {
                $month_format = 'n';
            }
            if (strlen($regs[3]) == 1) {
                $day_format = 'j';
            }
        } else {
            return false;
        }
    } else {
        $date = $dyear . '-' . $dmonth . '-' . $dday;
        $tmp = mktime(0, 0, 0, $dmonth, $dday, $dyear);
        if (strlen($dmonth) == 1) {
            $month_format = 'n';
        }
        if (strlen($dday) == 1) {
            $day_format = 'j';
        }
    }
    if ($date_format == 1) {
        $tmp_date = date("Y-$month_format-$day_format", $tmp);
    } elseif ($date_format == 2) {
        $tmp_date = date("Y-$month_format-$day_format H:i:s", $tmp);
    }
    if ($tmp_date == $date) {
        $retval = $tmp;
    }
    return $retval;
}

function select_date_fields($timestamp, $field_name = 'd', $month_type = 'm', $allow_empty = 0, $lang = '', $style = '')
{
    $retval["day"] = '';
    $retval["month"] = '';
    $retval["year"] = '';
    $retval["hour"] = '';
    $retval["minute"] = '';
    $retval["second"] = '';

    $retval["day"] = '<select name="' . $field_name . 'day" ' . (!empty($style) ? 'class="' . $style . '_day"' : '') . '>';
    $retval["month"] = '<select name="' . $field_name . 'month" ' . (!empty($style) ? 'class="' . $style . '_month"' : '') . '>';
    $retval["year"] = '<select name="' . $field_name . 'year" ' . (!empty($style) ? 'class="' . $style . '_year"' : '') . '>';
    $retval["hour"] = '<select name="' . $field_name . 'hour" ' . (!empty($style) ? 'class="' . $style . '_hour"' : '') . '>';
    $retval["minute"] = '<select name="' . $field_name . 'minute" ' . (!empty($style) ? 'class="' . $style . '_minute"' : '') . '>';
    $retval["second"] = '<select name="' . $field_name . 'second" ' . (!empty($style) ? 'class="' . $style . '_second"' : '') . '>';

    if (empty($timestamp) or $allow_empty) {
        $retval["day"] .= '<option value="00">DD</option>';
        $retval["month"] .= '<option value="00">MM</option>';
        $retval["year"] .= '<option value="0000">YY</option>';
        $retval["hour"] .= '<option value="00">HH</option>';
        $retval["minute"] .= '<option value="00">mm</option>';
        $retval["second"] .= '<option value="00">ss</option>';
    }
    if (empty($timestamp)) {
        $day = '';
        $month = '';
        $year = date("Y", time());
        $hour = '12';
        $minute = '00';
        $second = '00';
    } else {
        $day = date("j", $timestamp);
        $month = date("n", $timestamp);
        $year = date("Y", $timestamp);
        $hour = date("H", $timestamp);
        $minute = date("i", $timestamp);
        $second = date("s", $timestamp);
    }
    for ($i = 0; $i <= 23; $i++) {
        $retval["hour"] .= '<option value="' . str_repeat("0", (2 - strlen($i))) . $i . '" ' . (($hour == $i) ? "selected" : "") . '>' . str_repeat("0", 2 - strlen($i)) . $i . '</option>';
    }
    for ($i = 0; $i <= 59; $i++) {
        $retval["minute"] .= '<option value="' . str_repeat("0", (2 - strlen($i))) . $i . '" ' . (($minute == $i) ? "selected" : "") . '>' . str_repeat("0", 2 - strlen($i)) . $i . '</option>';
    }
    for ($i = 0; $i <= 59; $i++) {
        $retval["second"] .= '<option value="' . str_repeat("0", (2 - strlen($i))) . $i . '" ' . (($second == $i) ? "selected" : "") . '>' . str_repeat("0", 2 - strlen($i)) . $i . '</option>';
    }
    for ($i = 1; $i <= 31; $i++) {
        $retval["day"] .= '<option value="' . str_repeat("0", (2 - strlen($i))) . $i . '" ' . (($day == $i) ? "selected" : "") . '>' . str_repeat("0", 2 - strlen($i)) . $i . '</option>';
    }

    for ($i = 1; $i <= 12; $i++) {
        if ($lang == 'bg') {
            $month_name = bgdate(date($month_type, mktime(0, 0, 0, $i, 1, $year)), 1);
        } else {
            $month_name = date($month_type, mktime(0, 0, 0, $i, 1, $year));
        }
        $retval["month"] .= '<option value="' . str_repeat("0", 2 - strlen($i)) . $i . '" ' . (($month == $i) ? "selected" : "") . '>' . $month_name . '</option>';
    }

    for ($i = 2009; $i <= (date("Y", time()) + 3); $i++) {
        $retval["year"] .= '<option value="' . $i . '" ' . ((!empty($timestamp) && $year == $i) ? "selected" : "") . '>' . $i . '</option>';
    }

    $retval["day"] .= '</select>';
    $retval["month"] .= '</select>';
    $retval["year"] .= '</select>';
    $retval["hour"] .= '</select>';
    $retval["minute"] .= '</select>';
    $retval["second"] .= '</select>';

    return $retval;
}

function bgdate($str, $fstupper = false)
{
    //mnths
    if ($fstupper) {
        $mnths = array(
            'January' => "Януари",
            'February' => "Февруари",
            'March' => "Март",
            'April' => "Април",
            'May' => "Май",
            'June' => "Юни",
            'July' => "Юли",
            'August' => "Август",
            'September' => "Септемви",
            'October' => "Октомври",
            'November' => "Ноември",
            'December' => "Декември"
        );
        $dys = array(
            'Sunday' => "Неделя",
            'Monday' => "Понеделник",
            'Tuesday' => "Вторник",
            'Wednesday' => "Сряда",
            'Thursday' => "Четвъртък",
            'Friday' => "Петък",
            'Saturday' => "Събота"
        );
    } else {
        $mnths = array(
            'January' => "януари",
            'February' => "февруари",
            'March' => "март",
            'April' => "април",
            'May' => "май",
            'June' => "юни",
            'July' => "юли",
            'August' => "август",
            'September' => "септемви",
            'October' => "октомври",
            'November' => "ноември",
            'December' => "декември"
        );
        $dys = array(
            'Sunday' => "неделя",
            'Monday' => "понеделник",
            'Tuesday' => "вторник",
            'Wednesday' => "сряда",
            'Thursday' => "четвъртък",
            'Friday' => "петък",
            'Saturday' => "събота"
        );
    }


    $ret = strtr($str, $mnths);
    $ret = strtr($ret, $dys);
    return $ret;
}

function show_month($month)
{
    $month = intval($month);
    $months = array(
        '1' => "������",
        '2' => "��������",
        '3' => "����",
        '4' => "�����",
        '5' => "���",
        '6' => "���",
        '7' => "���",
        '8' => "������",
        '9' => "���������",
        '10' => "��������",
        '11' => "�������",
        '12' => "��������"
    );
    return ($months[$month]);
}

function striphtml($mystr)
{

    $search = array(
        "'<script[^>]*?>.*?</script>'si", // Strip out javascript 
        "'<[\/\!]*?[^<>]*?>'si", // Strip out html tags 
        "'([\r\n])[\s]+'", // Strip out white space 
        "'([\r])'", // Strip out white space 
        "'&(quot|#34);'i", // Replace html entities 
        "'&(amp|#38);'i",
        "'&(lt|#60);'i",
        "'&(gt|#62);'i",
        "'&(nbsp|#160);'i",
        "'&(iexcl|#161);'i",
        "'&(cent|#162);'i",
        "'&(pound|#163);'i",
        "'&(copy|#169);'i",
        "'&#(\d+);'"
    );                    // evaluate as php 

    $replace = array(
        "",
        "",
        "\\1",
        "\n\n",
        "\"",
        "&",
        "<",
        ">",
        " ",
        chr(161),
        chr(162),
        chr(163),
        chr(169),
        "chr(\\1)"
    );

    return preg_replace($search, $replace, $mystr);
}

function get_part($mystr, $start, $limit, $order = '', $delimiter = '/(([^.?!\n]+)(([.?!\n]+)|$))/', $min_lenght = 0, $max_lenght = 0)
{
    //$mystr = strip_tags($mystr);
    if ($max_lenght > 0) {
        $mystr = substr($mystr, 0, $max_lenght);
    }

    $limit = $start + $limit;

    $retval = '';
    $exploded = '';
    if (preg_match_all($delimiter, $mystr, $regs)) {
        reset($regs[1]);
        if ($order == 'desc') {
            for ($i = $limit; $i >= $start; $i++) {
                $retval .= $regs[1][$i];
            }
        } else {
            for ($i = $start; $i < $limit; $i++) {
                if (!empty($regs[1][$i])) {
                    $retval .= $regs[1][$i];
                }
            }
        }
    }

    //$retval = trim($retval);

    if ($min_lenght > 0 && $limit < count($regs[1]) && strlen($retval) < $min_lenght) {
        $retval = get_part($mystr, 0, ($limit + 1), $order, $delimiter, $min_lenght, $max_lenght);
    }

    if (empty($retval)) {
        return ($mystr);
    }
    return $retval;
}

function mystrip_tags($mystr)
{
    $mystr = strip_tags($mystr);
    $mystr = strtr($mystr, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
    return $mystr;
}

//defining function for bulgarian uppercase
function uppercase($str)
{
    /*
      $trans = array ('�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�', '�'=>'�', '�'=>'�');
      return strtoupper(strtr($str,$trans));
     */
    global $site_encoding;
    return mb_strtoupper($str, $site_encoding);
};

//defining function for bulgarian uppercase
function lowercase($str)
{
    /*
      $trans = array ('�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�','�'=>'�', '�'=>'�', '�'=>'�');
      $trans=array_flip($trans);
      return strtolower(strtr($str,$trans));
     */
    global $site_encoding;
    return mb_strtolower($str, $site_encoding);
};

function convert_cyr_str_to_lat($str)
{
    $trans = array('�' => 'a', '�' => 'A', '�' => 'b', '�' => 'B', '�' => 'v', '�' => 'V', '�' => 'g', '�' => 'G', '�' => 'd', '�' => 'D', '�' => 'e', '�' => 'E', '�' => 'j', '�' => 'J', '�' => 'z', '�' => 'Z', '�' => 'i', '�' => 'I', '�' => 'j', '�' => 'J', '�' => 'k', '�' => 'K', '�' => 'l', '�' => 'L', '�' => 'm', '�' => 'M', '�' => 'n', '�' => 'N', '�' => 'o', '�' => 'O', '�' => 'p', '�' => 'P', '�' => 'r', '�' => 'R', '�' => 's', '�' => 'S', '�' => 't', '�' => 'T', '�' => 'u', '�' => 'U', '�' => 'f', '�' => 'F', '�' => 'h', '�' => 'H', '�' => 'c', '�' => 'C', '�' => 'ch', '�' => 'Ch', '�' => 'sh', '�' => 'Sh', '�' => 'sht', '�' => 'Sht', '�' => 'a', '�' => 'A', '�' => '', '�' => '', '�' => 'iu', '�' => 'Iu', '�' => 'ia', '�' => 'Ia');
    return strtr($str, $trans);
};

function get_next_autoincrement($table, $field)
{
    // $myquery = "LOCK TABLES `$table` WRITE";
    // $MyResult = query($myquery);
    $myquery = "select max(`$field`) from `$table`";
    $MyResult = query($myquery);
    while ($row = mysqli_fetch_row($MyResult)) {
        return ($row[0] + 1);
    }
    // $myquery = "UNLOCK TABLES `$table`";
    // $MyResult = query($myquery);
}

function make_fe_pages_list($all_count, $start, $limit, $location, $max_pages = 9, $list_prefix = '��������')
{
    $retval = '';

    $this_page = ceil(($start + 1) / $limit);

    $all_pages = ceil($all_count / $limit);

    if ($all_pages <= 1) {
        return '';
    }

    if ($all_pages > $max_pages) {
        $p_end = $max_pages;
        $p_start = ($this_page - floor($max_pages / 2));
        if ($p_start <= 0) {
            $p_start = 1;
        } else {
            $p_end = $max_pages - 1 + $p_start;
            if ($p_end > $all_pages) {
                $p_end = $all_pages;
            }
        }
    } else {
        $p_end = $all_pages;
        $p_start = 1;
    }

    $retval .= '<ul class="pg">
				' . (!empty($list_prefix) ? '<li><span>' . $list_prefix . ':</span></li>' : '');

    //if($all_pages > 1) {
    if ($this_page > 1) {
        $retval .= '<li><a href="' . $location . '&start=' . ($this_page - 2) * $limit . '">&laquo;</a></li>';
    }
    if ($p_start > 1) {
        $retval .= '<li><a href="' . $location . '&start=0">1</a></li>';
    }
    if ($p_start >= 3) {
        $retval .= '<li>...</li>';
    }
    for ($i = $p_start; $i <= $p_end; $i++) {
        if ($i == $this_page) {
            $retval .= '<li class="active">' . $i . '</li>';
        } else {
            $retval .= '<li><a href="' . $location . '&start=' . (($i - 1) * $limit) . '">' . $i . '</a></li>';
        }
    }
    if ($p_end < $all_pages - 1) {
        $retval .= '<li>...</li>';
    }
    if ($this_page <> $all_pages && $p_end <> $all_pages) {
        $retval .= '<li><a href="' . $location . '&start=' . (($all_pages - 1) * $limit) . '">' . $all_pages . '</a></li>';
    }
    if ($this_page <> $all_pages && $all_pages > 1) {
        $retval .= '<li><a href="' . $location . '&start=' . ($this_page) * $limit . '">&raquo;</a></li>';
    }
    //}
    $retval .= '</ul>';
    return $retval;
}

function check_field_exists($table, $key)
{
    global $sqlConn; 

    if (empty($table)) {
        return false;
    }

    $myquery = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ? AND COLUMN_NAME = ?";
    
    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "ss", $table, $key);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    }
    return false;
}


function make_timestamp($date)
{
    if (preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $date, $regs)) {
        $day = $regs[3];
        $month = $regs[2];
        $year = $regs[1];
        if (preg_match("/([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $date, $regs)) {
            $hour = $regs[1];
            $minute = $regs[2];
            $second = $regs[3];
        } else {
            $hour = 0;
            $minute = 0;
            $second = 0;
        }
        return mktime($hour, $minute, $second, $month, $day, $year);
    } else {
        return false;
    }
}

function days_diff($start_date, $end_date)
{
    $retval = make_timestamp($end_date) - make_timestamp($start_date);
    $retval = $retval / 3600 / 24;
    return ($retval);
}

function azbuka($parameters = '')
{
    $letters = array(
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6',
        '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '7', '8', '9', '0'
    );
    for ($i = 0; $i < count($letters); $i++) {
        echo '<a href="' . $_SERVER["PHP_SELF"] . '?letter=' . urlencode($letters[$i]) . '&' . $parameters . '" class="azbuka' . ((!empty($_REQUEST["letter"]) && $_REQUEST["letter"] == $letters[$i]) ? " azbuka_selected" : "") . '">&nbsp;' . $letters[$i] . '</a>';
    }
}

function debugme($msg)
{
    if ($_SERVER["REMOTE_ADDR"] == '212.36.2.66') {
        echo $msg;
    }
}

function trimvars(&$value)
{
    $magic_quotes = ini_get("magic_quotes_gpc");

    foreach ($value as $key => $val) {
        if (!is_array($val)) {
            if ($magic_quotes) {
                $value[$key] = trim($val);
            } else {
                $value[$key] = addslashes(trim($val));
            }
        } else {
            trimvars($value[$key]);
        }
    }
}

function convert_cyr_to_entities($str)
{
    $search = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
    $replace = array('&#1072;', '&#1073;', '&#1074;', '&#1075;', '&#1076;', '&#1077;', '&#1078;', '&#1079;', '&#1080;', '&#1081;', '&#1082;', '&#1083;', '&#1084;', '&#1085;', '&#1086;', '&#1087;', '&#1088;', '&#1089;', '&#1090;', '&#1091;', '&#1092;', '&#1093;', '&#1094;', '&#1095;', '&#1096;', '&#1097;', '&#1098;', '&#1100;', '&#1102;', '&#1103;', '&#1040;', '&#1041;', '&#1042;', '&#1043;', '&#1044;', '&#1045;', '&#1046;', '&#1047;', '&#1048;', '&#1049;', '&#1050;', '&#1051;', '&#1052;', '&#1053;', '&#1054;', '&#1055;', '&#1056;', '&#1057;', '&#1058;', '&#1059;', '&#1060;', '&#1061;', '&#1062;', '&#1063;', '&#1064;', '&#1065;', '&#1066;', '&#1068;', '&#1070;', '&#1071;');
    return preg_replace($search, $replace, $str);
}

function convert_to_entities($str)
{
    $retval = '';
    $lenght = strlen($str);
    for ($i = 0; $i < $lenght; $i++) {
        $retval .= '&#' . ord(substr($str, $i, 1)) . ';';
    }
    return $retval;
}

function make_friendly_url($text)
{
    $text = preg_replace(array("/\//", "/[%?!.,;\\\"\\\'“„’]/", "/([-– ]+)/", '/[^-a-zA-Z0-9а-яА-Я]*/'), array(" ", "", "-", ""), remove_french_accents($text));
    return mb_strtolower($text);
}

function convert_cyr_str($str)
{
    $trans = array('а' => 'a', 'А' => 'A', 'б' => 'b', 'Б' => 'B', 'в' => 'v', 'В' => 'V', 'г' => 'g', 'Г' => 'G', 'д' => 'd', 'Д' => 'D', 'е' => 'e', 'Е' => 'E', 'ж' => 'j', 'Ж' => 'J', 'з' => 'z', 'З' => 'Z', 'и' => 'i', 'И' => 'I', 'й' => 'j', 'Й' => 'J', 'к' => 'k', 'К' => 'K', 'л' => 'l', 'Л' => 'L', 'м' => 'm', 'М' => 'M', 'н' => 'n', 'Н' => 'N', 'о' => 'o', 'О' => 'O', 'п' => 'p', 'П' => 'P', 'р' => 'r', 'Р' => 'R', 'с' => 's', 'С' => 'S', 'т' => 't', 'Т' => 'T', 'у' => 'u', 'У' => 'U', 'ф' => 'f', 'Ф' => 'F', 'х' => 'h', 'Х' => 'H', 'ц' => 'c', 'Ц' => 'C', 'ч' => 'ch', 'Ч' => 'Ch', 'ш' => 'sh', 'Ш' => 'Sh', 'щ' => 'sht', 'Щ' => 'Sht', 'ъ' => 'a', 'Ъ' => 'A', 'ь' => '', 'Ь' => '', 'ю' => 'yu', 'Ю' => 'Yu', 'я' => 'ya', 'Я' => 'Ya');
    return strtr($str, $trans);
}

function remove_french_accents($str)
{
    $trans = array(
        'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', '»' => '', '«' => ''
    );
    return strtr($str, $trans);
}


function validate_email($email, $checkDNS = true)
{
    if (!preg_match("/^([a-z0-9]+)([-a-z0-9_.]*)@([a-z0-9]+)([-a-z0-9_.]*)((\.[a-z]{2,4})+)$/i", $email)) {
        return false;
    }

    $parts = explode('@', $email, 2);
    $domain = end($parts);

    if ($checkDNS) {
        return checkdnsrr($domain . '.', 'MX');
    }

    return true;
}

function gen_google_sitemap()
{
    global $site_path;
    $fcontent = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
  xmlns="http://www.google.com/schemas/sitemap/0.84"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84
                      http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">
	<url>
		<loc>' . $site_path . 'index.php</loc>
		<changefreq>weekly</changefreq>
		<priority>1.0000</priority>
	</url>
';
    $fcontent .= gen_google_sitemap_nav_list('bg_navigation', 0, '&amp;lang=bg');
    $fcontent .= gen_google_sitemap_nav_list('en_navigation', 0, '&amp;lang=en');
    $fcontent .= gen_google_sitemap_news_list('bg_news', 0, '&amp;lang=bg');
    $fcontent .= gen_google_sitemap_news_list('en_news', 0, '&amp;lang=en');

    $fcontent .= '
</urlset>
';
    $fp = fopen("../sitemap.xml", "w");
    fwrite($fp, $fcontent);
    fclose($fp);
}

function gen_google_sitemap_nav_list($table, $pid, $add = '')
{
    global $site_path, $sqlConn;
    $retval = '';
    $where = " where pid = '$pid' and active = '1' ";

    $myquery = "select * from `$table` $where order by showorder";
    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "", $pid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        $retval .= '
	<url>
		<loc>' . $site_path . (($row['url'] == '') ? "static.php" : $row['url']) . '?content_id=' . $row['id'] . $add . '</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8000</priority>
	 </url>
		' . "\n";
        if (!empty($row["has_children"])) {
            gen_google_sitemap_nav_list($table, $row["id"]);
        }
        $i++;
    }
    return $retval;
}

function gen_google_sitemap_news_list($table, $pid, $add = '')
{
    global $site_path, $sqlConn;
    $retval = '';
    $where = " where active = '1' ";

    $myquery = "select * from `$table` $where order by date desc";
    $stmt = mysqli_prepare($sqlConn, $myquery);
    mysqli_stmt_bind_param($stmt, "", $pid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);


    $i = 1;
    while ($row = mysqli_fetch_array($result)) {
        $retval .= '
	<url>
		<loc>' . $site_path . 'news.php?news_id=' . $row['id'] . $add . '</loc>
		<changefreq>weekly</changefreq>
		<priority>0.8000</priority>
	 </url>
		' . "\n";
        if (!empty($row["has_children"])) {
            gen_google_sitemap_news_list($table, $row["id"]);
        }
        $i++;
    }
    return $retval;
}
