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
<!-- Modal Add -->
<div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="ModalAddLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content px-1 py-2 px-5" style="min-width: 40vw">
            <div class="modal-header">
                <h2 class="modal-title" id="ModalAddLabel">Add</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php

                echo '<table border="0" cellpadding="0" cellspacing="0" id="main_form_container">
                    <tr>
                        <td>
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
                echo ' <script language="JavaScript"> function content_doonsubmit(mmmyform) { 
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
                        ' : '') . '
                        mmmyform.submit();
                    } 
    </script>';
                echo '<input class="btn btn-primary" type="Submit" value="' . $admin_texts[$lang]["save"] . '" id="submit">';
                echo '</form></td></tr></table>';

                ?>
            </div>
        </div>
    </div>
</div>


<!-- Edit Modals -->
<?php
$maxID = getMaxId($table);

for ($i = 0; $i < $maxID; $i++) {
    echo '<div class="modal fade" id="ModalEdit' . ($i + 1) . '" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content px-1 py-2 px-5" style="min-width: 40vw">
            <div class="modal-header">
                <h2 class="modal-title" id="ModalEditLabel">Edit</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">';
    echo '<table border="0" cellpadding="0" cellspacing="0" id="main_form_container">
                    <tr>
                        <td>
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

    echo '<input type="Hidden" value="' . ($i + 1) . '" name="editID">';

    if (!empty($edit_additional_stuff_bottom)) {
        echo additional_stuff();
    }
    echo ' <script language="JavaScript"> function content_doonsubmit(mmmyform) { 
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
                        ' : '') . '
                        mmmyform.submit();
                    } 
    </script>';
    echo '<input class="btn btn-primary" type="Submit" value="' . $admin_texts[$lang]["save"] . '" id="submit">';
    echo '</form></td></tr></table>';
    echo '</div>
                </div>
            </div>
        </div>';
}

require("inc/bottom.php");

?>
<script>
    $('textarea').addClass('form-control');

    var links = $('a');

    links.each(function(index, link) {
        var childs = $(link).children();

        childs.each(function(index, child) {
            if (child.tagName.toLowerCase() === 'img' && $(child).attr('src') === 'images/down.gif') {
                var newChild = $('<i class="bi bi-arrow-down"></i>');
                $(link).empty().append(newChild);
            
            } else if (child.tagName.toLowerCase() === 'img' && $(child).attr('src') === 'images/up.gif') {
                var newChild = $('<i class="bi bi-arrow-up"></i>');
                $(link).empty().append(newChild);
            
            } else if (child.tagName.toLowerCase() === 'img' && $(child).attr('src') === 'images/delete.gif') {
                var newChild = $('<i class="bi bi-trash"></i>');
                $(link).empty().append(newChild);
            
            }
        });
    });
</script>