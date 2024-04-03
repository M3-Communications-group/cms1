<?php

$_GET["action"] = 'view';
$action = 'view';

require(__DIR__ . "/inc/head.php");

$showform = true;
$err = '';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["change"])) {
    
    $newPass = isset($_POST["new_password"]) ? $_POST["new_password"] : null;
    $confirm = isset($_POST["new_password1"]) ? $_POST["new_password1"] : null;
    $oldPass = isset($_POST["old_password"]) ? $_POST["old_password"] : null;

    
    $myq = "SELECT `password` FROM `m3cms_users` WHERE `id` = ?";
    $res = query($myq);
    
	if (!$res || mysqli_num_rows($res) === 0 || !password_verify($oldPass, mysqli_fetch_array($res)["password"])) {
        $err .= $admin_texts[$lang]["password_wong_old"] . '<br>';
    }

    if (!preg_match("/[^-a-zA-Z0-9.,?!@#$%^&*()_+=|~<>;:]+/", $newPass)) {
        $err .= $admin_texts[$lang]["password_invalid_symbols"] . "<br>";
    }
    if (strlen($newPass) < 8) {
        $err .= $admin_texts[$lang]["password_min8"] . "<br>";
    }
    if (!preg_match("/\\d+/", $newPass)) {
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
    
    if ($err === '' || $err === '0') {
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
    <div class="container"> 
        <div class="row justify-content-center mt-5"> 
            <div class="col-md-6"> 
                <form action="' . $_SERVER["PHP_SELF"] . '" method="post" id="main" class="needs-validation" novalidate> 
                    <div class="form-group"> 
                        <label for="old_password">' . $admin_texts[$lang]["password_old"] . ':</label> 
                        <input type="password" name="old_password" class="form-control" id="old_password" required> 
                        <div class="invalid-feedback"> 
                            ' . $admin_texts[$lang]["password_required"] . ' 
                        </div> 
                    </div> 
                    <div class="form-group"> 
                        <label for="new_password">' . $admin_texts[$lang]["password_new"] . ':</label> 
                        <input type="password" name="new_password" class="form-control" id="new_password" required> 
                        <div class="invalid-feedback"> 
                            ' . $admin_texts[$lang]["password_required"] . ' 
                        </div> 
                    </div> 
                    <div class="form-group"> 
                        <label for="new_password1">' . $admin_texts[$lang]["password_repeat"] . ':</label> 
                        <input type="password" name="new_password1" class="form-control" id="new_password1" required> 
                        <div class="invalid-feedback"> 
                            ' . $admin_texts[$lang]["password_required"] . ' 
                        </div> 
                    </div> 
                    <div class="form-group"> 
                        <input type="hidden" name="change" value="1"> 
                        <button type="submit" class="btn btn-primary">' . $admin_texts[$lang]["change"] . '</button> 
                    </div> 
                </form> 
            </div> 
        </div> 
    </div> 
    '; 
     
     
}
require(__DIR__ . "/inc/bottom.php");
