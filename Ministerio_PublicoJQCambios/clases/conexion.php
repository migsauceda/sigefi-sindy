<?php
    $host="127.0.0.1";
    $port="5432";
    $user="postgres";
    $pass="mariajose";
    $dbname="bd_muestra_lufergo";

 $conn_string = "host=127.0.0.1 port=5432 dbname=bd_muestra_lufergo user=postgres password=mariajose";
$dbconn4 = pg_connect($conn_string);

   // $connect = pg_connect("host=$host, port=$port, user=$user, pass=$pass, dbname=$dbname");

    if(!$dbconn4)
        echo "<p><i>No me conecte</i></p>";
		//$conn = pg_connect($connStr);
		
	$result = pg_query($dbconn4, "select * from mini_sedi.tbl_rol");
	if(pg_num_rows($result)>= 0){
		while($registro= pg_fetch_array($result)){
			//echo $registro[0].$registro[1].'<br>';
		}
	}
	//var_dump(pg_fetch_all($result));

    pg_close($dbconn4);
?>