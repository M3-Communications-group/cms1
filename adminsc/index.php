<?php
require("inc/head_operations.php");

if ($_SESSION['m3cms']["user_id"] > 0) { /// влезнал си бе, чичо ...
    mysqli_close($sqlConn);
    header("Location: main.php");
    die();
}
?>
<html>
    <head><title>Password request</title></head>
    <body>
        <form action="index.php" method="post">
            <label>Username: </label><input type="text"" name="user" value="">
            <label>Password: </label><input type="password" name="passwd">
            <input type="Hidden" name="token" value="<?php echo $_SESSION['m3cms']['token']; ?>">
            <input type=submit value="Go!">
        </form>
    </body>
</html>