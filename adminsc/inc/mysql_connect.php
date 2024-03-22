<?php

require_once __DIR__ . "/../../../settings/config.php";

$sqlConn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_BASE, DB_PORT) or die("System check in progress. Please, try again later.");

mysqli_query($sqlConn, "SET NAMES " . DB_COLLATE);
