<!inclusion de archivos>
<!controles para los campos del formulario y conexion>
<?php 	
        include "../clases/Usuario.php";
	include("../clases/controles/funct_select.php");

	//clase
	include("../clases/Imputado.php");
        	
	//funciones genericas
	include "../funciones/php_funciones.php";
        
        //inicia sesión
        session_start(); 
        
        if (isset($_SESSION['objUsuario'])){
            $objUsuario= $_SESSION['objUsuario'];        
        }else{
            header("location:index.php");
        }        

        //usr presiono boton nuevo
        if (isset($_GET["btn"]) && $_GET["btn"]== "nuevo"){ 
            //borra el objeto actual
            $_SESSION['oDenunciado']= 'f';
                   
            //ahora el objeto
            unset($_SESSION['oDenunciado']);
            unset($oDenunciado);             
        }else{   
            //usuario presiono boton para cargar otro denunciado            
            if(isset($_SESSION["oDenunciado"])){
                //inicializar el objeto
                $oDenunciado= $_SESSION["oDenunciado"];               
            }
            
            if (isset($_GET["nmr"])){             
                $id= $_GET["nmr"]; 
                
                $oDenunciado= new Imputado(); 
                $_SESSION["oDenunciado"]= $oDenunciado;
                //recuperar el denunciante con ese id para la denuncia actual
                $oDenunciado->RecuperarId($_SESSION['denunciaid'], $id);  
            }       
        }                 
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Formulario Denunciado</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link type="text/css" rel="stylesheet" href="../css/Estilos.css">
  <script type="text/javascript" src="../funciones/funciones.js"></script> 

  <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
  <link href="../java_script/css/smoothness/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
  <script src="../java_script/js/jquery-1.10.2.js"></script>
  <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>     
  <script src="../java_script/js/jquery.datetimepicker.js"></script>    
  <script> 
	$(document).ready(function() {   
//		$("#acordionDenunciadox").accordion({heightStyle: "content", collapsible: true, active: false,
//                                            heightStyle: "content"});                  
                                        
                $( "#acordionDenunciado" ).on( "accordionactivate", function( event, ui ) {
                    indice= ui.newHeader.index();
                    heightStyle: "fill";

                    if (indice== 0){
                        participante('lstDenunciado2','odenunciado');
                    }
                });                                        
	});      
        
	function Recargar() { 
            var i=  document.getElementById("lstDenunciado2").selectedIndex;
            var id= document.getElementById("lstDenunciado2").options;
            var personaid= id[i].value;
            
            location.href= "frmExpediente.php?nmr="+"'"+personaid+"'&tab=2";
	} 

	function ValidarNumeros(e) { 
		var keynum = window.event ? window.event.keyCode : e.which;
		if (keynum==8) return true;
		
		patron =/\d/;
		te = String.fromCharCode(keynum);
		
		if (te >= 0 && te <= 9)
			return true;
		else
			return false;
	}               
        
        function QuitarAnoRango(){         
                document.getElementById("rdAno30").checked= false;
                document.getElementById("rdAno31").checked= true;
//                $('#rdAno3')[0].checked= false;	
                $('#txtEdad3').value= "";
                for(i= 0; i <= 4; i++){
                        $('input:radio[name=rdRangoEdad3]')[i].checked= false;
                }
        }        

       //variables para contar filas de alias y delito-->
        Transporte= 1;        
        Armas= 1;
        Robo= 1;
        Alias= 1;
        Delitos= 1;
        Contador= 0;
        Delitosj= 1;
        Contadorj= 0;        
        Actual= 0;
        BorrarTransporte= 0;
        BorrarDelito= 0;
        BorrarDelitoj= 0;
        BorrarAlias= 0;
        BorrarArmas= 0;
        BorrarObjeto= 0;
       

        //agrega una fila y el alias correspondiente-->
        function RecuperarAlias(aliastxt)
        {
            Contador= 0;
            Alias++;
            Contador= Alias;
            //document.getElementById("Alias").value= Alias;

            var fil=document.getElementById("alias").insertRow(--Contador);

            col= document.createElement("td"); 
            col.width="5%";
            
            txt1= document.createElement("input");
            txt1.type= "button";
            txt1.name= "campo1"+Contador;
            txt1.id= "campo1"+Contador;
            txt1.size= 1;
            txt1.value= "Borrar";
            txt1.onclick= function() {BorrarFilaDelitos("alias",fil.rowIndex);};

            col.appendChild(txt1); 
            fil.appendChild(col);

            col= document.createElement("td"); 

            txt1= document.createElement("input");
            txt1.type= "text";
            txt1.name= "campo3"+Contador;
            txt1.id= "campo3"+Contador;
            txt1.size= 25;
            txt1.value= aliastxt;
            
            col.appendChild(txt1);
            fil.appendChild(col);

            //document.getElementById("opcion").option[0]= 5;
        }    
 
        //<!--agrega una fila y el delito correspondiente segun lo guardado en la base de datos-->
        function RecuperarDelitos(delitoid, clasificacion, tipopersona){ 
                Contador= 0;
                Delitos++;
                Contador= Delitos;

                Contadorj= 0;
                Delitosj++;
                Contadorj= Delitosj;

                if (tipopersona== 't')
                    var fil=document.getElementById("delito").insertRow(--Contador);
                else
                    var fil=document.getElementById("delitoj").insertRow(--Contador);

                col= document.createElement("td"); 
                col.width="5%";

                txt0= document.createElement("input");
                txt0.type= "button";
                txt0.name= "campo1"+Contador;
                txt0.id= "campo1"+Contador;
                txt0.value= "Borrar";
                
                if (tipopersona== 't')
                    txt0.onclick= function() {BorrarFilaDelitos("delito",fil.rowIndex);};
                else
                    txt0.onclick= function() {BorrarFilaDelitos("delitoj",fil.rowIndex);};
                
                
//                if (TablaId== "delitoj")
//                    txt0.onclick= function() {BorrarFilaDelitos("delitoj",fil.rowIndex);};                
        
                col.appendChild(txt0);
                fil.appendChild(col);                

                col= document.createElement("td"); 

                if (tipopersona== 't'){
                    txt1= document.createElement("select");
                    txt1.name= "delito"+Contador;
                    txt1.id= "delito"+Contador;
                }
                else{
                    txt1= document.createElement("select");
                    txt1.name= "delitoj"+Contador;
                    txt1.id= "delitoj"+Contador;                    
                }

                <?php 
                $resDelito= CargarDelito();
                while ($fila=pg_fetch_array($resDelito)){?>
                        opt= document.createElement("option");
                        opt.text=  "<?php echo($fila['cdescripcion']);?>";
                        opt.id= "opcion"+Contador;
                        opt.value= "<?php echo($fila['ndelitoid']);?>";

                        try{
                                txt1.add(opt,null);
                        }
                        catch(e)
                        {
                                txt1.add(opt);
                        }                        
                <?php
                } 		
                ?>
                        
                col.appendChild(txt1);
                fil.appendChild(col);           
                
                if (tipopersona== 't'){
                    document.getElementById("delito"+Contador).value= delitoid;                
                }
                else{
                    document.getElementById("delitoj"+Contador).value= delitoid;                
                }
                
                //desactivar para que no lo cambien
                txt1.disabled = "disabled";                
                
                //agregar br
                br= document.createElement("br");
                        
                txt2= document.createElement("input");
                txt2.type= "radio";
                txt2.name= "campo4"+Contador;
                txt2.id= "campo4"+Contador;
                txt2.value= "Culposo";  

                lbl2= document.createElement("label");
                lbl2.setAttribute("for","all");
                lbltext= document.createTextNode("Culposo");

                col.appendChild(br);
                lbl2.appendChild(lbltext);
                col.appendChild(lbl2);
                col.appendChild(txt2);
                fil.appendChild(col);                

                txt2= document.createElement("input");
                txt2.type= "radio";
                txt2.name= "campo5"+Contador;
                txt2.id= "campo5"+Contador;
                txt2.value= "Tentativa";  

                lbl2= document.createElement("label");
                lbl2.setAttribute("for","all");
                lbltext= document.createTextNode("Tentativa");

                lbl2.appendChild(lbltext);
                col.appendChild(txt2);
                col.appendChild(lbl2);                
                fil.appendChild(col);   

                if (clasificacion== 'c'){ 
                    nombrer= "campo4"+Contador; 
                    document.getElementById(nombrer).checked= true;
                }
                else if (clasificacion== 't') { 
                    nombrer= "campo5"+Contador;
                    document.getElementById(nombrer).checked= true;
                }
        }    

        function RecuperarArmas(armaid){ 
                Contador= 0;
                Armas++;
                Contador= Armas;

                var fil=document.getElementById("armas").insertRow(--Contador);

                col= document.createElement("td"); 
                col.width="5%";

                txt0= document.createElement("input");
                txt0.type= "button";
                txt0.name= "campo1"+Contador;
                txt0.id= "campo1"+Contador;
                txt0.value= "Borrar";
                
                txt0.onclick= function() {BorrarFilaDelitos("armas",fil.rowIndex);};
        
                col.appendChild(txt0);
                fil.appendChild(col);                

                col= document.createElement("td"); 

                txt1= document.createElement("select");
                txt1.name= "arma"+Contador;
                txt1.id= "arma"+Contador;

                <?php 
                $resArmas= CargarArmas();
                while ($fila=pg_fetch_array($resArmas)){?>
                        opt= document.createElement("option");
                        opt.text=  "<?php echo($fila['cdescripcion']);?>";
                        opt.id= "opcion"+Contador;
                        opt.value= "<?php echo($fila['narmaid']);?>";

                        try{
                                txt1.add(opt,null);
                        }
                        catch(e)
                        {
                                txt1.add(opt);
                        }                        
                <?php
                } 		
                ?>
                        
                col.appendChild(txt1);
                fil.appendChild(col);           
                
                document.getElementById("arma"+Contador).value= armaid;   
                //desactivar para que no lo cambien
                txt1.disabled = "disabled";     
                
        }    
        
        function RecuperarTransporte(transporteid){ 
                Contador= 0;
                Transporte++;
                Contador= Transporte;

                var fil=document.getElementById("transporte").insertRow(--Contador);

                col= document.createElement("td"); 
                col.width="5%";

                txt0= document.createElement("input");
                txt0.type= "button";
                txt0.name= "campo1"+Contador;
                txt0.id= "campo1"+Contador;
                txt0.value= "Borrar";
                
                txt0.onclick= function() {BorrarFilaDelitos("transporte",fil.rowIndex);};
        
                col.appendChild(txt0);
                fil.appendChild(col);                

                col= document.createElement("td"); 

                txt1= document.createElement("select");
                txt1.name= "transporte"+Contador;
                txt1.id= "transporte"+Contador;

                <?php 
                $resArmas= CargarTransporte();
                while ($fila=pg_fetch_array($resArmas)){?>//
                        opt= document.createElement("option");
                        opt.text=  "<?php echo($fila['cdescripcion']);?>";
                        opt.id= "opcion"+Contador;
                        opt.value= "<?php echo($fila['ntransporteid']);?>";

                        try{
                                txt1.add(opt,null);
                        }
                        catch(e)
                        {
                                txt1.add(opt);
                        }                        
                <?php
                } 		
                ?>
                        
                col.appendChild(txt1);
                fil.appendChild(col);           
                
                document.getElementById("transporte"+Contador).value= transporteid;                
        }            

        function RecuperarObjeto(objetoid){ 
                Contador= 0;
                Robo++;
                Contador= Robo;

                var fil=document.getElementById("objeto").insertRow(--Contador);

                col= document.createElement("td"); 
                col.width="5%";

                txt0= document.createElement("input");
                txt0.type= "button";
                txt0.name= "campo1"+Contador;
                txt0.id= "campo1"+Contador;
                txt0.value= "Borrar";
                
                txt0.onclick= function() {BorrarFilaDelitos("objeto",fil.rowIndex);};
        
                col.appendChild(txt0);
                fil.appendChild(col);                

                col= document.createElement("td"); 

                txt1= document.createElement("select");
                txt1.name= "objeto"+Contador;
                txt1.id= "objeto"+Contador;

                <?php 
                $resObjetos= CargarObjeto();
                while ($fila=pg_fetch_array($resObjetos)){?>//
                        opt= document.createElement("option");
                        opt.text=  "<?php echo($fila['cdescripcion']);?>";
                        opt.id= "opcion"+Contador;
                        opt.value= "<?php echo($fila['nobjetoid']);?>";

                        try{
                                txt1.add(opt,null);
                        }
                        catch(e)
                        {
                                txt1.add(opt);
                        }                        
                <?php
                } 		
                ?>
                        
                col.appendChild(txt1);
                fil.appendChild(col);           
                
                document.getElementById("objeto"+Contador).value= objetoid;                
        }            
        

        //<!--agregar filas a las tablas-->
        function AgregarFila(TablaId, Valor)
        {   
            Contador= 0;
            Contadorj= 0;
            if (TablaId== "alias")
            {
                Alias++;
                Contador= Alias;
                //document.getElementById("Alias").value= Alias;
            }
            else if(TablaId== "delito")
            {
                Delitos++;
                Contador= Delitos;
                //document.getElementById("Delitos").value= Delitos;
            }
            else if(TablaId== "delitoj")
            {
                Delitosj++;
                Contadorj= Delitosj;
                //document.getElementById("Delitos").value= Delitos;
            }                
            else if(TablaId== "transporte")
            {
                Transporte++;
                Contador= Transporte;                    
            }
            else if(TablaId== "objeto")
            {
                Robo++;
                Contador= Robo;                    
            }                
            else  //armas
            {
                Armas++;
                Contador= Armas;
            }

            if(TablaId== "delito"){
                var fil=document.getElementById(TablaId).insertRow(--Contador);
                fil.id= "campo1"+Contador;                         
            }
            if(TablaId== "delitoj"){
                var fil=document.getElementById(TablaId).insertRow(--Contadorj);
                fil.id= "campo1"+Contadorj;                         
            }                                
            if(TablaId!= "delitoj" && TablaId!= "delito"){
                var fil=document.getElementById(TablaId).insertRow(--Contador);
                fil.id= "campo1"+Contador;                         
            }                                   

            col= document.createElement("td"); 
            col.width="5%";

            txt0= document.createElement("input");
            txt0.type= "button";
            txt0.name= "campo2"+Contador;
            txt0.id= "campo2"+Contador;
            txt0.value= "Borrar";

            if (TablaId== "alias")
                txt0.onclick= function() {BorrarFilaDelitos("alias",fil.rowIndex);};

            if (TablaId== "delito")
                txt0.onclick= function() {BorrarFilaDelitos("delito",fil.rowIndex);};

            if (TablaId== "delitoj")
                txt0.onclick= function() {BorrarFilaDelitos("delitoj",fil.rowIndex);};     

            if (TablaId== "armas")
                txt0.onclick= function() {BorrarFilaDelitos("armas",fil.rowIndex);};

            if (TablaId== "transporte")
                txt0.onclick= function() {BorrarFilaDelitos("transporte",fil.rowIndex);};

            if (TablaId== "objeto")
                txt0.onclick= function() {BorrarFilaDelitos("objeto",fil.rowIndex);};                

            col.appendChild(txt0);
            fil.appendChild(col);                

            col= document.createElement("td"); 

            if (TablaId == "alias")
            { 
                    txt1= document.createElement("input");
                    txt1.type= "text";
                    txt1.name= "campo3"+Contador;
                    txt1.id= "campo3"+Contador;
                    txt1.size= 25;
                    txt1.value= Valor;

                    col.appendChild(txt1);
                    fil.appendChild(col);
            }else if(TablaId== "delito")
            {
                    txt1= document.createElement("select");
                    txt1.name= "delito"+Contador;
                    txt1.id= "delito"+Contador;

                    <?php 
                    $resDelito= CargarDelito();
                    while ($fila=pg_fetch_array($resDelito)){?>
                            opt= document.createElement("option");
                            opt.text=  "<?php echo($fila['cdescripcion']);?>";
                            opt.id= "opcion"+Contador;
                            opt.value= "<?php echo($fila['ndelitoid']);?>";

                            try{
                                    txt1.add(opt,null);
                            }
                            catch(e)
                            { 
                                    txt1.add(opt);
                            }
                    <?php
                    } 		
                    ?>

                    txt1.value= Valor; 

                    col.appendChild(txt1);
                    fil.appendChild(col);

                    //agregar br
                    br= document.createElement("br");

                    txt2= document.createElement("input");
                    txt2.type= "radio";
                    txt2.name= "campo4"+Contador;
                    txt2.id= "campo4"+Contador;
                    txt2.value= "Culposo";  

                    lbl2= document.createElement("label");
                    lbl2.setAttribute("for","all");
                    lbltext= document.createTextNode("Culposo");

                    col.appendChild(br);
                    lbl2.appendChild(lbltext);
                    col.appendChild(lbl2);
                    col.appendChild(txt2);
                    fil.appendChild(col);

                    txt2= document.createElement("input");
                    txt2.type= "radio";
                    txt2.name= "campo5"+Contador;
                    txt2.id= "campo5"+Contador;
                    txt2.value= "Tentativa";  

                    lbl2= document.createElement("label");
                    lbl2.setAttribute("for","all");
                    lbltext= document.createTextNode("Tentativa");

                    lbl2.appendChild(lbltext);
                    col.appendChild(txt2);
                    col.appendChild(lbl2);                
                    fil.appendChild(col);                        

            }else if(TablaId== "delitoj")  //tabla delitos persona juridica (empresa)
            { 
                    txt1= document.createElement("select");
                    txt1.name= "delitoj"+Contadorj;
                    txt1.id= "delitoj"+Contadorj;                            

                    <?php 
                    $resDelito= CargarDelito();
                    while ($fila=pg_fetch_array($resDelito)){?>                                   
                            opt= document.createElement("option");
                            opt.text=  "<?php echo($fila['cdescripcion']);?>";
                            opt.id= "opcionj"+Contadorj;
                            opt.value= "<?php echo($fila['ndelitoid']);?>";

                            try{
                                    txt1.add(opt,null);
                            }
                            catch(e)
                            { 
                                    txt1.add(opt);
                            }
                    <?php
                    } 		
                    ?>

                    txt1.value= Valor; 

                    col.appendChild(txt1);
                    fil.appendChild(col);

                    //agregar br
                    br= document.createElement("br");


                    txt2= document.createElement("input");
                    txt2.type= "radio";
                    txt2.name= "campo4"+Contadorj;
                    txt2.id= "campo4"+Contadorj;
                    txt2.value= "Culposo";  

                    lbl2= document.createElement("label");
                    lbl2.setAttribute("for","all");
                    lbltext= document.createTextNode("Culposo");

                    col.appendChild(br);
                    lbl2.appendChild(lbltext);
                    col.appendChild(lbl2);
                    col.appendChild(txt2);                        
                    fil.appendChild(col);

                    txt2= document.createElement("input");
                    txt2.type= "radio";
                    txt2.name= "campo5"+Contadorj;
                    txt2.id= "campo5"+Contadorj;
                    txt2.value= "Tentativa";  

                    lbl2= document.createElement("label");
                    lbl2.setAttribute("for","all");
                    lbltext= document.createTextNode("Tentativa");

                    lbl2.appendChild(lbltext);
                    col.appendChild(txt2);
                    col.appendChild(lbl2);                
                    fil.appendChild(col);                                                
            }    
            else //armas
            if(TablaId== "armas")
            { 
                    txt1= document.createElement("select");
                    if (TablaId== "armas"){
                        txt1.name= "armas"+Contador;
                        txt1.id= "armas"+Contador;
                    }

                    <?php 
                    $resArmas= CargarArmas();
                    while ($fila=pg_fetch_array($resArmas)){?>
                            opt= document.createElement("option");
                            opt.text=  "<?php echo($fila['cdescripcion']);?>";
                            opt.id= "opcion"+Contador;
                            opt.value= "<?php echo($fila['narmaid']);?>";

                            try{
                                    txt1.add(opt,null);
                            }
                            catch(e)
                            { 
                                    txt1.add(opt);
                            }
                    <?php
                    } 		
                    ?>

                    txt1.value= Valor; 

                    col.appendChild(txt1);
                    fil.appendChild(col);                                
            } 
            else if(TablaId== "transporte") //transporte
            { 
                    txt1= document.createElement("select");
                    if (TablaId== "transporte"){
                        txt1.name= "transporte"+Contador;
                        txt1.id= "transporte"+Contador;
                    }

                    <?php 
                    $resTransporte= CargarTransporte();
                    while ($fila=pg_fetch_array($resTransporte)){?> 
                            opt= document.createElement("option");
                            opt.text=  "<?php echo($fila['cdescripcion']);?>";
                            opt.id= "opcion"+Contador;
                            opt.value= "<?php echo($fila['ntransporteid']);?>";

                            try{
                                    txt1.add(opt,null);
                            }
                            catch(e)
                            { 
                                    txt1.add(opt);
                            }
                    <?php
                    } 		
                    ?>

                    txt1.value= Valor; 

                    col.appendChild(txt1);
                    fil.appendChild(col);                                            
            } 
            else if(TablaId== "objeto") //en caso de robo
            { 
                    txt1= document.createElement("select");
                    if (TablaId== "objeto"){
                        txt1.name= "objeto"+Contador;
                        txt1.id= "objeto"+Contador;
                    }

                    <?php 
                    $resRobo= CargarObjeto();
                    while ($fila=pg_fetch_array($resRobo)){?> 
                            opt= document.createElement("option");
                            opt.text=  "<?php echo($fila['cdescripcion']);?>";
                            opt.id= "opcion"+Contador;
                            opt.value= "<?php echo($fila['nobjetoid']);?>";

                            try{
                                    txt1.add(opt,null);
                            }
                            catch(e)
                            { 
                                    txt1.add(opt);
                            }
                    <?php
                    } 		
                    ?>

                    txt1.value= Valor; 

                    col.appendChild(txt1);
                    fil.appendChild(col);                                            
            } 
        }

        //<!--javas scripts para llenar los combos-->
        //<!--borrar fila de tabla-->
        function BorrarFilaDelitos(tabla, fila)
        { 
            if (tabla == "delito")
            {
                document.getElementById("delito").deleteRow(fila);
                Delitos--;
            }
            else           
            if (tabla == "delitoj")
            {
                document.getElementById("delitoj").deleteRow(fila);
                Delitosj--;
            }
            else
            if (tabla == "transporte")
            {
                document.getElementById("transporte").deleteRow(fila);
                Transporte--;
            }   
            else
            if (tabla == "armas")
            {
                document.getElementById("armas").deleteRow(fila);
                Armas--;
            }      
            else
            if (tabla == "objeto")
            {
                document.getElementById("objeto").deleteRow(fila);
                Robo--;
            }     
            else
            {
                document.getElementById("alias").deleteRow(fila);
                Alias--;           
            }                        
        }


        //recorre las tablas de delitos y alias para crear una lista
        //que se usa para grabar los datos a la base de datos
        function CrearListaDelitosAlias(TablaId){ 
            //alias
            Desde= 0;
            Hasta= 0;
            i= 0;
            iterar = document.getElementById("alias").rows.length;

            document.getElementById("txtTodosAlias3").value="";

            for(i=2; i <= iterar; i++)
            {
                try{
                    document.getElementById("txtTodosAlias3").value=
                        document.getElementById("txtTodosAlias3").value + 
                        "'"+document.getElementById("campo3"+i).value + "';";
                }catch(err){                    
                }
            }

            //armas
            Desde= 0;
            Hasta= 0;
            i= 0;
            iterar = document.getElementById("armas").rows.length;

            document.getElementById("txtTodosArmas").value="";            

            for(i=1; i <= iterar; i++)
            {                
                try{
                    document.getElementById("txtTodosArmas").value=
                            document.getElementById("txtTodosArmas").value + 
                            document.getElementById("armas"+i).value+";";            
                }catch(err){                    
                }                    
            }

            //transporte
            Desde= 0;
            Hasta= 0;
            i= 0;
            iterar = document.getElementById("transporte").rows.length;
            
            document.getElementById("txtTodosTransporte").value="";                         

            for(i=1; i <= iterar; i++)
            { 
                try{
                    document.getElementById("txtTodosTransporte").value=
                        document.getElementById("txtTodosTransporte").value + 
                        document.getElementById("transporte"+i).value+";";            
                }catch(err){                    
                }
            }          

            //objeto robado
            Desde= 0;
            Hasta= 0;
            i= 0;
            iterar = document.getElementById("objeto").rows.length;

            document.getElementById("txtTodosObjetos").value="";

            for(i=1; i <= iterar; i++)
            { 
                try{
                    document.getElementById("txtTodosObjetos").value=
                        document.getElementById("txtTodosObjetos").value + 
                        document.getElementById("objeto"+i).value+";";            
                }catch(err){                 
                }
            }             

            if (TablaId == "delito"){ 
                CrearListaDelitosNatural("delito");
            }
            else{
                CrearListaDelitosJuridica("delitoj");
            }
        }
        
        function CrearListaDelitosNatural(TablaId){
            //persona natural
            //delitos  txtTodosDelitos
            Desde= 0;
            Hasta= 0;
            i= 0;
            iterar = document.getElementById("delito").rows.length;

            document.getElementById("txtTodosDelitos3").value="";

            for(i=1; i <= iterar; i++)
            { 
                try{
                    if (TablaId == "delito"){ 
                        document.getElementById("txtTodosDelitos3").value=
                            document.getElementById("txtTodosDelitos3").value + 
                            document.getElementById("delito"+i).value+";";            
                    } 
                }catch(err){
                }
            } 

            //calificacion tentativa
            Desde= 0;
            Hasta= 0;
            i= 0; 
            
           
            document.getElementById("txtTentativa").value=""; 
            for(i=1; i <= iterar; i++)
            {
                try{
                    if (document.getElementById("campo5"+i).checked== true)
                    {                
                        document.getElementById("txtTentativa").value=
                            document.getElementById("txtTentativa").value + '1'+";";

                    }
                    else
                    {
                        document.getElementById("txtTentativa").value=
                            document.getElementById("txtTentativa").value + '0'+";";                     
                    }                
                }catch(err){
                }
            }  

            //calificacion culposa
            Desde= 0;
            Hasta= 0;
            i= 0;
            
            document.getElementById("txtCulposo").value=""; 
            
            for(i=1; i <= iterar; i++)
            { 
                try{
                    if (document.getElementById("campo4"+i).checked== true)
                    {
                        document.getElementById("txtCulposo").value=
                            document.getElementById("txtCulposo").value + '1'+";";                        
                    }
                    else
                    {
                        document.getElementById("txtCulposo").value=
                            document.getElementById("txtCulposo").value + '0'+";";
                    }
                }catch(err){
                }
            }

            frm= document.getElementById('frmImputado');
            result= ValidarDenunciado(frm);
            
            if(result){
                frm.submit();
            }
        }   
  
        
        function CrearListaDelitosJuridica(TablaId){ 
            //persona juridica
            //delitos  txtTodosDelitos
            Desde= 0;
            Hasta= 0;
            i= 0;

            document.getElementById("txtTodosDelitos3j").value="";

            for(i=1; i < Delitosj; i++)
            { 
                if (TablaId == "delitoj"){ 
                    document.getElementById("txtTodosDelitos3j").value=
                        document.getElementById("txtTodosDelitos3j").value +
                        document.getElementById("delitoj"+i).value+";";            
                }
            } 

            //calificacion tentativa
            Desde= 0;
            Hasta= 0;
            i= 0; 
            document.getElementById("txtTentativaj").value=""; 
            for(i=1; i < Delitos; i++)
            { 
                if (document.getElementById("campo5"+i).checked== true)
                {                
                    document.getElementById("txtTentativaj").value=
                        document.getElementById("txtTentativaj").value + '1'+";";
                    
                }
                else
                {
                    document.getElementById("txtTentativa").value=
                        document.getElementById("txtTentativa").value + '0'+";"; 
                    
                }
                
            }  
           
            //calificacion culposa
            Desde= 0;
            Hasta= 0;
            i= 0;
            document.getElementById("txtCulposo").value=""; 
            for(i=1; i < Delitos; i++)
            { 
                if (document.getElementById("campo4"+i).checked== true)
                {
                    document.getElementById("txtCulposo").value=
                        document.getElementById("txtCulposo").value + '1'+";";                        
                }
                else
                {
                    document.getElementById("txtCulposo").value=
                        document.getElementById("txtCulposo").value + '0'+";";
                }
            }            
                                   
            frm= document.getElementById('frmImputadoJuridico'); 
            result= ValidarDenunciadoJuridico(frm);
          
            if(result){ 
                frm.submit();
            }            
        }    


        /*funcion: participantes
         *lista los denunciantes ingresados
        */
        function participante(destino, participante){ 
//            alert(destino+" "+participante);
            $.ajax({
                data: "id="+destino+"&participante="+participante,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_DenuncianteImputadoOfendido.php",
                error: function(obj, que, otro){
                    alert("Error ajax al cargar lista de participante (denunciante, ofendido, imputado)");
                },
                success: function(data){  
                    $("#lstDenunciado").html(data);
                }
            });    
        } 
        
        function ActualizarListaDEnunciante(){
            //llenar el combo ofendidos ingresados
            participante('lstDenunciado2','denunciado');
        }
        
        function CrearNuevo(Tipo){
            if (Tipo == "Natural")
                location.href= "frmExpediente.php?nuevo=21";
            else
                location.href= "frmExpediente.php?nuevo=22";            
        }        

        //llena delitos   document.getElementById('cboNacionalidad').value= 
        function llenadelitos(Personaid, tipopersona){ 
//            Persona= document.getElementById('txtPersonaId').value;
//            alert(Personaid);
            $.ajax({
                data:       "personaid="+Personaid,
                type:       "POST",
                datatype:   "json",
                url:    "../funciones/ajax_LlenaDelitos.php",
                error: function (XMLHttpRequest, textStatus, errorThrown){
                    alert("Error al cargar datos para los delitos");
                },
                success: function(json_obj){  
                    //nombre completo del fiscal
         
                    json_txt= JSON.parse(json_obj);
                    var i= 0;
       
                    for (i= 0; i < json_txt.length; i++){                        
                        RecuperarDelitos(json_txt[i].ndelito, json_txt[i].cclasificacion, tipopersona);
                    }
                }
            });        
        } 

       //llena alias
        //llena delitos   document.getElementById('cboNacionalidad').value= 
        function llenaalias(Personaid){ 
//            Persona= document.getElementById('txtPersonaId').value;
//            alert(Persona);
            $.ajax({
                data:       "personaid="+Personaid,
                type:       "POST",
                datatype:   "json",
                url:    "../funciones/ajax_LlenaAlias.php",
                error: function (XMLHttpRequest, textStatus, errorThrown){
                    alert("Error al cargar datos para los delitos");
                },
                success: function(json_obj){  
                    //nombre completo del fiscal
//                    alert(json_obj);
                    json_txt= JSON.parse(json_obj);
                    var i= 0;
                    for (i= 0; i < json_txt.length; i++){                        
                        RecuperarAlias(json_txt[i].alias);
                    }
                }
            });        
        } 
        
        function llenaarmas(Personaid){ 
            Persona= Personaid;
//            alert("entra");
            $.ajax({
                data:       "personaid="+Personaid,
                type:       "POST",
                datatype:   "json",
                url:    "../funciones/ajax_LlenaArmas.php",
                error: function (XMLHttpRequest, textStatus, errorThrown){
                    alert("Error al cargar datos para los arma");
                },
                success: function(json_obj){  
                    //nombre completo del fiscal
//     alert("exito"+json_obj);
                    json_txt= JSON.parse(json_obj);
                    var i= 0;
                    for (i= 0; i < json_txt.length; i++){                        
                        RecuperarArmas(json_txt[i].narmaid);
                    }
                }
            });        
        } 

        function llenatransporte(Personaid){ 
//            Persona= document.getElementById('txtPersonaId').value;
            $.ajax({
                data:       "personaid="+Personaid,
                type:       "POST",
                datatype:   "json",
                url:    "../funciones/ajax_LlenaTransporte.php",
                error: function (XMLHttpRequest, textStatus, errorThrown){
//                    alert("Error al cargar datos para los transportes");
                },
                success: function(json_obj){  
                    //nombre completo del fiscal
     
//                    json_txt= JSON.parse(json_obj);
//                    var i= 0;
//       
//                    for (i= 0; i < json_txt.length; i++){                        
//                        RecuperarTransporte(json_txt[i].ntransporteid);
//                    }
                }
            });        
        } 

        function llenaobjeto(Personaid){ 
//            Persona= document.getElementById('txtPersonaId').value;
            $.ajax({
                data:       "personaid="+Personaid,
                type:       "POST",
                datatype:   "json",
                url:    "../funciones/ajax_LlenaObjeto.php",
                error: function (XMLHttpRequest, textStatus, errorThrown){
                    alert("Error al cargar datos para los objetos robados");
                },
                success: function(json_obj){  
                    //nombre completo del fiscal
     
                    json_txt= JSON.parse(json_obj); 
                    var i= 0;
       
                    for (i= 0; i < json_txt.length; i++){    
                        RecuperarObjeto(json_txt[i].nobjetoid);
                    }
                }
            });        
        } 
        
        
        function llenamovil(Personaid){ 
//            Persona= document.getElementById('txtPersonaId').value;
            $.ajax({
                data:       "personaid="+Personaid,
                type:       "POST",
                datatype:   "json",
                url:    "../funciones/ajax_LlenaMovil.php",
                error: function (XMLHttpRequest, textStatus, errorThrown){
                    alert("Error al cargar datos para los objetos robados");
                },
                success: function(json_obj){  
                    //nombre completo del fiscal

                    json_txt= JSON.parse(json_obj);
                    
                    var i= 0;
                    for (i= 0; i <= json_txt.length; i++){  
//                        RecuperarMovil(json_txt[i].nobjetoid);
                        document.getElementById('cboMovil').value= json_txt[0].nmovilid;
                    }
                }
            });        
        }
        
        
        //activa txt para numero de documento: identidad, pasaporte, carnet de ...
        function ActivarDocumento(){
            $("#txtIdentidad3").removeAttr('disabled');

            if ($("#cboTipoDoc3").val() == 0){
                $("#txtIdentidad3").val("");
                $("#txtIdentidad3").attr('disabled','disabled');  
            }
        }         

        function LlenaDireccion(Departamentoid, Municipioid, AldeaId, BarrioId){
//            alert(Departamentoid+" "+Municipioid+" "+AldeaId+" "+BarrioId);
            $.ajax({
                data:"accion=depto",
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Departamento: "+quepaso);
                },
                success: function(data){
                    $("#cboDepto3").html(data);
                    $("#cboDepto3 option[value="+Departamentoid+"]").attr("selected",true);
//                    $("#cboDepto3").attr("value",Departamentoid);
                    //ajax para llenar el municipio
                    $.ajax({
                        data: "accion=muni&coddepto="+Departamentoid,
                        type: "POST",
                        dataType: "html",
                        url: "../funciones/ajax_llenadireccion.php",
                        error: function(objeto, quepaso, otroobj){
                            alert("Error al cargar Municipio: "+quepaso);
                        },
                        success: function(data){
                            $("#cboMuni3").html(data);
                            $("#cboMuni3 option[value="+Municipioid+"]").attr("selected",true);
//                            $("#cboMuni1").attr("value",Municipioid);
                            //ajax para llenar la ciudad o aldea
                            $.ajax({                        
                                data: "accion=aldea&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId,
                                type: "POST",
                                dataType: "html",
                                url: "../funciones/ajax_llenadireccion.php",
                                error: function(objeto, quepaso, otroobj){
                                    alert("Error al cargar Aldea o Ciudad: "+quepaso);
                                },
                                success: function(data){
                                    $("#cboAldea3").html(data);
                                    $("#cboAldea3 option[value="+AldeaId+"]").attr("selected",true);
//                                    $("#cboAldea1").attr("value",AldeaId);
                                }
                            });
                        }
                    });
                }
            }); 
            $.ajax({
                data: "accion=barrio&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId+"&codbarrio="+BarrioId,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Barrio o Colonia");        
                },
                success: function(data){
                    $("#cboBarrio3").html(data);
                    $("#cboBarrio3 option[value="+BarrioId+"]").attr("selected",true);
//                    $("#cboBarrio1").attr("value",BarrioId);            
                }
            });     
        }

        // direccion para persona juridica        
        function LlenaDireccionJ(Departamentoid, Municipioid, AldeaId, BarrioId){
//            alert(Departamentoid+" "+Municipioid+" "+AldeaId+" "+BarrioId);
            $.ajax({
                data:"accion=depto",
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Departamento: "+quepaso);
                },
                success: function(data){
                    $("#cboDepto3J").html(data); //crea la lista de deptos
                    $("#cboDepto3J option[value="+Departamentoid+"]").attr("selected",true);
//                    $("#cboDepto3J").attr("value",Departamentoid); //selecciona el depto
                    //ajax para llenar el municipio
                    $.ajax({
                        data: "accion=muni&coddepto="+Departamentoid,
                        type: "POST",
                        dataType: "html",
                        url: "../funciones/ajax_llenadireccion.php",
                        error: function(objeto, quepaso, otroobj){
                            alert("Error al cargar Municipio: "+quepaso);
                        },
                        success: function(data){
                            $("#cboMuni3J").html(data);
                            $("#cboMuni3J option[value="+Municipioid+"]").attr("selected",true);
//                            $("#cboMuni1").attr("value",Municipioid);
                            //ajax para llenar la ciudad o aldea
                            $.ajax({                        
                                data: "accion=aldea&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId,
                                type: "POST",
                                dataType: "html",
                                url: "../funciones/ajax_llenadireccion.php",
                                error: function(objeto, quepaso, otroobj){
                                    alert("Error al cargar Aldea o Ciudad: "+quepaso);
                                },
                                success: function(data){
                                    $("#cboAldea3J").html(data);
                                    $("#cboAldea3J option[value="+AldeaId+"]").attr("selected",true);
//                                    $("#cboAldea1").attr("value",AldeaId);
                                }
                            });
                        }
                    });
                }
            }); 
            $.ajax({
                data: "accion=barrio&codmuni="+Municipioid+"&coddepto="+Departamentoid+"&codaldea="+AldeaId+"&codbarrio="+BarrioId,
                type: "POST",
                dataType: "html",
                url: "../funciones/ajax_llenadireccion.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al cargar Barrio o Colonia");        
                },
                success: function(data){
                    $("#cboBarrio3J").html(data);
                    $("#cboBarrio3J option[value="+BarrioId+"]").attr("selected",true);
//                    $("#cboBarrio1").attr("value",BarrioId);            
                }
            });     
        }                
          
        //agrega una fila y el arma correspondiente-->
        function RecuperarArma(armatxt)
        {
            Contador= 0;
            Armas++;
            Contador= Armas;
            //document.getElementById("Alias").value= Alias;

            var fil=document.getElementById("armas").insertRow(--Contador);

            col= document.createElement("td"); 
            col.width="5%";
            
            txt1= document.createElement("input");
            txt1.type= "button";
            txt1.name= "campo1"+Contador;
            txt1.id= "campo1"+Contador;
            txt1.size= 1;
            txt1.value= "Borrar";
            txt1.onclick= function() {BorrarFilaDelitos("armas",fil.rowIndex);};

            col.appendChild(txt1); 
            fil.appendChild(col);

            col= document.createElement("td"); 

            txt1= document.createElement("input");
            txt1.type= "text";
            txt1.name= "campo3"+Contador;
            txt1.id= "campo3"+Contador;
            txt1.size= 25;
            txt1.value= armatxt;
            
            col.appendChild(txt1);
            fil.appendChild(col);
        }            
        
        function LlenarCampos(frm, datos){
            frm.cboCivil3.value= datos.civil;
            frm.cboTipoDoc3.value= datos.tipodoc;           
            frm.cboEscolar3.value= datos.escolaridad; 
            frm.cboProfe3.value= datos.profesion;            
            frm.cboOcupa3.value= datos.ocupacion;
            frm.cboNacionalidad3.value= datos.nacionalidad;
            
            if (TipoPersona== 't') //persona natural
            {                      
                frm.rdCondicion.value= datos.ccondicion;
                frm.rdTrabajo.value= datos.ctrabajoremunerado;
                frm.rdEstudia.value= datos.casisteeducacion;
                llenaalias(datos.personaid);            
                llenaarmas(datos.personaid);
                llenatransporte(datos.personaid);
                llenaobjeto(datos.personaid);        
                llenamovil(datos.personaid);
            }

            LlenaDireccion(datos.departamento, datos.municipio, datos.ciudad, datos.barrio);
            LlenaDireccionJ(datos.departamento, datos.municipio, datos.ciudad, datos.barrio);
            llenadelitos(datos.personaid, datos.tipopersona);   
//            llenaarmas(datos.personaid);
            
            var frm= document.forms.frmImputado;
            llenarsexo('selSexo2', datos.sexo, frm, datos.orientacionsex);             
            
            document.getElementById('txtPersonaId').value= datos.personaid;
          
            if (TipoPersona== 'f') //persona juridica
            {
                if (datos.tipodoc == 0)//identidad
                {
                    document.getElementById('rdTipoDoc1').checked= true;
                }
                else if(datos.tipodoc == 2)//pasaporte
                {
                   document.getElementById('rdTipoDoc2').checked= true;
                }
                else if(datos.tipodoc == 5)//colegio abogado
                {
                   document.getElementById('rdTipoDoc0').checked= true;
                }
                document.getElementById('txtEmpresasHn3').focus(); 
            } 
        }        
        
        function BorrarRegistro(personaid){
            $.ajax({
                data: "borrar=denunciado&id="+personaid,
                type: "POST",
                dataType: "text",
                url: "../funciones/ajax_BorrarDenuncianteImputadoOfendido.php",
                error: function(objeto, quepaso, otroobj){
                    alert("Error al borrar denunciante");        
                },
                success: function(data){
                    alert(data);
                    Recargar();
                }
            });
        }         
        
        $('#desconocido').click(function(){            
            if(this.checked){                
                $("#txtEmpresasHn3").val("---Desconocido---");
                $("#txtRtn3").val("---Desconocido---");
            }
            else{
                $("#txtEmpresasHn3").val("");
                $("#txtRtn3").val("");
            }
        });
  </script>
