<?php
//Datos generales de la denuncia
if (isset($_POST['chkGenerales'])){
    $Generales= implode(", ",$_POST['chkGenerales']);
    echo $Generales;
}

//Datos del denunciante
if (isset($_POST['chkDenunciante'])){
    $Denunciante= implode(", ",$_POST['chkDenunciante']);
    echo $Denunciante;
}

//Datos del denunciado
if (isset($_POST['chkDenunciado'])){
    $Denunciado= implode(", ",$_POST['chkDenunciado']);
    echo $Denunciado;
}


//Datos del ofendido
if (isset($_POST['chkOfendido'])){
    $Ofendido= implode(", ",$_POST['chkOfendido']);
    echo $Ofendido;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
    </body>
</html>