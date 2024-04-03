<?php

require_once __DIR__ . "/mysql_connect.php";

session_start();
$servername = filter_input(INPUT_SERVER, "HTTP_HOST", FILTER_SANITIZE_URL);
$session_id = session_id();

if (isset($_GET['logout'])) {
    $myq = "UPDATE m3cms_users_log "
            . " SET session_id = '', logged = '0' "
            . " WHERE session_id = '" . $session_id . "'";
    mysqli_query($sqlConn, $myq);
    $_SESSION = array();
    unset($_SESSION);
    session_destroy();
    mysqli_close($sqlConn);
    header("Location: http://" . $servername . '/');
    die();
}

date_default_timezone_set('Europe/Sofia');
$_SESSION['ip'] = filter_input(INPUT_SERVER, "REMOTE_ADDR", FILTER_VALIDATE_IP);

if (!isset($_SESSION['m3cms']) || !is_array($_SESSION['m3cms'])) {
    $_SESSION['m3cms'] = array();
}
if (!isset($_SESSION['m3cms']['token'])) { //|| (isset($_POST['token']) && $_POST['token'] != $_SESSION['token'])) {
    $_SESSION['m3cms']['token'] = md5(uniqid(mt_rand(), TRUE));
}
if (!isset($_SESSION['m3cms']['prevURL'])) {
    $_SESSION['m3cms']['prevURL'] = '';
}
if (!isset($_SESSION['m3cms']['username'])) {
    $_SESSION['m3cms']['username'] = "";
}
if (!isset($_SESSION['m3cms']['password'])) {
    $_SESSION['m3cms']['password'] = "";
}
// това винаги се проверява !!!!!
$_SESSION['m3cms']['user_id'] = 0;
$_SESSION['m3cms']['group_id'] = '';

$token = isset($_POST['token']) ? $_POST['token'] : null;
$username = isset($_POST['user']) ? $_POST['user'] : null;
$password = isset($_POST['passwd']) ? $_POST['passwd'] : null;

// login
if ($username && $password && $token === $_SESSION['m3cms']['token']) {
    $_SESSION['m3cms']['username'] = $username;
    $_SESSION['m3cms']['password'] = $password;
    $_SESSION['m3cms']['token'] = md5(uniqid(mt_rand(), TRUE));
}

if (!empty($_SESSION['m3cms']['username']) && !empty($_SESSION['m3cms']['password'])) {

    $esc = [
        'user' => mysqli_real_escape_string($sqlConn, $_SESSION['m3cms']['username']),
        'pass' => mysqli_real_escape_string($sqlConn, $_SESSION['m3cms']['password']),
        'ip' => mysqli_real_escape_string($sqlConn, $_SESSION['ip']),
    ];
    $logAction = 'invalid username';
    $logged = 0;
    $myq = "SELECT id 
		FROM m3cms_users_log 
		WHERE time_last >= DATE_SUB(NOW(), INTERVAL 24 HOUR) 
			AND ip = '" . $esc['ip'] . "' 
			AND action LIKE 'invalid%'";
    $res = mysqli_query($sqlConn, $myq);
    if (mysqli_num_rows($res) > 5) {
        mail("webmaster@m3bg.com", $servername . " admin user blocked ", $_SESSION['ip'] . "\n" . date("Y-m-d H:i:s") . "\n" . filter_input(INPUT_SERVER, "REQUEST_URI", FILTER_SANITIZE_URL) . "\n");
    } else {
        $myq = "SELECT `id`, `group_id`, `password`, IF(`name` IS NULL, `username`, `name`) AS `full_name`
		FROM `m3cms_users`
		WHERE `username`='" . $esc['user'] . "' 
			AND `expires` > NOW()";
        $res = mysqli_query($sqlConn, $myq);
        if (mysqli_num_rows($res) > 0) {
            $r = mysqli_fetch_array($res);
            if (password_verify($_SESSION['m3cms']['password'], $r['password'])) {
                $_SESSION['m3cms']['password'] = md5($r['password']);
            }
            if (md5($r['password']) == $_SESSION['m3cms']['password']) {
                $_SESSION['m3cms']['user_id'] = $r['id'];
                $_SESSION['m3cms']['group_id'] = $r['group_id'];
                $_SESSION['m3cms']['name'] = $r['full_name'];
                $myq = "UPDATE `m3cms_users_log` SET `views` = `views` + 1, `time_last` = NOW() "
                        . " WHERE session_id = '" . $session_id . "'  AND logged AND DATE_ADD(time_login, INTERVAL 24 HOUR) > NOW()";
                mysqli_query($sqlConn, $myq);
                if (mysqli_affected_rows($sqlConn) > 0) {
                    $logAction = false;
                } else {
                    $logAction = 'access';
                    $logged = 1;
                }
            } else {
                $logAction = 'invalid password';
            }
        } else {
            $logAction = 'invalid username';
        }
        if ($logAction) {
            $myq = "INSERT INTO `m3cms_users_log` "
                    . " (session_id, time_login, time_last, username, ip, views, logged, action) "
                    . " VALUES ('" . $session_id . "', NOW(), NOW(), '" . $esc['user'] . "', '" . $esc['ip'] . "', '0', '" . $logged . "', '" . $logAction . "')";
            mysqli_query($sqlConn, $myq);
        }
    }
}

$isSetID = intval($_SESSION['m3cms']['user_id']) > 0;
$isSetUser = !empty($_SESSION['m3cms']['username']);

if ($isSetUser !== $isSetID) {
    $_SESSION['m3cms'] = array();
    mysqli_close($sqlConn);
    header("Location: index.php");
    die();
}
