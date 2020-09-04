<?php
    $sql= " SELECT tbl_denuncia.tdenunciaid, tbl_denuncia.dfechadenuncia, tbl_delito.cdescripcion, tbl_ofendido.cnombres AS cnombre_ofendido, tbl_ofendido.capellidos AS capellido_ofendido, tbl_imputado.cnombres AS cnombre_imputado, tbl_imputado.capellidos AS capellido_imputado, tbl_denunciante.cnombres AS cnombre_denunciante, tbl_denunciante.capellidos AS capellido_denunciante, tbl_denuncia.cestadodenuncia, tbl_ofendido.cdocumentoid AS cofendidoid, tbl_imputado.cdocumentoid AS cimputadoid, tbl_denunciante.cdocumentoid AS cdenuncianteid, tbl_denuncia.cdeptodenuncia, tbl_denuncia.cmunicipiodenuncia, tbl_denuncia.cexpedientejudicial, tbl_denuncia.cexpedientepolicial
   FROM mini_sedi.tbl_denuncia, mini_sedi.tbl_delito, mini_sedi.tbl_imputado, mini_sedi.tbl_ofendido, mini_sedi.tbl_denunciante, mini_sedi.tbl_imputado_delito
  WHERE tbl_denuncia.tdenunciaid = tbl_ofendido.tdenunciaid AND tbl_denuncia.tdenunciaid = tbl_imputado.tdenunciaid AND tbl_denuncia.tdenunciaid = tbl_denunciante.tdenunciaid AND tbl_imputado.tpersonaid = tbl_imputado_delito.tpersonaid AND tbl_imputado.tdenunciaid = tbl_imputado_delito.tdenunciaid AND tbl_imputado_delito.ndelito = tbl_delito.ndelitoid;
";
    $objConexion= new Conexion();
    $cursor= $objConexion->ejecutarComando($sql);
    
    while ($row = pg_fetch_array($cursor)) {        
        echo $row["imputado"];
    }    
?>