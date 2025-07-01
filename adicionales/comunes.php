<?php

include_once '../adicionales/varios.php';

if ($_POST["caso"] === '1') {

    $numero = $_POST["datosAEnviar"]["numero"];
    $np_tiponit = intval($_POST["datosAEnviar"]["np_tiponit"]);
        
    //si es un número 
    if (is_numeric($numero)) {
        //verifica si es un NIT colombiano
        if ($np_tiponit === 31) {
            //retorna el digito de verificación
            //iria a la tabla nm_juridicas
            echo json_encode(calcularDigitoVerificacion($numero));
        } else {
            //retorna -2 para significar que es una persona natural
            //iria a la tabla nm_personas
            echo json_encode('-2');
        }
    } else {
        //retornar -1 para significar que es un cliente internacional y es un tipo juridico por 
        //tanto iría a la tabla nm_juridicas
        echo json_encode('-1');
    }

}