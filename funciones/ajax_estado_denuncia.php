<?php
    session_start();
    
    if (isset($_SESSION['estado']))
        echo $_SESSION['estado'];
    else
        "nada";
?>
