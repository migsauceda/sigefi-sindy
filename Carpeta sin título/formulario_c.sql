SELECT 
  tbl_denuncia.dfechadenuncia as fecha_denuncia, 
  tbl_denuncia.dfechahecho as fecha_hecho, 
  tbl_delito.cdescripcion as delito, 
  tbl_departamentopais.cdescripcion as depto_hecho, 
  tbl_municipio.cdescripcion as muni_hecho, 
  tbl_aldea.cdescripcion as ciudad_hecho, 
  tbl_barrio.cdescripcion as barrio_hecho, 
  tbl_imputado.cnombres as imputado_nomb, 
  tbl_imputado.capellidos as imputado_ape, 
  tbl_imputado.cgenero as sexo, 
  tbl_imputado.iedad as edad, 
  tbl_imputado.cunidadmedidaedad as u_edad, 
  tbl_ocupacion.cdescripcion as ocupacion, 
  tbl_nacionalidad.cdescripcion as nacionalidad, 
  tbl_ofendido.cnombres as ofendido_nomb, 
  tbl_ofendido.capellidos as ofendido_apel, 
  tbl_ofendido.cgenero as ofendido_sexo, 
  tbl_ofendido.iedad as ofendido_edad, 
  tbl_ofendido.cunidadmedidaedad as ofendidio_u_edad, 
  tbl_nacionalidad.cdescripcion as ofendido_naci, 
  tbl_ocupacion.cdescripcion as ofendido_ocupa, 
  tbl_escolaridad.cdescripcion as ofendido_escola, 
  tbl_parentescos.cdescripcion as parentesco
FROM 
  mini_sedi.tbl_denuncia, 
  mini_sedi.tbl_delito, 
  mini_sedi.tbl_imputado, 
  mini_sedi.tbl_imputado_delito, 
  mini_sedi.tbl_departamentopais, 
  mini_sedi.tbl_municipio, 
  mini_sedi.tbl_aldea, 
  mini_sedi.tbl_barrio, 
  mini_sedi.tbl_ocupacion, 
  mini_sedi.tbl_nacionalidad, 
  mini_sedi.tbl_ofendido, 
  mini_sedi.tbl_nacionalidad as n, 
  mini_sedi.tbl_ocupacion as o, 
  mini_sedi.tbl_escolaridad, 
  mini_sedi.tbl_imputado_ofendido, 
  mini_sedi.tbl_parentescos
WHERE 
  tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND
  tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_aldea.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_aldea.cmunicipioid AND
  tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
  tbl_denuncia.cdeptohecho = tbl_municipio.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
  tbl_denuncia.cdeptohecho = tbl_barrio.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_barrio.cmunicipioid AND
  tbl_denuncia.caldeahecho = tbl_barrio.caldeaid AND
  tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid AND
  tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND
  tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
  tbl_imputado.nocupacionid = tbl_ocupacion.nocupacionid AND
  tbl_imputado.cnacionalidadid = tbl_nacionalidad.cnacionalidadid AND
  tbl_imputado.tpersonaid = tbl_imputado_ofendido.nimputadoid AND
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
  tbl_ofendido.cnacionalidadid = n.cnacionalidadid AND
  tbl_ofendido.nocupacionid = o.nocupacionid AND
  tbl_ofendido.nescolaridadid = tbl_escolaridad.nescolaridadid AND
  tbl_ofendido.tdenunciaid = tbl_imputado_ofendido.tdenunciaid AND
  tbl_ofendido.tpersonaid = tbl_imputado_ofendido.nofendidoid AND
  tbl_imputado_ofendido.nparentescoid = tbl_parentescos.nparentescoid
 order by tbl_denuncia.dfechadenuncia;
