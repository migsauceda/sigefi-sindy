SELECT 
  tbl_denuncia.dfechadenuncia as fecha_denuncia, 
  tbl_denuncia.dfechahecho as fecha_hecho, 
  tbl_departamentopais.cdescripcion as depto_hecho, 
  tbl_municipio.cdescripcion as muni_hecho, 
  tbl_aldea.cdescripcion as aldea_hecho, 
  tbl_barrio.cdescripcion as barrio_hecho, 
  tbl_delito.cdescripcion as delito, 
  tbl_imputado.cnombres as imputado_nombre, 
  tbl_imputado.capellidos as imputado_apellido, 
  tbl_imputado.cgenero as imputado_sexo, 
  tbl_imputado.iedad as imputado_edad, 
  tbl_imputado.cunidadmedidaedad as imputado_umedida, 
  tbl_ocupacion.cdescripcion as imputado_ocupacion, 
  tbl_nacionalidad.cdescripcion as imputado_nacionalidad, 
  tbl_ofendido.cnombres as ofendido_nombre, 
  tbl_ofendido.capellidos as ofendido_apellido, 
  tbl_ofendido.cgenero as ofendido_sexo, 
  tbl_ofendido.iedad as ofendido_edad, 
  tbl_ofendido.cunidadmedidaedad as ofendido_unidad, 
  o.cdescripcion as ofendido_ocupacion, 
  n.cdescripcion as ofendido_nacionalidad,    
  tbl_imputado.tpersonaid as imputadoid, 
  tbl_ofendido.tpersonaid as ofendidoid,
  tbl_denuncia.cexpedientesedi 
FROM 
  mini_sedi.tbl_denuncia, 
  mini_sedi.tbl_aldea, 
  mini_sedi.tbl_barrio, 
  mini_sedi.tbl_departamentopais, 
  mini_sedi.tbl_municipio, 
  mini_sedi.tbl_delito, 
  mini_sedi.tbl_imputado, 
  mini_sedi.tbl_imputado_delito, 
  mini_sedi.tbl_ocupacion, 
  mini_sedi.tbl_nacionalidad, 
  mini_sedi.tbl_ofendido,  
  mini_sedi.tbl_ocupacion as o, 
  mini_sedi.tbl_nacionalidad as n  
WHERE 
  tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_municipio.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
  tbl_denuncia.cdeptohecho = tbl_aldea.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_aldea.cmunicipioid AND
  tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
  tbl_denuncia.cdeptohecho = tbl_barrio.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_barrio.cmunicipioid AND
  tbl_denuncia.caldeahecho = tbl_barrio.caldeaid AND
  tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid AND
  tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
  tbl_imputado.tdenunciaid = tbl_denuncia.tdenunciaid AND
  tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
  tbl_imputado.nocupacionid = tbl_ocupacion.nocupacionid AND
  tbl_imputado.cnacionalidadid = tbl_nacionalidad.cnacionalidadid AND
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
  tbl_ofendido.nocupacionid = o.nocupacionid AND
  tbl_ofendido.cnacionalidadid = n.cnacionalidadid  and tbl_denuncia.cexpedientesedi like '%2091%'
;
