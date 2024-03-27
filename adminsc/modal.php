<?php

//$table devuelve el nombre de la tabla a la que hacer el select

$myquery = "select * from `$table`"; //Select a toda la tabla

$MyResult = query($myquery); //Ejecutar la query

//función para crear el item
$formItems .= '';
function make_formItem ($label, $value) {

    return "<label>$label:</label> <input type='text' name='$label' value='$value'><br>";
}

if (mysqli_num_rows($MyResult) > 0) { //Si tiene algún valor recuperado
    $current_item = mysqli_fetch_assoc($MyResult); //Creamos el array con los resultados del select

    foreach ($current_item as $key => $value) { //Recorremos dicho array seccionandolo en
        //Procedemos a comprobar si el resultado contiene los valores que NO nos interesan
        if (!isset($row["id"]) || !isset($row["smallpath"]) || !isset($row["origpath"]) || !isset($row["showorder"]) || !isset($row["level"]) || !isset($row["has_children"]) || !isset($row["show_inmenu"]) || !isset($row["content_table"])) 
        {
            $formItems .= make_formItem($key, $value);

        }
    }
}


// Cosas que NO muestra el form


// CONDICIONES
// SI TIENE PID SE HACE SELECT A LA TABLA CON LOS PID=0 PARA EL SELECT
