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
                        <th>recepcion</th>
                        <th>numero</th>
                        <th>narracion</th>
                        <th>f_denuncia</th>
                        <th>f_hecho</th>
                        <th>depto_den</th>
                        <th>muni_den</th>
                        <th>aldea_den</th>
                        <th>bario_den</th>
                        <th>numero_den</th>
                        <th>nombre_imp</th>
                        <th>alias_imp</th>
                        <th>edad_imp</th>
                        
                        <th>sexo_imp</th>
                        <th>genero_imp</th>
                        <th>etnia_imp</th>
                        <th>aplica_lgbtiimp</th>
                        <th>ocupacion_imp</th>
                        <th>profe_imp</th>
                        <th>escolar_imp</th>
                        <th>nacional_imp</th>
                        <th>civil_imp</th>
                        <th>depto_imp</th>
                        <th>muni_imp</th>
                        <th>ald_imp</th>
                        <th>barr_imp</th>
                        <th>nombre_ofendi</th>
                        <th>edad_ofe</th>
                        <th>sexo_ofe</th>
                        <th>etnia_ofe</th>
                        <th>genero_ofe</th>
                        <th>aplica_lgbtiofe</th>
                        <th>depto_ofe</th>
                        <th>muni_ofe</th>
                        <th>ciudad_ofe</th>
                        <th>barrio_ofe</th>
                        <th>profe_ofe</th>
                        <th>nacion_ofe</th>
                        <th>ocupa_ofe</th>
                        <th>civil_ofe</th>
                        <th>escolar_ofe</th>
                        <th>delito</th>
                        <th>nombre_denciante</th>
                        <th>edad_denucinte</th>
                        <th>sexo_denunte</th>
                        <th>genero_denunte</th>
                        <th>aplica_lgbtidenut</th>
                        <th>etnia_denunte</th>
                        <th>depto_denunte</th>
                        <th>muni_denunte</th>
                        <th>ciudad_denunte</th>
                        <th>barrio_denunte</th>
                        <th>profe_denunte</th>
                        <th>nacion_denunte</th>
                        <th>ocupa_denunte</th>
                        <th>civil_denunte</th>
                        <th>escolar_denunte</th>


                        </tr>
                      </thead>
                      <tbody>';
               $sql= "SELECT
  bandejas.cdescripcion as recepcion,
  tbl_denuncia.tdenunciaid as numero,
  tbl_denuncia.cnarracionhecho as narracion,
  tbl_denuncia.dfechadenuncia as f_denuncia,
  tbl_denuncia.dfechahecho as f_hecho,
 
  tbl_departamentopais.cdescripcion as depto_den,
  tbl_municipio.cdescripcion as muni_den,
  tbl_aldea.cdescripcion as aldea_den,
  tbl_barrio.cdescripcion as bario_den,
  tbl_denuncia.tdenunciaid as numero_den,
  tbl_imputado.cnombres as nombre_imp,
  tbl_imputado.capellidos as epellido_imp,
  tbl_imputado.calias as alias_imp,
  tbl_imputado.iedad as edad_imp,
  
  tbl_imputado.csexo as sexo_imp,
  tbl_imputado.cgenero as genero_imp,
  tbl_etnia.cdescripcion as etnia_imp, 
  tbl_imputado.aplicalgbti as aplica_lgbtiimp,
  tbl_ocupacion.cdescripcion as ocupacion_imp,
  tbl_profesion.cdescripcion as profe_imp,
  tbl_escolaridad.cdescripcion as escolar_imp,
  tbl_nacionalidad.cdescripcion as nacional_imp,
  tbl_estadoscivil.cdescripcion as civil_imp,
  dpto_imp.cdescripcion as depto_imp,
  muni_imp.cdescripcion as muni_imp,
  aldea_imp.cdescripcion as ald_imp,
  barr_imp.cdescripcion as barr_imp,   
  tbl_ofendido.cnombres as nombre_ofendi,   
  tbl_ofendido.capellidos as epellido_ofendido,
  tbl_ofendido.iedad as edad_ofe,
  
  tbl_ofendido.csexo as sexo_ofe,
  et_ofe.cdescripcion as etnia_ofe,

  tbl_ofendido.cgenero as genero_ofe,
   tbl_ofendido.aplicalgbti as aplica_lgbtiofe,
  depto_ofe.cdescripcion as depto_ofe,
  muni_ofe.cdescripcion as muni_ofe,
  aldea_ofe.cdescripcion as ciudad_ofe,
  barrio_ofe.cdescripcion as barrio_ofe,
  prof_ofe.cdescripcion as profe_ofe,
  nac_ofe.cdescripcion as nacion_ofe,
  ocu_ofe.cdescripcion as ocupa_ofe,
  civil_ofe.cdescripcion as civil_ofe,
  eco_ofe.cdescripcion as escolar_ofe,
  del.cdescripcion as delito,
  tbl_denunciante.cnombres as nombre_denciante,
  tbl_denunciante.capellidos as epellido_denunciante,
  tbl_denunciante.iedad as edad_denucinte,
    
  tbl_denunciante.csexo as sexo_denunte,
  tbl_denunciante.cgenero as genero_denunte,
  tbl_denunciante.aplicalgbti as aplica_LGBTIdenut,
  etn_denunte.cdescripcion as etnia_denunte,
  depto_denunte.cdescripcion as depto_denunte,
  muni_denunte.cdescripcion as muni_denunte,
  aldea_denunte.cdescripcion as ciudad_denunte,
  barrio_denunte.cdescripcion as barrio_denunte,
  prof_denunte.cdescripcion as profe_denunte,
  nac_denunte.cdescripcion as nacion_denunte,
  ocu_denunte.cdescripcion as ocupa_denunte,
  civil_denunte.cdescripcion as civil_denunte,
  eco_denunte.cdescripcion as escolar_denunte
