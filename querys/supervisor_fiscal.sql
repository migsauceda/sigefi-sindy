SELECT 
  tbl_fiscal.capellidos || ' '|| tbl_fiscal.cnombres as fiscal,
  tbl_imputado_actividad.tdenunciaid, 
  tbl_materia.cdescripcion as materia, 
  tbl_etapa.cdescripcion as etapa, 
  tbl_subetapa.cdescripcion as subetapa, 
  tbl_actividad.cdescripcion as actividad, 
  tbl_imputado_actividad.dfecha, 
  tbl_imputado.capellidos || ' ' || tbl_imputado.cnombres as imputado,
  tbl_delito.cdescripcion as delito
FROM 
  mini_sedi.tbl_imputado_actividad, 
  mini_sedi.tbl_imputado, 
  mini_sedi.tbl_actividad, 
  mini_sedi.tbl_fiscal, 
  mini_sedi.tbl_etapa, 
  mini_sedi.tbl_materia, 
  mini_sedi.tbl_subetapa, 
  mini_sedi.tbl_imputado_delito, 
  mini_sedi.tbl_delito
WHERE 
  tbl_imputado_actividad.netapa = tbl_etapa.netapaid AND
  tbl_imputado_actividad.cfiscalid = tbl_fiscal.cfiscalid AND
  tbl_imputado.tpersonaid = tbl_imputado_actividad.tpersonaid AND
  tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND
  tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
  tbl_actividad.nactividadid = tbl_imputado_actividad.nactividadid AND
  tbl_materia.nmateria = tbl_imputado_actividad.nmateriaid AND
  tbl_subetapa.nsubetapaid = tbl_imputado_actividad.nactividadid2 AND
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid
ORDER BY
  tbl_imputado_actividad.cfiscalid ASC, 
  tbl_imputado_actividad.tdenunciaid,
  tbl_imputado_actividad.dfecha DESC;