</head> 
<body>
<div id="acordionDenunciado">        

    <div id="BotonesEscabezado" style="background-image: url('../css/smoothness/images/ui-bg_glass_75_e6e6e6_1x400.png')">
        <!--los botones generales persona natural y juridica-->    
        <table align="center" summary="botones persona natural">
            <tr>
                <td><b>Denunciados ingresados</b></td>
                <td></td>
                <td colspan="2"><b>Agregar un nuevo denunciado</b></td>
            </tr>
            <tr>     
            <td>
                <span id="lstDenunciado"></span>
                <script type="text/javascript">
                    participante('lstDenunciado2','denunciado');
                </script>    
            </td>
            <td><pre>                                       </pre></td>
            <td><INPUT type="button" name="btnNuevo" value="Persona Natural" 
                       onClick="CrearNuevo('Natural');"></td> 
            <td><INPUT type="button" name="btnNuevo" value="Persona Juridica" 
                       onClick="CrearNuevo('Juridica');"></td>         
            <td></td>      
            </tr>
        </table>      
    </div>

<!--inicia acordion persona natural-->    
<div style="display:none;" id="PersonaNaturalDiv2">
       
<h3><a href="#">Persona Natural</a></h3>
    <!-- IMPORTANTE se usa ValidarDenunciado porque es igual  -->
    <FORM action="procesaimputado.php" method="POST" name="frmImputado" 
        id="frmImputado">  
        
        <!-- input ocultos para guardar info sobre alias y delitos -->
        <input type="hidden" name="aliases" id="aliases" >
        <input type="hidden" name="txtTotalAlias" id="txtTotalAlias">
        <input type="hidden" name="txtTodosAlias3" id= "txtTodosAlias3">

        <input type="hidden" name="txtTotalDelitos3" id="txtTotalDelitos3">
        <input type="hidden" name="txtTodosDelitos3" id="txtTodosDelitos3"> 
        
