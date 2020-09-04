<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;


class Reportes extends Model
{

     public static function ActividadFiscal($usuario=null) {
		$sql="select a.ndelito,
					   a.thora,
					   b.cdescripcion Materia_Descripcion,
					   c.cdescripcion Descripcion_Actividad,
					   d.cdescripcion Descripcion_etapa,
					   e.cdescripcion Descripcion_Sub_Etapa,
					   f.dfechadenuncia,
					   f.cexpedientesedi,
					   f.tdenunciaid,
					   f.basignadafiscalia,
					   f.ibandejaid,
					   g.cdescripcion Fiscalia_Asignada,
					   h.cnombres,
					   h.crtn,
					   h.tdenunciaid

					   from
					   mini_sedi.tbl_imputado_actividad_delito a,
					   mini_sedi.tbl_materia b,
					   mini_sedi.tbl_actividad c,
					   mini_sedi.tbl_etapa d,
					   mini_sedi.tbl_subetapa e,
					   mini_sedi.tbl_denuncia f,
					   mini_sedi.tbl_bandejas g,
					   mini_sedi.tbl_imputado h
					   
				   where a.nmateriaid=b.nmateria and
					a.nactividadid=c.nactividadid and
					a.netapa=d.netapaid and
					d.netapaid=e.netapaid and
					c.netapaid=d.netapaid and
					c.nsubetapaid=e.nsubetapaid and
					a.tdenunciaid=f.tdenunciaid and
					f.ibandejaid=g.ibandejaid and
					a.tdenunciaid=h.tdenunciaid and
					f.tdenunciaid=h.tdenunciaid and
					a.cfiscalid=(select u.identidad from 
							mini_sedi.tbl_usuarios u where u.usuario='$usuario'
							and a.cfiscalid=u.identidad)
					
					order by a.ndelito Desc	";
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}
	
	  public static function ActividadFiscalFechas($usuario=null,$fechainicio=null,$fechafinal=null) {
		$sql="select a.ndelito,
					   a.thora,
					   b.cdescripcion Materia_Descripcion,
					   c.cdescripcion Descripcion_Actividad,
					   d.cdescripcion Descripcion_etapa,
					   e.cdescripcion Descripcion_Sub_Etapa,
					   f.dfechadenuncia,
					   f.cexpedientesedi,
					   f.tdenunciaid,
					   f.basignadafiscalia,
					   f.ibandejaid,
					   g.cdescripcion Fiscalia_Asignada,
					   h.cnombres,
					   h.crtn,
					   h.tdenunciaid

					   from
					   mini_sedi.tbl_imputado_actividad_delito a,
					   mini_sedi.tbl_materia b,
					   mini_sedi.tbl_actividad c,
					   mini_sedi.tbl_etapa d,
					   mini_sedi.tbl_subetapa e,
					   mini_sedi.tbl_denuncia f,
					   mini_sedi.tbl_bandejas g,
					   mini_sedi.tbl_imputado h
					   
				   where a.nmateriaid=b.nmateria and
					a.nactividadid=c.nactividadid and
					a.netapa=d.netapaid and
					d.netapaid=e.netapaid and
					c.netapaid=d.netapaid and
					c.nsubetapaid=e.nsubetapaid and
					a.tdenunciaid=f.tdenunciaid and
					f.ibandejaid=g.ibandejaid and
					a.tdenunciaid=h.tdenunciaid and
					f.tdenunciaid=h.tdenunciaid and
					a.cfiscalid=(select u.identidad from 
							mini_sedi.tbl_usuarios u where u.usuario='$usuario'
							and a.cfiscalid=u.identidad) and 
					f.dfechadenuncia BETWEEN '$fechainicio' AND '$fechafinal'
					
					order by a.ndelito Desc	";
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}
	
