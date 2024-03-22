<?php

$_GET["action"] = 'view';
$action = 'view';

require("inc/head.php");

$showform = true;
$err = '';

if (filter_input(INPUT_POST, "change")) {

    $newPass = filter_input(INPUT_POST, "new_password", FILTER_SANITIZE_STRING);
    $confirm = filter_input(INPUT_POST, "new_password1", FILTER_SANITIZE_STRING);
    $oldPass = filter_input(INPUT_POST, "old_password", FILTER_SANITIZE_STRING);
    $myq = "SELECT `password` FROM `m3cms_users` "
            . " WHERE `id`='" . mysqli_real_escape_string($sqlConn, $_SESSION['m3cms']['user_id']) . "' 
			AND `expires` > NOW()";
    $res = query($myq);
    
	if (mysqli_num_rows($res) == 0 || !password_verify($oldPass, mysqli_fetch_array($res)["password"])) {
        $err .= $admin_texts[$lang]["password_wong_old"] . '<br>';
    }
    if (preg_match("/[^-a-zA-Z0-9.,?!@#$%^&*()_+=|~<>;:]+/", $newPass)) {
        $err .= $admin_texts[$lang]["password_invalid_symbols"] . "<br>";
    }
    if (strlen($newPass) < 8) {
        $err .= $admin_texts[$lang]["password_min8"] . "<br>";
    }
    if (!preg_match("/[0-9]+/", $newPass)) {
        $err .= $admin_texts[$lang]["password_one_number"] . "<br>";
    }
    if (!preg_match("/[a-z]+/", $newPass)) {
        $err .= $admin_texts[$lang]["password_one_small_letter"] . "<br>";
    }
    if (!preg_match("/[A-Z]+/", $newPass)) {
        $err .= $admin_texts[$lang]["password_one_big_letter"] . "<br>";
    }
    if ($newPass != $confirm) {
        $err .= $admin_texts[$lang]["passwords_dont_match"] . '<br>';
    }
    if (empty($err)) {
        $new = password_hash($newPass, PASSWORD_DEFAULT);
        $myq = "UPDATE m3cms_users SET password = '" . mysqli_real_escape_string($sqlConn, $new) . "' WHERE `id`='" . (int) $_SESSION['m3cms']["user_id"] . "' AND `expires`>NOW()";
        query($myq);
        if (mysqli_affected_rows($sqlConn) > 0) {
            $_SESSION['m3cms']["password"] = md5($new);
            echo '<div class="success">' . $admin_texts[$lang]["password_changed"] . '</div>';
            $showform = false;
        } else {
            echo '<div class="err">Unknown error occured.</div>';
        }
    } else {
        echo '<div class="err">' . $err . '</div>';
    }
}

if ($showform) {
    echo '
<table border="0" cellpadding="0" cellspacing="0" id="main_form_container"><tr><td>
<form action="' . $_SERVER["PHP_SELF"] . '" method="post" id="main">
<table border="0" cellpadding="5" cellspacing="0" class="normal_inputs change_password">
	<tr><td>' . $admin_texts[$lang]["password_old"] . ': </td><td><input type="Password" name="old_password" value="" size="30"><br></td></tr>
	<tr><td>' . $admin_texts[$lang]["password_new"] . ': </td><td><input type="Password" name="new_password" value="" size="30"><br></td></tr>
	<tr><td>' . $admin_texts[$lang]["password_repeat"] . ': </td><td><input type="Password" name="new_password1" value="" size="30"><br></td></tr>
	<tr><td colspan="2">
	<input type="Hidden" name="change" value="1">
	<input type=submit value="' . $admin_texts[$lang]["change"] . '"><br><br></td></tr>
</table>
</form>
</tr></td></table>
';
}
require("inc/bottom.php");
