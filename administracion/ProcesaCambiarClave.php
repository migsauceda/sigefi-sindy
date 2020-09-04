<?php
session_start();

include_once("../clases/class_conexion_pg.php");
include_once("../funciones/php_funciones.php");

//variables recibidas
$Actual= $_POST["PassActual"];
$Nueva=  $_POST["PassNueva"];
$Repita= $_POST["PassRepita"];
        
//otras variables
$Longitud= -1;
$Valido= -1;
$Exito= 1;
$Usr= $_SESSION['usuario'];

//conocer la contrasena encriptada
$oConeccion= new Conexion();
$sql= "SELECT usuario, contrasena 
        FROM mini_sedi.tbl_usuarios WHERE usuario='$Usr'";

$resultado=$oConeccion->ejecutarComando($sql); 

//verificar si se obtiene contraseña. 
if (pg_num_rows($resultado)<= 0){  
    //no trajo registos porke el usr es errado
    echo '<script type="text/javascript">
          alert("Combinación Usuario/Contraseña no valida");'
         .'window.location="CambiarClave.php"; '
         .'</script>';                         
}

$registro= pg_fetch_array($resultado);
$PassCript= $registro["contrasena"];
//$Propio= $registro["nombreapellido"];
//$Depto= $registro["ubicacion"];

//verificar si es el password correcto. 
//clave retorna true si coninciden
//exit($Actual." ".$PassCript);
if (clave($Actual, $PassCript)){    
    //clave nueva no es igual a la repetida
    if ($Nueva!= $Repita){
        echo
        "<script>
            alert('La clave nueva y su repetición, NO coinciden');
            window.location='CambiarClave.php';
        </script>";
    }
    else
    {
        //clave no cumple con creiterios de seguridad
        //clave mayor a 8 caracteres
        //incluir numeros

        //validar longitud
//        $Longitud= strlen($Nueva);
//        if ($Longitud < 8){
//            echo
//            "<script>
//                alert('La clave nueva debe ser mayor a 8 letras y contener números');
//                window.location='CambiarClave.php';
//            </script>";
//        }

        //validar que tenga numeros $Valido != 1 &&
//        $Valido= 0;
//        $i= 0;
//        while ( i < $Longitud){ 
//            //caracter es numero: 48 es cero y 57 es 9 en tabla ascii
//            if (ord(substr($Nueva,i,1)) >= 48 &&
//                ord(substr($Nueva,i,1)) <= 57 )
//                    $Valido= 1;
//    
//            $i++;
//        }

//        $Valido= 1;
//        if (!$Valido)
//        {
//        echo
//        "<script>
//            alert('La clave nueva debe ser mayor a 8 letras y contener números');
//            window.location='CambiarClave.php';
//        </script>";
//        }
    
        //generar nueva clave, segun funcin hash, encriptar
        $PassCript= clave($Nueva, false);
        
        //ahora si, a sustituir la clave
        $sql= "select usuario_clave("
            ."'".$Usr."', "
            ."'".$PassCript."');";        

        $reg= $oConeccion->ejecutarProcedimiento($sql);
        $valor= pg_fetch_array($reg);
		
        if(substr($valor[0], 1, 1) != '0'){
            echo
            "<script>
                alert('Error al cambiar clave de acceso');
                window.location='CambiarClave.php';
            </script>";
        }    
        else {
            echo
            "<script>
                alert('Se ha cambiado la clave de acceso');
                window.location='../busqueda.php';
            </script>";
        }
    }
}
else{     //error
    echo '<script type="text/javascript">
          alert("Combinación Usuario/Contraseña no valida");
		  window.location="CambiarClave.php";'
         .'</script>';                         
}
?>