<!--        <input type="hidden" name="txtTotalDelitos3j" id="txtTotalDelitos3j">
        <input type="hidden" name="txtTodosDelitos3j" id="txtTodosDelitos3j">         -->
        
        <input type="hidden" name="txtCulposo" id="txtCulposo">
        <input type="hidden" name="txtTentativa" id="txtTentativa">
        
        <input type="hidden" name="txtCulposoj" id="txtCulposoj">
        <input type="hidden" name="txtTentativaj" id="txtTentativaj">        
        
        <input type="hidden" name="txtTotalObjetos" id="txtTotalObjetos">
        <input type="hidden" name="txtTodosObjetos" id="txtTodosObjetos">         

        <input type="hidden" name="txtTotalTransporte" id="txtTotalTransporte">
        <input type="hidden" name="txtTodosTransporte" id="txtTodosTransporte">     

        <input type="hidden" name="txtTotalArmas" id="txtTotalArmas">
        <input type="hidden" name="txtTodosArmas" id="txtTodosArmas">  
        
        <script type="text/javascript">
               $("#txtTodosDelitos3").attr("value",-1);
//               $("#txtTodosDelitos3j").attr("value",-1);
               $("#txtTodosAlias3").attr("value",-1);
               $("#txtTodosTransporte").attr("value",-1);
               $("#txtTodosObjetos").attr("value",-1);               
               $("#txtTodosArmas").attr("value",-1);  
        </script>
        
        <input type="hidden" name="txtDireccion2" id="txtDireccion2">
        <input type="hidden" name="txtPersonaId" id="txtPersonaId"
               value="<?php if (isset($_SESSION['oDenunciado']))
                   { echo $oDenunciado->getPersonaId(); } ?>"/>        
        
    <!--los botones para guardar persona natural-->    
    <table align="center" summary="botones persona natural">
        <tr> 
            <td><INPUT type="button" name="btnSubmit" value="Guardar datos" onClick="CrearListaDelitosAlias('delito');"></td>
        <td><pre>    </pre></td>    
        <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">      
        </tr>
    </table> 
        
        <table id="tblDenunciado0" align="center" border="0" 
               class="TablaCaja" summary="persona natural">
            <tr class="SubTituloCentro">
                    <th align="center" style="width:15%">Identificación</th>
                    <th align="center" style="width:15%">Genero</th>
                    <th align="center" style="width:15%">Sexo</th>
                    <th align="center" style="width:15%">Comunidad LGBTI</th>
                    <th align="center" style="width:18%">Detenido</th>
            </tr>
            <tr>
                <td>
                    <input type="radio" name="rdConocido" id="rdConocido" value="0" 
                           onClick="ValidarConocido('des',document.forms.frmImputado);"/>Desconocido<br>

                    <input type="radio" name="rdConocido" id="rdConocido" value="1" checked
                           onClick="ValidarConocido('con',document.forms.frmImputado);"/>Conocido<br>
                </td>

                <!--Genero-->
                <td>
                    <input type="radio" name="rdSexo3" id="rdSexo0" value="m" onclick="txtEdad3.disabled= false;"/>Masculino<br>
                    <input type="radio" name="rdSexo3" id="rdSexo1" value="f" onclick="txtEdad3.disabled= false;"/>Femenino<br>    
                    <input type="radio" name="rdSexo3" id="rdSexo2" value="x" onclick="txtEdad3.disabled= false;"/>No consignado<br>
                </td>

                <!--Sexo-->
                <td>
                    <input type="radio" name="rdSexo33" id="rdSexo00" value="m" />Hombre<br>
                    <input type="radio" name="rdSexo33" id="rdSexo11" value="f" />Mujer<br>    
                    <input type="radio" name="rdSexo33" id="rdSexo22" value="x" checked />No consignado<br>
                </td>                
                <td>
