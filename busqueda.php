<?php 
    include("clases/Usuario.php");
    
    session_start();
    if (isset($_SESSION['objUsuario'])){
        $objUsuario= $_SESSION['objUsuario'];
    }
    else{	
        header("location:index.php");
    }    
    
    include("clases/controles/funct_text.php");
    include("clases/controles/funct_select.php");	
    include("clases/controles/funct_radio.php");
    include("clases/controles/funct_check.php");

    include("clases/class_conexion_pg.php");

    include_once "./funciones/php_funciones.php"; 
    BorrarDenunciaRAM();
    PrepararCrearDenunciaNueva();    
    
    $objConexion=new Conexion(); 
    $sql= "select distinct ctablatxt, ctabla from mini_sedi.tbl_criterio order by ctablatxt;";
    $resTabla=$objConexion->ejecutarComando($sql);    
 
    $sql= "select distinct ccampotxt, ccampo from mini_sedi.tbl_criterio order by ccampotxt;";
    $resCampo=$objConexion->ejecutarComando($sql);    

    $sql= "SELECT cdepartamentoid as txt, cdescripcion as des FROM mini_sedi.tbl_departamentopais;";
    $resCriterio=$objConexion->ejecutarComando($sql);    
    
    $sql= "select distinct ccampotxt, ccampo from mini_sedi.tbl_criterio ";
    $sql= $sql . "where substring(ccampotxt,1,1)= '.$_SESSION[CampoTabla].'";
    $resCampoFiltrado=$objConexion->ejecutarComando($sql);    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>    
    <meta name="GENERATOR" content="Quanta Plus">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Busqueda</title>
    <link type="text/css" rel="stylesheet" href="css/Estilos.css"> 
    
	<link type="text/css" rel="stylesheet" href="../css/Estilos.css"> 
	<script type="text/javascript" src="java_script/funciones.js"></script>    
        
        <!-- jquery -->
	<link href="java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="java_script/js/jquery-1.10.2.js"></script>
	<script src="java_script/js/jquery-ui-1.10.4.custom.js"></script>

<style type="text/css">
    .ui-datepicker {
        font-size: 11px;
        margin-left:10px
     }
</style>

<script type="text/javascript">
	var Contador= 1;
	var fil= 0;
	var FilaCompleta= 1;
</script>


</head>

<!-- rgba(0, 255, 0, 0.1)-->
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
    
<!-- ocultar y mostrar divs de busquedas -->
<script type="text/javascript">
function MostrarOcultarDiv(mostrar, ocultar1, ocultar2, ocultar3){ 
    document.getElementById(mostrar).style.display= 'block';
    document.getElementById(ocultar1).style.display= 'none';
    document.getElementById(ocultar2).style.display= 'none';
    document.getElementById(ocultar3).style.display= 'none';
}
</script>
    