FROM
  mini_sedi.tbl_imputado_delito imp_del,
  mini_sedi.tbl_delito del,
  mini_sedi.tbl_denuncia,
  mini_sedi.tbl_imputado,
  mini_sedi.tbl_departamentopais,
  mini_sedi.tbl_municipio,
  mini_sedi.tbl_barrio,
  mini_sedi.tbl_aldea,
  mini_sedi.tbl_etnia,
  mini_sedi.tbl_departamentopais dpto_imp,
  mini_sedi.tbl_municipio muni_imp,
  mini_sedi.tbl_aldea aldea_imp,
  mini_sedi.tbl_barrio barr_imp,
  mini_sedi.tbl_escolaridad,
  mini_sedi.tbl_estadoscivil,
  mini_sedi.tbl_nacionalidad,
  mini_sedi.tbl_ocupacion,
  mini_sedi.tbl_profesion,
  mini_sedi.tbl_ofendido,
  mini_sedi.tbl_denunciante,
  mini_sedi.tbl_departamentopais depto_ofe,
  mini_sedi.tbl_municipio muni_ofe,
  mini_sedi.tbl_aldea aldea_ofe,
  mini_sedi.tbl_barrio barrio_ofe,
  mini_sedi.tbl_profesion prof_ofe,
  mini_sedi.tbl_nacionalidad nac_ofe,
  mini_sedi.tbl_ocupacion ocu_ofe,
  mini_sedi.tbl_estadoscivil civil_ofe,
  mini_sedi.tbl_escolaridad eco_ofe,
  mini_sedi.tbl_etnia et_ofe,

  mini_sedi.tbl_departamentopais depto_denunte,
  mini_sedi.tbl_municipio muni_denunte,
  mini_sedi.tbl_aldea aldea_denunte,
 
  mini_sedi.tbl_barrio barrio_denunte,
  mini_sedi.tbl_profesion prof_denunte,
  mini_sedi.tbl_nacionalidad nac_denunte,
  mini_sedi.tbl_ocupacion ocu_denunte,
  mini_sedi.tbl_estadoscivil civil_denunte,
  mini_sedi.tbl_escolaridad eco_denunte,
  mini_sedi.tbl_etnia etn_denunte,
 
  mini_sedi.tbl_bandejas bandejas
