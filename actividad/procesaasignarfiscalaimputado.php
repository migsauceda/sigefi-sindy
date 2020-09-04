<?php
	include("../clases/class_conexion_pg.php");
        $Accion= $_POST[accion];

        if (strcmp($Accion,"Recuperar")== 0){
            $gall= $_COOKIE["denuncia"];

            //primero saber la fiscalia actual
            $sql= "select cdescripcion as cdesc, if.nfiscaliaid as cfisc "
                ."from tbl_imputado_fiscalia if, tbl_fiscalia f "
                ."where if.nfiscaliaid= f.nfiscaliaid and "
                ." tdenunciaid= ".$gall
                ." and timputadoid= ".$_POST[Imputado]
                ." and bactivo= true;";

            $objConexion= new Conexion();
            $Reg= pg_fetch_array($objConexion->ejecutarComando($sql));

            $jsondata['CodFiscalia']= $Reg["cfisc"];
            $jsondata['DesFiscalia']= $Reg["cdesc"];

            //ahora el fiscal actual, si fue asignado
            $sql= "select ltrim(rtrim(cnombres)) || ', ' "
                ."|| ltrim(rtrim(capellidos)) as nombrefiscal, f.cfiscalid as cod"
                ." from tbl_imputado_fiscal if, tbl_fiscal f "
                ." where if.cfiscal= f.cfiscalid and "
                ." tdenunciaid= ".$gall
                ." and timputadoid= ".$_POST[Imputado]
                ." and bactivo= true;";

            //$objConexion= new Conexion();
            $Reg= pg_fetch_array($objConexion->ejecutarComando($sql));

            $jsondata['CodFiscal']= $Reg["cod"];
            $jsondata['DesFiscal']= $Reg["nombrefiscal"];

            echo json_encode($jsondata);
        }
        else if(strcmp($Accion,"Fiscales")== 0) {
            ?>
            <option value=-1>Seleccione opción...</option>
            <?php
            $Fiscalia= $_POST[Fiscalia];

            $objConexion=new Conexion();

            $sql= "select cnombres, cfiscalid from tbl_fiscal "
                ."where nfiscaliaid= " ."'".$Fiscalia."'"."order by cnombres;";

            $resCampo=$objConexion->ejecutarComando($sql);

            while ($fila=pg_fetch_array($resCampo)){
                $Campo= $fila[cfiscalid];
                $Descripcion= $fila[cnombres];
            ?>
            <option value='<?php echo $Campo?>'><?php echo $Descripcion?></option>
            <?php
            }
        }
        else //grabar
	if(!empty($_COOKIE["denuncia"]))
	{
		$gall= $_COOKIE["denuncia"];
		$objConexion= new Conexion();

                //convertir a fecha ansi
                $Fecha= $_POST[txtFechaAsignacion];
                $FechaAnsi= substr($Fecha,10,5).substr($Fecha,5,2).substr($Fecha,0,2);

		//nuevo fiscal
		$sql= "insert into tbl_imputado_fiscal ("
		."tdenunciaid, timputadoid, cfiscal, bactivo, dfechaasignacion) values ("
                .$gall.", "
		.$_POST[cboImputado].", "
		."'".$_POST[cboFiscalN]."', "
		."'1', "
		."'".$FechaAnsi."');";

		$objConexion= new Conexion();
		if(!$objConexion->ejecutarComando($sql)){
			echo"<script type='text/javascript'>
			alert(\"Error al asignar el nuevo fiscal \\nintentelo nuevamente\");
			</script>";
		}

		//desactivar fiscal anterior si es que estaba asignado

			$sql="update tbl_imputado_fiscal set bactivo= '0', "
			."dfechaasignacion= '".$FechaAnsi."' "
			."where timputadoid= ".$_POST[cboImputado]." and "
			."cfiscal= '".$_POST[CodFiscalActual]."';";

			$objConexion= new Conexion();
			if(!$objConexion->ejecutarComando($sql)){
				echo"<script type='text/javascript'>
				alert(\"Error al actualizar fiscal anterior\\nintentelo nuevamente\");
				</script>";
			}
                        else {
                            echo "<script type='text/javascript'>
                                alert(\" Imputado seleccionado ha sido asignado a una fiscalía\");
                                </script>";
                        }
	}
	else //cookies
	{
		echo"<script type='text/javascript'>
			alert(\"Error al guardar, NO se pudo acceder a las COOKIEs \\nintentelo nuevamente\");
		</script>";
	}
?>