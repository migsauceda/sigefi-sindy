<!DOCTYPE html>
<?php
    include "../clases/Usuario.php";
    include("../clases/class_conexion_pg.php");

    //funciones genericas
    include "../funciones/php_funciones.php";   
    session_start();

    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];  
    }else{
        header("location:index.php");
    }  
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Rotar Expediente entre Fiscales</title>
    </head>
    <link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
    <script type="text/javascript" src="../java_script/funciones.js"></script>

    <!-- jquery -->
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>
              

    <style type="text/css">
        .ui-datepicker {
            font-size: 11px;
            margin-left:10px
         }
    </style>   
    <body>
        <br><br>
        <FORM action="procesaRotarExpediente.php" method="POST" id="frmAsignar" onsubmit=" return Validar(this);">            
        <Table align="center" width="60%" border="0" id="tblAsignar" class="TablaCaja">
            <!-- titulo de la tabla -->
            <TR class="SubTituloCentro"><TH colspan="4" align="center"><strong>Reasignar Expediente</strong></TH></TR>  
            <tr><td>Todos los expedientes seleccionados del fiscal: <select id="origen" name="origen" onchange="TablaCargaFiscal(this.value)"></select></td></tr>
            <tr><td><br>Asignarlos al fiscal: <select id="destino" name="destino"></select></td></tr>
        </table>
           
        <br><br>
        
        <div align="center">            
            <table align='center'>
                <input type='submit' value="Rotar">
                <input type="button" value="Cancelar">
            </table>
        </div>
        
        <br/><br/>
        
        <table align="center" border="0" id="listado" name="listado" class="TablaCaja" width="100%">
            <tr class="SubTituloCentro"><th>Expediente</th><th>Imputado</th><th>Delito</th></th></tr>
        </table>
        
        <br><br>
     
        <div align="center">  
            <table align='center'>
                <input type='submit' value="Rotar">
                <input type="button" value="Cancelar">
            </table>
        </div>
                
        <input type="hidden" id="txtjson" name="txtjson">
        </form>
        
        <script type="text/javascript">
        <?php
            $curOrigen= CargarFiscal($objUsuario->getBandejaId(), $objUsuario->getSubBandejaId());?>
            opt= document.createElement("option");
            opt.value= "0"
            opt.text= "Seleccione un fiscal"
            origen= document.getElementById("origen");                
            origen.appendChild(opt);                
            <?php    
            while ($regOrigen= pg_fetch_array($curOrigen)){?>
                opt= document.createElement("option");
                opt.value= "<?php echo($regOrigen[identidad]); ?>"
                opt.text= "<?php echo($regOrigen[nombre]); ?>"
                origen= document.getElementById("origen");                
                origen.appendChild(opt);
        <?php } 
            $curOrigen= CargarFiscal($objUsuario->getBandejaId(), $objUsuario->getSubBandejaId());?>
            opt= document.createElement("option");
            opt.value= "0"
            opt.text= "Seleccione un fiscal"
            destino= document.getElementById("destino");                
            destino.appendChild(opt);                
            <?php                 
            while ($regOrigen= pg_fetch_array($curOrigen)){?>
                opt= document.createElement("option");
                opt.value= "<?php echo($regOrigen[identidad]); ?>"
                opt.text= "<?php echo($regOrigen[nombre]); ?>"
                destino= document.getElementById("destino");                
                destino.appendChild(opt);                
         <?php } ?>
             
        function TablaCargaFiscal(Fiscal){ 
            $.ajax({
                data:       "fiscal="+Fiscal,
                type:       "POST",
                datatype:   "text",
                url:    "../funciones/ajax_CargarCargaFiscal.php",
                error: function (XMLHttpRequest, textStatus, errorThrown){
                    alert("Error al mostrar el listado de expedientes");
                },
                success: function(data){ 
                    var CantidadRegistros= document.getElementById("listado").rows.length;
                    if (CantidadRegistros > 1){ 
                        for(var j= CantidadRegistros; j > 1 ; j--){false
                            document.getElementById("listado").deleteRow(1);                            
                        }
                    }
                    var Cursor= JSON.parse(data);
                    var Anterior= "vacio";
                    var Fondo= "#ffffff";
                    
                    for(var i= 0; i < Cursor.length; i++){
                        fila= document.createElement("tr");
                        fila.id= "fila"+i;
                        if (Anterior != Cursor[i].denuncia){
                            //cambiar fondo
                            if (Fondo== "#ffffff"){
                                Fondo= "#e6f0ef";
                            }
                            else{
                                 Fondo= "#ffffff";
                            }                            
                        }
                        fila.style.background = Fondo;
                            
                        tabla= document.getElementById("listado");
                        tabla.appendChild(fila);                                                                               
                      
//                      columna numero de expediente o denuncia
                      col1= document.createElement("td");
                      col1.id= "col1"+i;
                      tr= document.getElementById("fila"+i);
                      tr.appendChild(col1);
                      
                      if (Anterior != Cursor[i].denuncia){
                            chk= document.createElement("input");
                            chk.type = "checkbox"
                            chk.id= "chk"+i;
                            chk.value= Cursor[i].denuncia;
                            chk.className= "id";
                            col1.appendChild(chk);                                                                                       
                            
//                            chk.onclick= function(){AgregarEliminarId(this)}
                            
                            lbl1= document.createElement("label");
                            lbl1.id= "lbl1"+i;
                            lbl1.innerHTML= Cursor[i].denuncia;
                            col1.appendChild(lbl1); 
                                                                                     
                            Anterior= Cursor[i].denuncia;                            
                      }
//                      columna nombre del imputado 
                      col2= document.createElement("td");
                      tr= document.getElementById("fila"+i);
                      tr.appendChild(col2);
                      
                      lbl2= document.createElement("label");
                      lbl2.id= "lbl2"+i;
                      lbl2.innerHTML= Cursor[i].imputado;
                      col2.appendChild(lbl2); 
                      
                      txt2h= document.createElement("input");
                      txt2h.type= "hidden";
                      txt2h.id= "txt2h"+i;
                      txt2h.value= Cursor[i].imputadoid;
                      col2.appendChild(txt2h);                       
                      
//                      columna para delito
                      col3= document.createElement("td");
                      tr= document.getElementById("fila"+i);
                      tr.appendChild(col3);         
                      
                      txt3h= document.createElement("input");
                      txt3h.type= "hidden";
                      txt3h.id= "txt3h"+i;
                      txt3h.value= Cursor[i].delitoid;
                      col3.appendChild(txt3h);                      
                      
                      lbl3= document.createElement("label");
                      lbl3.id= "lbl3"+i;
                      lbl3.innerHTML= Cursor[i].delito.substring(0,40);
                      col3.appendChild(lbl3);                      
                    }
                }
            });            
        }
        
        function Validar(frm){ 
            var FOrigen= frm.origen.value;
            var FDestino= frm.destino.value;
            var filas= document.getElementsByClassName("id");
            var primero= "si";
            
            //recorrer filas marcadas y formar JSON
            var json = "["
            for(var i= 0; i < filas.length; i++){
                if(filas[i].checked== false){
                    continue;
                }
                if (primero == "si"){
                    primero= "no";
                    json += "{";
                }
                else{
                    json += ",{";
                }
                json += "\"denuncia\":\""+filas[i].value+"\",";  //denuncia
                json += "\"origen\":\""+FOrigen+"\",";  //fiscalorigen
                json += "\"destino\":\""+FDestino+"\"";  //fiscal destino
                json += "}";
            }
            json += "]";
            
            Struct_json= JSON.stringify(json);
            
            if(json.length == 2){
                alert("No se han seleccinado expedientes");
                return false;
            }
            if(FDestino== 0){
                alert("¿A quién le va a asignar los expedientes?... seleccione un fiscal destino");
                return false
            }
            if(FOrigen== FDestino){
                alert("Se debe asignar los expedientes a un fiscal distinto al que ya lo tiene");
                return false;
            }
         
            document.getElementById("txtjson").value= json;            
          
            return true;
        }
        </script>
              
    </body>
</html>
