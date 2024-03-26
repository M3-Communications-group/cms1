<!DOCTYPE HTML>

<html>

<head>
    <title>Admin Tool</title>
    <META http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css?version=2" />
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/jquery-migrate-1.2.1.min.js"></script>
    <link rel="icon" type="image/x-icon" href="images\statehouse_crest.jpg">
    <!-- <script language="JavaScript" src="../js/ajax.js"></script> -->
    <!--
        <script type="text/javascript" src="inc/tiny_mce/tiny_mce.js"></script>
        <script src="js/ckeditor/ckeditor.js"></script>
        -->

    <link rel="stylesheet" href="css\app.min.css">
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="css\bootstrap.min.css">

    <script src="js\app.min.js"></script>
    <script src="js\head.js"></script>
    <script src="js\vendor.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


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

        function openWindow(mypage, myname, w, h, scroll) {
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

        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            <tr>
                <td valign="top">

                    <div id="wrapper">

                        <!-- menu-left -->
                        <div class="app-menu">
                            <div class="scrollbar py-5">


                                <!--- Menu -->
                                <ul class="menu">
                                    <!-- Brand Logo -->
                                    <div class="logo-box mb-5">
                                        <a href="./main.php"><img src="images/statehouse_crest.jpg" alt="Logo" width="112" border="0" align="left"></a>
                                    </div>


                                    <ul class="menu">
                                        <?php

                                        // foreach ($menu_html as $menu_item) {
                                        //     echo $menu_item;
                                        // }

                                        echo $menu_html;


                                        ?>
                                    </ul>
                                </ul>

                                <!--- End Menu -->
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <!-- ============================================================== -->
                        <!-- Start Page Content here -->
                        <!-- ============================================================== -->
                        <div class="content-page ">

                            <!-- ========== Topbar Start ========== -->
                            <div class="navbar-custom">
                                <div class="topbar">
                                    <div class="topbar-menu d-flex align-items-center gap-1">

                                        <!-- Topbar Brand Logo -->
                                        <div class="logo-box">
                                            <!-- Brand Logo Light -->
                                            <a href="index.html" class="logo-light">
                                                <img src="images/statehouse_crest.jpg" alt="logo" class="logo-lg">
                                                <img src="images/statehouse_crest.jpg" alt="small logo" class="logo-sm">
                                            </a>

                                            <!-- Brand Logo Dark -->
                                            <a href="main.php" class="logo-dark">
                                                <img src="images/statehouse_crest.jpg" alt="dark logo" class="logo-lg">
                                                <img src="images/statehouse_crest.jpg" alt="small logo" class="logo-sm">
                                            </a>
                                        </div>

                                        <!-- Sidebar Menu Toggle Button -->
                                        <button class="button-toggle-menu">
                                            <i class="mdi mdi-menu"></i>
                                        </button>
                                    </div>

                                    <ul class="topbar-menu d-flex align-items-center">

                                        <!-- App Dropdown -->
                                        <li class="dropdown d-none d-md-inline-block">
                                            <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                <i class="fe-grid font-22"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg p-0">

                                                <div class="p-2">
                                                    <div class="row g-0">
                                                        <div class="col">
                                                            <a class="dropdown-icon-item" href="#">
                                                                <img src="images/brands/slack.png" alt="slack">
                                                                <span>Slack</span>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <a class="dropdown-icon-item" href="#">
                                                                <img src="images/brands/github.png" alt="Github">
                                                                <span>GitHub</span>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <a class="dropdown-icon-item" href="#">
                                                                <img src="images/brands/dribbble.png" alt="dribbble">
                                                                <span>Dribbble</span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="row g-0">
                                                        <div class="col">
                                                            <a class="dropdown-icon-item" href="#">
                                                                <img src="images/brands/bitbucket.png" alt="bitbucket">
                                                                <span>Bitbucket</span>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <a class="dropdown-icon-item" href="#">
                                                                <img src="images/brands/dropbox.png" alt="dropbox">
                                                                <span>Dropbox</span>
                                                            </a>
                                                        </div>
                                                        <div class="col">
                                                            <a class="dropdown-icon-item" href="#">
                                                                <img src="images/brands/g-suite.png" alt="G Suite">
                                                                <span>G Suite</span>
                                                            </a>
                                                        </div>
                                                    </div> <!-- end row-->
                                                </div>
                                            </div>
                                        </li>

                                        <!-- Language flag dropdown  -->
                                        <li class="dropdown d-none d-md-inline-block">
                                            <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                <img src="images/flags/us.jpg" alt="user-image" class="me-0 me-sm-1" height="18">
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">

                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <img src="images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                                                </a>

                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <img src="images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                                                </a>

                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <img src="images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                                                </a>

                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <img src="images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                                                </a>

                                            </div>
                                        </li>

                                        <!-- User Dropdown -->
                                        <li class="dropdown">
                                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                <img src="images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                                                <span class="ms-3 d-none d-md-inline-block">
                                                    <h1 class="user"><?php echo $_SESSION['m3cms']["name"] ?></h1> <i class="mdi mdi-chevron-down"></i>
                                                </span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                                                <!-- item-->
                                                <div class="my-3">
                                                    <a class="mx-2 fs-5 text text-primary" href="change_password.php?admin_option=1" style="color: #850208;">Change password</a>

                                                </div>
                                                <!-- item-->
                                                <div class=" mt-4 mb-3">
                                                    <a class="mx-2 fs-5 text-primary" href="index.php?logout" style="color: #850208;">Logout</a><br>

                                                </div>

                                            </div>
                                        </li>

                                        <!-- Right Bar offcanvas button (Theme Customization Panel) -->
                                        <li>
                                            <a class="nav-link waves-effect waves-light" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                                                <i class="fe-settings font-22"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- ========== Topbar End ========== -->

                            <div class="content">

                                <!-- Start Content-->
                                <div class="container-fluid">

                                    <div class="row mt-5">
                                    <?php
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
                                        echo '</td><td valign="top"> <div style="margin: 0px 0px 0px 20px;">' . '<h2>' . $pname . '</h2>' . (($show_viewadd) ? $menu_viewadd : '') . '<div class="clear"></div>';
                                    }
                                } else {
                                    echo $menu_viewadd;
                                }
                                    ?>
                                    </div>

                                    <!-- end row -->

                                </div> <!-- container -->

                            </div> <!-- content -->
                        </div>
                    </div>
                    <?php
                    require('modal.php');
                    ?>