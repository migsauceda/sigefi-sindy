<?php

	require_once("conexionp.php");
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 </head>

      <link rel="stylesheet" href="menus/menu.css"/>
      <link rel="stylesheet" href="menus/tablas.css"/>

      <link rel="stylesheet" href="/css/master.css" media="screen" title="no title" charset="utf-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">

      <link href="assets/css/bootstrap.css" rel="stylesheet" />
      <!-- FontAwesome Styles-->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- Morris Chart Styles-->
      <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
      <!-- Custom Styles-->
      <link href="assets/css/custom-styles.css" rel="stylesheet" />
      <!-- Google Fonts-->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

 <body>

	 <script type="text/javascript">
			//override defaults
			alertify.defaults.transition = "zoom";
			alertify.defaults.theme.ok = "ui positive button";
			alertify.defaults.theme.cancel = "ui black button";
	 </script>

    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>

    <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>

 </body>
 </html>
