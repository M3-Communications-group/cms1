<?php

/*
  Promenlivi:
 */

$photo_definition_profile = array(
    "name" => 'photo',
    "title" => '������',
    "type" => 'image',
    "select_list" => "",
    "default_value" => '',
    "required" => 0,
    "check_type" => 'jpg|jpeg|gif|png',
    "check_width" => '',
    "check_height" => '',
    "check_propotion" => '',
    "check_maxheight" => '2806',
    "check_maxwidth" => '2806',
    "check_minheight" => '190', //Ako e shiroka da proveriava za min height 250, ako e shiroka za min width 300
    "check_minwidth" => '150',
    "check_sizes_orientation" => "1",
    "max_size" => '2048', //KB
    "upload_dir" => 'uploads/images',
    "path" => '',
    "check_value" => '',
    "auto_images" => array(
        "photo|800|600|||1|2", // name|width|height|propotion|writesize|optional|crop "photo_big|640|480||"
        "photo_medium|150|190||||3", // name|width|height|propotion|writesize|optional|crop "photo_small|180|135||"
        "photo_small|76|76||||1", // name|width|height|propotion|writesize|optional|crop "photo_small|180|135||"
    ),
);

$arr_allow_file_types = array(
    "gif" => "image/gif",
    "png" => "image/png",
    "jpg" => "image/jpeg",
    "jpeg" => "image/jpeg",
);

/*
  $admin_texts['bg']["edit"] = "�����������";
  $admin_texts['bg']["add"] = "��������";
  $admin_texts['bg']["view"] = "������";
  $admin_texts['bg']["list"] = "������";
  $admin_texts['bg']["total"] = "����";
  $admin_texts['bg']["select"] = "������";
  $admin_texts['bg']["delete"] = "������";
  $admin_texts['bg']["delete_image"] = "������ ��������";
  $admin_texts['bg']["is_required"] = " � ������������";
  $admin_texts['bg']["is_unique"] = "������ �� � ��������, ���� ����������";
  $admin_texts['bg']["is_invalid"] = "��������� ���������� �";
  $admin_texts['bg']["is_invalid_email"] = "��������� e-mail � ����";
  $admin_texts['bg']["is_invalid_format"] = "��������� ������ ��";
  $admin_texts['bg']["is_mkdir"] = "������������ ���������� �� ���� �� ���� ���������. ������� �� �� �������� ��� ��������� mkdir";
  $admin_texts['bg']["is_big"] = "� ����� �����. ��������� � ��������";
  $admin_texts['bg']["width_of"] = "�������� ��";
  $admin_texts['bg']["height_of"] = "���������� ��";
  $admin_texts['bg']["propotion_of"] = "����������� ��";
  $admin_texts['bg']["has_to"] = "������ �� ����";
  $admin_texts['bg']["not"] = "��";
  $admin_texts['bg']["maximum"] = "��������";
  $admin_texts['bg']["minimum"] = "�������";
  $admin_texts['bg']["save"] = "������";
  $admin_texts['bg']["success"] = "���������� � �������!";
  $admin_texts['bg']["archive_open_failed"] = "������ �� ���� �� ���� �������!";

  $admin_texts['en']["edit"] = "Edit";
  $admin_texts['en']["add"] = "Add";
  $admin_texts['en']["view"] = "List";
  $admin_texts['en']["list"] = "List";
  $admin_texts['en']["total"] = "Total";
  $admin_texts['en']["select"] = "Select";
  $admin_texts['en']["delete"] = "delete";
  $admin_texts['en']["delete_image"] = "Delete Image";
  $admin_texts['en']["is_required"] = " is required";
  $admin_texts['en']["is_unique"] = "needs to have unique value, this value already exists in the database: ";
  $admin_texts['en']["is_invalid"] = "Invalid content in";
  $admin_texts['en']["is_invalid_email"] = "Invalid e-mail address in field";
  $admin_texts['en']["is_invalid_format"] = "Invalid format of";
  $admin_texts['en']["is_mkdir"] = "The needed folder can't be automatically created. Please call Administrator or mkdir";
  $admin_texts['en']["is_big"] = "is too big. Maximum allowed size is ";
  $admin_texts['en']["width_of"] = "Width of";
  $admin_texts['en']["height_of"] = "Height of";
  $admin_texts['en']["propotion_of"] = "Propotion of";
  $admin_texts['en']["has_to"] = "has to be";
  $admin_texts['en']["not"] = "not";
  $admin_texts['en']["maximum"] = "maximum";
  $admin_texts['en']["minimum"] = "minimum";
  $admin_texts['en']["save"] = "Save";
  $admin_texts['en']["success"] = "Operation successfull!";
  $admin_texts['en']["archive_open_failed"] = "file cannot be opened!";
 */