	public static function ActividadFiscalPersonal($usuario=null,$fechainicio=null,$fechafinal=null) {
		//agregar variable de session en donde esta elusuario
	
		$sql="select a.ndelito,
					   a.thora,
					   b.cdescripcion Materia_Descripcion,
					   c.cdescripcion Descripcion_Actividad,
					   d.cdescripcion Descripcion_etapa,
					   e.cdescripcion Descripcion_Sub_Etapa,
					   f.dfechadenuncia,
					   f.cexpedientesedi,
					   f.tdenunciaid,
					   f.basignadafiscalia,
					   f.ibandejaid,
					   g.cdescripcion Fiscalia_Asignada,
					   h.cnombres,
					   h.crtn,
					   h.tdenunciaid

					   from
					   mini_sedi.tbl_imputado_actividad_delito a,
					   mini_sedi.tbl_materia b,
					   mini_sedi.tbl_actividad c,
					   mini_sedi.tbl_etapa d,
					   mini_sedi.tbl_subetapa e,
					   mini_sedi.tbl_denuncia f,
					   mini_sedi.tbl_bandejas g,
					   mini_sedi.tbl_imputado h
					   
				   where a.nmateriaid=b.nmateria and
					a.nactividadid=c.nactividadid and
					a.netapa=d.netapaid and
					d.netapaid=e.netapaid and
					c.netapaid=d.netapaid and
					c.nsubetapaid=e.nsubetapaid and
					a.tdenunciaid=f.tdenunciaid and
					f.ibandejaid=g.ibandejaid and
					a.tdenunciaid=h.tdenunciaid and
					f.tdenunciaid=h.tdenunciaid and
					a.cfiscalid=(select u.identidad from 
							mini_sedi.tbl_usuarios u where u.usuario='$usuario'
							and a.cfiscalid=u.identidad) and 
					f.dfechadenuncia BETWEEN '$fechainicio' AND '$fechafinal'
					
					order by a.ndelito Desc	";
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}
	

	
	public static function ConfirmacionDenuncia() {
			$sql='select  a.tdenunciaid,
					a.tpersonaid,
					b.cnombres,
					b.crtn,
					c.ndelito,
					h.cdescripcion nombredelito,
					d.nfiscaliaid,
					d.timputadoid,
					d.dfechaasignacion,
					e.basignadafiscalia,
					e.cexpedientesedi,
					f.cdescripcion bandeja,
					g.cdescripcion subbandeja
				from 
				
				mini_sedi.tbl_imputado_denuncia a,
				mini_sedi.tbl_imputado b,
				mini_sedi.tbl_imputado_delito c,
				mini_sedi.tbl_imputado_fiscalia d,
				mini_sedi.tbl_denuncia e,
				mini_sedi.tbl_bandejas f,
				mini_sedi.tbl_subbandejas g,
				mini_sedi.tbl_delito h
				
				where 
				a.tpersonaid=b.tpersonaid and
				c.tdenunciaid=a.tdenunciaid and 
				c.tpersonaid=a.tpersonaid and
				c.tpersonaid=d.timputadoid and
				a.tdenunciaid=e.tdenunciaid and 
				f.ibandejaid=e.ibandejaid and 
				f.ibandejaid=g.ibandejaid and
				h.ndelitoid=c.ndelito';
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}
	
	public static function ConfirmacionDenunciaNombre($nombre=null) {
	$sql="select  a.tdenunciaid,
				a.tpersonaid,
				b.cnombres,
				b.crtn,
				c.ndelito,
				h.cdescripcion nombredelito,
				d.nfiscaliaid,
				d.timputadoid,
				d.dfechaasignacion,
				e.basignadafiscalia,
				e.cexpedientesedi,
				f.cdescripcion bandeja,
				g.cdescripcion subbandeja
			from 
			
			mini_sedi.tbl_imputado_denuncia a,
			mini_sedi.tbl_imputado b,
			mini_sedi.tbl_imputado_delito c,
			mini_sedi.tbl_imputado_fiscalia d,
			mini_sedi.tbl_denuncia e,
			mini_sedi.tbl_bandejas f,
			mini_sedi.tbl_subbandejas g,
			mini_sedi.tbl_delito h
			
			where 
			a.tpersonaid=b.tpersonaid and
			c.tdenunciaid=a.tdenunciaid and 
			c.tpersonaid=a.tpersonaid and
			c.tpersonaid=d.timputadoid and
			a.tdenunciaid=e.tdenunciaid and 
			f.ibandejaid=e.ibandejaid and 
			f.ibandejaid=g.ibandejaid and
			h.ndelitoid=c.ndelito and
				   UPPER(b.cnombres) like UPPER('%".$nombre."%')";
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}

