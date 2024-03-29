<?php

require("inc/head.php");



if (isset($commit_result) && $_SERVER["REQUEST_METHOD"] == "POST") {
    if ($commit_result[0]) {
        //gen_google_sitemap();
        if (function_exists($table . "_additional")) {
            eval($table . "_additional(" . $commit_result[1] . ");");
        }
        echo '<div class="success">' . $admin_texts[$lang]["success"] . '</div>';
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo '<div class="err">' . $commit_result[1] . '</div>';
        }
    }
}

// if (($action == 'edit' && !empty($_GET["editID"])) || $action == 'add') {
//     echo '<h2>' . ucfirst($admin_texts[$lang][$action]) . '</h2>';
//     echo '<table border="0" cellpadding="0" cellspacing="0" id="main_form_container"><tr><td>
// 			<form id="main" name="main" action="' . $_SERVER["PHP_SELF"] . $CURRENT_LOCATION . '" method="post" enctype="multipart/form-data" onsubmit="content_doonsubmit(this); return false;">';
//     $doonsubmit = '';
//     if (!empty($edit_additional_stuff_top)) {
//         echo "" . $edit_additional_stuff_top . "";
//     }
//     if (empty($custom_form)) {
//     } else {
//         echo $custom_form;
//     }
//     if (!empty($_GET["editID"])) {
//         echo '<input type="Hidden" value="' . $_GET["editID"] . '" name="editID">';
//     }
//     if (!empty($edit_additional_stuff_bottom)) {
//         echo additional_stuff();
//     }
// }

if ($action == 'view') {
    if (!empty($view_additional_stuff_top)) {
        echo "" . $view_additional_stuff_top . "";
    }
    if (count($fields_to_show) > 0) {
        $start = filter_input(INPUT_GET, 'start', FILTER_VALIDATE_INT, ['options' => ['default' => 0, 'min_range' => 1]]);
        sitemap($table, $fields_to_show, $pid, 0, $fields_to_show, $fields_showorder, $start, $custom_limit, $sub_pid, $fields_to_show_join, $fields_to_select, (!empty($custom_where) ? $custom_where : ""), (!empty($group_by) ? $group_by : ""), (!empty($show_sum) ? $show_sum : ""));
    }

    if (!empty($view_additional_stuff_bottom)) {
        echo additional_stuff_view();
    }
}
?>
<script>
    var rows = document.querySelectorAll('table tr:not(:first-child)');
    rows.forEach(function(row) {
        var link = row.cells[1].querySelector('a');

        link.setAttribute('href', '#ModalEdit');
        link.setAttribute('data-bs-toggle', 'modal');
        link.setAttribute('data-bs-target', '#ModalEdit');




    });
</script>

<a href="?admin_option=28&amp;start=view&amp;&amp;editID=1400&amp;action=edit"><img src="images/edit.gif" alt="" width="16" height="16" border="0"><img src="../uploads/galls_photos/1400_sjWC6t0Ux.jpg" border="0"></a>

