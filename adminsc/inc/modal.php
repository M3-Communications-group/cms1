<?php
require "mysql_connect.php"; //Connect DB

//Obtain form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Store form data
    $fields = array();
    $values = array();

    foreach ($_POST as $field => $value) {
        //Add data to arrays
        $fields[] = $field;
        $values[] = $value;
    }

    //Query
    $sqlQuery = 'INSERT INTO ' . $table . '(' . implode(',', $fields) . ') VALUES (';
    $valuesQuery = array();
    foreach ($values as $value) {
        //
        $valuesQuery[] = "'" . $value . "'";
    }
    $sqlQuery .= implode(',', $valuesQuery) . ')';

    //Execute
    if ($conn->query($sqlQuery)) {
        header('Location: '. 'main.php');
    } else {
        $err = 1;
    header('Location: '. 'main.php');
    }
} else {
    $err = 1;
    header('Location: '. 'main.php');
}
