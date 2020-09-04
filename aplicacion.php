<?php 
session_start();
if (!isset($_SESSION['usuario'])){header("location:index.php");}
?>

<html>   
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
</head>    
<BODY>
<center>
<div align="center">
<iframe src="banner_horizontal.php" name="banner_horizontal" id="banner_horizontal" frameborder="0" width="1200" height="5000" scrolling="auto">
</iframe>
</div> 
</center>
</Body>
</html>
<!--align="center" width="1240"  height="2000" scrolling="no"-->
