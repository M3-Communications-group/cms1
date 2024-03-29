<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" class="pb-0">

<head>
    <meta charset="utf-8" />
    <title>Calendar | Ubold - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="images\statehouse_crest.jpg">

    <!-- Plugin css -->
    <link href="../assets/libs/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="assets/js/head.js"></script>

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css?version=2">
    <link rel="stylesheet" type="text/css" href="css/app.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- Custom JavaScript -->
    <script src="assets/js/head.js"></script>
    <script src="assets/js/app.min.js"></script>
</head>

<body class="pt-0 mt-0">
    <?php
    if (empty($_GET["hide_nav"])) {
    ?>
        <!-- Begin page -->
        <div id="wrapper">


            <!-- ========== Menu ========== -->
            <div class="app-menu">

                <!-- Brand Logo -->
                <div class="logo-box">
                    <!-- Brand Logo Light -->
                    <a href="main.php" class="logo-light">
                        <img src="images/statehouse_crest.jpg" alt="logo" class="logo-lg" style="height: 60px;">
                        <img src="images/statehouse_crest.jpg" alt="small logo" class="logo-sm" style="height: 40px;">
                    </a>

                    <!-- Brand Logo Dark -->
                    <a href="main.php" class="logo-dark">
                        <img src="images/statehouse_crest.jpg" alt="dark logo" class="logo-lg" style="height: 60px;">
                        <img src="images/statehouse_crest.jpg" alt="small logo" class="logo-sm" style="height: 40px;">
                    </a>
                </div>

                <!-- menu-left -->
                <div class="scrollbar">

                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
                        <div class="dropdown">
                            <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown">Geneva Kennedy</a>
                            <div class="dropdown-menu user-pro-dropdown">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-settings me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-lock me-1"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-log-out me-1"></i>
                                    <span>Logout</span>
                                </a>

                            </div>
                        </div>
                        <p class="text-muted mb-0">Admin Head</p>
                    </div>

                    <!--- Menu -->
                    <ul class="menu">
                        <?php
                        echo $menu_html;


                        ?>
                        <style>

                        </style>
                    </ul>
                    <!--- End Menu -->
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- ========== Left menu End ========== -->





            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <!-- ========== Topbar Start ========== -->
                <div class="navbar-custom">
                    <div class="topbar">
                        <div class="topbar-menu d-flex align-items-center gap-1">

                            <!-- Topbar Brand Logo -->
                            <div class="logo-box">
                                <!-- Brand Logo Light -->
                                <a href="main.php" class="logo-light">
                                    <img src="images/statehouse_crest.jpg" alt="logo" class="logo-lg" style="height: 60px;">
                                    <img src="images/statehouse_crest.jpg" alt="small logo" class="logo-sm" style="height: 40px;">
                                </a>

                                <!-- Brand Logo Dark -->
                                <a href="main.php" class="logo-dark">
                                    <img src="images/statehouse_crest.jpg" alt="dark logo" class="logo-lg" style="height: 60px;">
                                    <img src="images/statehouse_crest.jpg" alt="small logo" class="logo-sm" style="height: 40px;">
                                </a>
                            </div>

                            <!-- Sidebar Menu Toggle Button -->
                            <button class="button-toggle-menu">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                                </svg>
                            </button>

                        </div>

                        <ul class="topbar-menu d-flex align-items-center">



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

                            <!-- Light/Darj Mode Toggle Button -->
                            <li class="d-none d-sm-inline-block">
                                <div class="nav-link waves-effect waves-light" id="light-dark-mode">
                                    <i class="bi bi-brightness-high-fill me-2"></i> / <i class="bi bi-moon ms-2"></i>
                                </div>
                            </li>


                            </li>

                            <!-- User Dropdown -->
                            <li class="dropdown">
                                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <img src="images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                                    <span class="ms-3 d-none d-md-inline-block">
                                        <h1 class="user"><?php echo $_SESSION['m3cms']["name"] ?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down" viewBox="0 0 16 16">
                                                <path d="M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659" />
                                            </svg> </h1>
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

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <script>
                                document.write(new Date().getFullYear())
                            </script>© <a href="https://www.m3bg.com/" target="_blank">M3 Communications Group, Inc.</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-none d-md-flex gap-4 align-item-center justify-content-md-end footer-links">
                            <a href="javascript: void(0);">About</a>
                            <a href="javascript: void(0);">Support</a>
                            <a href="javascript: void(0);">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>

        </footer>


        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

        <!-- plugin js -->
        <script src="../assets/libs/moment/min/moment.min.js"></script>
        <script src="../assets/libs/fullcalendar/main.min.js"></script>

        <!-- Calendar init -->
        <script src="assets/js/pages/calendar.init.js"></script>

</body>

</html>