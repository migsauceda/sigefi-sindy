<!doctype html> 
<html>
    <head>
        <title>Expedientes con Actualizaciones</title>
        <meta charset="utf-8">
        
<!--         Bootstrap core CSS 
        <link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>     
        
        Data Tables
        <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>      
        <script type="text/javascript" src="DataTables/datatables.min.js"></script>       -->
        
        <!--Complementos data tables-->
<!--        <script type="text/javascript" src="DataTables/DataTables-1.10.18/js/jquery-3.3.1.js"></script>         
        <script type="text/javascript" src="DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>    -->
        
<!--        <script type="text/javascript" src="DataTables/Buttons-1.5.2/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="DataTables/DataTables-1.10.18/js/dataTables.select.min.js"></script>
        <script type="text/javascript" src="DataTables/DataTables-1.10.18/js/dataTables.editor.min.js"></script>-->
        
        <!--<link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css"/>--> 
        
<!--        <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.18/css/select.dataTables.min.css"/> 
        <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.18/css/editor.dataTables.min.css"/> 
        <link rel="stylesheet" type="text/css" href="DataTables/Buttons-1.5.2/css/buttons.dataTables.min.css"/> -->

<!--funcionaba-->
<!--        <script type="text/javascript" src="DataTables/DataTables-1.10.18/js/jquery-3.3.1.js"></script>         
        <script type="text/javascript" src="DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css"/> -->

      <link href="assets/css/bootstrap.css" rel="stylesheet" />
      <!-- FontAwesome Styles-->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- Morris Chart Styles-->
      <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
      <!-- Custom Styles-->
      <link href="assets/css/custom-styles.css" rel="stylesheet" />
      
      <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
      <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
     <script src="assets/js/dataTables/jquery.dataTables.js"></script>
     <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>    
     <script src="assets/js/custom-scripts.js"></script>
     
    <!--para la fecha-->
    <script src="../java_script/js/jquery-1.10.2.js"></script>
    <script src="../java_script/js/jquery-ui-1.10.4.custom.js"></script>  
    <link href="../java_script/css/smoothness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
    <script> 
        $( function() {
            $( "#inicio" ).datepicker({
                dateFormat: "dd/mm/yy"
            });
        } );
        
        $( function() {
            $( "#fin" ).datepicker({
                dateFormat: "dd/mm/yy"
            });
        } );        
    </script>
  
</script>    

    </head>
    
    <body>
        <div id="Reporte" align="center">
            <br>
            <h2>Rango de fechas a evaluar</h2><br>
            <form id="frmCriterios">
                <label for="inicio">Fecha inicio</label>
                <input type="text" id="inicio" name="inicio">
                <label for="fin">Fecha fin</label>
                <input type="text" id="fin" name="fin">
                <input type="button" name="btnSubmit" value="Buscar" onclick="GenerarReporte();">
            </form>
                              
            <div align="left" class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                          <thead>
                              <tr>
                                  <th>Fiscal</th>  
                                  <th>Expediente</th>
                                  <th>Ultima Actualizacion</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                  </div>
              </div>

<!--        <nav class="navbar navbar-light bg-light">         
            <form class="form-inline">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>                       -->
<!--                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">Fiscal</th>
                      <th scope="col">Expediente</th>
                      <th scope="col">Ultima actualizacion</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1</th>
                      <td>Mark</td>
                      <td>Otto</td>
                    </tr>
                    <tr>
                      <th scope="row">2</th>
                      <td>Jacob</td>
                      <td>Thornton</td>
                    </tr>
                    <tr>
                      <th scope="row">3</th>
                      <td>Larry</td>
                      <td>the Bird</td>
                    </tr>
                  </tbody>
                </table>   -->
<!--            </form>     
        </nav>-->
        </div>
    </body>
    <script type="text/javascript">
        function GenerarReporte(){
            var Formulario= document.getElementById("frmCriterios");
           
            $.ajax({
                data:       "inicio= \""+Formulario.inicio.value+"&fin= \""+Formulario.fin.value,                
                type:       "POST",
                datatype:   "text",
                url:    "../funciones/ajax_ExpedientesActualizados.php",
                success: function(json_obj){ //alert(json_obj);
                    var json_data= JSON.parse(json_obj);
                    var registros= json_data.Objeto.length; 
                    var tds= "";
                    
                    //borrar filas de busquedas anteriores
                    var filas= document.getElementById("dataTables-example").rows.length;
                    if(filas > 1){
                       for(j= filas-1; j > 0; j--){
                           document.getElementById("dataTables-example").deleteRow(j);
                       }
                    }
                    
                    for(i= 0; i < registros; i++){
                        tds= "<tr>";
                        tds+= "<td>"+json_data.Objeto[i].Fiscal+"</td>"+
                              "<td>"+json_data.Objeto[i].Expediente+"</td>"+
                              "<td>"+json_data.Objeto[i].Fecha+"</td>";
                        tds+= "</tr>";
                        $('#dataTables-example').append(tds);
                    }
//                    alert(json_data.Objeto[0].Fiscal);
                }
            });                    
        }
        
    </script>
    
</html>
