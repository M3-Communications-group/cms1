<!DOCTYPE html>
<html data-bs-theme="light">

<head>
    <title>Admin Tool</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="icon" type="image/x-icon" href="images/statehouse_crest-removebg-preview.png">

    <!-- Bootstrap CSS CDN -->
    <link id="app-style" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Popper.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css?version=2">
    <link rel="stylesheet" type="text/css" href="css/app.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!-- Custom JavaScript -->
    <script src="assets/js/head.js"></script>
    <script src="assets/js/app.min.js"></script>

    <!-- TinyMCE -->
    <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>

</head>

<body class="p-0">
    <?php
    if (empty($_GET["hide_nav"])) {
    ?>

        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            <tr>
                <td valign="top">

                    <div id="wrapper">

                        <!-- menu-left -->
                        <div class="app-menu">
                            <div class="scrollbar py-3  ">


                                <!--- Menu -->
                                <ul class="menu">
                                    <!-- Brand Logo -->
                                    <div class="logo-box mt-4 mb-5">
                                        <a href="./main.php"><img src="images/statehouse_crest.jpg" alt="Logo" width="112" border="0" align="left"></a>
                                    </div>
                                    <!--- Menu -->
                                    <ul class="menu scrollbar" style="max-height: 67dvh; overflow-x: hidden;">



                                        <ul class="menu">
                                            <?php
                                            echo $menu_html;


                                            ?>
                                            <style>

                                            </style>
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
                                    <div class="topbar-menu d-flex align-items-center  gap-1">

                                        <!-- Topbar Brand Logo -->
                                        <div class="logo-box">
                                            <!-- Brand Logo Light -->
                                            <a href="index.html" class="logo-light">
                                                <img src="images/statehouse_crest-removebg-preview.png" alt="logo" class="logo-lg">
                                                <img src="images/statehouse_crest-removebg-preview.png" alt="small logo" class="logo-sm">
                                            </a>

                                            <!-- Brand Logo Dark -->
                                            <a href="main.php" class="logo-dark">
                                                <img src="images/statehouse_crest-removebg-preview.png" alt="dark logo" class="logo-lg">
                                                <img src="images/statehouse_crest-removebg-preview.png" class="logo-sm">
                                            </a>
                                        </div>

                                        <!-- Sidebar Menu Toggle Button -->
                                        <button id="toggle-menu" class="button-toggle-menu">
                                            <i class="bi bi-list"></i>
                                        </button>
                                        <!-- <script>
                                            
                                            document.getElementById('toggle-menu').addEventListener('click', function() {
                                                var e = n.config.sidenav.size,
                                                    t = n.html.getAttribute("data-sidenav-size", e);
                                                "full" === t ? n.showBackdrop() : "fullscreen" == e ? "fullscreen" === t ? n.changeLeftbarSize("fullscreen" == e ? "default" : e, !1) : n.changeLeftbarSize("fullscreen", !1) : "condensed" === t ? n.changeLeftbarSize("condensed" == e ? "default" : e, !1) : n.changeLeftbarSize("condensed", !1), n.html.classList.toggle("sidebar-enable")
                                            })
                                        </script> -->
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