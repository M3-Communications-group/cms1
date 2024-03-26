<!DOCTYPE HTML>

<html>
    <head>
        <title>Admin Tool</title>
        <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/style.css?version=2"/>
        <script src="js/jquery-1.11.0.min.js"></script>
        <script src="js/jquery-migrate-1.2.1.min.js"></script>
        <!-- <script language="JavaScript" src="../js/ajax.js"></script> -->
        <!--
        <script type="text/javascript" src="inc/tiny_mce/tiny_mce.js"></script>
        <script src="js/ckeditor/ckeditor.js"></script>
        -->
        <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>

        <script language="JavaScript">

            function del(delurl) {
                if (confirm('Do You really want to delete this record?')) {
                    if (confirm('OK!')) {
                        tmp = document.getElementById('mycustsearchform');
                        if (tmp != null && (tmp.method == 'POST' || tmp.method == 'post')) {
                            tmp.action = delurl;
                            tmp.submit();
                        } else {
                            location.href = delurl;
                        }
                    }
                }
            }

            function change_status(delurl) {
                location.href = delurl;
            }

            function toggle_visibility(element, element_img) {
                var tmp = element.style;
                var tmp_img = element_img.src;
                if (tmp.display == 'block') {
                    tmp.display = 'none';
                    element_img.src = 'images/link_plus.gif';
                } else {
                    tmp.display = 'block';
                    element_img.src = 'images/link_minus.gif';
                }
            }

            function openWindow(mypage, myname, w, h, scroll)
            {
                var winl = (screen.width - w) / 2;
                var wint = (screen.height - h) / 2;
                winprops = 'height=' + h + ',width=' + w + ',top=' + wint + ',left=' + winl + ',scrollbars=' + scroll + ',resizable'
                gmtWindow = window.open(mypage, myname, winprops)
                if (parseInt(navigator.appVersion) >= 4) {
                    gmtWindow.window.focus();
                }
            }

            function make_dependency(myindex, mydiv) {
                // alert(myindex.value);
                tmp = document.getElementById(mydiv);
                tmp.innerHTML = eval('dep_' + mydiv + '_' + myindex.value);
            }

            function toggle_color(element) {
                var tmp = element.style;
                if (tmp.background == '') {
                    tmp.background = '#efefef';
                } else {
                    tmp.background = '';
                }
            }
        </script>
    </head>
    <body>
        <?php
        if (empty($_GET["hide_nav"])) {
            ?>

            <div style="float: left; padding-right: 10px; margin-right: 10px;">
                <a href="./main.php"><img src="images/statehouse_crest.jpg" alt="Logo" width="112"  border="0" align="left"></a>
            </div>
            <h1 class="user"><?php echo $_SESSION['m3cms']["name"] ?></h1>
            <a href="change_password.php?admin_option=1" style="color: #850208;">Change password</a>
            <span style="padding:0 5px 0 5px">|</span>
            <a href="index.php?logout" style="color: #850208;">Logout</a><br>
            <div style="clear: both;"></div>
            <br>
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tr><td valign="top">
                        <?php
                        echo '
		' . @$menu_html[0] . '<br>
		<div class="clear"></div>
		' . @$menu_html[1] . '<br>
		<div class="clear"></div>
		<br>
		
	';

                        echo '
	<table border="0" cellpadding="0" cellspacing="0">
		<tr><td valign="top">';


                        $pname = '<a href="' . $_SERVER["PHP_SELF"] . '?table=' . $table . '&admin_option=' . $admin_option . '">' . $table_name . '</a>';
                        if (empty($_GET["hide_nav"]) && !empty($table_categories)) {
                            echo '<table border="0" cellpadding="0" cellspacing="0">';
                            echo '<tr><td><a href="' . $_SERVER["PHP_SELF"] . '?admin_option=' . $admin_option . '&table=' . $table . (!empty($_GET["common_sense"]) ? "&common_sense=1" : "") . '"><img src="images/house.gif" alt="" width="16" height="15" border="0"></a></td></tr>';

                            if (!empty($table_categories_title_field) && check_field_exists($table_categories, $table_categories_title_field)) {
                                $fieldname = $table_categories_title_field;
                            } elseif (check_field_exists($table_categories, "name")) {
                                $fieldname = "name";
                            } elseif (check_field_exists($table_categories, "title")) {
                                $fieldname = "title";
                            } elseif (check_field_exists($table_categories, "en_name")) {
                                $fieldname = "en_name";
                            } elseif (check_field_exists($table_categories, "en_title")) {
                                $fieldname = "en_title";
                            } elseif (check_field_exists($table_categories, "title_" . $lang)) {
                                $fieldname = "title_" . $lang;
                            } elseif (check_field_exists($table_categories, "name_" . $lang)) {
                                $fieldname = "name_" . $lang;
                            } else {
                                $fieldname = "id";
                            }

                            $table_fields = array(
                                // 'Name' => '<a href="' . $_SERVER["PHP_SELF"] . '?admin_option=' . $admin_option . '&table=###content_table###&action=view&pid=###id###' . (!empty($_GET["common_sense"])?"&common_sense=1":"") . '">###name###</a>', 
                                'Name' => '<a href="' . $_SERVER["PHP_SELF"] . '?admin_option=' . $admin_option . '&table=' . $table . '&action=view&pid=###id###' . (!empty($_GET["common_sense"]) ? "&common_sense=1" : "") . '">###' . $fieldname . '###</a>',
                            );
                            sitemap_fancy($table_categories, 0, 0, $table_fields, 'showorder', 1, $table_categories_query);
                            echo '</table>';
                        }

                        if ($show_more) {
                            echo '</td><td valign="top">
                                <div style="margin: 0px 0px 0px 20px;">'
                            . '<h2>' . $pname . '</h2>'
                            . (($show_viewadd) ? $menu_viewadd : '')
                            . '<div class="clear"></div>';
                        }
                    } else {
                        echo $menu_viewadd;
                    }
