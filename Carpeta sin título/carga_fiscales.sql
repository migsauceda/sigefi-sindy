SELECT 
  tbl_fiscal.cnombres, 
  tbl_fiscal.capellidos, 
  tbl_delito.cdescripcion, 
  tbl_denuncia.tdenunciaid, 
  tbl_denuncia.cexpedientesedi
FROM 
  mini_sedi.tbl_imputado_fiscal, 
  mini_sedi.tbl_fiscal, 
  mini_sedi.tbl_denuncia, 
  mini_sedi.tbl_delito, 
  mini_sedi.tbl_imputado_delito
WHERE 
  tbl_imputado_fiscal.cfiscal = tbl_fiscal.cfiscalid AND
  tbl_denuncia.tdenunciaid = tbl_imputado_fiscal.tdenunciaid AND
  tbl_denuncia.tdenunciaid = tbl_imputado_delito.tdenunciaid AND
  tbl_imputado_delito.ndelito = tbl_delito.ndelitoid;