<!--                    Orientación sexual<br>
                    <select name="selSexo2" id="selSexo2"></select>
                    <span id="selSexo2"></span>              
                    <br>                -->
                        <input type="checkbox" name="AplicaLGBTI" id="AplicaLGBTI" value="0"/>Integra comunidad
                        <br><br>                                        
                </td>
                
                <td>
                        <input type="radio" name="rdDetenido" id="rdDetenido0" value="m" onclick="txtEdad3.disabled= false;"/>Flagrante<br>
                        <input type="radio" name="rdDetenido" id="rdDetenido1" value="m" onclick="txtEdad3.disabled= false;"/>Detención preventiva<br>
                        <input type="radio" name="rdDetenido" id="rdDetenido2" value="m" onclick="txtEdad3.disabled= false;"/>Prisión preventiva<br>
                        <input type="radio" name="rdDetenido" id="rdDetenido0" value="m" onclick="txtEdad3.disabled= false;"/>Con medida sustitutiva<br>
                </td>
            </tr> 
        </table>                                     
            
    <?php if (isset($_SESSION['oDenunciado'])) {
        if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't'){
            if ($oDenunciado->getConocido()== 0)
            {
        ?>
            <script type="text/javascript">
                $('input:radio[name=rdConocido]')[0].checked= true;            
            </script>
        <?php // 
            }
            elseif($oDenunciado->getConocido()== 1)
            {
        ?>
            <script type="text/javascript">
                $('input:radio[name=rdConocido]')[1].checked= true;            
            </script>           
        <?php 
            }
        }
    }
    ?>
    <!--Orientacion sexual-->
    <script type="text/javascript">         
