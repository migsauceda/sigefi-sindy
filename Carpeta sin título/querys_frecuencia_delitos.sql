//todos los delitos al detalle de barrio
SELECT 
  count(tbl_delito.cdescripcion) as frecuencia,
  tbl_delito.cdescripcion,
  tbl_departamentopais.cdescripcion, 
  tbl_municipio.cdescripcion, 
  tbl_aldea.cdescripcion,
  tbl_barrio.cdescripcion
FROM 
  mini_sedi.tbl_delito, 
  mini_sedi.tbl_imputado_delito, 
  mini_sedi.tbl_denuncia, 
  mini_sedi.tbl_departamentopais, 
  mini_sedi.tbl_municipio, 
  mini_sedi.tbl_aldea, 
  mini_sedi.tbl_barrio
WHERE 
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
  tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
  tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_municipio.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_aldea.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_barrio.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
  tbl_denuncia.cmunicipiohecho = tbl_aldea.cmunicipioid AND
  tbl_denuncia.cmunicipiohecho = tbl_barrio.cmunicipioid AND
  tbl_denuncia.caldeahecho = tbl_aldea.caldeaid AND
  tbl_denuncia.caldeahecho = tbl_barrio.caldeaid AND
  tbl_denuncia.ccaseriohecho = tbl_barrio.cbarrioid
group by
  tbl_delito.cdescripcion,
  tbl_departamentopais.cdescripcion, 
  tbl_municipio.cdescripcion, 
  tbl_aldea.cdescripcion,
  tbl_barrio.cdescripcion;

//todos los delitos al detalle por ciudad
SELECT 
  count(tbl_delito.cdescripcion) as frecuencia,
  tbl_delito.cdescripcion,
  tbl_departamentopais.cdescripcion, 
  tbl_municipio.cdescripcion, 
  tbl_aldea.cdescripcion
FROM 
  mini_sedi.tbl_delito, 
  mini_sedi.tbl_imputado_delito, 
  mini_sedi.tbl_denuncia, 
  mini_sedi.tbl_departamentopais, 
  mini_sedi.tbl_municipio, 
  mini_sedi.tbl_aldea
WHERE 
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
  tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
  tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_municipio.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_aldea.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid AND
  tbl_denuncia.cmunicipiohecho = tbl_aldea.cmunicipioid AND
  tbl_denuncia.caldeahecho = tbl_aldea.caldeaid
group by
  tbl_delito.cdescripcion,
  tbl_departamentopais.cdescripcion, 
  tbl_municipio.cdescripcion, 
  tbl_aldea.cdescripcion;

//todos los delitos al detalle por municipio
SELECT 
  count(tbl_delito.cdescripcion) as frecuencia,
  tbl_delito.cdescripcion,
  tbl_departamentopais.cdescripcion, 
  tbl_municipio.cdescripcion
FROM 
  mini_sedi.tbl_delito, 
  mini_sedi.tbl_imputado_delito, 
  mini_sedi.tbl_denuncia, 
  mini_sedi.tbl_departamentopais, 
  mini_sedi.tbl_municipio
WHERE 
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
  tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
  tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid AND
  tbl_denuncia.cdeptohecho = tbl_municipio.cdepartamentoid AND
  tbl_denuncia.cmunicipiohecho = tbl_municipio.cmunicipioid
group by
  tbl_delito.cdescripcion,
  tbl_departamentopais.cdescripcion, 
  tbl_municipio.cdescripcion;

//todos los delitos al detalle por departamento
SELECT 
  count(tbl_delito.cdescripcion) as frecuencia,
  tbl_delito.cdescripcion,
  tbl_departamentopais.cdescripcion
FROM 
  mini_sedi.tbl_delito, 
  mini_sedi.tbl_imputado_delito, 
  mini_sedi.tbl_denuncia, 
  mini_sedi.tbl_departamentopais
WHERE 
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
  tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
  tbl_denuncia.cdeptohecho = tbl_departamentopais.cdepartamentoid
group by
  tbl_delito.cdescripcion,
  tbl_departamentopais.cdescripcion;

//todos los delitos en general
SELECT 
  count(tbl_delito.cdescripcion) as frecuencia,
  tbl_delito.cdescripcion
FROM 
  mini_sedi.tbl_delito, 
  mini_sedi.tbl_imputado_delito, 
  mini_sedi.tbl_denuncia
WHERE 
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid AND
  tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid 
group by
  tbl_delito.cdescripcion;

