<?php
session_start();
include_once "php_funciones.php";
//exit($_GET['Parametro']);
switch ($_GET['Parametro']){
    case 'autenticar':
        $_SESSION['usuario']= $_POST['txtUsr'];
        $password= $_POST['txtPasswd'];
        $usuario= $_SESSION['usuario'];
        $tipoacceso= $_POST['cboTipoAcceso'];

        autenticar($usuario, $password, $tipoacceso);        
        break;
    
    case 'validar':
        $usuario= $_SESSION['usuario'];
        $denuncia= $_SESSION['denunciaid'];

        //conocer los elementos pendientes: generales, denunciates, denunciados
        //ofendidos, relaciones (opcional)
        $sql= "select incompleta_actual('".$_SESSION['usuario']."', ".$_SESSION['denunciaid'].");";

        $objConexion= new Conexion();
        $rsp= $objConexion->ejecutarProcedimiento($sql);        
        
        $resul= pg_fetch_array($rsp);

        //validar si esta completa
        //7:generales, 9:denunciates, 11:denunciados
        //13:ofendidos, 15:relaciones (opcional)        
        $gen= substr($resul[0],7,1);
        $den= substr($resul[0],9,1);
        $imp= substr($resul[0],11,1);
        $ofe= substr($resul[0],13,1);
        $rel= substr($resul[0],15,1);
        
        if($gen <= 0){
            //raro... no se grabo ni la denuncia            
        }

        if($den <= 0){
            //no se grabo denunciante
            $_SESSION['denunciante']== 'f';
        }
        
        if($imp <= 0){
            //no se grabo denunciando
            $_SESSION['denunciado']== 'f';
        }
        
        if($ofe <= 0){
            //no se grabo ofendido
            $_SESSION['ofendido']== 'f';
        }   
        
        if($rel == '0'){
            //no se grabo denunciante
            $_SESSION['relacion']== 'f';
        } 
        else{
            $_SESSION['relacion']== 't';
        }
        
        echo $resul[0];
        break;    
    
    case 'finalizar':
        $denuncia= $_SESSION['denunciaid'];
        
        ValidarEstado();
        
        //limpiar tabla de estado
        session_start();                    
        if (isset($_SESSION['usuario'])){                      
            //borrar registros en tabla control de estados, si no queda denuncia pendiente    
            $Usr= $_SESSION['usuario'];
            $sql= "select controlestados_delete('".$Usr."',".$_SESSION['denunciaid'].");";

            $objConexion= new Conexion();
            $rsp= $objConexion->ejecutarProcedimiento($sql);     

        }        
        
        //hacer copia a la tabla para imprimir
        $sql= "select denuncia_finalizar(".$_SESSION['denunciaid'].");";

        $objConexion= new Conexion();
        $rsp= $objConexion->ejecutarProcedimiento($sql);                

        //retornar estado
//        echo $_SESSION['estado'];
        echo $denuncia;
        break;
        
    case 'control':
        //conocer el estado de la tabla control de estado
        
        session_start();
        $sql= "select estado from mini_sedi.tbl_controlestados where denuncia=".$_SESSION['denunciaid'];
        
        $objConexion= new Conexion();
        $rsp= $objConexion->ejecutarProcedimiento($sql);        
        
        $dato= pg_fetch_array($rsp);
        
        if ($dato[0]== "Nueva")
            echo "Modificable";
        elseif ($dato[0]== "Modificando") 
            echo "No se puede modificar";
        else echo "Error";

        break;
        
    case 'forzar':
        //conocer el estado de la tabla control de estado
        
        session_start();
        $sql= "update mini_sedi.tbl_controlestados set estado= 'Nueva' where denuncia=".$_SESSION['denunciaid'];
        
        $objConexion= new Conexion();
        $rsp= $objConexion->ejecutarProcedimiento($sql);        
        
        echo "ok";

        break;       
    
    case 'pdf':
        session_start();
        $denuncia= $_SESSION['denunciaid'];
      
        if ($_GET['Modificar']== 'si'){        
            //hacer la copia del expediente al pdf
            $sql= "SELECT mini_sedi.denuncia_pdf($denuncia);";
//exit($sql);
            $objConexion= new Conexion();
            $rsp= $objConexion->ejecutarProcedimiento($sql);
        }
        
        echo $denuncia;
        
        break;
}
?>
