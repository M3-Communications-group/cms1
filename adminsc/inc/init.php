<?php

require_once __DIR__ . '/session.php';

if (TRUE !== $isSetID) {
    mysqli_close($sqlConn);
    header("Location: index.php");
    die();
}
