<?php
session_start();

if (isset($_SESSION['tipoacceso']))
    if ($_SESSION['tipoacceso'] == "Receptor"){
        echo "Receptor";
    }

?>