//        var frm= document.forms.frmImputado;
//        llenarsexo('selSexo2','f', frm);
    </script>

    <?php if (isset($_SESSION['oDenunciado'])) {
        if ($oDenunciado->getGenero()== 'm')
        {
    ?>
        <script type="text/javascript">
            $('input:radio[name=rdSexo3]')[0].checked= true;        
        </script>
    <?php 
        }
        elseif($oDenunciado->getGenero()== 'f')
        {
    ?>          
        <script type="text/javascript">
            $('input:radio[name=rdSexo3]')[1].checked= true; 
        </script>
    <?php 
        }
        elseif($oDenunciado->getGenero()== 'x') 
        {
    ?>          
        <script type="text/javascript">
            $('input:radio[name=rdSexo3]')[2].checked= true; 
        </script>                
    <?php
        }
    }
    ?>      
  
    <script type="text/javascript">
    //llenar el combo denunciantes ingresados
    participante('lstDenunciado2','denunciado');    
    </script>
    <br><br>
    
    <table id="tblDenunciado1" align="center" width="100%" border="0" 
           class="TablaCaja" summary="persona natural">    
        <tr class="SubTituloCentro"><TH colspan="4">Datos Generales</TH></tr>        
        <tr class="Grid">
        <td align="right">Nombres</td>
        <td>
            <input name="txtNombres" type="text" id="txtNombres" size="25" maxlength="24"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       {  if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getNombreCompleto()); } ?>"/>  
        </td>   
        <td align="right">Apellidos</td>
        <td>            
            <input name="txtApellidos" type="text" id="txtApellidos" size="25" maxlength="24"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getApellidoCompleto()); } ?>"/> 
       </tr>
        <tr class="Grid">
        <td align="right">Nacionalidad</td>
        <td>
            <?php
            $resNacion3= CargarNacionalidad();
            combo("cboNacionalidad3",$resNacion3,"cnacionalidadid","cdescripcion");
            ?>
        </td>
        <td align="right">Estado civil</td>
        <td>	
            <?php
                $resCivil3= CargarEstadoCivil();
                combo("cboCivil3",$resCivil3,"ncivil","cdescripcion");
            ?>           
        </td>
        </tr>  
        <tr class="Grid">
        <td align="right">Pasaporte/Identidad</td>
        <td> 
            Tipo de documento
            <?php
                $resTipodoc3= CargarTipoDocumento();
                combo("cboTipoDoc3",$resTipodoc3,"ndocumentoid","cdescripcion","","onchange='ActivarDocumento()'");
            ?>    

            <input name="txtIdentidad3" type="text" id="txtIdentidad3" size="15" maxlength="19" disabled
                value="<?php if (isset($_SESSION['oDenunciado']))
                { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getIdentidad()); }?>"/>                

            <script type="text/javascript">
                if ($("#cboTipoDoc3").val() != 0){
                    $("#txtIdentidad3").removeAttr('disabled');
                }                    
            </script>            
            
        </td>
        <td align="right">Escolaridad</td>
        <td>
            <?php
                $resEscolar3= CargarEscolaridad();
                combo("cboEscolar3",$resEscolar3,"nescolaridadid","cdescripcion");
            ?>    
        </td>
        </tr>  
        <tr class="Grid">
        <td align="right">Profesion/oficio</td>
        <td>
            <?php
                $resProfe3= CargarProfesion();
                combo("cboProfe3",$resProfe3,"nprofesionid","cdescripcion");
            ?>           
        </td>
        <td align="right">Ocupación</td>
        <td>	
            <?php
                $resOcupa3= CargarOcupacion();
                combo("cboOcupa3",$resOcupa3,"nocupacionid","cdescripcion");
            ?>           
        </td>
        </tr> 
        <tr class="Grid">
        <td align="right">Edad</td>
        <td> 
            <!--<input type="txtEdad2" onkeypress="return ValidarNumeros(event)">-->