<!--para la direccion: depto, municipio, aldea, barrio-->
<script type="text/javascript">
//<!--departamento hecho-->
function CargarDepartamento()
{
	<?php
//	$objConexion=new Conexion(); 
//	$sql= "SELECT cdepartamentoid, cdescripcion FROM mini_sedi.tbl_departamentopais order by  cdescripcion;";
//	$resDepto=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<!--para la direccion: depto, municipio, aldea, barrio-->
<script type="text/javascript">
//<!--departamento hecho-->
function CargarDepartamento2()
{
	<?php
//	$objConexion=new Conexion();
//	$sql= "SELECT cdepartamentoid, cdescripcion FROM mini_sedi.tbl_departamentopais order by  cdescripcion;";
//	$resDepto2=$objConexion->ejecutarComando($sql);
	?>
}
</script>

<script type="text/javascript">
<!--crear cookiee con lista de tareas-->
function frmListaTareas()
{
document.write("<form method='POST' action='clases/tareas_procesar.php' id='frm1' name='frm1'>"+
	"<input type='text' id='usuario' name='usuario' >" +
	"<input type='text' id='tarea' name='tarea' >")
document.getElementById("usuario").value= 
document.frm1.submit();
}

<!--municipio hecho-->
function CargarMunicipio()
{
	<?php
//	$objConexion=new Conexion();
//        $sql= "select m.cdepartamentoid || cmunicipioid as id, m.cdescripcion || ', ' || d.cdescripcion as cdescripcion "
//        ."from mini_sedi.tbl_municipio m, mini_sedi.tbl_departamentopais d "
//        ."where m.cdepartamentoid= d.cdepartamentoid order by m.cdescripcion;";
//	$resMuni=$objConexion->ejecutarComando($sql);
	?>		
}
</script>

<script type="text/javascript">
<!--municipio hecho-->
function CargarMunicipio2()
{
	<?php
//	$objConexion=new Conexion();
//        $sql= "select m.cdepartamentoid || cmunicipioid as id, m.cdescripcion || ', ' || d.cdescripcion as cdescripcion "
//        ."from mini_sedi.tbl_municipio m, mini_sedi.tbl_departamentopais d "
//        ."where m.cdepartamentoid= d.cdepartamentoid order by m.cdescripcion;";
//	$resMuni2=$objConexion->ejecutarComando($sql);
	?>
}
</script>

<script type="text/javascript">
<!--ciudad hecho-->
function Ciudad()
{
	<?php
//	$objConexion=new Conexion();
//	$sql= "select a.cdepartamentoid || cmunicipioid || caldeaid as id, a.cdescripcion || ', ' || d.cdescripcion as cdescripcion  "
//            ."from mini_sedi.tbl_aldea a, mini_sedi.tbl_departamentopais d "
//            ."where a.cdepartamentoid= d.cdepartamentoid order by a.cdescripcion;";
//        $resCiudad=$objConexion->ejecutarComando($sql);
        
        
//	$sql= "select m.cdepartamentoid || ',' || cmunicipioid || ',' || caldeaid as id, m.cdescripcion as campo "
//            ."from tbl_aldea m, tbl_departamentopais d "
//            ."where m.cdepartamentoid= d.cdepartamentoid and m.cdescripcion like 'AGUAN%' order by m.cdescripcion;";
	
	?>
}
</script>

<br><br>
<!--lista tabla segun tabla seleccionada-->
<script type="text/javascript">
function CargarTabla()
{
	<?php
//	$objConexion=new Conexion(); 
//	$sql= "select distinct ctablatxt, ctabla from mini_sedi.tbl_criterio order by ctablatxt;";
//	$resTabla=$objConexion->ejecutarComando($sql);
	?>
}
</script>

<!--lista campos segun tabla seleccionada-->
<script type="text/javascript">
function CargarCampos()
{
	<?php
//	$objConexion=new Conexion(); 
//	$sql= "select distinct ccampotxt, ccampo from mini_sedi.tbl_criterio order by ccampotxt;";
//	$resCampo=$objConexion->ejecutarComando($sql);
	?>
}
</script>

<!--para la direccion: depto, municipio, aldea, barrio-->

<script type="text/javascript">
//<!--departamento-->
function CargarCriterio(Criterio)
{
    if (Criterio== "depto"){
    <?php
//        $objConexion=new Conexion(); 
//        $sql= "SELECT cdepartamentoid as txt, cdescripcion as des FROM mini_sedi.tbl_departamentopais;";
//        $resCriterio=$objConexion->ejecutarComando($sql);
    ?>
    }
}
   
</script>

<script type="text/javascript">
//<!--departamento-->
function FiltrarCampo()
{
    Seleccion= document.getElementById("tbl"+Contador).selectedIndex;
    CampoBorrar= document.getElementById("tbl"+Contador).options[Seleccion].text.substring(0,1);

    <?php
//        $objConexion=new Conexion();
//        $sql= "select distinct ccampotxt, ccampo from mini_sedi.tbl_criterio ";
//        $sql= $sql . "where substring(ccampotxt,1,1)= '.$_SESSION[CampoTabla].'";
//        $resCampoFiltrado=$objConexion->ejecutarComando($sql);
    ?>

}
</script>
      
<!--formulario para enviar el sqk-->
<form action="RealizarBusqueda.php" method="POST" id="frmsql" name="frmsql">
	<input type="hidden" id="sql" name="sql" >	
        <input type="hidden" id="total" name="total" >	
</form>

<!--agregar contenido al campo-->
<script type="text/javascript">
function AgregarCampos()
{
	Seleccion= document.getElementById("tbl"+Contador).selectedIndex;
	CampoBorrar= document.getElementById("tbl"+Contador).options[Seleccion].text.substring(0,1);
	TotalElementos= document.getElementById("campo"+Contador).length;
	ListaElementos= document.getElementById("campo"+Contador);
	i= 0;
	while (i < TotalElementos)
	{
		if (ListaElementos.options[i].text.substring(0,1)!= CampoBorrar &&  
		    ListaElementos.options[i].text!= "Seleccione opcion"
		   )
		{
			ListaElementos.options[i]= null;
			TotalElementos= document.getElementById("campo"+Contador).length;
			i= 0;	
		}
		else
		{
			i++;
		}
	}
}
</script>

<!--crear instruccion sql-->
<script type="text/javascript">
function CrearCriterio()
{
        //verifica si ya existe elemento donde escribir criterio
        if (FilaCompleta== 1){
            $("#criterio"+Contador).remove();
            //return;
        }

	if (document.getElementById("campo"+Contador).value== "cdeptodenuncia")
	{
		//deptos del pais
                if (FilaCompleta!= 1)
                    col= document.createElement("td");
		dep1= document.createElement("select");
		dep1.name= "criterio"+Contador; //tbl
		dep1.id= "criterio"+Contador;

		<?php 
		while ($fila=pg_fetch_array($resDepto)){?>
			opt= document.createElement("option");
			opt.text=  "<?php echo($fila[cdescripcion]);?>"
			opt.id= "tblsel"+Contador;
			opt.value= "<?php echo($fila[cdepartamentoid]);?>"
	
			try{
				dep1.add(opt,null);
			}
			catch(e)
			{
				dep1.add(opt);
			}
		<?php
		}
		?>
		col.appendChild(dep1);
		fil.appendChild(col);
	}
	else
        if (document.getElementById("campo"+Contador).value.substring(16,34)== "cmunicipiodenuncia")
	{
		//muncipios del pais
                if (FilaCompleta!= 1)
                    col= document.createElement("td");
		muni1= document.createElement("select");
		muni1.name= "criterio"+Contador; //tbl
		muni1.id= "criterio"+Contador;
	
		<?php 
		while ($fila=pg_fetch_array($resMuni)){?>
			opt= document.createElement("option");
			opt.text=  "<?php echo($fila[cdescripcion]);?>"
			opt.id= "tblsel"+Contador;
			opt.value= "<?php echo($fila[id]);?>"
	
			try{ 
				muni1.add(opt,null);
			}
			catch(e)
			{
				muni1.add(opt);
			}
		<?php
		}
		?>
		col.appendChild(muni1);
		fil.appendChild(col);
	}
	else
	if (document.getElementById("campo"+Contador).value== "cdeptohecho")
	{            
		//deptos del pais
                if (FilaCompleta!= 1)
                    col= document.createElement("td");
		dep1= document.createElement("select");
		dep1.name= "criterio"+Contador; 
		dep1.id= "criterio"+Contador;

		<?php
                while ($fila=pg_fetch_array($resDepto2)){?>
			opt= document.createElement("option");
			opt.text=  "<?php echo($fila[cdescripcion]);?>"
			opt.id= "tblsel"+Contador;
			opt.value= "<?php echo($fila[cdepartamentoid]);?>"
	
			try{
				dep1.add(opt,null);
			}
			catch(e)
			{
				dep1.add(opt);
			}
		<?php
		}
		?>
		col.appendChild(dep1);
		fil.appendChild(col);
	}
	else
        if (document.getElementById("campo"+Contador).value.substring(16,31)== "cmunicipiohecho")
	{
		//muncipios del pais
                if (FilaCompleta!= 1)
                    col= document.createElement("td");
		muni1= document.createElement("select");
		muni1.name= "criterio"+Contador; //tbl
		muni1.id= "criterio"+Contador;
	
		<?php 
		while ($fila=pg_fetch_array($resMuni2)){?>
			opt= document.createElement("option");
			opt.text=  "<?php echo($fila[cdescripcion]);?>"
			opt.id= "tblsel"+Contador;
			opt.value= "<?php echo($fila[id]);?>"
	
			try{ 
				muni1.add(opt,null);
			}
			catch(e)
			{
				muni1.add(opt);
			}
		<?php
		}
		?>
		col.appendChild(muni1);
		fil.appendChild(col);
	}
	else
        if (document.getElementById("campo"+Contador).value.substring(33,44)== "caldeahecho")
	{
		//muncipios del pais
                if (FilaCompleta!= 1)
                    col= document.createElement("td");
		muni1= document.createElement("select");
		muni1.name= "criterio"+Contador; //tbl
		muni1.id= "criterio"+Contador;
		<?php
		while ($fila=pg_fetch_array($resCiudad)){?>
			opt= document.createElement("option");
                        opt.value= "<?php echo($fila[id]);?>"
                        opt.id= "tblsel"+Contador;

			opt.text= "<?php echo($fila[cdescripcion]);?>"
			try{
				muni1.add(opt,null);
			}
			catch(e)
			{
				muni1.add(opt);
			}
		<?php
		}
		?>
		col.appendChild(muni1);
		fil.appendChild(col);

	}
        else //fechas, agregar un datepicker
        if (document.getElementById("campo"+Contador).value.substring(0,1)== "d")
        {
		//criterio
                if (FilaCompleta!= 1)
                    col= document.createElement("td");
		txt1= document.createElement("input");
		txt1.type= "text";
		txt1.name= "criterio"+Contador;
		txt1.id= "criterio"+Contador;
		txt1.size= 20;

                col.appendChild(txt1);
		fil.appendChild(col);

                $(function() {
                    $( "#"+txt1.id).datepicker({
                    dateFormat: 'dd / mm / yy',
                    changeMonth: true,
                    changeYear: true
                });

                function Calendario(){
                    $( "#"+txt1.id).datepicker();
                }
    });
        }
        else
	{
		//criterio
                if (FilaCompleta!= 1)
                    col= document.createElement("td");
		txt1= document.createElement("input");
		txt1.type= "text";
		txt1.name= "criterio"+Contador;
		txt1.id= "criterio"+Contador;
		txt1.size= 20;
	
		col.appendChild(txt1); 
		fil.appendChild(col);
	}

	FilaCompleta= 1;
}
</script>

<!--agregar filas a las tablas-->
<script type="text/javascript">
function AgregarFila()
{ 

//        document.getElementById("btnBuscar").disabled= false;
        $("#btnBuscar").removeAttr("disabled");//ACtiva el botton buscar
        if (FilaCompleta== 0)
	{
		alert("Debe completar la busqueda, seleccione un Campo");
		return;
	}
	
	FilaCompleta= 0;

	fil=document.getElementById("tblBuscar").insertRow(Contador++);

	//tabla
	col= document.createElement("td"); 
	sel1= document.createElement("select");
	sel1.name= "tbl"+Contador;
	sel1.id= "tbl"+Contador;

	opt= document.createElement("option");
	opt.text=  "Seleccione tabla";
	opt.id= "tblsel"+Contador;
	opt.value= "-1";

	try{
		sel1.add(opt,null);
	}
	catch(e)
	{
		sel1.add(opt);
	}
	<?php 
	while ($fila=pg_fetch_array($resTabla)){?>
		opt= document.createElement("option");
		opt.text=  "<?php echo($fila[ctablatxt]);?>"
		opt.id= "tblsel"+Contador;
		opt.value= "<?php echo($fila[ctabla]);?>"

		try{
			sel1.add(opt,null);
		}
		catch(e)
		{
			sel1.add(opt);
		}
	<?php
	}
	?>
        
	col.appendChild(sel1);
	fil.appendChild(col);
        
	//campo
	col= document.createElement("td"); 
	//col.width="5%";

	sel2= document.createElement("select");
	sel2.name= "campo"+Contador;
	sel2.id= "campo"+Contador;

	opt= document.createElement("option");
	opt.text=  "Seleccione opcion";
	opt.id= "cpsel"+Contador;
	opt.value= "-1";

	try{
		sel2.add(opt,null);
	}
	catch(e)
	{
		sel2.add(opt);
	}

        //llena combo de campos
        ComboTabla= sel1.id;
        ComboCampo= sel2.id;
        $("#"+ComboTabla).change(function(){ 
            $.ajax({
                type: "GET",
                url: "CriterioBusqueda.php",
                data: "Tabla="+$("#"+ComboTabla).val(),
                dataType: "text",
                success: function(dato){ 
                    $("#"+ComboCampo).html(dato);
                }
            });
        });

	col.appendChild(sel2);
	fil.appendChild(col);
    
	//operador
	col= document.createElement("td"); 

	sel1= document.createElement("select");
	sel1.name= "opr"+Contador;
	sel1.id= "opr"+Contador;	

	opt= document.createElement("option");
	opt.text= "Contiene";
	opt.id= "oprsel"+Contador;
	opt.value= " like "
	try{
		sel1.add(opt,null);
	}
	catch(e)
	{
		sel1.add(opt);
	}

	opt= document.createElement("option");
	opt.text= "Igual a";
	opt.id= "oprsel"+Contador;
	opt.value= "="
	try{
		sel1.add(opt,null);
	}
	catch(e)
	{
		sel1.add(opt);
	}

	opt= document.createElement("option");
	opt.text= "Menor a";
	opt.id= "oprsel"+Contador;
	opt.value= "<"
	try{
		sel1.add(opt,null);
	}
	catch(e)
	{
		sel1.add(opt);
	}

	opt= document.createElement("option");
	opt.text= "Mayor a";
	opt.id= "oprsel"+Contador;
	opt.value= ">"
	try{
		sel1.add(opt,null);
	}
	catch(e)
	{
		sel1.add(opt);
	}

	col.appendChild(sel1);
	fil.appendChild(col);

	//agregar evento al campo seleciconado
	document.getElementById("campo"+Contador).onchange= CrearCriterio;

	//agregar evento a tabla seleciconada
	//document.getElementById("tbl"+Contador).onchange= AgregarCampos;
        document.getElementById("tbl"+Contador).onchange= FiltrarCampo; 
}
</script>



<!--crear instruccion sql-->
<script type="text/javascript">
function CrearSQL()
{    
        CriteriosBlancos= 0;
	Sql= ""; Wheretxt= ""; Fromtxt= ""; MasdeUno= 1;
	tblDenunciante= 1; tblDenuncia= 1; tblOfendido= 1; tblImputado= 1;
        Direccion= 0;        
	for(i= 2; i<= Contador; i++) 
	{		            
		//formar el from
		//incluir tabla denuncia                
		if (document.getElementById("tbl"+i).value== "tbl_denuncia" && tblDenuncia== 0)
		{
			if (MasdeUno== 1)
				Fromtxt= Fromtxt + ", ";
			Fromtxt= Fromtxt + document.getElementById("tbl"+i).value;
			tblDenuncia= 1;
		}

		//incluir tabla denunciante
		if (document.getElementById("tbl"+i).value== "tbl_denunciante" && tblDenunciante== 0)
		{
			if (MasdeUno== 1)
				Fromtxt= Fromtxt + ", ";
			Fromtxt= Fromtxt + document.getElementById("tbl"+i).value;
			tblDenunciante= 1;
		}

		//incluir tabla imputado
		if (document.getElementById("tbl"+i).value== "tbl_imputado" && tblImputado== 0)
		{
			if (MasdeUno== 1)
				Fromtxt= Fromtxt + ", ";
			Fromtxt= Fromtxt + document.getElementById("tbl"+i).value;
			tblImputado= 1;
		}

		//incluir tabla ofendido
		if (document.getElementById("tbl"+i).value== "tbl_ofendido" && tblOfendido== 0)
		{
			if (MasdeUno== 1)
				Fromtxt= Fromtxt + ", ";
			Fromtxt= Fromtxt + document.getElementById("tbl"+i).value;
			tblOfendido= 1;
		}

		//ahora vienen los where
		//campos indicando la tabla origen
		Wheretxt= Wheretxt + 
			document.getElementById("tbl"+i).value
			+"."+document.getElementById("campo"+i).value;

		//saber si agregar comillas, fecha ansi, etc		
		//pasar a fecha ansi
		if (document.getElementById("campo"+i).value.charAt(0)== "d")
		{
			if (document.getElementById("opr"+i).value== " like ")
			{
//				alert("Uso no valido del operador 'Contiene', " +
//					"se cambiará por 'Igual a'");
				document.getElementById("opr"+i).value= "=";	
			}

                        //substring inicia con cero (0)
			Criteriotxt= document.getElementById("criterio"+i).value.substring(10,14);
			
			Criteriotxt= Criteriotxt + document.getElementById("criterio"+i).value.substring(5,7);
			
			Criteriotxt= Criteriotxt + document.getElementById("criterio"+i).value.substring(0,2);

			Wheretxt= Wheretxt + document.getElementById("opr"+i).value;
			Wheretxt= Wheretxt + "'" + Criteriotxt + "'";
		}

		//si es texto
		if (document.getElementById("campo"+i).value.charAt(0)== "c")
		{
                    //se desea buscar sobre un campo depto
                    if (document.getElementById("campo"+i).value.substring(0,6)== "cdepto" &&
                        document.getElementById("campo"+i).value.indexOf("|") < 0)
                    {
			Wheretxt= Wheretxt + document.getElementById("opr"+i).value;
			if (document.getElementById("opr"+i).value== " like ")
			{
				Wheretxt= Wheretxt +
				"'%" + document.getElementById("criterio"+i).value.toUpperCase() + "%'";
			}
			else
			{
				Wheretxt= Wheretxt +
				"'" + document.getElementById("criterio"+i).value.toUpperCase() + "'";
			}
                    }else //si el campo es municipio de denuncia
                    if (document.getElementById("campo"+i).value.substring(16,34)== "cmunicipiodenuncia")
                    {
			Wheretxt= Wheretxt + document.getElementById("opr"+i).value;
                        Criterio= document.getElementById("criterio"+i).value.toUpperCase();
			if (document.getElementById("opr"+i).value== " like ")
			{
				Wheretxt= Wheretxt +
				"'%" + Criterio + "%'";
			}
			else
			{
				Wheretxt= Wheretxt +
				"'" + Criterio + "'";
			}
                    }else //si es municipio del hecho
                    if (document.getElementById("campo"+i).value.substring(16,31)== "cmunicipiohecho")
                    {
			Wheretxt= Wheretxt + document.getElementById("opr"+i).value;
                        Criterio= document.getElementById("criterio"+i).value.toUpperCase();
			if (document.getElementById("opr"+i).value== " like ")
			{
				Wheretxt= Wheretxt +
				"'%" + Criterio + "%'";
			}
			else
			{
				Wheretxt= Wheretxt +
				"'" + Criterio + "'";
			}
                    }else //si es ciudad del hecho
                    if (document.getElementById("campo"+i).value.substring(33,44)== "caldeahecho")
                    {
			Wheretxt= Wheretxt + document.getElementById("opr"+i).value;
                        Criterio= document.getElementById("criterio"+i).value.toUpperCase();
			if (document.getElementById("opr"+i).value== " like ")
			{
				Wheretxt= Wheretxt +
				"'%" + Criterio + "%'";
			}
			else
			{
				Wheretxt= Wheretxt +
				"'" + Criterio + "'";
			}
                    }else
                    //si es campo de texto cualquiera pero no un
                    //depto, muncipio o ciudad
                    if (document.getElementById("campo"+i).value.charAt(0)== "c")
                    {
                            Wheretxt= Wheretxt + document.getElementById("opr"+i).value;

                            if (document.getElementById("opr"+i).value== " like ")
                            {
                                if (document.getElementById("criterio"+i).value== '')
                                    CriteriosBlancos= 1;
                                
                                Wheretxt= Wheretxt +
                                "'%" +
                                document.getElementById("criterio"+i).value.toUpperCase() + "%'";
                            }
                            else
                            {
                                Wheretxt= Wheretxt +
                                "'" +
                                document.getElementById("criterio"+i).value.toUpperCase() + "'";
                            }
                    }
		}

		//si es numero, 
		if (document.getElementById("campo"+i).value.charAt(0)== "n")
		{
			if (document.getElementById("opr"+i).value== " like ")
			{
//				alert("Uso no valido del rango 'Contiene', " +
//					"se cambiará por 'Igual a'");
				document.getElementById("opr"+i).value= "=";	
			}
			Wheretxt= Wheretxt + document.getElementById("opr"+i).value;
			Wheretxt= Wheretxt + 
			document.getElementById("criterio"+i).value;
                    
                        if (document.getElementById("criterio"+i).value== '')
                            CriteriosBlancos= 1;                    
                    
		}

		//si es numero de denuncia		
		if (document.getElementById("campo"+i).value.charAt(0)== "t")
		{
			if (document.getElementById("opr"+i).value== " like ")
			{
//				alert("Uso no valido del rango 'Contiene', " +
//					"se cambiará por 'Igual a'");
				document.getElementById("opr"+i).value= "=";	
			}
			Wheretxt= Wheretxt + document.getElementById("opr"+i).value;
			Wheretxt= Wheretxt + 
			document.getElementById("criterio"+i).value;    
                    
                        if (document.getElementById("criterio"+i).value== '')
                            CriteriosBlancos= 1;                    
		}	

                //enlazar wheres con and
		if (i < Contador)
		{
			Wheretxt= Wheretxt + " and ";
			MasdeUno= 1;
			
		}
	}

	if (MasdeUno== 1)
	{	
		Join= "";
		if (tblDenunciante== 1)
		{
			if (Join== "")
				Join= "tbl_denuncia.tdenunciaid= tbl_denunciante.tdenunciaid";
			else
				Join= Join + "tbl_denuncia.tdenunciaid= tbl_denunciante.tdenunciaid";
		}
	
		if (tblOfendido== 1)
		{
			if (Join== "")
				Join= "tbl_denuncia.tdenunciaid= tbl_ofendido.tdenunciaid ";
			else
				Join= Join + " and tbl_denuncia.tdenunciaid= tbl_ofendido.tdenunciaid ";
		}

		if (tblImputado== 1)
		{
			if (Join== "")
				Join= "tbl_denuncia.tdenunciaid= tbl_imputado.tdenunciaid ";
			else
				Join= Join + " and tbl_denuncia.tdenunciaid= tbl_imputado.tdenunciaid ";
		}

		if (Join== "")
			Wheretxt= Wheretxt; 
		else
			Wheretxt= Join + " and " + Wheretxt; 
	}

        /******* inicio criterios de busqueda segun perfil *******/ 
        if ("<?php echo !strcmp ($objUsuario->getTipoUsuario(), 'Fiscal') ?>")        
        {
            // ver solo las asignadas al fiscal logeado
            Wheretxt= " tbl_denuncia.basignadafiscal= 't' and " +
                    "tbl_denuncia.tdenunciaid= tbl_imputado_fiscal.tdenunciaid and " +
                    "tbl_imputado_delito.tdenunciaid= tbl_denuncia.tdenunciaid and " +
                    "tbl_imputado_delito.tpersonaid= tbl_imputado.tpersonaid and " +
                    "tbl_imputado_delito.ndelito= tbl_delito.ndelitoid and " + 
                    "tbl_imputado_fiscal.bactivo= 't' and " +
                    "tbl_imputado_fiscal.cfiscal= tbl_usuarios.identidad and " + 
                    "tbl_usuarios.identidad= '" + "<?php echo $objUsuario->getIdentidad(); ?>" + "' and " +
                     Wheretxt;        

            Fromtxt= "tbl_denuncia, tbl_ofendido, tbl_denunciante, tbl_imputado, tbl_imputado_fiscal, " +
                     "tbl_usuarios, tbl_imputado_delito, tbl_delito  ";
        }
        //si se logea como receptor
        if ("<?php echo !strcmp ($objUsuario->getTipoUsuario(), 'Receptor') ?>")
        {
            Wheretxt= "   tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND " +
                    "tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid AND " +
                    "tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND " +
                    "tbl_denuncia.ibandejaid = tbl_bandejas.ibandejaid AND " +
                    "tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND " +
                    "tbl_imputado.tdenunciaid = tbl_denuncia.tdenunciaid AND " +
                    "tbl_delito.ndelitoid = tbl_imputado_delito.ndelito AND " +
                    "tbl_usuarios.ibandejaid = tbl_bandejas.ibandejaid AND " +
                    "tbl_denuncia.basignadafiscalia = 'f' AND " + 
                    "tbl_usuarios.usuario = '" + "<?php echo $objUsuario->getUsuario(); ?>" + "' AND " +
                    "tbl_usuarios.ibandejaid = " + "<?php echo $objUsuario->getBandejaId(); ?>" + " AND " +
                     Wheretxt;        
            Fromtxt= "  tbl_denuncia, tbl_imputado, tbl_ofendido, tbl_denunciante, tbl_imputado_delito, " +
                    "tbl_delito, tbl_bandejas, tbl_usuarios";     
        }
        //si se logea como estadigrafo
        if ("<?php echo !strcmp ($objUsuario->getTipoUsuario(), 'Estadigrafo') ?>")
        {
            
        }
        
        Sql= "select tbl_denuncia.tdenunciaid, tbl_denuncia.dfechadenuncia, " +
            "tbl_ofendido.cnombres || ',' || tbl_ofendido.capellidos as ofendido, " +
            "tbl_imputado.cnombres || ',' || tbl_imputado.capellidos as imputado, " +
            "tbl_denunciante.cnombres || ',' || tbl_denunciante.capellidos as denunciante, " +
            "tbl_delito.cdescripcion " +
            "from " + Fromtxt + " where " + Wheretxt;             
        
        SqlTotales= "select count(*) from " + Fromtxt + " where " + Wheretxt;
             
//  Ver todos los expedientes por fiscalia logeada                     
//        
//                Wheretxt= " tbl_denuncia.basignadafiscal= 't' and " +
//                "tbl_denuncia.tdenunciaid= tbl_imputado_fiscal.tdenunciaid and " +
//                "tbl_imputado_delito.tdenunciaid= tbl_denuncia.tdenunciaid and " +
//                "tbl_imputado_delito.tpersonaid= tbl_imputado.tpersonaid and " +
//                "tbl_imputado_delito.ndelito= tbl_delito.ndelitoid and " + 
//                "tbl_imputado_fiscal.bactivo= 't' and " +
//                "tbl_imputado_fiscal.cfiscal= tbl_fiscal.cfiscalid and " + 
//                "tbl_imputado_fiscalia.timputadoid= tbl_imputado.tpersonaid and " + 
//                "tbl_imputado_fiscalia.tdenunciaid= tbl_denuncia.tdenunciaid and " + 
//                "tbl_imputado_fiscalia.nfiscaliaid= tbl_fiscalia.nfiscaliaid and " + 
//                "tbl_fiscalia.nfiscaliaid= '" + "<?php echo $_SESSION['ubicacionid']; ?>" + "' and " +
//                 Wheretxt;   
//        
//        Fromtxt= "tbl_denuncia, tbl_ofendido, tbl_denunciante, tbl_imputado, tbl_imputado_fiscal, " +
//                 "tbl_fiscal, tbl_imputado_delito, tbl_delito, tbl_imputado_fiscalia, tbl_fiscalia  ";

//        Sql= "select tbl_denuncia.tdenunciaid, tbl_denuncia.dfechadenuncia, " +
//            "tbl_ofendido.cnombres || ',' || tbl_ofendido.capellidos as ofendido, " +
//            "tbl_imputado.cnombres || ',' || tbl_imputado.capellidos as imputado, " +
//            "tbl_denunciante.cnombres || ',' || tbl_denunciante.capellidos as denunciante, " +
//            "tbl_delito.cdescripcion, tbl_fiscalia.cdescripcion as fiscaliadesc " +
//            "from " + Fromtxt + " where " + Wheretxt;       
        
        
        
        /******* fin criterios de busqueda segun perfil *******/ 
        
        //para incluir la info de los involucrados
//        Fromtxt= "tbl_denuncia, tbl_ofendido, tbl_denunciante, tbl_imputado, tbl_imputado_fiscal, tbl_fiscal ";
        
        //este query para que lo vean todos indenp si se asigno o no y del usr
//        Fromtxt= "tbl_denuncia, tbl_ofendido, tbl_denunciante, tbl_imputado, tbl_imputado_fiscal, tbl_fiscal ";
//        Fromtxt= "tbl_denuncia, tbl_ofendido, tbl_denunciante, tbl_imputado ";
//        Sql= "select tbl_denuncia.tdenunciaid, tbl_denuncia.dfechadenuncia, " +
//            "tbl_ofendido.cnombres || ',' || tbl_ofendido.capellidos as ofendido, " +
//            "tbl_imputado.cnombres || ',' || tbl_imputado.capellidos as imputado, " +
//            "tbl_denunciante.cnombres || ',' || tbl_denunciante.capellidos as denunciante " +
//            "from " + Fromtxt + " where " + Wheretxt        

//	alert(Sql);
	document.getElementById("sql").value= Sql;
        document.getElementById("total").value= SqlTotales;
        
        document.frmsql.submit();
        
//        if (CriteriosBlancos== 1)
//        {
//            if (confirm("Ha dejado criterios de búsqueda en blanco.\nEsto puede ocasionar que la búsqueda tarde mucho y recupere un exceso de expedientes\n\n¿Desea continuar?"))
//            {
//                document.frmsql.submit();
//            }        
//        }
//        else
//        {
//            document.frmsql.submit();
//        }
}
</script>

<table align="center" border="0" id="ambito" class="">
    <tr>
        <td align="center"><h3>Ambito de la búsqueda</h3></td>
    </tr>
    <tr>
        <td><input align="left" type="radio" name="ambito" id="ambito" 
                   onclick="MostrarOcultarDiv('Global','PorFiscalia','PorBandeja', 'PorFiscal');">
                    Todas las denuncias asignadas o no a una fiscalía, en todo el Ministerio Público</td>
    </tr>
    <tr>
        <td><input align="left" type="radio" name="ambito" id="ambito"
                   onclick="MostrarOcultarDiv('PorFiscalia','Global','PorBandeja', 'PorFiscal');">
                    Denuncias asignadas a cualquier Fiscalía</td>
    </tr>
    <tr>
        <td><input align="left" type="radio" name="ambito" id="ambito" 
                   onclick="MostrarOcultarDiv('PorFiscal','PorFiscalia','PorBandeja', 'Global');">
                    Conocer el fiscal asignado a un expediente en esta fiscalía</td>
    </tr>    
    <tr>
        <?php if ($_SESSION['tipoacceso']== 'Receptor')
        {
        ?>            
            <td><input align="left" type="radio" name="ambito" id="ambito" checked
                       onclick="MostrarOcultarDiv('PorBandeja','Global','PorFiscalia', 'PorFiscal');" >
                        Ingresadas únicamente en esta Sede y no asignadas a fiscalía</td>
        <?php
        }
        else
        {
        ?>
            <td><input align="left" type="radio" name="ambito" id="ambito" checked
                       onclick="MostrarOcultarDiv('PorBandeja','Global','PorFiscalia', 'PorFiscal');" >
                        Asignadas al fiscal que actualmente ha accedido al sistema</td>            
        <?php } ?>
    </tr>
</table>

<br><br>

<div id='PorBandeja'>
<table align="center" border="1" id="tblBuscar" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
      <th><strong>Buscar en</strong></th>
      <th><strong>Campo</strong></th>
      <th><strong>Rango</strong></th>
      <th><strong>Criterio</strong></th>
    </tr>
    <tr>
      <td colspan="4"><br></td>
    </tr>
    <tr>
      <td colspan="4" align="center">
	<INPUT type="button" name="btnAgregar" id="btnAgregar" value="Agregar Busqueda" onclick="AgregarFila();">
        <INPUT type="button" name="btnBuscar" id="btnBuscar" value="Buscar" onclick="CrearSQL();" disabled>
      </td>
    </tr>
  </tbody>
</table>
</div>

<!-- buscar global -->
<div id="Global" style="display: none;">
<form id="frmGlobal" action="BusquedaGlobal.php" method="post" >
<table align="center" border="1" id="tblGlobal" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
      <th><strong>Nombres</strong></th>
      <th><strong>Apellidos</strong></th>
    </tr>
    <tr>
      <td><input type='text' name='FiscNombres' id='FiscNombres' onkeyup="this.value=this.value.toUpperCase()"></td>
      <td><input type='text' name='FiscApellidos' id='FiscApellidos' onkeyup="this.value=this.value.toUpperCase()"></td>
    </tr>
    <tr>
        <td colspan='2'>
            Buscar por:<br>
            <input type='radio' name='buscar' value='denunciante'>Denuncinate<br>
            <input type='radio' name='buscar' value='denunciado' >Denunciado<br>
            <input type='radio' name='buscar' value='ofendido' checked>Ofendido<br>
        </td>
    </tr>     
    <tr>
      <td colspan="2" align="center">
        <INPUT type="submit" value="Buscar" >
      </td>
    </tr>
  </tbody>
</table>
</form>
</div>

<!-- buscar en todas las fiscalias -->
<div id="PorFiscalia" style="display: none;">
<form id="frmFiscalia" action="BusquedaFiscalia.php" method="post">
<table align="center" border="1" id="tblPorFiscalia" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
      <th><strong>Nombres</strong></th>
      <th><strong>Apellidos</strong></th>
    </tr>
    <tr>
      <td><input type='text' name='FiscNombres' id='FiscNombres' onkeyup="this.value=this.value.toUpperCase()"></td>
      <td><input type='text' name='FiscApellidos' id='FiscApellidos' onkeyup="this.value=this.value.toUpperCase()"></td>
    </tr>
    <tr>
        <td colspan='2'>
            Buscar por<br>
            <input type='radio' name='buscar' value='denunciante'>Denuncinate<br>
            <input type='radio' name='buscar' value='denunciado' checked>Denunciado<br>
            <input type='radio' name='buscar' value='ofendido' checked>Ofendido<br>
        </td>
    </tr>    
    <tr>
      <td colspan="2" align="center">
        <INPUT type="submit" value="Buscar" >
      </td>
    </tr>
  </tbody>
</table>
</form>
</div>


<!-- buscar en la fiscalia actual mostrando al fiscal -->
<div id="PorFiscal" style="display: none;">
<form id="frmFiscal" action="BusquedaFiscal.php" method="post">
<table align="center" border="1" id="tblPorFiscal" class="TablaCaja">
  <tbody>
    <tr class="SubTituloCentro">
      <th><strong>Nombres / Denuncia</strong></th>
      <th><strong>Apellidos</strong></th>
    </tr>
    <tr>
      <td><input type='text' name='FiscNombres' id='FiscNombres' onkeyup="this.value=this.value.toUpperCase()"></td>
      <td><input type='text' name='FiscApellidos' id='FiscApellidos' onkeyup="this.value=this.value.toUpperCase()"></td>
    </tr>
    <tr>
        <td colspan='2'>
            Buscar por<br>
            <input type='radio' name='buscar' value='denuncia'>Número denuncia<br>
            <input type='radio' name='buscar' value='denunciante'>Denuncinate<br>
            <input type='radio' name='buscar' value='denunciado'>Denunciado<br>
            <input type='radio' name='buscar' value='ofendido' checked>Ofendido<br>
        </td>
    </tr>    
    <tr>
      <td colspan="2" align="center">
        <INPUT type="submit" value="Buscar" >
      </td>
    </tr>
  </tbody>
</table>
</form>
</div>

</body>
</html>