WHERE
  imp_del.ndelito= del.ndelitoid and
  imp_del.tpersonaid= tbl_imputado.tpersonaid and
  tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
  tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
  tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
  tbl_denuncia.cmunicipiohecho = tbl_aldea.cmunicipioid AND
  tbl_denuncia.cdeptohecho = tbl_aldea.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_municipio.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_barrio.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_barrio.cmunicipioid AND
  tbl_denuncia.caldeahecho = tbl_barrio.caldeaid AND
  tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid AND
  tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
  tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
  tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid and
  
  
  tbl_imputado.cdepartamentoid = dpto_imp.cdepartamentoid ANd
  tbl_imputado.cdepartamentoid = muni_imp.cdepartamentoid AND
  tbl_imputado.cdepartamentoid = aldea_imp.cdepartamentoid AND
  tbl_imputado.cdepartamentoid = barr_imp.cdepartamentoid AND
  tbl_imputado.cmunicipioid = muni_imp.cmunicipioid AND
  tbl_imputado.cmunicipioid = aldea_imp.cmunicipioid AND
  tbl_imputado.caldeaid = aldea_imp.caldeaid AND
  tbl_imputado.cmunicipioid = barr_imp.cmunicipioid AND
  tbl_imputado.caldeaid = barr_imp.caldeaid AND
  tbl_imputado.cbarrioid = barr_imp.cbarrioid AND
  tbl_imputado.netniaid = tbl_etnia.netniaid and
  
  tbl_imputado.nocupacionid = tbl_ocupacion.nocupacionid AND
  tbl_imputado.nprofesionid = tbl_profesion.nprofesionid AND
  tbl_imputado.nescolaridadid = tbl_escolaridad.nescolaridadid AND
  tbl_imputado.cnacionalidadid = tbl_nacionalidad.cnacionalidadid AND
  tbl_imputado.nestadocivil = tbl_estadoscivil.ncivil AND
  tbl_ofendido.cdepartamentoid = depto_ofe.cdepartamentoid AND
  tbl_ofendido.cmunicipioid = muni_ofe.cmunicipioid AND
  tbl_ofendido.cdepartamentoid = muni_ofe.cdepartamentoid AND
  tbl_ofendido.cdepartamentoid = aldea_ofe.cdepartamentoid AND
  tbl_ofendido.cmunicipioid = aldea_ofe.cmunicipioid AND
  tbl_ofendido.caldeaid = aldea_ofe.caldeaid AND
  tbl_ofendido.cdepartamentoid = barrio_ofe.cdepartamentoid AND
  tbl_ofendido.cmunicipioid = barrio_ofe.cmunicipioid AND
  tbl_ofendido.caldeaid = barrio_ofe.caldeaid AND
  tbl_ofendido.cbarrioid = barrio_ofe.cbarrioid AND
  tbl_ofendido.nprofesionid = prof_ofe.nprofesionid AND
  tbl_ofendido.netniaid = et_ofe.netniaid and
  
  nac_ofe.cnacionalidadid = tbl_ofendido.cnacionalidadid AND
  ocu_ofe.nocupacionid = tbl_ofendido.nocupacionid AND
  civil_ofe.ncivil = tbl_ofendido.nestadocivil AND
  eco_ofe.nescolaridadid = tbl_ofendido.nescolaridadid AND   
  tbl_denunciante.cdepartamentoid = depto_denunte.cdepartamentoid AND
  tbl_denunciante.cmunicipioid = muni_denunte.cmunicipioid AND
  tbl_denunciante.cdepartamentoid = muni_denunte.cdepartamentoid AND
  tbl_denunciante.cdepartamentoid = aldea_denunte.cdepartamentoid AND
  tbl_denunciante.cmunicipioid = aldea_denunte.cmunicipioid AND
  tbl_denunciante.caldeaid = aldea_denunte.caldeaid AND
  tbl_denunciante.cdepartamentoid = barrio_denunte.cdepartamentoid AND
  tbl_denunciante.cmunicipioid = barrio_denunte.cmunicipioid AND
  tbl_denunciante.caldeaid = barrio_denunte.caldeaid AND
  tbl_denunciante.cbarrioid = barrio_denunte.cbarrioid AND
  tbl_denunciante.nprofesionid = prof_denunte.nprofesionid AND
  tbl_denunciante.netniaid = etn_denunte.netniaid and
  nac_denunte.cnacionalidadid = tbl_denunciante.cnacionalidadid AND
  ocu_denunte.nocupacionid = tbl_denunciante.nocupacionid AND
  civil_denunte.ncivil = tbl_denunciante.nestadocivil AND
  eco_denunte.nescolaridadid = tbl_denunciante.nescolaridadid AND
  /*bandejas.isubbandejaid = tbl_denuncia.nlugarrecepcion and*/
  bandejas.ibandejaid = tbl_denuncia.ibandejaid and
  tbl_denuncia.dfechadenuncia between '$_fecha_inicial' and '$_fecha_final'
  order by dfechadenuncia, tbl_denuncia.tdenunciaid";

                     $resultado= $con->ejecutarComando($sql);
                     while ($rows = pg_fetch_ASSOC($resultado))
                      {
                          echo '<tr>
                                
                                <td>'.$rows["recepcion"].'</td>
                                <td>'.$rows["numero"].'</td>
                                <td>'.$rows["narracion"].'</td>
                                <td>'.$rows["f_denuncia"].'</td>
                                <td>'.$rows["f_hecho"].'</td>
                                <td>'.$rows["depto_den"].'</td>
                                <td>'.$rows["muni_den"].'</td>
                                <td>'.$rows["aldea_den"].'</td>
                                <td>'.$rows["bario_den"].'</td>
                                <td>'.$rows["numero_den"].'</td>
                                <td>'.$rows["nombre_imp"].''.$rows["epellido_imp"].'</td>
                                <td>'.$rows["alias_imp"].'</td>
                                <td>'.$rows["edad_imp"].'</td>
                                <td>'.$rows["sexo_imp"].'</td>
                                <td>'.$rows["genero_imp"].'</td>
                                <td>'.$rows["etnia_imp"].'</td>
                                <td>'.$rows["aplica_lgbtiimp"].'</td>
                                <td>'.$rows["ocupacion_imp"].'</td>
                                <td>'.$rows["profe_imp"].'</td>
                                <td>'.$rows["escolar_imp"].'</td>
                                <td>'.$rows["nacional_imp"].'</td>
                                <td>'.$rows["civil_imp"].'</td>
                                <td>'.$rows["depto_imp"].'</td>
                                <td>'.$rows["muni_imp"].'</td>
                                <td>'.$rows["ald_imp"].'</td>
                                <td>'.$rows["barr_imp"].'</td>
                                <td>'.$rows["nombre_ofendi"].''.$rows["epellido_ofendido"].'</td>
                                <td>'.$rows["edad_ofe"].'</td>
                                <td>'.$rows["sexo_ofe"].'</th>
                                <td>'.$rows["etnia_ofe"].'</th>
                                <td>'.$rows["genero_ofe"].'</th>
                                <td>'.$rows["aplica_lgbtiofe"].'</td>
                                <td>'.$rows["depto_ofe"].'</td>
                                <td>'.$rows["muni_ofe"].'</td>
                                <td>'.$rows["ciudad_ofe"].'</td>
                                <td>'.$rows["barrio_ofe"].'</td>
                                <td>'.$rows["profe_ofe"].'</td>
                                <td>'.$rows["nacion_ofe"].'</td>
                                <td>'.$rows["ocupa_ofe"].'</td>
                                <td>'.$rows["civil_ofe"].'</td>
                                <td>'.$rows["escolar_ofe"].'</td>
                                <td>'.$rows["delito"].'</td>
                                <td>'.$rows["nombre_denciante"].''.$rows["epellido_denunciante"].'</td>
                                <td>'.$rows["edad_denucinte"].'</td>
                                <td>'.$rows["sexo_denunte"].'</td>
                                <td>'.$rows["genero_denunte"].'</td>
                                <td>'.$rows["aplica_lgbtidenut"].'</td>
                                <td>'.$rows["etnia_denunte"].'</td>
                                <td>'.$rows["depto_denunte"].'</td>
                                <td>'.$rows["muni_denunte"].'</td>
                                <td>'.$rows["ciudad_denunte"].'</td>
                                <td>'.$rows["barrio_denunte"].'</td>
                                <td>'.$rows["profe_denunte"].'</td>
                                <td>'.$rows["nacion_denunte"].'</td>
                                <td>'.$rows["ocupa_denunte"].'</td>
                                <td>'.$rows["civil_denunte"].'</td>
                                <td>'.$rows["escolar_denunte"].'</td>
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
