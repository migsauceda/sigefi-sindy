<html>
<head>
<meta charset="utf.8">
<title></title>
</head>
<body>
<?php
  include "../clases/class_conexion_pg.php";
$con= new Conexion();

    $_fecha_inicial=$_GET['fecha1'];
    $_fecha_final=$_GET['fecha2'];
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=reporte.xls");
    echo '<table class="table table-hover table-striped table-bordered" id="example" value="consulta">        
            <thead>
            <tr>
            <th>Creada por</th>
            <th>subbandeja lugar_recepcion</th>
            <th>Denunciaid</th>
            <th>Narracion hecho</th>
            <th>Fecha denuncia</th> 
            <th>Fecha hecho</th>
            <th>clase_lugar</th>
            <th>Expediente judicial</th>
            <th>Expediente policial</th>
            <th>Expediente sedi</th>
            <th>Depto denuncia</th>
            <th>Muni denuncia</th>
            <th>Depto hecho</th> 
            <th>Muni hecho</th> 
            <th>Aldea ciudad hecho</th> 
            <th>Barrio colonia hecho</th> 
            <th>Denunciado</th> 
            <th>Alias</th> 
            <th>Edad</th> 
            <th>Sexo</th> 
            <th>Genero</th> 
            <th>Etnia</th> 
            <th>Aplicalgbti</th>
            <th>Oficio</th> 
            <th>Profesion</th> 
            <th>Escolaridad</th> 
            <th>Nacionalidad</th> 
            <th>Estadocivil</th> 
            <th>Departamento</th> 
            <th>Municipio</th> 
            <th>Aldeaciudad</th> 
            <th>Barriocolonia</th> 
            <th>Discapacidad</th> 
            <th>Condicion</th>
            <th>Delito</th> 
            <th>Transporte</th> 
            <th>Arma</th> 
            <th>Objeto</th>                        
            <th>Ofendido</th>  
            <th>Edad</th> 
            <th>Sexo</th> 
            <th>Etnia</th> 
            <th>Genero</th> 
            <th>Aplicalgbti</th> 
            <th>x.imputado_ofendido</th>
            <th>Etnia</th> 
            <th>Departamento</th> 
            <th>Municipio</th> 
            <th>Aldeaciudad</th> 
            <th>Barriocolonia</th> 
            <th>Profesion</th> 
            <th>Nacionalidad</th> 
            <th>Oficio</th> 
            <th>Estadocivil</th> 
            <th>Escolaridad</th> 
            <th>Discapacidad</th> 
            <th>Embarazada</th> 
            <th>Frec_violacion</th> 
            <th>Cantidad hijos</th> 
            <th>Intento Suicidio</th> 
            <th>Enfermedad mental</th> 
            <th>Mecanismo muerte</th> 
            <th>Denunciante</th>  
            <th>Edad</th> 
            <th>Sexo</th> 
            <th>Genero</th> 
            <th>Aplicalgbti</th> 
            <th>x.imputado_denunciante</th>
            <th>Etnia</th> 
            <th>Departamento</th> 
            <th>Municipio</th> 
            <th>Aldeaciudad</th> 
            <th>Barrio colonia</th> 
            <th>Profesion</th> 
            <th>Nacionalidad</th> 
            <th>Oficio</th> 
            <th>Estadocivil</th> 
            <th>Discapacidad</th>   
            </tr>
            </thead>
            <tbody>';

    $sql= "SELECT