<!--                OJO no se debe modificar el nombre y id de este campo pq lo usa la
                funcion javascript llenarsexo, que se dispara de los radios sexo-->            
             <input name="txtEdad3" type="text" id="txtEdad3" size="5" maxlength="3"
                   onkeypress="return ValidarNumeros(event);" disabled="disabled"
                   onfocus="QuitarAnoRango();"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getEdad()); } else {echo "0" ;}?>"/> 

            &nbsp;&nbsp; 
            <!-- ojo valores en value con/des afectan "procesaDenunciado.php"-->
            <input type="radio" name="rdAno3" id="rdAno30" value="con" 
                   onclick="ValidarEdadrb(this);"/>Años
            <input type="radio" name="rdAno3" id="rdAno31" value="des" checked
                   onclick="ValidarEdadrb(this);"/>Desconocida
            
            <?php if (isset($_SESSION['oDenunciado']))
                   { 
                       if ($oDenunciado->getUmeDidaEdad()== 'a')
                       {
            ?>
                            <script type="text/javascript">
                                $('input:radio[name=rdAno3]')[0].checked= true;
                            </script>                           
            <?php
                       }
                       else
                       {
            ?>
                            <script type="text/javascript">
                                $('input:radio[name=rdAno3]')[1].checked= true;
                            </script>                          
            <?php
                       }
                   }
            ?>
        </td>
        <td colspan="2">
            <!-- ojo los cambios en value, se deben confirmar en procedaDenunciado.php -->
            <input type="radio" name="rdRangoEdad3" id="rdRangoEdad30" value="infante" 
                   onclick="ValidarRangoEdad(forms.frmImputado);"/>Infante
            
            <input type="radio" name="rdRangoEdad3" id="rdRangoEdad31" value="adelescente" 
                   onclick="ValidarRangoEdad(forms.frmImputado);"/>Adolescente
            
            <input type="radio" name="rdRangoEdad3" id="rdRangoEdad32" value="menoradulto" 
                   onclick="ValidarRangoEdad(forms.frmImputado);"/>Menor adulto
            
            <input type="radio" name="rdRangoEdad3" id="rdRangoEdad33" value="adulto" 
                   onclick="ValidarRangoEdad(forms.frmImputado);"/>Adulto
            
            <input type="radio" name="rdRangoEdad3" id="rdRangoEdad34" value="adultomayor" 
                   onclick="ValidarRangoEdad(forms.frmImputado);"/>Adulto mayor
            
            <input type="radio" name="rdRangoEdad3" id="rdRangoEdad35" value="noconsignado"
                   onclick="ValidarRangoEdad(forms.frmImputado);" checked/>No consignado            
            
            <?php if (isset($_SESSION['oDenunciado']))
                   { 
                       if ($oDenunciado->getRangoEdad()== 'ni')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad3]')[0].checked= true;
                        </script>  
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'na')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad3]')[1].checked= true;
                        </script>        
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'nm')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad3]')[2].checked= true;
                        </script> 
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'a')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad3]')[3].checked= true;
                        </script> 
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'am')
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad3]')[4].checked= true;
                        </script>                                  
            <?php
                       }
                       elseif ($oDenunciado->getRangoEdad()== 'x') 
                       {
            ?>
                        <script type="text/javascript">
                            $('input:radio[name=rdRangoEdad3]')[5].checked= true;
                        </script>                         
           <?php
                       }
                   }
            ?>
        </td>
        </tr>        
    </table>
    
    <br><br>
    <!--inicio-->
