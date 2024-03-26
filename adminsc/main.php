<?php

require("inc/head.php");



if (isset($commit_result)) {
    if ($commit_result[0]) {
        //gen_google_sitemap();
        if (function_exists($table . "_additional")) {
            eval($table . "_additional(" . $commit_result[1] . ");");
        }
        echo '<div class="success">' . $admin_texts[$lang]["success"] . '</div>';
    } else {
        echo '<div class="err">' . $commit_result[1] . '</div>';
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
<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content px-1 py-5" style="width: 30vw; display">
            <div class="modal-header">
                <h5 class="modal-title" id="Modal">Add menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>

            <?php

            echo '<h2>' . ucfirst($admin_texts[$lang][$action]) . '</h2>';
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
            echo '<input type="Submit" value="' . $admin_texts[$lang]["save"] . '" id="submit" class="btn btn-primary">';
            echo '</form></td></tr></table>';


            ?>

        </div>
    </div>
</div>
<?php

require("inc/bottom.php");
