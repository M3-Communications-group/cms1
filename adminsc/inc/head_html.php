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


        <div style="clear: both;"></div>
        <br>
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

                                    <li class="menu-title">Main Menu</li>

                                    <ul class="menu">
                                        <?php
                                        foreach ($menu_html as $menu_item) {
                                            echo $menu_item;
                                        }
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
                                                <div class="my-4">
                                                    <a class="mx-2 fs-5 text" href="change_password.php?admin_option=1" style="color: #850208;">Change password</a>

                                                </div>
                                                <!-- item-->
                                                <div>
                                                    <a class="mx-2 fs-5" href="index.php?logout" style="color: #850208;">Logout</a><br>

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
                    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="main" name="main" action="/new1-statehouse.gov.sc_0/public/adminsc/main.php?admin_option=29&amp;action=add&amp;table=&amp;pid=0&amp;start=view&amp;" method="post" enctype="multipart/form-data" onsubmit="content_doonsubmit(this); return false;"><label>* Type</label><br><select class="form-control" name="type">
                                            <option class="form-option" value="1" selected="">News</option>
                                            <option class="form-option" value="2">Speeches</option>
                                            <option class="form-option" value="3">Messages</option>
                                        </select><br><label>Topic</label><br><select class="form-control" name="pid" id="pid">
                                            <option class="form-option" value="0">Select...</option>
                                            <option class="form-option" value="37">Blue Economy</option>
                                            <option class="form-option" value="48">Cabinet Business</option>
                                            <option class="form-option" value="27">Climate Change</option>
                                            <option class="form-option" value="40">Commonwealth</option>
                                            <option class="form-option" value="10">Community Development</option>
                                            <option class="form-option" value="41">Condolences</option>
                                            <option class="form-option" value="32">Culture</option>
                                            <option class="form-option" value="2">Defence</option>
                                            <option class="form-option" value="18">Education</option>
                                            <option class="form-option" value="42">Employment</option>
                                            <option class="form-option" value="29">Energy</option>
                                            <option class="form-option" value="21">Enterpreneurship Development</option>
                                            <option class="form-option" value="26">Environment</option>
                                            <option class="form-option" value="23">Finance</option>
                                            <option class="form-option" value="47">Fisheries</option>
                                            <option class="form-option" value="19">Foreign Affairs</option>
                                            <option class="form-option" value="46">Gender</option>
                                            <option class="form-option" value="30">Health</option>
                                            <option class="form-option" value="34">Housing</option>
                                            <option class="form-option" value="6">Hydrocarbons</option>
                                            <option class="form-option" value="14">Immigration</option>
                                            <option class="form-option" value="8">Information Communications Technology</option>
                                            <option class="form-option" value="25">Investment</option>
                                            <option class="form-option" value="33">Land Use</option>
                                            <option class="form-option" value="3">Legal Affairs</option>
                                            <option class="form-option" value="20">Natural Resources</option>
                                            <option class="form-option" value="12">Piracy</option>
                                            <option class="form-option" value="45">Politics</option>
                                            <option class="form-option" value="43">Public Administration</option>
                                            <option class="form-option" value="13">Religion</option>
                                            <option class="form-option" value="28">SIDS</option>
                                            <option class="form-option" value="9">Social Affairs</option>
                                            <option class="form-option" value="11">Sport</option>
                                            <option class="form-option" value="1">State House</option>
                                            <option class="form-option" value="31">Tourism</option>
                                            <option class="form-option" value="17">Transport</option>
                                            <option class="form-option" value="5">Youth</option>
                                        </select><br><label>* Language</label><br><select class="form-control" name="language">
                                            <option class="form-option" value="1" selected="">English</option>
                                            <option class="form-option" value="2">French</option>
                                            <option class="form-option" value="3">Creole</option>
                                        </select><br><label>Date</label><br><input class="form-control" type="Text" name="date" value="2024-03-22"><br><label>* Title</label><br><input class="form-control" type="Text" name="title" value=""><br><label>Short title for slider (news only)</label><br><input class="form-control" type="Text" name="short_title" value=""><br><label>* Text</label><br>
                                        <script type="text/javascript">
                                            tinymce.init({
                                                // General options
                                                mode: "exact",
                                                elements: "text",
                                                gecko_spellcheck: true,
                                                plugins: ["advlist autolink lists link image charmap print preview hr anchor pagebreak", "searchreplace wordcount visualblocks visualchars code fullscreen", "insertdatetime media nonbreaking save table directionality paste"],
                                                menubar: false,
                                                relative_urls: true,
                                                remove_script_host: false,
                                                document_base_url: "",
                                                entity_encoding: "raw",
                                                image_advtab: true,
                                                resize: "both",
                                                // contextmenu: "link image inserttable | cell row column deletetable",

                                                paste_use_dialog: true,
                                                paste_auto_cleanup_on_paste: true,
                                                paste_convert_headers_to_strong: false,
                                                paste_strip_class_attributes: "all",
                                                paste_remove_spans: true,
                                                paste_remove_styles: true,

                                                // Theme options
                                                toolbar1: "pastetext | styleselect |  bold italic underline sub sup | link unlink anchor | image media | alignleft aligncenter alignright | bullist numlist | table | removeformat code",
                                                toolbar2: "",

                                                content_css: "css/rte.css" // resolved to http://domain.mine/mycontent.css
                                            });
                                        </script>


                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>

                                        <div style="clear: both;"></div>
                                        <label>Photo (news only) - min size 720x458</label><br><input class="form-control" type="File" name="photo_big_homepage"><br><label>* Show on homepage slider</label><br><select class="form-control" name="home_page_show">
                                            <option class="form-option" value="0" selected="">No</option>
                                            <option class="form-option" value="1">Yes</option>
                                        </select><br><label>* Active</label><br><select class="form-control" name="active">
                                            <option class="form-option" value="0">No</option>
                                            <option class="form-option" value="1" selected="">Yes</option>
                                        </select><br>
                                        <script language="JavaScript">
                                            function content_doonsubmit(mmmyform) {


                                                mmmyform.submit();
                                            }
                                        </script><input class="btn btn-primary" type="Submit" value="Save" id="submit">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="button" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>