<table align="center" border="0" class="TablaCaja" width="100%">
  <tbody>
    <tr class="SubTituloCentro"><Th colspan="4"><strong>Dirección Domiciliar</strong></Th></tr>
    <tr class="SubTituloDerecha">
      <td>Departamento</td>
      <td>Municipio</td>
      <td>Ciudad o Aldea</td>
      <td>Barrio</td>
    </tr>
    <tr class="Grid">
      <td>
	<?php 
		$resDepto3= CargarDepto();
		 combo("cboDepto3",$resDepto3,"cdepartamentoid","cdescripcion","",
                         "onchange='llena_muni(".'"cboDepto3"'.",".'"cboMuni3"'.","
                         .'"tdMuni3"'.",".'"42"'.",".'"cboAldea3"'.",".'"cboBarrio3"'
                         .")'");
	?>
      </td>
      <td id="tdMuni3">
	<?php
		combo("cboMuni3","","cmunicipioid","cdescripcion","",
                      "onchange='llena_aldea(".'"cboDepto3"'.",".'"cboMuni3"'.",
                      ".'"cboAldea3"'.",".'"tdAldea3"'.",".'"43"'.",".'"cboBarrio3"'.")'");
	?>
      </td>
      <td id="tdAldea3">
	<?php
            combo("cboAldea3","","cbaldeaId","cdescripcion","","");
	?>
      </td>
      <td id="tdBarrio3">
          <select name="cboBarrio3" id="cboBarrio3">
              
          </select>
      </td>
    </tr>
    <tr>
      <td colspan="4">Detalle de dirección:<br>
            <input name="txtDireccion3" type="text" id="txtDireccion3" size="80" maxlength="199"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getDetalle()); } ?>"/>   
      </td>
    </tr>    
    <tr>
        <td colspan="4">Teléfonos:<br>
        <input name="txtTelefono" type="text" id="txtTelefono" size="50" maxlength="49"
               value="<?php if (isset($_SESSION['oDenunciado']))
               { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') echo($oDenunciado->getTelefono()); } ?>"/>
    </td>            
    </tr>             
  </tbody>
</table>    
    
    <br><br>
    <!--- otros datos -->
    <table id="tblDenunciado4" align="center" width="100%" border="0" 
           class="TablaCaja" summary="persona natural">    
        <tr class="SubTituloCentro"><TH colspan="4">Otros Datos</TH></tr>     
        <tr class="Grid">
            <td align="right">Pueblo indígena</td>
        <td>	
                <?php
                    $resEtnia3= CargarEtnia();
                    combo("cboEtnia3",$resEtnia3,"netniaid","cdescripcion",
                            "Seleccione una etnia");
                ?>
                <script type="text/javascript">
                $("#cboEtnia3 option[value="+
                        "<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') 
                           echo($oDenunciado->getGrupoEtnico());                        
                       } else { echo(0); } ?>"
                    +"]").attr("selected", true);                                  
                </script>                  
        </td>
        <td align="right">Discapacidad</td>
        <td>	<?php
                    $resDisca3= CargarDiscapacidad();
                    combo("cboDiscapacidad3",$resDisca3,"ndiscapacidadid",
                            "cdescripcion","Seleccione una discapacidad");
                    ?>
                <script type="text/javascript">
                $("#cboDiscapacidad3 option[value="+
                        "<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') 
                           echo($oDenunciado->getDiscapacidad());                        
                       } else { echo(0); } ?>"
                    +"]").attr("selected", true);          
                </script>   
        </td>
        </tr>
    </table>
    <br><br>
    <!--alias-->
    <table id="alias" align="center" width="100%" border="0" 
           class="TablaCaja" summary="alias">    
        <tr class="SubTituloCentro"><TH colspan="4">Alias</TH></tr>     
        <tr class="Grid">
        <td colspan="2">
            <INPUT type="button" id="alias_agre"  name="alias_agre" value="Agregar alias" onclick=AgregarFila("alias");>
        </td>          
        </tr>
    </table>
    
    <br><br>
    <! --delitos y faltas-- >   
    <table id="delito" align="center" width="100%" border="0" 
           class="TablaCaja" summary="delitos">    
        <tr class="SubTituloCentro"><TH colspan="4">Delitos y Faltas</TH></tr>     
        <tr class="Grid">
        <td colspan="2">
            <INPUT type="button" id="delito_agre" name="delito_agre" value="Agregar delitos y faltas" onclick=AgregarFila("delito",0);>
        </td>            
        </tr>
    </table>
    
    
    <!--armas usadas--> 
    <br><br>
    <table id="armas" align="center" width="100%" border="0" 
           class="TablaCaja" summary="armas">    
        <tr class="SubTituloCentro"><TH colspan="4">Tipo de arma/objeto utilizado</TH></tr>     
        <tr class="Grid">
        <td colspan="2">
            <INPUT type="button" id="armas_agre" name="armas_agre" value="Agregar arma/objeto" onclick=AgregarFila("armas",0);>
        </td>            
        </tr>
    </table>
    
    <!--transporte usado--> 
    <br><br>
    <table id="transporte" align="center" width="100%" border="0" 
           class="TablaCaja" summary="transporte">    
        <tr class="SubTituloCentro"><TH colspan="4">Transporte usado</TH></tr>     
        <tr class="Grid">
        <tr>
        <td colspan="2">
            <INPUT type="button" id="transpo_agre" name="transpo_agre" value="Agregar transporte" onclick=AgregarFila("transporte",0);>
        </td>          
        </tr>
        </tr>
    </table>
    
    <!--moivil--> 
    <br><br>
    <table id="contexto" align="center" width="100%" border="0" 
           class="TablaCaja" summary="contexto">    
        <tr class="SubTituloCentro"><TH colspan="4">Móvil / contexto en que ocurren los hechos (según narra el denunciante)</TH></tr>     
        <tr class="Grid">
        <td colspan="2">
            <?php
            $resMovil= CargarMovil();
            combo("cboMovil",$resMovil,"nmovilid","cdescripcion");            
            ?>             
        </td>            
        </tr>
    </table>
    
    
    <!--condicion del agresor--> 
    <br><br>
    <table id="agresor" align="center" width="100%" border="0" 
           class="TablaCaja" summary="agresor">    
        <tr class="SubTituloCentro"><TH colspan="3">Condición del agresor</TH></tr>     
        <tr class="Grid">
            <td><br>
                Condición del agresor:<br>
                <input type="radio" name="rdCondicion" id="rdCondicion" value="Sobrio">Sobrio<br>
                <input type="radio" name="rdCondicion" id="rdCondicion" value="Alcohol">Alcohol<br>
                <input type="radio" name="rdCondicion" id="rdCondicion" value="estupefacientes">Bajo efectos estupefacientes<br>
                <input type="radio" name="rdCondicion" id="rdCondicion" value="Perturbación">Perturbación psicológica<br>
                <input type="radio" name="rdCondicion" id="rdCondicion" value="NA" checked>No Aplica
            </td>           
            <td>
                Posee trabajo remunerado:<br>
                <input type="radio" name="rdTrabajo" id="rdPeriodo" value="SI">Si<br>
                <input type="radio" name="rdTrabajo" id="rdPeriodo" value="NO">No<br>
                <input type="radio" name="rdTrabajo" id="rdPeriodo" value="NA" checked>No Aplica<br>
            </td>  
            <td><br>
                Asiste a centro educacional:<br>
                <input type="radio" name="rdEstudia" id="rdEstudia" value="SI">Si<br>
                <input type="radio" name="rdEstudia" id="rdEstudia" value="NO">No<br>
                <input type="radio" name="rdEstudia" id="rdEstudia" value="NA" checked>No Aplica
            </td>                      
        </td>            
        </tr>
    </table>            
    
    
        <!--tipo objeto robado-hurtado--> 
    <br><br>
    <table id="objeto" align="center" width="100%" border="0" 
           class="TablaCaja" summary="objeto">    
        <tr class="SubTituloCentro"><TH colspan="4">Tipo de objeto robado/hurtado</TH></tr>     
        <tr><td colspan="2">Monto robado declarado por la víctima (en Lempiras): <input type="text" name="txtMonto" id="txtMonto"></td></tr>
        <tr class="Grid">
        <td colspan="2">
            <INPUT type="button" id="objetorobo" name="objetorobo" value="Agregar objeto robado" onclick=AgregarFila("objeto",0);>
        </td>            
        </tr>
    </table>

    <!--los botones para guardar persona natural-->
    <br>
    <table align="center" summary="botones persona natural">
        <tr> 
        <td><INPUT type="button" name="btnSubmit" value="Guardar datos" onClick="CrearListaDelitosAlias('delito');"></td>
        <td><INPUT type="button" name="btnBorrar" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">      
        </tr>
    </table>     
    
    </FORM>         
</div> <!--fin acordion persona natural-->    

<div style="display:none;" id="PersonaJuridicaDiv2">
<h3><a href="#">Persona Juridica</a></h3>