// Izvikva se taka:
//upload_photo($photo_definition, 'ime na tablica', 'id na zapisa kam kojto e snimkata');

$lang = 'en';

function upload_photo($item, $table, $id)
{
    global $admin_texts, $arr_allow_file_types, $lang, $db;

    $err = '';

    //echo '<pre>';
    //print_r($_FILES);
    //var_dump($_FILES["images"]["tmp_name"][$item["name"]]);
    //echo '</pre>';

    if (!empty($_FILES["images"]["tmp_name"][$item["name"]]) && (is_uploaded_file($_FILES["images"]["tmp_name"][$item["name"]]) || file_exists($_FILES["images"]["tmp_name"][$item["name"]]))) {
        $pic_expl = explode(".", $_FILES["images"]["name"][$item["name"]]);
        $extension = strtolower(array_pop($pic_expl));

        $err .= check_file_extension($_FILES["images"]["name"][$item["name"]], $item);

        if ($extension == 'zip') {
            $zip = zip_open($_FILES["images"]["tmp_name"][$item["name"]]);

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
            if (filesize($_FILES["images"]["tmp_name"][$item["name"]]) > ($item["max_size"] * 1024)) {
                $err .= '' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') , ' . $admin_texts[$lang]["is_big"] . ' ' . $item["max_size"] . ' KB<br>';
            }
        }

        if (!empty($item["keep_orig_name"])) {
            $copyURL = $item["upload_dir"] . "/" . $_FILES["images"]["name"][$item["name"]];

            $mysexquery = "select count(*) from `$table` where `" . $item["name"] . "` = '" . $copyURL . "' " . (!empty($id) ? " and id <> '$id'" : '');
            $MySexResult = $db->query($mysexquery);
            $sexrow = mysql_fetch_row($MySexResult);
            if ($sexrow[0] > 0) {
                $err .= "" . $item["title"] . " " . $admin_texts[$lang]["is_unique"] . " '" . $_FILES["images"]["name"][$item["name"]] . "'.<br>";
            }
        }

        if ($item["type"] == 'image') {
            if (!empty($item["check_width"]) or ! empty($item["check_height"]) or ! empty($item["check_maxwidth"]) or ! empty($item["check_minwidth"]) or ! empty($item["check_maxheight"]) or ! empty($item["check_propotion"])) {
                $img_size = getimagesize($_FILES["images"]["tmp_name"][$item["name"]]);
                if (!empty($item["check_width"]) && $img_size[0] <> $item["check_width"]) {
                    $err .= '' . $admin_texts[$lang]["width_of"] . ' ' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $item["check_width"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[0] . 'px.<br>';
                } elseif (!empty($item["check_maxwidth"]) && $img_size[0] > $item["check_maxwidth"]) {
                    $err .= '' . $admin_texts[$lang]["width_of"] . ' ' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $admin_texts[$lang]["maximum"] . ' ' . $item["check_maxwidth"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[0] . 'px.<br>';
                } elseif (!empty($item["check_minwidth"]) && $img_size[0] < $item["check_minwidth"]) {
                    $err .= '' . $admin_texts[$lang]["width_of"] . ' ' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $admin_texts[$lang]["minimum"] . ' ' . $item["check_minwidth"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[0] . 'px.<br>';
                }
                if (!empty($item["check_height"]) && $img_size[1] <> $item["check_height"]) {
                    $err .= '' . $admin_texts[$lang]["height_of"] . ' ' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $item["check_height"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[1] . 'px.<br>';
                } elseif (!empty($item["check_maxheight"]) && $img_size[1] > $item["check_maxheight"]) {
                    $err .= '' . $admin_texts[$lang]["height_of"] . ' ' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $admin_texts[$lang]["maximum"] . ' ' . $item["check_maxheight"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[1] . 'px.<br>';
                } elseif (!empty($item["check_minheight"]) && $img_size[1] < $item["check_minheight"]) {
                    $err .= '' . $admin_texts[$lang]["height_of"] . ' ' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $admin_texts[$lang]["minimum"] . ' ' . $item["check_minheight"] . 'px, ' . $admin_texts[$lang]["not"] . ' ' . $img_size[1] . 'px.<br>';
                }
                if (!empty($item["check_propotion"]) && ($img_size[0] / $img_size[1] <> $item["check_propotion"])) {
                    $err .= '' . $admin_texts[$lang]["propotion_of"] . ' ' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') ' . $admin_texts[$lang]["has_to"] . ' ' . $item["check_propotion"] . '.<br>';
                }
            }
        }
    } elseif ($item["required"] == 1) {
        $err .= "" . $item["title"] . "" . $admin_texts[$lang]["is_required"] . ".<br>";
    }

    if (!empty($err)) {
        return array(false, $err);
    }

    // Upload 
    $copyDIR = (isset($item["path"]) ? $item["path"] : "../");

    if (!empty($item["keep_orig_name"])) {
        $copyURL = $item["upload_dir"] . "/" . $_FILES["images"]["name"][$item["name"]];
    } else {
        $copyURL = $item["upload_dir"] . "/" . $item["name"] . "_$id.$extension";
    }

    $tmp_res = copy($_FILES["images"]["tmp_name"][$item["name"]], $copyDIR . $copyURL);
    if (!$tmp_res) {
        $err .= 'Cannot copy file ' . $item["title"] . '(' . $_FILES["images"]["name"][$item["name"]] . ') into ' . $copyURL . '. Please call webmaster.<br>';
        return(array(false, $err));
    } else {
        $my3query = "update `$table` set `" . $item["name"] . "` = '" . $copyURL . "'";
        if ($item["type"] == 'image' && !empty($item["writesize"])) {
            $img_size = getimagesize($copyDIR . $copyURL);
            $my3query .= "`" . $item["name"] . "x` = '" . $img_size[0] . "', `" . $item["name"] . "y` = '" . $img_size[1] . "'";
        }
        $my3query .= " where id = '$id'";
        $My3Result = $db->query($my3query);
    }
    // generate auto image sizes
    if ($item["type"] == 'image' && isset($item["auto_images"]) && is_array($item["auto_images"]) && count($item["auto_images"]) > 0) {
        reset($item["auto_images"]);
        while (list($not_important, $auto_image) = each($item["auto_images"])) {
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
            // [0] -> name, [1] -> width, [2] -> height, [3] -> propotion, [4] -> writesize, [5] -> optional-olny-if-size-allows, [6] -> 0: just resize; 1: crop; 2: resize and toggle width/height if portrait; 3: crop bez riazane a chrez dobaviane na prazno mqsto; 4: resize without messing up the propotion - width and height are maximum values, 5: similar to 3, but do only for portrait images, if landscape, do as 1 [7] -> watermark
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
            if ($img_params[6] == 5) {
                if ($img_src_size[0] <= $img_src_size[1]) { // only if img orientation is portrait
                    $img_params[6] = 3;
                } else {
                    $img_params[6] = 1;
                }
                //var_dump($img_params[6]);
            }

            // width
            if (!empty($img_params[1])) {
                $new_width = $img_params[1];
            } elseif (!empty($img_params[3])) {
                $new_width = $img_src_size[0] * $img_params[1];
            } elseif (!empty($img_params[2])) {
                $new_width = round($img_src_size[0] * ($img_params[2] / $img_src_size[1]));
            } else {
                $err .= 'Invalid parameters: no width defined for auto image ' . $item["title"] . ' - ' . $not_important . '(' . $_FILES["images"]["name"][$item["name"]] . '). Please call webmaster.<br>';
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
                $err .= 'Invalid parameters: no height defined for auto image ' . $item["title"] . ' - ' . $not_important . '(' . $_FILES["images"]["name"][$item["name"]] . '). Please call webmaster.<br>';
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
                $autocopyDIR = (isset($item["path"]) ? $item["path"] : "../");
                $autocopyURL = $item["upload_dir"] . "/" . $img_params[0] . "_$id.jpg";
                imagejpeg($im_dst, $autocopyDIR . $autocopyURL, 95);
                imagedestroy($im_dst);
                $my3query = "update `$table` set `" . $img_params[0] . "` = '" . $autocopyURL . "'";
                if ($item["type"] == 'image' && $img_params[4] == '1') {
                    $img_size = getimagesize($copyDIR . $copyURL);
                    $my3query .= "`" . $img_params[0] . "x` = '" . $new_width . "', `" . $img_params[0] . "y` = '" . $new_height . "'";
                }
                $my3query .= " where id = '$id'";
                //echo $my3query;
                $My3Result = $db->query($my3query);
            }
        }
    }
    return array(true, $admin_texts[$lang]["success"]);
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
    } elseif (!preg_match("/^(" . $item["check_type"] . ")$/", $extension)) {
        $err .= $additional_text . '' . $admin_texts[$lang]["is_invalid_format"] . ' <!-- ' . $item["title"] . '( -->' . $filename . '<br>';
    }

    return $err;
}

?>