den.ccreada usr_creo,
den.subbandeja lugar_recepcion,
den.tdenunciaid numero_den,
den.cnarracionhecho narracion,
den.dfechadenuncia f_denuncia, 
den.dfechahecho f_hecho,
den.clase_lugar clase_lugar,
den.cexpedientejudicial judicial,
den.cexpedientepolicial policial,
den.cexpedientesedi interno,
den.deptodenuncia depto_den,
den.munidenuncia muni_den,
den.deptohecho deptp_hecho, 
den.munihecho muni_hecho, 
den.aldeaciudadhecho aldea_hecho, 
den.barriocoloniahecho barrio_hecho, 
vdd2.cnombres nombre_imputado, 
vdd2.capellidos apellido_imputado, 
vdd2.alias alias_imputado, 
vdd2.iedad edad_imputado, 
vdd2.csexo sexo_imputado, 
vdd2.cgenero genero_imputado, 
vdd2.etnia etnia_imputado, 
vdd2.aplicalgbti lgbti_imputado,
vdd2.oficio oficio_imputado, 
vdd2.profesion profesion_imputado, 
vdd2.escolaridad escolar_imputado, 
vdd2.nacionalidad nacional_imputado, 
vdd2.estadocivil estadoc_imputado, 
vdd2.departamento depto_imputado, 
vdd2.municipio muni_imputado, 
vdd2.aldeaciudad aldea_imputado, 
vdd2.barriocolonia barrio_imputado, 
vdd2.discapacidad discapa_imputado, 
vdd2.ccondicion condicion_imputado,
vdd2.delito delito_imputado, 
vdd2.transporte transp_imputado, 
vdd2.arma arma_imputado, 
vdd2.objeto objeto_imputado,
vdo.cnombres nombre_ofen, 
vdo.capellidos apellildo_ofen, 
vdo.iedad edad_ofen, 
vdo.csexo sexo_ofen, 
vdo.etnia etnia_ofen, 
vdo.cgenero genero_ofen, 
vdo.aplicalgbti lgbti_ofen, 
x.imputado_ofendido rel_impu_ofen,
vdo.etnia etnia_ofen, 
vdo.departamento depto_ofen, 
vdo.municipio muni_ofen, 
vdo.aldeaciudad aldea_ofen, 
vdo.barriocolonia barrio_ofen, 
vdo.profesion profesion_ofen, 
vdo.nacionalidad nacional_ofen, 
vdo.oficio oficio_ofen, 
vdo.estadocivil estadoc_ofen, 
vdo.escolaridad escolar_ofen, 
vdo.discapacidad discapacidad_ofen, 
vdo.embarazada emnaraza_ofen, 
vdo.frec_violacion violacion_ofen, 
vdo.cantidadhijos hijos_ofen, 
vdo.intentosuicidio suicidio_ofen, 
vdo.enfermedadmental mental_ofen, 
vdo.mecanismomuerte mecanismo_ofen, 
vdd.cnombres nombre_denunciante, 
vdd.capellidos apellido_denunciante, 
vdd.iedad edad_denunciante, 
vdd.csexo sexo_denunciante, 
vdd.cgenero genero_denunciante, 
vdd.aplicalgbti lgbti_denunciante, 
x.imputado_denunciante imputado_denunciante,
vdd.etnia etnia_denunciante, 
vdd.departamento depto_denunciante, 
vdd.municipio muni_denunciante, 
vdd.aldeaciudad aldea_denunciante, 
vdd.barriocolonia barrio_denunciante, 
vdd.profesion profesion_denunciante, 
vdd.nacionalidad nacionalidad_denunciante, 
vdd.oficio oficio_denunciante, 
vdd.estadocivil civil_denunciante, 
vdd.discapacidad  discapacidad_denunciante
FROM
mini_sedi.vw_dipegec_denuncia den
inner join mini_sedi.vw_dipegec_denunciante vdd on vdd.tdenunciaid = den.tdenunciaid
inner join mini_sedi.vw_dipegec_denunciado vdd2 on vdd2.tdenunciaid = den.tdenunciaid 
inner join mini_sedi.vw_dipegec_ofendido vdo on vdo.tdenunciaid = den.tdenunciaid
inner join mini_sedi.vw_dipegec_parentesco x on x.tdenunciaid = den.tdenunciaid
WHERE
den.dfechadenuncia between '$_fecha_inicial' and '$_fecha_final' 
order by den.dfechadenuncia, den.tdenunciaid ";
//exit($sql);
        $resultado= $con->ejecutarComando($sql);
        while ($rows = pg_fetch_ASSOC($resultado))
        {
            echo '<tr>
            <td>'.$rows["usr_creo"].'</td>
            <td>'.$rows["lugar_recepcion"].'</td>
            <td>'.$rows["numero_den"].'</td>
            <td>'.$rows["narracion"].'</td>
            <td>'.$rows["f_denuncia"].'</td>
            <td>'.$rows["f_hecho"].'</td>
            <td>'.$rows["clase_lugar"].'</td>                   
            <td>'.$rows["judicial "].'</td>
            <td>'.$rows["policial"].'</td>
            <td>'.$rows["interno"].'</td>
            <td>'.$rows["depto_den"].'</td>
            <td>'.$rows["muni_den"].'</td>                    
            <td>'.$rows["deptp_hecho "].'</td>
            <td>'.$rows["muni_hecho"].'</td>
            <td>'.$rows["aldea_hecho"].'</td>
            <td>'.$rows["barrio_hecho"].'</td>
            <td>'.$rows["nombre_imputado"].' '.$rows["epellido_imputado"].'</td>
            <td>'.$rows["alias_imputado"].'</td>
            <td>'.$rows["edad_imputado"].'</td>
            <td>'.$rows["sexo_imputado"].'</td>
            <td>'.$rows["genero_imputado"].'</td>
            <td>'.$rows["etnia_imputado"].'</td>
            <td>'.$rows["lgbti_imputado"].'</td>
            <td>'.$rows["oficio_imputado"].'</td>
            <td>'.$rows["profesion_imputado"].'</td>
            <td>'.$rows["escolar_imputado"].'</td>
            <td>'.$rows["nacional_imputado"].'</td>
            <td>'.$rows["estadoc_imputado"].'</td>
            <td>'.$rows["depto_imputado"].'</td>
            <td>'.$rows["muni_imputado"].'</td>
            <td>'.$rows["aldea_imputado"].'</td>
            <td>'.$rows["barrio_imputado"].'</td>
            <td>'.$rows["discapa_imputado"].'</td>
            <td>'.$rows["condicion_imputado"].'</td>
            <td>'.$rows["delito_imputado"].'</td>
            <td>'.$rows["transp_imputado"].'</td>
            <td>'.$rows["arma_imputado"].'</td>
            <td>'.$rows["objeto_imputado"].'</td>
            <td>'.$rows["nombre_ofen"].' '.$rows["apellido_ofe"].'</td>
            <td>'.$rows["edad_ofen"].'</td>
            <td>'.$rows["sexo_ofen"].'</th>
            <td>'.$rows["etnia_ofen"].'</th>
            <td>'.$rows["genero_ofen"].'</th>
            <td>'.$rows["lgbti_ofen"].'</td>
            <td>'.$rows["rel_impu_ofen"].'</td>
            <td>'.$rows["etnia_ofen"].'</td>
            <td>'.$rows["depto_ofen"].'</td>
            <td>'.$rows["muni_ofen"].'</td>
            <td>'.$rows["aldea_ofen"].'</td>
            <td>'.$rows["barrio_ofen"].'</td>
            <td>'.$rows["profesion_ofen"].'</td>
            <td>'.$rows["nacional_ofen"].'</td>
            <td>'.$rows["oficio_ofen"].'</td>
            <td>'.$rows["estadoc_ofen"].'</td>
            <td>'.$rows["escolar_ofen"].'</td>
            <td>'.$rows["discapacidad_ofen"].'</td>
            <td>'.$rows["emnaraza_ofen"].'</td>
            <td>'.$rows["violacion_ofen"].'</td>
            <td>'.$rows["hijos_ofen"].'</td>
            <td>'.$rows["suicidio_ofen"].'</td>
            <td>'.$rows["mental_ofen"].'</td>
            <td>'.$rows["mecanismo_ofen"].'</td>
            <td>'.$rows["nombre_denunciante"].' '.$rows["apellido_denunciante"].'</td>
            <td>'.$rows["edad_denunciante"].'</td>
            <td>'.$rows["sexo_denunciante"].'</td>
            <td>'.$rows["genero_denunciante"].'</td>
            <td>'.$rows["lgbti_denunciante"].'</td>
            <td>'.$rows["imputado_denunciante"].'</td>
            <td>'.$rows["etnia_denunciante"].'</td>
            <td>'.$rows["depto_denunciante"].'</td>
            <td>'.$rows["muni_denunciante"].'</td>
            <td>'.$rows["aldea_denunciante"].'</td>
            <td>'.$rows["barrio_denunciante"].'</td>
            <td>'.$rows["profesion_denunciante"].'</td>
            <td>'.$rows["nacionalidad_denunciante"].'</td>
            <td>'.$rows["oficio_denunciante"].'</td>
            <td>'.$rows["civil_denunciante"].'</td>
            <td>'.$rows["discapacidad_denunciante"].'</td>  
                    </tr>';
        }  
        echo "</tbody>
    </table>";               
 
$filename="reporte1.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename."");
?>
</body>
</html>
