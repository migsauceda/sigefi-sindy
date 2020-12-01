<!DOCTYPE html>
<?php
    //funcion generar combo
    include("../clases/controles/funct_select.php");

    //funciones genericas php
    include "../funciones/php_funciones.php";
        
        //clase depto_municipio_ciudad
        include "../clases/DeptoMuniCiudad.php";      

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <!-- jquery -->
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>  

        <script type="text/javascript">
        function Opcion(data){
            if (data== "CPrincipal"){
                document.getElementById('txtOpcion').value= "CPrincipal";
                document.getElementById('txtNombrePrincipal').disabled= false;
            }else if (data== "MPrincipal"){
                document.getElementById('txtOpcion').value= "MPrincipal";  
                document.getElementById('txtNuevoNombrePrincipal').disabled= false;
            }else if (data== "CSub"){
                document.getElementById('txtOpcion').value= "CSub";
                document.getElementById('txtNombreSub').disabled= false;
            }else if (data== "MSub"){
                document.getElementById('txtOpcion').value= "MSub";
                document.getElementById('txtNombreSub2').disabled= false;
            }
            
        }
        
        function Recargar(){
            var Bandeja= document.getElementById("cboModiSubBandejaPrincipal").value;
            if (Bandeja <= 0){
                alert("Esta bandeja no tiene definida una subbandeja");
            }
            $.ajax({
                data:"bandeja="+Bandeja,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_RecargarBandeja.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Bandejas: "+quepaso);
                },
                success: function(data){ 
                    $("#cboModiSubBandeja").html(data);
                }                
            })
        }
        </script>           
    </head>
    <body>
        <?php
        
        if (isset($_POST[txtOpcion])){            
            $con= new Conexion();
            if ($_POST[txtOpcion]== 'CPrincipal'){                
                $Nombre= $_POST[txtNombrePrincipal];
                $Fiscalia= $_POST[EsFiscalia1];
                $Pais= $_POST[DeptoBandeja0];
                $Muni= $_POST[MuniBandeja1];

                if ($_POST['EsFiscalia1']){
                   $Fiscalia= '1';
                        }
                else{
                 $Fiscalia= '0';
             }
                if (!is_null($Nombre)){

                  $sql= "INSERT INTO mini_sedi.tbl_bandejas (esfiscalia, cdescripcion, cdeptopais,cmunicipio) 
                         VALUES  ('$Fiscalia', 
                            '$Nombre', '$Pais', '$Muni');";


                    $con->ejecutarComando($sql);

             echo
                "<script>
            alert('Se ha Creado Correctamente la Bandeja');
                </script>";
                    

                    
                }
            }elseif ($_POST[txtOpcion]== 'MPrincipal') {
                $Principal= $_POST[cboBandejaPrincipal];
                $Nuevo= $_POST[txtNuevoNombrePrincipal];
                $Pais= $_POST[DeptoBandeja1];
                $Muni= $_POST[MuniBandeja2];
                $Fiscalia= $_POST[EsFiscalia2];

                if ($_POST['EsFiscalia2']){
                   $Fiscalia= '1';
                        }
                else{
                 $Fiscalia= '0';
             }

                if (!is_null($Principal)){
                    $sql= "update mini_sedi.tbl_bandejas set cdescripcion= '$Nuevo',
                        esfiscalia= $Fiscalia,
                        cdeptopais= $Pais,
                        cmunicipio= $Muni "
                            . "where ibandejaid= $Principal;";
                    $con->ejecutarComando($sql);

                  echo
                "<script>
            alert('Se ha Modificado Correctamente la Bandeja');
                </script>";

               
                }                

            }elseif ($_POST[txtOpcion]== 'CSub') {

                $Principal= $_POST[cboSubBandejaPrincipal];
                $Sub= $_POST[txtNombreSub];
                $Pais= $_POST[DeptoBandeja6];
                $Muni= $_POST[MuniBandeja3];

                $Fiscalia= $_POST[EsFiscalia3];

                if ($_POST['EsFiscalia3']){
                   $Fiscalia= '1';
                        }
                else{
                 $Fiscalia= '0';
             }
                

               
                if (!is_null($Principal)){

                  $sql=  "INSERT INTO mini_sedi.tbl_subbandejas(isubbandejaid,cdescripcion, ibandejaid,ilugarid, cdeptopaisid,cmunicipioid, dfechacreacion, esfiscalia) 
                         VALUES  (DEFAULT,'$Sub', $Principal, 0, '$Pais', '$Muni', now(), $Fiscalia);";

//                    exit($sql);        
                 
                    $con->ejecutarComando($sql);

                        echo
                "<script>
            alert('Se ha Creado Correctamente la Sub Bandeja');
                </script>";
     

                }                
            }elseif ($_POST[txtOpcion]== 'MSub') {
                $Principal= $_POST[cboModiSubBandejaPrincipal];
                $Sub= $_POST[cboModiSubBandeja];
                $Nombre= $_POST[txtNombreSub2];
                $Pais= $_POST[DeptoBandeja4];
                $Muni= $_POST[MuniBandeja4];

                $Fiscalia= $_POST[EsFiscalia5];

                if ($_POST['EsFiscalia5']){
                   $Fiscalia= '1';
                        }
                else{
                 $Fiscalia= '0';
             }


                if (!is_null($Principal)){
                    $sql= "update mini_sedi.tbl_subbandejas set cdescripcion= '$Nombre',
                        cdeptopaisid= '$Pais',
                        cmunicipioid= '$Muni',
                        esfiscalia= $Fiscalia"
                            . "where ibandejaid=  $Principal and isubbandejaid= $Sub; ";
//                    exit($sql);
                    $con->ejecutarComando($sql);

                     echo
                "<script>
            alert('Se ha Modificado Correctamente la Sub Bandeja');
                </script>";


                }                
            }else{
                echo "error";
            }                        
        }
        ?>

        <form action="AdmonBandejas.php" method="post">
            <strong>
   
            <input type="radio" id="rdCrearBandejaPrincipal" name="AdmonBandejas" value="CrearPrincipal" onchange="Opcion('CPrincipal')">Crear bandeja principal
            </strong>
            <br>
            Nombre de la bandeja nueva:<input type="text" id="txtNombrePrincipal" name="txtNombrePrincipal" disabled="true">            
            Departamento:   
            <select name="DeptoBandeja0" id="DeptoBandeja0">
                <?php
                $depto= new DeptoMuniCiudad();
                $cursor= $depto->getDepartamentoLista();
                echo "<option value=  0 >Seleccione...</option>";
                while ($reg= pg_fetch_array($cursor)){                    
                    echo "<option value=  $reg[cdepartamentoid] onclick= 'CargarMuni($reg[cdepartamentoid], 1);'>$reg[cdescripcion]</option>";
                }                               
                ?>
            </select>
            Municipio: 
            <select name="MuniBandeja1" id="MuniBandeja1">
                <?php
                $muni= new DeptoMuniCiudad();
                $cursor= $muni->getMunicipioLista();
                while ($reg= pg_fetch_array($cursor)){    
                    echo "<option value=  $reg[cmunicipioid] >$reg[cdescripcion]</option>";
                }                               
                ?>                
            </select>
            <br>¿Es fiscalía?:<input type="checkbox" id="EsFiscalia1" name="EsFiscalia1"><br>
            <input type="submit" value="Crear">
            <br><br><br>
            <strong>


            <input type="radio" id="rdModificaBandejaPrincipal" name="AdmonBandejas" value="ModificarPrincipal" onchange="Opcion('MPrincipal')">Modificar bandeja principal
            </strong>
            <br>
            Bandeja a modificar: 
            <select id="cboBandejaPrincipal" name="cboBandejaPrincipal">
                <?php
                $Bandejas= CargarBandeja();
                echo "<option value='0'>Seleccione... </option>";
                while($fila= pg_fetch_array($Bandejas)){
                    echo "<option value='".$fila[ibandejaid]."'>".$fila[cdescripcion]."</option>";
                }
                ?>
            </select>
            <br>
            Nuevo nombre:<input type="text" id="txtNuevoNombrePrincipal" name="txtNuevoNombrePrincipal" disabled="true">            
            Departamento: 
            <select name="DeptoBandeja1" id="DeptoBandeja1">
                <?php
                $depto= new DeptoMuniCiudad();
                $cursor= $depto->getDepartamentoLista();
                echo "<option value=  0 >Seleccione...</option>";
                while ($reg= pg_fetch_array($cursor)){                    
                    echo "<option value=  $reg[cdepartamentoid] onclick= 'CargarMuni($reg[cdepartamentoid], 2);'>$reg[cdescripcion]</option>";
                }                               
                ?>
            </select>            
            Municipio: 
            <select name="MuniBandeja2" id="MuniBandeja2">
                <?php
                $muni= new DeptoMuniCiudad();
                $cursor= $muni->getMunicipioLista();
                while ($reg= pg_fetch_array($cursor)){    
                    echo "<option value=  $reg[cmunicipioid] >$reg[cdescripcion]</option>";
                }                               
                ?>                
            </select>            
            <br>¿Es fiscalía?:<input type="checkbox" id="EsFiscalia2" name="EsFiscalia2"><br>
            <input type="submit" value="Modificar">
            <br><br><br>
            <strong>


            <input type="radio" id="rdCrearSub" name="AdmonBandejas" value="CrearSub" onchange="Opcion('CSub')">Crear sub bandeja 
            </strong>
            <br>
            Bandeja principal:
            <select id="cboSubBandejaPrincipal" name="cboSubBandejaPrincipal">
                <?php
                $Bandejas= CargarBandeja();
                echo "<option value='0'>Seleccione... </option>";
                while($fila= pg_fetch_array($Bandejas)){
                    echo "<option value='".$fila[ibandejaid]."'>".$fila[cdescripcion]."</option>";
                }
                ?>
            </select>      
            <br>
            Nombre de la Sub-Bandeja: <input type="text" id="txtNombreSub" name="txtNombreSub" disabled="true">
            Departamento: 
            <select name="DeptoBandeja6" id="DeptoBandeja6">
                <?php
                $depto= new DeptoMuniCiudad();
                $cursor= $depto->getDepartamentoLista();
                echo "<option value=  0 >Seleccione...</option>";
                while ($reg= pg_fetch_array($cursor)){                    
                    echo "<option value=  $reg[cdepartamentoid] onclick= 'CargarMuni($reg[cdepartamentoid], 3);'>$reg[cdescripcion]</option>";
                }                               
                ?>
            </select>                
            Municipio: 
            <select name="MuniBandeja3" id="MuniBandeja3">
                <?php
                $muni= new DeptoMuniCiudad();
                $cursor= $muni->getMunicipioLista();
                while ($reg= pg_fetch_array($cursor)){    
                    echo "<option value=  $reg[cmunicipioid] >$reg[cdescripcion]</option>";
                }                               
                ?>                
            </select>            
            <br>¿Es fiscalía?:<input type="checkbox" id="EsFiscalia3" name="EsFiscalia3"><br>
            <input type="submit" value="Crear">
            <br><br><br>



            <strong>
            <input type="radio" id="rdModificarSub" name="AdmonBandejas" value="ModificarSub" onchange="Opcion('MSub')">Modificar sub bandeja 
            </strong>
            <br>
            Bandeja principal:
            <select id="cboModiSubBandejaPrincipal" name="cboModiSubBandejaPrincipal" onchange="Recargar()">
                <?php
                $Bandejas= CargarBandeja();
                echo "<option value='0'>Seleccione... </option>";
                while($fila= pg_fetch_array($Bandejas)){
                    echo "<option value='".$fila[ibandejaid]."'>".$fila[cdescripcion]."</option>";
                }
                ?>
            </select> 
            <br>
            Sub Bandeja:
            <select id="cboModiSubBandeja" name="cboModiSubBandeja">
                <?php                
                echo "<option value=0>Seleccione... </option>";
                ?>
            </select>          
            <br>
            Nuevo nombre de la Sub-Bandeja: <input type="text" id="txtNombreSub2" name="txtNombreSub2" disabled="true">
            Departamento: 
            <select name="DeptoBandeja4" id="DeptoBandeja4">
                <?php
                $depto= new DeptoMuniCiudad();
                $cursor= $depto->getDepartamentoLista();
                echo "<option value=  0 >Seleccione...</option>";
                while ($reg= pg_fetch_array($cursor)){                    
                    echo "<option value=  $reg[cdepartamentoid] onclick= 'CargarMuni($reg[cdepartamentoid], 4);'>$reg[cdescripcion]</option>";
                }                               
                ?>
            </select>             
            Municipio: 
            <select name="MuniBandeja4" id="MuniBandeja4">
                <?php
                $muni= new DeptoMuniCiudad();
                $cursor= $muni->getMunicipioLista();
                while ($reg= pg_fetch_array($cursor)){    
                    echo "<option value=  $reg[cmunicipioid] >$reg[cdescripcion]</option>";
                }                               
                ?>                
            </select>               
            <br>¿Es fiscalía?:<input type="checkbox" id="EsFiscalia5" name="EsFiscalia5"><br>
            <input type="submit" value="Modificar">                   
            
            <input type="hidden" name="txtOpcion" id="txtOpcion">
        </form>
    </body>
    <script type="text/javascript">
    function CargarMuni(depto, opcion){
        $.ajax({
            data:"data="+depto,
            type: "POST",
            dataType: "html",
            url: "../funciones/ajax_muni_obj.php",
            error: function(){
                    alert("error");
            },
            success: function(data){         
                if (opcion== 1)
                    document.getElementById("MuniBandeja1").innerHTML= data;
                else if(opcion=== 2)
                    document.getElementById("MuniBandeja2").innerHTML= data;
                else if(opcion === 3)
                    document.getElementById("MuniBandeja3").innerHTML= data;
                else if(opcion === 4)
                    document.getElementById("MuniBandeja4").innerHTML= data;
            }
        });
    }
    </script>    
</html>