<FORM action="procesaimputado.php" method="POST" name="frmImputadoJuridico" 
      id="frmImputadoJuridico" >  
    <!--onsubmit="return ValidarDenunciadoJuridico(this);"-->

    <input type="hidden" name="txtTotalDelitos3j" id="txtTotalDelitos3j">
    <input type="hidden" name="txtTodosDelitos3j" id="txtTodosDelitos3j"> 

    <input type="hidden" name="txtCulposoj" id="txtCulposoj">
    <input type="hidden" name="txtTentativaj" id="txtTentativaj">

    <script type="text/javascript">
           $("#txtTodosDelitos3j").attr("value",-1);
    </script>

    <input type="hidden" name="txtTipoDoc3" id="txtTipoDoc3">
    <input type="hidden" name="txtNaturalJuridico" id="txtNaturalJuridico">
    <input type="hidden" id='Denunciado3Jur' name='Denunciado3Jur'>
    <input type="hidden" name="txtPersonaId3j" id="txtPersonaId3j"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '0' || $oDenunciado->getPersonaNatural()== 'f') echo($oDenunciado->getPersonaId());} ?>"/>
    
    <table id="tblPersonaJuridica" align="center" border= "0"
           class="TablaCaja" summary="datos persona natural">
        
    <tr class="SubTituloCentro"><th colspan="4">Datos generales de la empresa</th></tr>
       
        <td align="right">Nombre de empresa o institución</td>
        
        <td><input list="txtEmpresasHn3" name="txtEmpresasHn3" id="txtEmpresasHn3" size="30" maxlength="99" 
                   onblur="document.getElementById('Denunciado3Jur').value= 'juridico';"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                        { if ($oDenunciado->getPersonaNatural()== '0' || $oDenunciado->getPersonaNatural()== 'f') echo($oDenunciado->getNombreCompleto());  } ?>"/>
            <datalist id="txtEmpresasHn3-list">
                <?php
                    $resEmpresas= CargarEmpresasHN();
                    while ($Rol= pg_fetch_array($resEmpresas)) {
                        echo "<option value='$Rol[cdescripcion]'>";
                    }
                ?>
            </datalist>    
            <input type="checkbox" id="desconocido" name="desconocido">Desconocido
        </td>
        <td align="right">RTN</td>
        <td>            
            <input type="text" id="txtRtn3" name="txtRtn3" size="15" maxlength="19" 
                   value="<?php if (isset($_SESSION['oDenunciado']))
                        { if ($oDenunciado->getPersonaNatural()== '0' || $oDenunciado->getPersonaNatural()== 'f') echo($oDenunciado->getRTN());  } ?>">
        </td> 
    <tr>
        <td align="right">Nacionalidad</td>
        <td>
            <?php
            $resNacionJ= CargarNacionalidad();
            combo("cboNacionalidad3J",$resNacionJ,"cnacionalidadid","cdescripcion");
            ?>        
        </td>        
        <td align="right">Teléfonos</td>
        <td>
            <input type="text" id="txtTelefono3" name="txtTelefono3" size="15" maxlength="59"
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '0' || $oDenunciado->getPersonaNatural()== 'f') echo($oDenunciado->getTelefono()); } ?>">
        </td>
        <td></td>
    </tr>
        <tr class="Grid">
        <td align="right">Departamento</td>
        <td>
            <?php
                    $resDepto= CargarDepto();
                    combo("cboDepto3J",$resDepto,"cdepartamentoid","cdescripcion","",
                            "onchange='llena_muni(".'"cboDepto3J"'.",".'"cboMuni3J"'.",
                                ".'"tdMuni3J"'.",".'"52"'.",".'"cboAldea3J"'.",".'"cboBarrio3J"'.")'");
            ?>
        </td>
        <td align="right">Municipio</td>
        <td id="tdMuni3J">
            <select id="cboMuni3J" name="cboMini3J"></select>
        </td>
        </tr>
        <tr class="Grid">
        <td align="right">Ciudad o Aldea</td>
        <td id="tdAldea3J">
            <select id="cboAldea3J" name="cboAldea3J"></select>
        </td>
        <td align="right">Barrio</td>
        <td id="tdBarrio3J">
            <select id="cboBarrio3J" name="cboBarrio3J"></select>
        </td>
        </tr>
     <tr>
        <td align="right">Detalle dirección</td>
        <td colspan="3">
            <input list="txtDireccionJuridica3" name="txtDireccionJuridica3" size="80" maxlength="199" required
                   value="<?php if (isset($_SESSION['oDenunciado']))
                       { if ($oDenunciado->getPersonaNatural()== '0' || $oDenunciado->getPersonaNatural()== 'f') echo($oDenunciado->getTxtDireccion());} ?>">
        </td>
     </tr>    
    </table>  
    <br>
        <table id="tblApoderado" align="center" border="0" 
               class="TablaCaja" summary="apoderado legal">
            <tr class="SubTituloCentro"><th colspan="4">Representante o apoderado Legal</th></tr>
            <tr class=" Grid">
                <td align="right">Nombre completo</td>
                <td>            
                    <input name="txtApoderado3J" type="text" id="txtApoderado3J" size="25" maxlength="50" 
                           value="<?php if (isset($_SESSION['oDenunciado']))
                           { if ($oDenunciado->getPersonaNatural()== '0' || $oDenunciado->getPersonaNatural()== 'f') echo($oDenunciado->getApoderadoNombre()); } ?>"/> 
                </td>
            </tr>
            <tr>
                <td align="right">Identificación</td>
                <td>            
                    <input name="txtColegio3J" type="text" id="txtColegio3J" size="15" maxlength="20"
                           value="<?php if (isset($_SESSION['oDenunciado']))
                           { if ($oDenunciado->getPersonaNatural()== '0' || $oDenunciado->getPersonaNatural()== 'f') 
                                   echo($oDenunciado->getIdentidad());
                               else
                                   echo("-- No consignado --");                                
                           } ?>"/>                     
                    <input name="rdTipoDoc3" id="rdTipoDoc0" type="radio" value="colegio">Número colegiado
                    <input name="rdTipoDoc3" id="rdTipoDoc1" type="radio" value="identidad">Identidad
                    <input name="rdTipoDoc3" id="rdTipoDoc2" type="radio" value="pasaporte">Pasaporte
                    <input name="rdTipoDoc3" id="rdTipoDoc3" type="radio" value="nodefinido" checked="">Sin identificación
                </td>            
            </tr>
        </table>     
    <br>
    <! --delitos y faltas-- >   
    <table id="delitoj" align="center" width="100%" border="0" 
           class="TablaCaja" summary="delitos">    
        <tr class="SubTituloCentro"><TH colspan="4">Delitos y Faltas</TH></tr>     
        <tr class="Grid">
        <td colspan="2">
            <INPUT type="button" id="delito_agre" name="delito_agre" value="Agregar delitos y faltas" onclick=AgregarFila("delitoj",0);>
        </td>            
        </tr>
    </table>   
    
    <!--los botones para guardar-->
    <br>
    <table align="center" summary="botones persona natural">
        <tr>     
        <td><INPUT type="button" name="btnSubmit" value="Guardar datos" 
                   onClick="CrearListaDelitosJuridica('delitoj');"></td>
        <td><INPUT type="button" name="btnNuevo" value="Borrar actual" 
                   onClick="BorrarRegistro(document.getElementById('txtPersonaId').value);">
        </td>  
        </tr>
    </table>   
</form>
</div> <!--fin acordion persona juridica-->
</div>

<script type="text/javascript">    
    //    hacer visible el div persona natural 
    
    Natural= "<?php
        if (isset($_SESSION['PersonaNaturalJuridica'])){ 
        echo($_SESSION['PersonaNaturalJuridica']);} 
    ?>";
        
    if (Natural == 'Natural') 
        document.getElementById('PersonaNaturalDiv2').style.display= 'block';
    
    //    hacer visible el div persona juridica
    Juridica= "<?php
        if (isset($_SESSION['PersonaNaturalJuridica'])){ 
        echo($_SESSION['PersonaNaturalJuridica']);} 
    ?>";
      
    if (Juridica == 'Juridica'){ 
        document.getElementById('PersonaJuridicaDiv2').style.display= 'block';
        document.getElementById('txtEmpresasHn3').focus(); 
    }
    
    //cuando se selecciona un denunciante y saber que div mostrar
    TipoPersona= "<?php if (isset($oDenunciado)){ echo($oDenunciado->getPersonaNatural());}
                        else { echo 'x';}
                  ?>";
                     
    if (TipoPersona== 't') //persona natural
    {
        Natural = 'Natural';
        document.getElementById('PersonaNaturalDiv2').style.display= 'block';
    }
    if (TipoPersona== 'f') //persona juridica
    {
        Natural = 'Juridica';
        document.getElementById('PersonaJuridicaDiv2').style.display= 'block';  
    }    
    
 <?php if (isset($_SESSION['oDenunciado']))
        { ?>                                     
            datos= new Array();
    
            datos.civil= "<?php 
            if ($oDenunciado->getPersonaNatural() == '1' || $oDenunciado->getPersonaNatural() == 't') {
                    echo($oDenunciado->getEstadoCivil());
            } else {
                    echo(0);
            }
            ?>";    

            datos.tipodoc= "<?php        if ($oDenunciado->getPersonaNatural() == '1' || $oDenunciado->getPersonaNatural() == 't') {
                echo($oDenunciado->getTipoDocumento());
            } else {
                echo(0);
            }
            ?>";                           

            datos.escolaridad= "<?php     if ($oDenunciado->getPersonaNatural() == '1' || $oDenunciado->getPersonaNatural() == 't') {
                echo($oDenunciado->getEscolaridad());
            } else {
                echo(0);
            }
            ?>";

            datos.nacionalidad= "<?php if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') 
                                        echo($oDenunciado->getNacionalidad());                        
                                        else echo "HN"; ?>";

            datos.profesion= "<?php if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') 
                                    echo($oDenunciado->getProfesion());                        
                                    else echo(0); ?>";

            datos.ocupacion= "<?php if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') 
                                    echo($oDenunciado->getOcupacion());                        
                                    else echo(0); ?>";

            datos.departamento= "<?php 
                                if (isset($oDenunciado)){
                                   echo($oDenunciado->getDepartamentoid());                        
                                }
                                else {
                                    echo(0);
                                }?>";

            datos.municipio= "<?php
                                if (isset($oDenunciado)){
                                   echo($oDenunciado->getMunicipioid());                        
                                }
                                else {  
                                    echo(0); 
                                }?>";

            datos.ciudad= "<?php 
                             if (isset($oDenunciado)){
                                   echo($oDenunciado->getAldeaId()); 
                             }
                             else {
                                 echo(0); 
                             }?>";

            datos.barrio= "<?php 
                            if (isset($oDenunciado)){
                                   echo($oDenunciado->getBarrioId()); 
                            }
                            else {
                                echo(0);
                            }?>";                                                      
    
            datos.personaid= "<?php 
                                if (isset($oDenunciado)){
                                   echo($oDenunciado->getPersonaId()); 
                                }
                                ?>";

                             
            datos.sexo= "<?php if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') 
                                   echo($oDenunciado->getGenero()); ?>"; 
                                       
            datos.orientacionsex= "<?php if ($oDenunciado->getPersonaNatural()== '1' || $oDenunciado->getPersonaNatural()== 't') 
                                   echo($oDenunciado->getOrientacionSex()); ?>";                                       

            datos.tipopersona= "<?php 
                                if (isset($oDenunciado)){
                                   echo($oDenunciado->getPersonaNatural()); 
                                }
                                ?>";

            datos.ccondicion= "<?php 
                                if (isset($oDenunciado)){
                                   echo($oDenunciado->getCondicionAgresor()); 
                                }
                                ?>";

            datos.ctrabajoremunerado= "<?php 
                                if (isset($oDenunciado)){
                                   echo($oDenunciado->getTrabajoRemunerado()); 
                                }
                                ?>";
                                    
            datos.casisteeducacion= "<?php 
                                if (isset($oDenunciado)){
                                   echo($oDenunciado->getAsisteEducacion()); 
                                }
                                ?>";

            frm= document.forms.frmImputado;            

            LlenarCampos(frm, datos); 

            frmImputadoJuridico.cboNacionalidad3J.value= datos.nacionalidad;    
            frmImputado.cboNacionalidad3.value= datos.nacionalidad;             
  
  <?php }
    else
    { ?> 
        frmImputadoJuridico.cboNacionalidad3J.value= "HN";
        frmImputado.cboNacionalidad3.value= "HN";  
    <?php        
    }
    ?>        
</script>            
</body>
</html>