<!-- Modal Add-->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content px-1 py-2 px-5" style="min-width: 40vw">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <?php
                $action = 'add';
                echo '<h2>Add</h2>';
                echo '<table border="0" cellpadding="0" cellspacing="0" id="main_form_container"><tr><td>
			<form id="main" name="main" action="' . $_SERVER["PHP_SELF"] . $CURRENT_LOCATION . '" method="post" enctype="multipart/form-data" onsubmit="content_doonsubmit(this); return false;">';
                $doonsubmit = '';
                if (!empty($edit_additional_stuff_top)) {
                    echo "" . $edit_additional_stuff_top . "";
                }
                if (empty($custom_form)) {
                    foreach ($fields_to_manage as $key => $val) {

                        echo make_form_item($val, $current_item);
                    }
                } else {
                    echo $custom_form;
                }
                if (!empty($_GET["editID"])) {
                    echo '<input type="Hidden" value="' . $_GET["editID"] . '" name="editID">';
                }
                if (!empty($edit_additional_stuff_bottom)) {
                    echo additional_stuff();
                }
                echo '
		<script language="JavaScript">
                    function content_doonsubmit(mmmyform) { 
                            ' . (!empty($doonsubmit) ? $doonsubmit : '') . ' 
                            ' . ((find_rte($fields_to_manage)) ? '
                            editor._textArea.value = editor.getHTML();
                            var a = this.__msh_prevOnSubmit;
                            // call previous submit methods if they were there.
                            if (typeof a != "undefined") {
                                for (var i = a.length; --i >= 0;) {
                                    a[i]();
                                }
                            }
                        ' : '')
                    . '
                        mmmyform.submit();
                    } 
                    
		</script>';
                echo '
            <script>
            var inputs = document.getElementsByTagName("input");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].classList.add("form-control");
            }
            
        </script>
        
        ';
                echo '<input type="Submit" value="' . $admin_texts[$lang]["save"] . '" id="submit" class="btn btn-primary">';
                echo '</form></td></tr></table>';


                ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit-->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content px-1 py-2 px-5" style="width: fit-content;">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <?php
                $action = 'edit';
                echo '<h2>Edit</h2>';
                echo '<table border="0" cellpadding="0" cellspacing="0" id="main_form_container"><tr><td>
			<form id="main" name="main" action="' . $_SERVER["PHP_SELF"] . $CURRENT_LOCATION . '" method="post" enctype="multipart/form-data" onsubmit="content_doonsubmit(this); return false;">';
                $doonsubmit = '';
                if (!empty($edit_additional_stuff_top)) {
                    echo "" . $edit_additional_stuff_top . "";
                }
                if (empty($custom_form)) {
                    foreach ($fields_to_manage as $key => $val) {

                        echo make_form_item($val, $current_item);
                    }
                } else {
                    echo $custom_form;
                }
                if (!empty($_GET["editID"])) {
                    echo '<input type="Hidden" value="' . $_GET["editID"] . '" name="editID">';
                }
                if (!empty($edit_additional_stuff_bottom)) {
                    echo additional_stuff();
                }
                echo '
		<script language="JavaScript">
                    function content_doonsubmit(mmmyform) { 
                            ' . (!empty($doonsubmit) ? $doonsubmit : '') . ' 
                            ' . ((find_rte($fields_to_manage)) ? '
                            editor._textArea.value = editor.getHTML();
                            var a = this.__msh_prevOnSubmit;
                            // call previous submit methods if they were there.
                            if (typeof a != "undefined") {
                                for (var i = a.length; --i >= 0;) {
                                    a[i]();
                                }
                            }
                        ' : '')
                    . '
                        mmmyform.submit();
                    } 
                    
		</script>';
                echo '
        <script>
                var inputs = document.getElementsByTagName("input");
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].classList.add("form-control");
                }
               
        </script>
        ';
                echo '<input type="Submit" value="' . $admin_texts[$lang]["save"] . '" id="submit" class="btn btn-primary">';
                echo '</form></td></tr></table>';


                ?>
<script>
    function toggle_color(row) {
        var td = row.getElementsByTagName('td')[4]; // Seleccionar el quinto td (índice 4)
        var link = td.querySelector('a');

        // Agregar las propiedades data-bs-toggle y data-bs-target al enlace
        link.setAttribute('data-bs-toggle', 'modal');
        link.setAttribute('data-bs-target', '#ModalEdit');

        // Realizar acciones adicionales si es necesario
    }
</script>
<script>
    function toggle_color(row) {
        var td = row.getElementsByTagName('td')[4]; // Seleccionar el quinto td (índice 4)
        var link = td.querySelector('a');

        // Agregar las propiedades data-bs-toggle y data-bs-target al enlace
        link.setAttribute('data-bs-toggle', 'modal');
        link.setAttribute('data-bs-target', '#ModalEdit');
        link.removeAttribute('href');

        // Mostrar el segundo modal
        $('#ModalEdit').modal('show');
    }
</script>



            </div>
        </div>
    </div>
</div>

<?php

require("inc/bottom.php");
