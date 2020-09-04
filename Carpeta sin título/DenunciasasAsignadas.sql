SELECT 
  tbl_imputado_fiscalia.tdenunciaid, 
  tbl_imputado_fiscalia.dfechaasignacion,
  tbl_fiscalia.cdescripcion, 
  tbl_usuarios.nombreapellido
FROM 
  mini_sedi.tbl_imputado_fiscalia, 
  mini_sedi.tbl_fiscalia, 
  mini_sedi.tbl_usuarios
WHERE 
  tbl_imputado_fiscalia.cusuario = tbl_usuarios.usuario AND
  tbl_fiscalia.nfiscaliaid = tbl_imputado_fiscalia.nfiscaliaid