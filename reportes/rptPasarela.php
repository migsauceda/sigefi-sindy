<?php
    include "../clases/Usuario.php";
        
    session_start();

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];        
    }else{
        header("location:index.php");
    }                
    
    if ($_POST['tiporpt']== 'Alta' && $objUsuario->getPermiso(10)== '1'){
        header("location: rptActividadImputado.php");
    }
            
    if ($_POST['tiporpt']== 'Media' && $objUsuario->getPermiso(11)== '1'){
        header("location: rptActividadImputadoInterfaz.php");
    }
                        
    if ($_POST['tiporpt']== 'Operativo' && $objUsuario->getPermiso(12)== '1'){
        header("location: rptActividadImputadoInterfaz.php");
    }
   
    echo "<script type='text/javascript'>";
    echo "alert('No tiene acceso a esta opción')";
    echo "</script>";
    
?>