	/*public static function VaciadoDenuncia($delito=null) {
			$sql='select distinct a.tpersonaid,
				a.ndelito,
				f.cdescripcion delitodescripcion,
				a.tdenunciaid,
				a.cclasificacion,
				b.basignadafiscalia,
				b.cnarracionhecho "narracion_denuncia",
				b.fecharegistro "fecha_denuncia",
				concat(c.cnombres,c.capellidos) "nombres_imputados",
				c.cgenero genero_imputados ,
				c.cdireccion direccion_imputados,
				c.csexo sexo_imputados,
				c.aplicalgbti aplicalgbti_imputados,
				c.netniaid netniaid_imputados,
				c.cbarrioid barrio_imputados,
				concat(d.cnombres,d.capellidos) nombre_ofendido,
				d.cgenero genero_ofendido,
				d.cnacionalidadid nacionalidad_ofendido,
				--d.netniaid etnia_ofendido,
				g.cdescripcion etnia_ofendido,
				d.iedad edad_ofendido,
				d.cdireccion direccion_ofendido,
				d.aplicalgbti aplicalbti_ofendido,
				d.csexo sexo_ofendido,
				concat(e.cnombres,e.capellidos) nombre_denunciante
									
				from mini_sedi.tbl_imputado_delito a,
					mini_sedi.tbl_denuncia b,
					mini_sedi.tbl_imputado c,
					mini_sedi.tbl_ofendido d,
					mini_sedi.tbl_denunciante e,
					mini_sedi.tbl_delito f,
					mini_sedi.tbl_etnia g
				where a.tdenunciaid=b.tdenunciaid and
					c.tpersonaid=a.tpersonaid and
					b.tdenunciaid=d.tdenunciaid and
					a.tdenunciaid=d.tdenunciaid and
					e.tdenunciaid=d.tdenunciaid and
					a.ndelito=f.ndelitoid and
					d.netniaid=g.netniaid and
					a.ndelito='.$delito.'
				order by  a.ndelito desc';
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}




	public static function VaciadoDenunciaFechas($delito=null,$fechainicio=null,$fechafinal=null) {
			$sql="select distinct a.tpersonaid,
				a.ndelito,
				f.cdescripcion delitodescripcion,
				a.tdenunciaid,
				a.cclasificacion,
				b.basignadafiscalia,
				b.cnarracionhecho narracion_denuncia,
				to_char(b.fecharegistro,'YYYY-DD-MM') fecha_denuncia,
				concat(c.cnombres,c.capellidos) nombres_imputados,
				c.cgenero genero_imputados ,
				c.cdireccion direccion_imputados,
				c.csexo sexo_imputados,
				c.aplicalgbti aplicalgbti_imputados,
				c.netniaid netniaid_imputados,
				c.cbarrioid barrio_imputados,
				concat(d.cnombres,d.capellidos) nombre_ofendido,
				d.cgenero genero_ofendido,
				d.cnacionalidadid nacionalidad_ofendido,
				--d.netniaid etnia_ofendido,
				g.cdescripcion etnia_ofendido,
				d.iedad edad_ofendido,
				d.cdireccion direccion_ofendido,
				d.aplicalgbti aplicalbti_ofendido,
				d.csexo sexo_ofendido,
				concat(e.cnombres,e.capellidos) nombre_denunciante
									
				from mini_sedi.tbl_imputado_delito a,
					mini_sedi.tbl_denuncia b,
					mini_sedi.tbl_imputado c,
					mini_sedi.tbl_ofendido d,
					mini_sedi.tbl_denunciante e,
					mini_sedi.tbl_delito f,
					mini_sedi.tbl_etnia g
				where a.tdenunciaid=b.tdenunciaid and
					c.tpersonaid=a.tpersonaid and
					b.tdenunciaid=d.tdenunciaid and
					a.tdenunciaid=d.tdenunciaid and
					e.tdenunciaid=d.tdenunciaid and
					a.ndelito=f.ndelitoid and
					d.netniaid=g.netniaid  and 
					a.ndelito='$delito' and
					to_char(b.fecharegistro,'YYYY-MM-DD') BETWEEN '$fechainicio' and '$fechafinal'
				order by  a.ndelito desc";
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}*/
public static function VaciadoDenuncia($delito=null) {
		$DAY='DAY';
		$DD='DD';
		$MONTH='MONTH';
		$YYYY='YYYY';
		$coma=',';
		
		$sql="select a.tdenunciaid as tdenunciaid ,
					 a.tpersonaid  as  personaimputada,
					concat(to_char(b.dfechadenuncia, '$DAY'),to_char(b.dfechadenuncia, '$DD'),'$coma',to_char(b.dfechadenuncia,'$MONTH'),to_char(b.dfechadenuncia, '$YYYY')) as fechadenuncia ,
					concat(to_char(b.dfechahecho , '$DAY'),to_char(b.dfechahecho , '$DD'),'$coma',to_char(b.dfechahecho ,'$MONTH'),to_char(b.dfechahecho , '$YYYY')) as fechahecho,
					b.thoradenuncia as thoradenuncia,
					b.thorahecho as thorahecho,
					b.cnarracionhecho as narracionhecho,
					f.cdescripcion as delitodescripcion,
					h.cdescripcion as departamentodenuncia,
					a.cclasificacion as cclasificacion,
					b.basignadafiscalia as basignadafiscalia,
					b.cdetalledireccionhecho as direccionhecho,
					concat(c.cnombres,c.capellidos) as nombres_imputados,
					c.cgenero as genero_imputados ,
					c.cdireccion as direccion_imputados,
					c.csexo as sexo_imputados,
					c.aplicalgbti as aplicalgbti_imputados,
					g.cdescripcion as netniaid_imputados,
					c.cbarrioid as barrio_imputados,
					concat(d.cnombres,d.capellidos) as nombre_ofendido,
					d.cgenero as genero_ofendido,
					d.cnacionalidadid as nacionalidad_ofendido,
					
					
					d.iedad as edad_ofendido,
					d.cdireccion as direccion_ofendido,
					d.aplicalgbti as aplicalbti_ofendido,
					d.csexo as sexo_ofendido,
					concat(e.cnombres,e.capellidos) as nombre_denunciante
								
					from mini_sedi.tbl_imputado_delito a,
						 mini_sedi.tbl_denuncia b,
						 mini_sedi.tbl_imputado c,
						 mini_sedi.tbl_ofendido d,
						 mini_sedi.tbl_denunciante e,
						 mini_sedi.tbl_delito f,
						 mini_sedi.tbl_etnia g,
						 mini_sedi.tbl_departamentopais h
					where a.tdenunciaid=b.tdenunciaid and
						  c.tpersonaid=a.tpersonaid and
						  b.tdenunciaid=d.tdenunciaid and
						  a.tdenunciaid=d.tdenunciaid and
						  e.tdenunciaid=d.tdenunciaid and
						  a.ndelito=f.ndelitoid and
						  d.netniaid=g.netniaid and
						  b.cdeptodenuncia=h.cdepartamentoid and
						  a.ndelito=".$delito;
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}




