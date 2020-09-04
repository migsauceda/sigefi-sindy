<?php
    include("../clases/Usuario.php");
//    include "funciones/php_funciones.php";

    session_start();

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
<?php

echo $objUsuario->getUsuario();
echo "<br>";
echo $objUsuario->getOficina();
echo "<br>";
echo $objUsuario->getRolId();
echo "<br>";
if ($objUsuario->getRolId()==2) {
echo "Fiscal Normal";
}
elseif ($objUsuario->getRolId()==3) {
echo "Fiscal Jefe";
}


?>
  </body>
</html>
