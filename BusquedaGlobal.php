<?php 
    session_start();
    if (!isset($_SESSION['usuario'])){	
        header("location:index.php");
    }    
    
    include("clases/class_conexion_pg.php");
    include_once "./funciones/php_funciones.php"; 
    
    //si se carga por primera vez, no existe botones
    if (!isset($_POST['boton'])){
        //total de registro
        $TotalRegistros= ContarBusquedaGlobal($_POST['buscar'], $_POST['FiscNombres'], $_POST['FiscApellidos'], ALL, 0);
//        exit($TotalRegistros);
        //para control de paginacion
        $limit= 10;  //total por pagina
        $offset= 0;  //iniciar desde el registro
        
    }
    else{
    //si se recarga despues de presionar algun boton: sig o ant
        $TotalRegistros= (int)$_POST['TotalRegistro'];
        if($_POST['boton']== 'sig'){   
            $offset= (int)$_POST['offset'];
            $limit= 10;  
            if ($offset > $TotalRegistros) $offset = 0;
        }        
        
        if (isset($_POST['boton'])){
            if($_POST['boton']== 'ant'){
                $offset = (int)$_POST['offset'];                
                $limit= 10; 
                $offset -= ($limit * 2);
                if ($offset < 0) $offset= 0;  
            }
        }        
    }   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="css/Estilos.css">
        <link type="text/css" rel="stylesheet" href="./css/smoothness/jquery-ui-1.8.12.custom.css"> 
        <script type="text/javascript" src="java_script/jquery-1.5.1.min.js"></script>
        <script type="text/javascript" src="java_script/jquery-ui-1.8.12.custom.min.js"></script>        
        <title>Busqueda Global</title>
        
        <script type='text/javascript'>
        function Paginar(limite){
            if (limite== "ant"){
                  document.getElementById('boton').value= 'ant';                            
            }

            if (limite== "sig"){
                  document.getElementById('boton').value= 'sig';                                                                       
            }     
            frmBusquedaGlobal.submit();
        }                 
        </script>
    </head>
    
    <style type="text/css">
            body,html{background-color:transparent;}
            .Fila_0{
                background-color: #FFFFFF;
            }
            .Fila_1{
                background-color: #F8F8FF;
            }                         
    </style>    
    
    <body>
        <div align="center"> <h3>Búsqueda en todo el Ministerio Público</h3> </div>
        <form method="post" id="frmBusquedaGlobal">
            <input type="hidden" name="boton" id="boton">
            <input type="hidden" name="offset" id="offset">
            <input type="hidden" name="actual" id="actual">
            <input type="hidden" name="TotalRegistro" id="TotalRegistro">
            <input type="hidden" name="buscar" id="buscar">
            <input type="hidden" name="FiscNombres" id="FiscNombres">
            <input type="hidden" name="FiscApellidos" id="FiscApellidos">   

            <div align="center">
                <progress value="0" id="progreso" max="<?php echo $TotalRegistros; ?>" </progress>;
            </div>
            
            <script type='text/javascript'>
            <?php 
                if (isset($_POST['FiscNombres'])){
            ?>
                    document.getElementById('FiscNombres').value= "<?php echo $_POST['FiscNombres']; ?>"; 
                    document.getElementById('FiscApellidos').value= "<?php echo $_POST['FiscApellidos']; ?>"; 
                    document.getElementById('buscar').value= "<?php echo $_POST['buscar']; ?>"; 
                    document.getElementById("progreso").value = "<?php echo ($offset + $limit); ?>";    
            <?php
                }
            ?>
            </script>          
        
                
            <div align="center"> <input type="button" id="ant" name="ant" value="Anterior" 
                                        onclick='Paginar("ant")'> 
                                 <input type="button" id="sig" name="sig" value="Siguiente"
                                        onclick='Paginar("sig")'>
            </div>    
            <br>
        
            <table align="center" border="1" id="tblBuscar" class="TablaCaja">
                <tbody>
                    <tr class="SubTituloCentro">
                        <th><strong>Denuncia</strong></th>
                        <th><strong>Num. Interno</strong></th>
                        <?php
                        if ($_POST['buscar']== 'denunciado')
                        {
                        ?>
                            <th><strong>Nombre completo denunciado</strong></th>
                        <?php
                        }else {
                        ?>
                            <th><strong>Nombre completo denunciante</strong></th>
                        <?php
                        }
                        ?>
                        <th><strong>Delito</strong></th>
                        <th><strong>Fecha denuncia</strong></th>
                        <th><strong>Asignada</strong></th>
                        <th><strong>Tomada en</strong></th>
                    </tr>       

                    <?php 
                        $regDenuncias= BusquedaGlobal($_POST['buscar'], $_POST['FiscNombres'], $_POST['FiscApellidos'], $limit, $offset);
                        $fila= pg_fetch_array($regDenuncias);                    

                        $i= 1;
                        while ($fila)
                        {
                    ?>
                                <tr class="<?php if($i % 2 == 0) echo Fila_1; else echo FIla_0; ?>">
                                <td><?php echo $fila["tdenunciaid"]; ?> </td>
                                <td><?php echo $fila["cexpedientesedi"]; ?> </td>
                                <td><?php echo $fila["nombrecompleto"]; ?></td>
                                <td><?php echo $fila["delito"]; ?></td>"   
                                <td><?php echo $fila["dfechadenuncia"]; ?></td>
                                <td><?php echo $fila["asignada"]; ?></td>
                                <td><?php echo $fila["cdescripcion"]; ?></td>                     
                                </tr>
                    <?php
                                $fila= pg_fetch_array($regDenuncias);
                                $i++;
                        }
                        $offset += $limit;
                    ?>
                    <script type="text/javascript">
                        document.getElementById('offset').value= <?php echo $offset; ?>;
                        document.getElementById('TotalRegistro').value= <?php echo $TotalRegistros; ?>;
                    </script>                                
                </tbody>
            </table>
        </form>
    </body>
</html>