	public static function VaciadoDenunciaFechas($delito=null,$fechainicio=null,$fechafinal=null) {
			
		$DAY='DAY';
		$DD='DD';
		$MONTH='MONTH';
		$YYYY='YYYY';
		$coma=',';
			$sql="select a.tdenunciaid as tdenunciaid ,
					 a.tpersonaid  as  personaimputada,
					concat(to_char(b.dfechadenuncia, '$DAY'),to_char(b.dfechadenuncia, '$DD'),'$coma',to_char(b.dfechadenuncia,'$MONTH'),to_char(b.dfechadenuncia, '$YYYY')) as fechadenuncia ,
					concat(to_char(b.dfechahecho , '$DAY'),to_char(b.dfechahecho , '$DD'),'$coma',to_char(b.dfechahecho ,'$MONTH'),to_char(b.dfechahecho , '$YYYY')) as fechahecho,
					b.thoradenuncia as thoradenuncia,
					b.thorahecho as thorahecho,
					b.cnarracionhecho as narracionhecho,
					f.cdescripcion as delitodescripcion,
					h.cdescripcion as departamentodenuncia,
					a.cclasificacion as cclasificacion,
					b.basignadafiscalia as basignadafiscalia,
					b.cdetalledireccionhecho as direccionhecho,
					concat(c.cnombres,c.capellidos) as nombres_imputados,
					c.cgenero as genero_imputados ,
					c.cdireccion as direccion_imputados,
					c.csexo as sexo_imputados,
					c.aplicalgbti as aplicalgbti_imputados,
					g.cdescripcion as netniaid_imputados,
					c.cbarrioid as barrio_imputados,
					concat(d.cnombres,d.capellidos) as nombre_ofendido,
					d.cgenero as genero_ofendido,
					d.cnacionalidadid as nacionalidad_ofendido,
					
					
					d.iedad as edad_ofendido,
					d.cdireccion as direccion_ofendido,
					d.aplicalgbti as aplicalbti_ofendido,
					d.csexo as sexo_ofendido,
					concat(e.cnombres,e.capellidos) as nombre_denunciante
									
				from mini_sedi.tbl_imputado_delito a,
					mini_sedi.tbl_denuncia b,
					mini_sedi.tbl_imputado c,
					mini_sedi.tbl_ofendido d,
					mini_sedi.tbl_denunciante e,
					mini_sedi.tbl_delito f,
					mini_sedi.tbl_etnia g,
					mini_sedi.tbl_departamentopais h
				where a.tdenunciaid=b.tdenunciaid and
					c.tpersonaid=a.tpersonaid and
					b.tdenunciaid=d.tdenunciaid and
					a.tdenunciaid=d.tdenunciaid and
					e.tdenunciaid=d.tdenunciaid and
					a.ndelito=f.ndelitoid and
					d.netniaid=g.netniaid  and 
					 b.cdeptodenuncia=h.cdepartamentoid and
					a.ndelito='$delito' and
					to_char(b.fecharegistro,'YYYY-MM-DD') BETWEEN '$fechainicio' and '$fechafinal'";
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}
   

    public static function Usuariohijos($user = null)
	//agregar usuario de seron
    {
        $sql="select *from mini_sedi.tbl_usuarios  where isubbandejaid=(
				Select isubbandejaid from mini_sedi.tbl_usuarios where usuario='$user')";
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }

 public static function delitos($parameters = null)
    {
        $sql="select *from mini_sedi.tbl_delito";
			$result = new TblDepartamentoPais();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
}
