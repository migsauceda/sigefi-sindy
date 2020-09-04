<?php
//session_start();
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Reportes extends Model
{

     public static function ActividadFiscal($usuario=null) {
		$sql="select 	a.ndelito,
						i.cdescripcion delito,
					    a.thora,
						to_char(f.fecharegistro ,'YYYY-MM-DD') fecharegistro,
					   b.cdescripcion Materia_Descripcion,
					   c.cdescripcion Descripcion_Actividad,
					   d.cdescripcion Descripcion_etapa,
					   e.cdescripcion Descripcion_Sub_Etapa,
					   f.dfechadenuncia,
					   f.cexpedientesedi,
					   f.tdenunciaid,
					   f.basignadafiscalia,
					   f.ibandejaid,
					   g.cdescripcion fiscalia_asignada,
					   h.cnombres,
					   h.crtn crtn,
					   h.tdenunciaid

					   from
					   mini_sedi.tbl_imputado_actividad_delito a,
					   mini_sedi.tbl_materia b,
					   mini_sedi.tbl_actividad c,
					   mini_sedi.tbl_etapa d,
					   mini_sedi.tbl_subetapa e,
					   mini_sedi.tbl_denuncia f,
					   mini_sedi.tbl_bandejas g,
					   mini_sedi.tbl_imputado h,
					   mini_sedi.tbl_delito i
					   
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
					a.ndelito=i.ndelitoid and 
					a.cfiscalid=(select u.identidad from 
							mini_sedi.tbl_usuarios u where u.usuario='$usuario'
							and a.cfiscalid=u.identidad)
					
					order by a.ndelito Desc	";
		$Ireporte = new Reportes();
		return new Resultset(null, $Ireporte, $Ireporte->getReadConnection()->query($sql));
	}
	
	  public static function ActividadFiscalFechas($usuario=null,$fechainicio=null,$fechafinal=null) {
		$sql="select 	a.ndelito,
						i.cdescripcion delito,
					   a.thora,
					  to_char(f.fecharegistro ,'YYYY-MM-DD') fecharegistro,
					   b.cdescripcion Materia_Descripcion,
					   c.cdescripcion Descripcion_Actividad,
					   d.cdescripcion Descripcion_etapa,
					   e.cdescripcion Descripcion_Sub_Etapa,
					   f.dfechadenuncia,
					   f.cexpedientesedi,
					   f.tdenunciaid,
					   f.basignadafiscalia,
					   f.ibandejaid,
					   g.cdescripcion fiscalia_asignada,
					   h.cnombres,
					   h.crtn crtn,
					   h.tdenunciaid

					   from
					   mini_sedi.tbl_imputado_actividad_delito a,
					   mini_sedi.tbl_materia b,
					   mini_sedi.tbl_actividad c,
					   mini_sedi.tbl_etapa d,
					   mini_sedi.tbl_subetapa e,
					   mini_sedi.tbl_denuncia f,
					   mini_sedi.tbl_bandejas g,
					   mini_sedi.tbl_imputado h,
					   mini_sedi.tbl_delito i
					   
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
					a.ndelito=i.ndelitoid and 
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

		
	public static function VaciadoDenuncia($delito=null) {
		$DAY='DAY';
		$DD='DD';
		$MONTH='MONTH';
		$YYYY='YYYY';
		$coma=',';
		$MM='MM';
		
		$sql="select a.tdenunciaid as tdenunciaid,
					concat(to_char(b.dfechadenuncia, '$DAY'),to_char(b.dfechadenuncia, '$DD'),'$coma',to_char(b.dfechadenuncia,'$MONTH'),to_char(b.dfechadenuncia, '$YYYY')) as fechadenuncia ,
					b.thoradenuncia as thoradenuncia,
					to_char(b.dfechahecho,'$DAY') nombrediahecho,
					to_char(b.dfechahecho , '$DD') numerodiahecho,
					to_char(b.dfechahecho , '$MM') numeromeshecho,
					to_char(b.dfechahecho , '$MONTH') nombremeshecho,
					to_char(b.dfechahecho , '$YYYY') aniohecho,
					b.thorahecho as thorahecho,
					CASE  
					 WHEN b.thorahecho BETWEEN '00:00' AND '00:59' THEN 'Rango(00:00-00:59)'
						  WHEN b.thorahecho BETWEEN '01:00' AND '01:59' THEN 'Rango(01:00-01:59)' 
						  WHEN b.thorahecho BETWEEN '02:00' AND '02:59' THEN 'Rango(02:00-02:59)' 
						  WHEN b.thorahecho BETWEEN '03:00' AND '03:59' THEN 'Rango(03:00-03:59)' 
						  WHEN b.thorahecho BETWEEN '04:00' AND '04:59' THEN 'Rango(04:00-0:59)'
						  WHEN b.thorahecho BETWEEN '05:00' AND '05:59' THEN 'Rango(05:00-05:59)'
						  WHEN b.thorahecho BETWEEN '06:00' AND '06:59' THEN 'Rango(06:00-06:59)'
						  WHEN b.thorahecho BETWEEN '07:00' AND '07:59' THEN 'Rango(07:00-07:59)' 
						  WHEN b.thorahecho BETWEEN '08:00' AND '08:59' THEN 'Rango(08:00-08:59)'
						  WHEN b.thorahecho BETWEEN '09:00' AND '09:59' THEN 'Rango(09:00-09:59)'
						  WHEN b.thorahecho BETWEEN '10:00' AND '10:59' THEN 'Rango(10:00-10:59)'
						  WHEN b.thorahecho BETWEEN '11:00' AND '11:59' THEN 'Rango(11:00-11:59)'
						  WHEN b.thorahecho BETWEEN '12:00' AND '12:59' THEN 'Rango(12:00-12:59)' 
						  WHEN b.thorahecho BETWEEN '13:00' AND '13:59' THEN 'Rango(13:00-13:59)'
						  WHEN b.thorahecho BETWEEN '14:00' AND '14:59' THEN 'Rango(14:00-14:59)' 
						  WHEN b.thorahecho BETWEEN '15:00' AND '15:59' THEN 'Rango(15:00-15:59)' 
						  WHEN b.thorahecho BETWEEN '16:00' AND '16:59' THEN 'Rango(16:00-16:59)' 
						  WHEN b.thorahecho BETWEEN '17:00' AND '17:59' THEN 'Rango(17:00-17:59)'
						  WHEN b.thorahecho BETWEEN '18:00' AND '18:59' THEN 'Rango(18:00-18:59)'
						  WHEN b.thorahecho BETWEEN '19:00' AND '19:59' THEN 'Rango(19:00-19:59)'
						  WHEN b.thorahecho BETWEEN '20:00' AND '20:59' THEN 'Rango(20:00-20:59)'
						  WHEN b.thorahecho BETWEEN '21:00' AND '21:59' THEN 'Rango(21:00-21:59)'
						  WHEN b.thorahecho BETWEEN '22:00' AND '22:59' THEN 'Rango(22:00-22:59)' 
						  WHEN b.thorahecho BETWEEN '23:00' AND '23:59' THEN 'Rango(23:00-23:59)' 

					 END as rango,
					i.cdescripcion lugarhecho,
					f.cdescripcion as delitodescripcion,
					b.cnarracionhecho as narracionhecho,
					h.cdescripcion deptohecho,
					j.cdescripcion municipiohecho,
					k.cdescripcion aldeahecho,
					concat(m.cnombres,m.capellidos) nombreofendido,
					m.iedad edadofendido,
					m.cdireccion direccionofendido,
					m.csexo sexoofendido,
					m.cgenero generoofendido,
					n.cdescripcion profesionofendido,
					o.cdescripcion ocupacionofendido,
					es.cdescripcion escolaridadofendido,
					na.cdescripcion nacionalidadofendido,
					g.cdescripcion etniafendido,
					dis.cdescripcion discapacidadofendido,
					ec.cdescripcion estadocivilofendido,
					m.cantidadhijos cantidadhijosofendido,
					m.embarazo embarazoofendido,
					m.frecuencia frecuanciaagresionofendido,
					m.trabajoremunerado,
					m.estudia estudiaofendido,
					m.intentosuicidio intentossucicidioofendido,
					m.enfermedadmental enfermedadmentalofendido,
					m.mecanismomuerte mecanismomuerteofendido,
					concat(e.cnombres,e.capellidos)nombredenunciante,
					e.iedad edaddenunciante,
					g2.cdescripcion etniaodenunciante,
					n2.cdescripcion profesiondenunciante,
					o2.cdescripcion ocupaciondenunciante,
					es2.cdescripcion escolaridaddenunciante,
					na2.cdescripcion nacionalidaddenunciante,
					g2.cdescripcion etniadenunciante,
					dis2.cdescripcion discapacidaddenunciante,
					ec2.cdescripcion estadocivildenunciante,
					bandeja.cdescripcion bandejarecepcion,
					b.cexpedientesedi expedientesedi,
					b.cexpedientejudicial expedientejudicial,
					b.cexpedientepolicial expedientepolicial,
					b.clevantamiento levantamiento,
					b.ctransito transito,
					b.cautopsia autopsia,
					concat(c.cnombres,c.capellidos) nombreimputado,
					g3.cdescripcion etniaoimputado,
					n3.cdescripcion profesionimputado,
					o3.cdescripcion ocupacionimputado,
					es3.cdescripcion escolaridadimputado,
					na3.cdescripcion nacionalidadimputado,
					g3.cdescripcion etniaimputado,
					dis3.cdescripcion discapacidadimputado,
					ec3.cdescripcion estadocivilimputado
					
					from mini_sedi.tbl_imputado_delito a,
						 mini_sedi.tbl_denuncia b,
						 mini_sedi.tbl_imputado c,
						 mini_sedi.tbl_ofendido d,
						 mini_sedi.tbl_denunciante e,
						mini_sedi.tbl_delito f,
						mini_sedi.tbl_etnia g,
						mini_sedi.tbl_departamentopais h,
						mini_sedi.tbl_clase_lugar_hecho i,
						mini_sedi.tbl_municipio j,
						mini_sedi.tbl_aldea k,
						mini_sedi.tbl_ofendido m,
						mini_sedi.tbl_profesion n,
						mini_sedi.tbl_ocupacion o,
						mini_sedi.tbl_escolaridad es,
						mini_sedi.tbl_nacionalidad na,
						mini_sedi.tbl_discapacidad dis,
						mini_sedi.tbl_estadoscivil ec,
						mini_sedi.tbl_profesion n2,
						mini_sedi.tbl_ocupacion o2,
						mini_sedi.tbl_escolaridad es2,
						mini_sedi.tbl_nacionalidad na2,
						mini_sedi.tbl_discapacidad dis2,
						mini_sedi.tbl_estadoscivil ec2,
						mini_sedi.tbl_etnia g2,
						mini_sedi.tbl_bandejas bandeja,
						mini_sedi.tbl_profesion n3,
						mini_sedi.tbl_ocupacion o3,
						mini_sedi.tbl_escolaridad es3,
						mini_sedi.tbl_nacionalidad na3,
						mini_sedi.tbl_discapacidad dis3,
						mini_sedi.tbl_estadoscivil ec3,
						mini_sedi.tbl_etnia g3
	    
	   where a.tdenunciaid=b.tdenunciaid and
		     c.tpersonaid=a.tpersonaid and
		     b.tdenunciaid=d.tdenunciaid and
		     a.tdenunciaid=d.tdenunciaid and
		     e.tdenunciaid=d.tdenunciaid and
		     a.ndelito=f.ndelitoid and
		     d.netniaid=g.netniaid and
		     b.nlugarid=i.nlugarid and 
		     b.cdeptodenuncia=h.cdepartamentoid and
		     b.cdeptohecho=h.cdepartamentoid and
		     b.cmunicipiohecho=j.cmunicipioid and
		     j.cdepartamentoid=h.cdepartamentoid and
		     b.caldeahecho=k.caldeaid and
		     k.cmunicipioid=j.cmunicipioid and 
		     k.cdepartamentoid=h.cdepartamentoid and
		     m.tdenunciaid=b.tdenunciaid and
		     m.tdenunciaid=a.tdenunciaid and
		     m.nprofesionid=n.nprofesionid and
		     m.nocupacionid=o.nocupacionid and
		     m.nescolaridadid=es.nescolaridadid and
		     m.cnacionalidadid=na.cnacionalidadid and
		     m.netniaid=g.netniaid and 
		     m.ndiscapacidadid=dis.ndiscapacidadid and
		     m.nestadocivil=ec.ncivil and


		     e.nprofesionid=n2.nprofesionid and
		     e.nocupacionid=o2.nocupacionid and
		     e.nescolaridadid=es2.nescolaridadid and
		     e.cnacionalidadid=na2.cnacionalidadid and
		     e.netniaid=g2.netniaid and 
		     e.ndiscapacidadid=dis2.ndiscapacidadid and
		     e.nestadocivil=ec2.ncivil and
		     e.netniaid=g2.netniaid and
		     bandeja.ibandejaid=b.ibandejaid and

		     c.nprofesionid=n3.nprofesionid and
		     c.nocupacionid=o3.nocupacionid and
		     c.nescolaridadid=es3.nescolaridadid and
		     c.cnacionalidadid=na3.cnacionalidadid and
		     c.netniaid=g3.netniaid and 
		     c.ndiscapacidadid=dis3.ndiscapacidadid and
		     c.nestadocivil=ec3.ncivil and
		     c.netniaid=g3.netniaid and
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
		$MM='MM';
	   
	   $sql="select a.tdenunciaid as tdenunciaid,
					concat(to_char(b.dfechadenuncia, '$DAY'),to_char(b.dfechadenuncia, '$DD'),'$coma',to_char(b.dfechadenuncia,'$MONTH'),to_char(b.dfechadenuncia, '$YYYY')) as fechadenuncia ,
					b.thoradenuncia as thoradenuncia,
					to_char(b.dfechahecho,'$DAY') nombrediahecho,
					to_char(b.dfechahecho , '$DD') numerodiahecho,
					to_char(b.dfechahecho , '$MM') numeromeshecho,
					to_char(b.dfechahecho , '$MONTH') nombremeshecho,
					to_char(b.dfechahecho , '$YYYY') aniohecho,
					b.thorahecho as thorahecho,
					CASE  
					 WHEN b.thorahecho BETWEEN '00:00' AND '00:59' THEN 'Rango(00:00-00:59)'
						  WHEN b.thorahecho BETWEEN '01:00' AND '01:59' THEN 'Rango(01:00-01:59)' 
						  WHEN b.thorahecho BETWEEN '02:00' AND '02:59' THEN 'Rango(02:00-02:59)' 
						  WHEN b.thorahecho BETWEEN '03:00' AND '03:59' THEN 'Rango(03:00-03:59)' 
						  WHEN b.thorahecho BETWEEN '04:00' AND '04:59' THEN 'Rango(04:00-0:59)'
						  WHEN b.thorahecho BETWEEN '05:00' AND '05:59' THEN 'Rango(05:00-05:59)'
						  WHEN b.thorahecho BETWEEN '06:00' AND '06:59' THEN 'Rango(06:00-06:59)'
						  WHEN b.thorahecho BETWEEN '07:00' AND '07:59' THEN 'Rango(07:00-07:59)' 
						  WHEN b.thorahecho BETWEEN '08:00' AND '08:59' THEN 'Rango(08:00-08:59)'
						  WHEN b.thorahecho BETWEEN '09:00' AND '09:59' THEN 'Rango(09:00-09:59)'
						  WHEN b.thorahecho BETWEEN '10:00' AND '10:59' THEN 'Rango(10:00-10:59)'
						  WHEN b.thorahecho BETWEEN '11:00' AND '11:59' THEN 'Rango(11:00-11:59)'
						  WHEN b.thorahecho BETWEEN '12:00' AND '12:59' THEN 'Rango(12:00-12:59)' 
						  WHEN b.thorahecho BETWEEN '13:00' AND '13:59' THEN 'Rango(13:00-13:59)'
						  WHEN b.thorahecho BETWEEN '14:00' AND '14:59' THEN 'Rango(14:00-14:59)' 
						  WHEN b.thorahecho BETWEEN '15:00' AND '15:59' THEN 'Rango(15:00-15:59)' 
						  WHEN b.thorahecho BETWEEN '16:00' AND '16:59' THEN 'Rango(16:00-16:59)' 
						  WHEN b.thorahecho BETWEEN '17:00' AND '17:59' THEN 'Rango(17:00-17:59)'
						  WHEN b.thorahecho BETWEEN '18:00' AND '18:59' THEN 'Rango(18:00-18:59)'
						  WHEN b.thorahecho BETWEEN '19:00' AND '19:59' THEN 'Rango(19:00-19:59)'
						  WHEN b.thorahecho BETWEEN '20:00' AND '20:59' THEN 'Rango(20:00-20:59)'
						  WHEN b.thorahecho BETWEEN '21:00' AND '21:59' THEN 'Rango(21:00-21:59)'
						  WHEN b.thorahecho BETWEEN '22:00' AND '22:59' THEN 'Rango(22:00-22:59)' 
						  WHEN b.thorahecho BETWEEN '23:00' AND '23:59' THEN 'Rango(23:00-23:59)' 

					 END as rango,
					i.cdescripcion lugarhecho,
					f.cdescripcion as delitodescripcion,
					b.cnarracionhecho as narracionhecho,
					h.cdescripcion deptohecho,
					j.cdescripcion municipiohecho,
					k.cdescripcion aldeahecho,
					concat(m.cnombres,m.capellidos) nombreofendido,
					m.iedad edadofendido,
					m.cdireccion direccionofendido,
					m.csexo sexoofendido,
					m.cgenero generoofendido,
					n.cdescripcion profesionofendido,
					o.cdescripcion ocupacionofendido,
					es.cdescripcion escolaridadofendido,
					na.cdescripcion nacionalidadofendido,
					g.cdescripcion etniafendido,
					dis.cdescripcion discapacidadofendido,
					ec.cdescripcion estadocivilofendido,
					m.cantidadhijos cantidadhijosofendido,
					m.embarazo embarazoofendido,
					m.frecuencia frecuanciaagresionofendido,
					m.trabajoremunerado,
					m.estudia estudiaofendido,
					m.intentosuicidio intentossucicidioofendido,
					m.enfermedadmental enfermedadmentalofendido,
					m.mecanismomuerte mecanismomuerteofendido,
					concat(e.cnombres,e.capellidos)nombredenunciante,
					e.iedad edaddenunciante,
					g2.cdescripcion etniaodenunciante,
					n2.cdescripcion profesiondenunciante,
					o2.cdescripcion ocupaciondenunciante,
					es2.cdescripcion escolaridaddenunciante,
					na2.cdescripcion nacionalidaddenunciante,
					g2.cdescripcion etniadenunciante,
					dis2.cdescripcion discapacidaddenunciante,
					ec2.cdescripcion estadocivildenunciante,
					bandeja.cdescripcion bandejarecepcion,
					b.cexpedientesedi expedientesedi,
					b.cexpedientejudicial expedientejudicial,
					b.cexpedientepolicial expedientepolicial,
					b.clevantamiento levantamiento,
					b.ctransito transito,
					b.cautopsia autopsia,
					concat(c.cnombres,c.capellidos) nombreimputado,
					g3.cdescripcion etniaoimputado,
					n3.cdescripcion profesionimputado,
					o3.cdescripcion ocupacionimputado,
					es3.cdescripcion escolaridadimputado,
					na3.cdescripcion nacionalidadimputado,
					g3.cdescripcion etniaimputado,
					dis3.cdescripcion discapacidadimputado,
					ec3.cdescripcion estadocivilimputado
					
					from mini_sedi.tbl_imputado_delito a,
						 mini_sedi.tbl_denuncia b,
						 mini_sedi.tbl_imputado c,
						 mini_sedi.tbl_ofendido d,
						 mini_sedi.tbl_denunciante e,
						mini_sedi.tbl_delito f,
						mini_sedi.tbl_etnia g,
						mini_sedi.tbl_departamentopais h,
						mini_sedi.tbl_clase_lugar_hecho i,
						mini_sedi.tbl_municipio j,
						mini_sedi.tbl_aldea k,
						mini_sedi.tbl_ofendido m,
						mini_sedi.tbl_profesion n,
						mini_sedi.tbl_ocupacion o,
						mini_sedi.tbl_escolaridad es,
						mini_sedi.tbl_nacionalidad na,
						mini_sedi.tbl_discapacidad dis,
						mini_sedi.tbl_estadoscivil ec,
						mini_sedi.tbl_profesion n2,
						mini_sedi.tbl_ocupacion o2,
						mini_sedi.tbl_escolaridad es2,
						mini_sedi.tbl_nacionalidad na2,
						mini_sedi.tbl_discapacidad dis2,
						mini_sedi.tbl_estadoscivil ec2,
						mini_sedi.tbl_etnia g2,
						mini_sedi.tbl_bandejas bandeja,
						mini_sedi.tbl_profesion n3,
						mini_sedi.tbl_ocupacion o3,
						mini_sedi.tbl_escolaridad es3,
						mini_sedi.tbl_nacionalidad na3,
						mini_sedi.tbl_discapacidad dis3,
						mini_sedi.tbl_estadoscivil ec3,
						mini_sedi.tbl_etnia g3
	    
	   where a.tdenunciaid=b.tdenunciaid and
		     c.tpersonaid=a.tpersonaid and
		     b.tdenunciaid=d.tdenunciaid and
		     a.tdenunciaid=d.tdenunciaid and
		     e.tdenunciaid=d.tdenunciaid and
		     a.ndelito=f.ndelitoid and
		     d.netniaid=g.netniaid and
		     b.nlugarid=i.nlugarid and 
		     b.cdeptodenuncia=h.cdepartamentoid and
		     b.cdeptohecho=h.cdepartamentoid and
		     b.cmunicipiohecho=j.cmunicipioid and
		     j.cdepartamentoid=h.cdepartamentoid and
		     b.caldeahecho=k.caldeaid and
		     k.cmunicipioid=j.cmunicipioid and 
		     k.cdepartamentoid=h.cdepartamentoid and
		     m.tdenunciaid=b.tdenunciaid and
		     m.tdenunciaid=a.tdenunciaid and
		     m.nprofesionid=n.nprofesionid and
		     m.nocupacionid=o.nocupacionid and
		     m.nescolaridadid=es.nescolaridadid and
		     m.cnacionalidadid=na.cnacionalidadid and
		     m.netniaid=g.netniaid and 
		     m.ndiscapacidadid=dis.ndiscapacidadid and
		     m.nestadocivil=ec.ncivil and


		     e.nprofesionid=n2.nprofesionid and
		     e.nocupacionid=o2.nocupacionid and
		     e.nescolaridadid=es2.nescolaridadid and
		     e.cnacionalidadid=na2.cnacionalidadid and
		     e.netniaid=g2.netniaid and 
		     e.ndiscapacidadid=dis2.ndiscapacidadid and
		     e.nestadocivil=ec2.ncivil and
		     e.netniaid=g2.netniaid and
		     bandeja.ibandejaid=b.ibandejaid and

		     c.nprofesionid=n3.nprofesionid and
		     c.nocupacionid=o3.nocupacionid and
		     c.nescolaridadid=es3.nescolaridadid and
		     c.cnacionalidadid=na3.cnacionalidadid and
		     c.netniaid=g3.netniaid and 
		     c.ndiscapacidadid=dis3.ndiscapacidadid and
		     c.nestadocivil=ec3.ncivil and
		     c.netniaid=g3.netniaid and
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

public static function FrecuenciaDenRecibidas()
	//agregar usuario de seron
    {
        $sql="select UPPER(c.cdescripcion) cdescripcion,
				count(*) totaldelito,
				count(CASE   WHEN (b.cgenero='m') THEN 1 END ) totalhombres,
				count(CASE   WHEN (b.cgenero='f') THEN 1 END ) totalmujeres ,
				count(CASE   WHEN (b.cgenero='x') THEN 1 END ) noconsignado ,
				count(CASE   WHEN (b.iedad>=0 and b.iedad<5 ) THEN 1 END ) edad_0_4 ,
				count(CASE   WHEN (b.iedad>=5 and b.iedad<10 ) THEN 1 END ) edad_5_9,
				count(CASE   WHEN (b.iedad>=10 and b.iedad<15 ) THEN 1 END ) edad_10_14,
				count(CASE   WHEN (b.iedad>=15 and b.iedad<20 ) THEN 1 END ) edad_15_19,
				count(CASE   WHEN (b.iedad>=20 and b.iedad<25 ) THEN 1 END ) edad_20_24,
				count(CASE   WHEN (b.iedad>=25 and b.iedad<30 ) THEN 1 END ) edad_25_29,
				count(CASE   WHEN (b.iedad>=30 and b.iedad<35 ) THEN 1 END ) edad_30_34,
				count(CASE   WHEN (b.iedad>=35 and b.iedad<40 ) THEN 1 END ) edad_35_39,
				count(CASE   WHEN (b.iedad>=40 and b.iedad<45 ) THEN 1 END ) edad_40_44,
				count(CASE   WHEN (b.iedad>=45 and b.iedad<50 ) THEN 1 END ) edad45_49,
				count(CASE   WHEN (b.iedad>=50 and b.iedad<55 ) THEN 1 END ) edad_50_54,
				count(CASE   WHEN (b.iedad>=55 and b.iedad<60 ) THEN 1 END ) edad_55_59,
				count(CASE   WHEN (b.iedad>=60 and b.iedad<65 ) THEN 1 END ) edad_60_64,
				count(CASE   WHEN (b.iedad>=65 and b.iedad<70 ) THEN 1 END ) edad_65_69,
				count(CASE   WHEN (b.iedad>=70 and b.iedad<75 ) THEN 1 END ) edad_70_74,
				count(CASE  WHEN  (b.iedad>=75 and b.iedad<80 ) THEN 1 END ) edad_75_79,
				count(CASE   WHEN (b.iedad>=80) THEN 1 END ) edad_80mas
				from mini_sedi.tbl_imputado_delito a,
						mini_sedi.tbl_imputado b,
						mini_sedi.tbl_delito c
			where a.tpersonaid=b.tpersonaid and
				a.ndelito=c.ndelitoid 
			group by c.cdescripcion 
			order by totaldelito desc";
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaDenRecibidasNcant($limite=null,$orden=null)
    {
		
		if($orden==1){
			 $sql="select UPPER(c.cdescripcion) cdescripcion,
				count(*) totaldelito,
				count(CASE   WHEN (b.cgenero='m') THEN 1 END ) totalhombres,
				count(CASE   WHEN (b.cgenero='f') THEN 1 END ) totalmujeres ,
				count(CASE   WHEN (b.cgenero='x') THEN 1 END ) noconsignado ,
				count(CASE   WHEN (b.iedad>=0 and b.iedad<5 ) THEN 1 END ) edad_0_4 ,
				count(CASE   WHEN (b.iedad>=5 and b.iedad<10 ) THEN 1 END ) edad_5_9,
				count(CASE   WHEN (b.iedad>=10 and b.iedad<15 ) THEN 1 END ) edad_10_14,
				count(CASE   WHEN (b.iedad>=15 and b.iedad<20 ) THEN 1 END ) edad_15_19,
				count(CASE   WHEN (b.iedad>=20 and b.iedad<25 ) THEN 1 END ) edad_20_24,
				count(CASE   WHEN (b.iedad>=25 and b.iedad<30 ) THEN 1 END ) edad_25_29,
				count(CASE   WHEN (b.iedad>=30 and b.iedad<35 ) THEN 1 END ) edad_30_34,
				count(CASE   WHEN (b.iedad>=35 and b.iedad<40 ) THEN 1 END ) edad_35_39,
				count(CASE   WHEN (b.iedad>=40 and b.iedad<45 ) THEN 1 END ) edad_40_44,
				count(CASE   WHEN (b.iedad>=45 and b.iedad<50 ) THEN 1 END ) edad45_49,
				count(CASE   WHEN (b.iedad>=50 and b.iedad<55 ) THEN 1 END ) edad_50_54,
				count(CASE   WHEN (b.iedad>=55 and b.iedad<60 ) THEN 1 END ) edad_55_59,
				count(CASE   WHEN (b.iedad>=60 and b.iedad<65 ) THEN 1 END ) edad_60_64,
				count(CASE   WHEN (b.iedad>=65 and b.iedad<70 ) THEN 1 END ) edad_65_69,
				count(CASE   WHEN (b.iedad>=70 and b.iedad<75 ) THEN 1 END ) edad_70_74,
				count(CASE  WHEN  (b.iedad>=75 and b.iedad<80 ) THEN 1 END ) edad_75_79,
				count(CASE   WHEN (b.iedad>=80) THEN 1 END ) edad_80mas
				from mini_sedi.tbl_imputado_delito a,
						mini_sedi.tbl_imputado b,
						mini_sedi.tbl_delito c
			where a.tpersonaid=b.tpersonaid and
				a.ndelito=c.ndelitoid 
			group by c.cdescripcion 
			order by totaldelito desc limit '$limite'";
			
		}
		else{
			 $sql="select UPPER(c.cdescripcion) cdescripcion,
				count(*) totaldelito,
				count(CASE   WHEN (b.cgenero='m') THEN 1 END ) totalhombres,
				count(CASE   WHEN (b.cgenero='f') THEN 1 END ) totalmujeres ,
				count(CASE   WHEN (b.cgenero='x') THEN 1 END ) noconsignado ,
				count(CASE   WHEN (b.iedad>=0 and b.iedad<5 ) THEN 1 END ) edad_0_4 ,
				count(CASE   WHEN (b.iedad>=5 and b.iedad<10 ) THEN 1 END ) edad_5_9,
				count(CASE   WHEN (b.iedad>=10 and b.iedad<15 ) THEN 1 END ) edad_10_14,
				count(CASE   WHEN (b.iedad>=15 and b.iedad<20 ) THEN 1 END ) edad_15_19,
				count(CASE   WHEN (b.iedad>=20 and b.iedad<25 ) THEN 1 END ) edad_20_24,
				count(CASE   WHEN (b.iedad>=25 and b.iedad<30 ) THEN 1 END ) edad_25_29,
				count(CASE   WHEN (b.iedad>=30 and b.iedad<35 ) THEN 1 END ) edad_30_34,
				count(CASE   WHEN (b.iedad>=35 and b.iedad<40 ) THEN 1 END ) edad_35_39,
				count(CASE   WHEN (b.iedad>=40 and b.iedad<45 ) THEN 1 END ) edad_40_44,
				count(CASE   WHEN (b.iedad>=45 and b.iedad<50 ) THEN 1 END ) edad45_49,
				count(CASE   WHEN (b.iedad>=50 and b.iedad<55 ) THEN 1 END ) edad_50_54,
				count(CASE   WHEN (b.iedad>=55 and b.iedad<60 ) THEN 1 END ) edad_55_59,
				count(CASE   WHEN (b.iedad>=60 and b.iedad<65 ) THEN 1 END ) edad_60_64,
				count(CASE   WHEN (b.iedad>=65 and b.iedad<70 ) THEN 1 END ) edad_65_69,
				count(CASE   WHEN (b.iedad>=70 and b.iedad<75 ) THEN 1 END ) edad_70_74,
				count(CASE  WHEN  (b.iedad>=75 and b.iedad<80 ) THEN 1 END ) edad_75_79,
				count(CASE   WHEN (b.iedad>=80) THEN 1 END ) edad_80mas
				from mini_sedi.tbl_imputado_delito a,
						mini_sedi.tbl_imputado b,
						mini_sedi.tbl_delito c
			where a.tpersonaid=b.tpersonaid and
				a.ndelito=c.ndelitoid 
			group by c.cdescripcion 
			order by totaldelito asc limit '$limite'";
			
		}
       
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaDenDepto()
    {
		
		$sql="select UPPER(c.cdescripcion) cdescripcion,
			   count(*) totaldenuncia,
			   d.cdescripcion cdescripciondepto,
				  
			      count(CASE   WHEN (to_char(dfechahecho,'MM')='01') THEN 1 END ) enero,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='02') THEN 1 END ) febrero,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='03') THEN 1 END ) marzo,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='04') THEN 1 END ) abril,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='05') THEN 1 END ) mayo,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='06') THEN 1 END ) junio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='08') THEN 1 END ) agosto,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='09') THEN 1 END ) septiembre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='10') THEN 1 END ) octubre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='11') THEN 1 END ) noviembre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='12') THEN 1 END ) diciembre
				  
				from mini_sedi.tbl_denuncia a,
				mini_sedi.tbl_imputado_delito b,
				mini_sedi.tbl_delito c,
				mini_sedi.tbl_departamentopais d 
				
			   where a.tdenunciaid=b.tdenunciaid and
					 c.ndelitoid=b.ndelito and
					 a.cdeptodenuncia=d.cdepartamentoid  					      
				group by c.cdescripcion ,d.cdescripcion";
			


       
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaDenDeptoNcant($limite=null,$orden=null)
    {
		
		if($orden==1){
			 $sql="select UPPER(c.cdescripcion) cdescripcion,
			   count(*) totaldenuncia,
			   d.cdescripcion cdescripciondepto,
				 
			      count(CASE   WHEN (to_char(dfechahecho,'MM')='01') THEN 1 END ) enero,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='02') THEN 1 END ) febrero,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='03') THEN 1 END ) marzo,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='04') THEN 1 END ) abril,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='05') THEN 1 END ) mayo,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='06') THEN 1 END ) junio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='08') THEN 1 END ) agosto,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='09') THEN 1 END ) septiembre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='10') THEN 1 END ) octubre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='11') THEN 1 END ) noviembre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='12') THEN 1 END ) diciembre
				  
				from mini_sedi.tbl_denuncia a,
				mini_sedi.tbl_imputado_delito b,
				mini_sedi.tbl_delito c,
				mini_sedi.tbl_departamentopais d 
				
			   where a.tdenunciaid=b.tdenunciaid and
					 c.ndelitoid=b.ndelito and
					 a.cdeptodenuncia=d.cdepartamentoid  					      
				group by c.cdescripcion ,d.cdescripcion
			order by totaldenuncia desc limit '$limite'";
			
		}
		else{
			 $sql="select UPPER(c.cdescripcion) cdescripcion,
			   count(*) totaldenuncia,
			   d.cdescripcion cdescripciondepto,
				  count(d.cdescripcion) totaldepto,
			      count(CASE   WHEN (to_char(dfechahecho,'MM')='01') THEN 1 END ) enero,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='02') THEN 1 END ) febrero,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='03') THEN 1 END ) marzo,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='04') THEN 1 END ) abril,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='05') THEN 1 END ) mayo,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='06') THEN 1 END ) junio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='08') THEN 1 END ) agosto,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='09') THEN 1 END ) septiembre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='10') THEN 1 END ) octubre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='11') THEN 1 END ) noviembre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='12') THEN 1 END ) diciembre
				  
				from mini_sedi.tbl_denuncia a,
				mini_sedi.tbl_imputado_delito b,
				mini_sedi.tbl_delito c,
				mini_sedi.tbl_departamentopais d 
				
			   where a.tdenunciaid=b.tdenunciaid and
					 c.ndelitoid=b.ndelito and
					 a.cdeptodenuncia=d.cdepartamentoid  					      
				group by c.cdescripcion ,d.cdescripcion
			order by totaldenuncia  asc limit '$limite'";
			
		}
       
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaDenDeptoAnios($anio=null)
    {
	
			 $sql="select UPPER(c.cdescripcion) cdescripcion,
			   count(*) totaldenuncia,
			   d.cdescripcion cdescripciondepto,
				 
			      count(CASE   WHEN (to_char(dfechahecho,'MM')='01') THEN 1 END ) enero,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='02') THEN 1 END ) febrero,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='03') THEN 1 END ) marzo,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='04') THEN 1 END ) abril,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='05') THEN 1 END ) mayo,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='06') THEN 1 END ) junio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='08') THEN 1 END ) agosto,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='09') THEN 1 END ) septiembre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='10') THEN 1 END ) octubre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='11') THEN 1 END ) noviembre,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='12') THEN 1 END ) diciembre
				  
				from mini_sedi.tbl_denuncia a,
				mini_sedi.tbl_imputado_delito b,
				mini_sedi.tbl_delito c,
				mini_sedi.tbl_departamentopais d 
				
			   where a.tdenunciaid=b.tdenunciaid and
					 c.ndelitoid=b.ndelito and
					 a.cdeptodenuncia=d.cdepartamentoid  
					 and to_char(a.dfechadenuncia,'YYYY')='$anio'
				group by c.cdescripcion ,d.cdescripcion
			order by totaldenuncia desc ";
			
		
	
       
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function aniosdenunciasreportes()
    {
		
			 $sql="select distinct  to_char(dfechadenuncia,'YYYY') anios from mini_sedi.tbl_denuncia 
					order by anios desc";
			
		
		
       
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
		public static function FrecuenciaDenDeptoDia()
    {
			 $sql="select UPPER(c.cdescripcion) cdescripcion,
					  to_char(dfechahecho,'DAY') dia,
					  count(*) totaldenuncia,
					  count(to_char(dfechahecho,'DAY')) diatotal,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='01') THEN 1 END ) enero,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='02') THEN 1 END ) febrero,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='03') THEN 1 END ) marzo,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='04') THEN 1 END ) abril,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='05') THEN 1 END ) mayo,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='06') THEN 1 END ) junio,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='08') THEN 1 END ) agosto,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='09') THEN 1 END ) septiembre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='10') THEN 1 END ) octubre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='11') THEN 1 END ) noviembre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='12') THEN 1 END ) diciembre
					  
					   from mini_sedi.tbl_denuncia a,
						mini_sedi.tbl_imputado_delito b,
						mini_sedi.tbl_delito c
				   
				      where a.tdenunciaid=b.tdenunciaid and
						    c.ndelitoid=b.ndelito
							
					group by  cdescripcion,dia
					order by totaldenuncia ";
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaDenDeptoDiaNdelitos($limite=null,$orden=null)
    {
		
		if($orden==1){
			$sql="select UPPER(c.cdescripcion) cdescripcion,
					  to_char(dfechahecho,'DAY') dia,
					  count(*) totaldenuncia,
					  count(to_char(dfechahecho,'DAY')) diatotal,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='01') THEN 1 END ) enero,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='02') THEN 1 END ) febrero,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='03') THEN 1 END ) marzo,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='04') THEN 1 END ) abril,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='05') THEN 1 END ) mayo,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='06') THEN 1 END ) junio,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='08') THEN 1 END ) agosto,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='09') THEN 1 END ) septiembre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='10') THEN 1 END ) octubre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='11') THEN 1 END ) noviembre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='12') THEN 1 END ) diciembre
					  
					   from mini_sedi.tbl_denuncia a,
						mini_sedi.tbl_imputado_delito b,
						mini_sedi.tbl_delito c
				   
				      where a.tdenunciaid=b.tdenunciaid and
						    c.ndelitoid=b.ndelito 						
							
							
					group by  cdescripcion,dia
					order by totaldenuncia desc limit '$limite'";
			
		}
		else{
			$sql="select UPPER(c.cdescripcion) cdescripcion,
					  to_char(dfechahecho,'DAY') dia,
					  count(*) totaldenuncia,
					  count(to_char(dfechahecho,'DAY')) diatotal,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='01') THEN 1 END ) enero,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='02') THEN 1 END ) febrero,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='03') THEN 1 END ) marzo,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='04') THEN 1 END ) abril,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='05') THEN 1 END ) mayo,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='06') THEN 1 END ) junio,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='08') THEN 1 END ) agosto,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='09') THEN 1 END ) septiembre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='10') THEN 1 END ) octubre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='11') THEN 1 END ) noviembre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='12') THEN 1 END ) diciembre
					  
					   from mini_sedi.tbl_denuncia a,
						mini_sedi.tbl_imputado_delito b,
						mini_sedi.tbl_delito c
				   
				      where a.tdenunciaid=b.tdenunciaid and
						    c.ndelitoid=b.ndelito 						
							
					group by  cdescripcion,dia
					order by totaldenuncia asc limit '$limite'";
			
		}
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaDenDeptoDiaAnio($anio=null)
    {
		
			$sql="select UPPER(c.cdescripcion) cdescripcion,
					  to_char(dfechahecho,'DAY') dia,
					  count(*) totaldenuncia,
					  count(to_char(dfechahecho,'DAY')) diatotal,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='01') THEN 1 END ) enero,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='02') THEN 1 END ) febrero,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='03') THEN 1 END ) marzo,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='04') THEN 1 END ) abril,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='05') THEN 1 END ) mayo,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='06') THEN 1 END ) junio,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='08') THEN 1 END ) agosto,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='09') THEN 1 END ) septiembre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='10') THEN 1 END ) octubre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='11') THEN 1 END ) noviembre,
					  count(CASE   WHEN (to_char(dfechahecho,'MM')='12') THEN 1 END ) diciembre
					  
					   from mini_sedi.tbl_denuncia a,
						mini_sedi.tbl_imputado_delito b,
						mini_sedi.tbl_delito c
				   
				      where a.tdenunciaid=b.tdenunciaid and
						    c.ndelitoid=b.ndelito 
							and to_char(a.dfechadenuncia,'YYYY')='$anio'	
							
					group by  cdescripcion,dia
					order by totaldenuncia asc";
			
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaImputado()
    {
		
			$sql="select d.cdescripcion cdescripcion,
				   count(*) totaldelito,
				   count(CASE   WHEN (a.cgenero='m') THEN 1 END ) totalhombres,
				   count(CASE   WHEN (a.cgenero='f') THEN 1 END ) totalmujeres ,
				   count(CASE   WHEN (a.cgenero='x') THEN 1 END ) noconsignado ,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='01') THEN 1 END ) enero,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='02') THEN 1 END ) febrero,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='03') THEN 1 END ) marzo,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='04') THEN 1 END ) abril,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='05') THEN 1 END ) mayo,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='06') THEN 1 END ) junio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='08') THEN 1 END ) agosto,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='09') THEN 1 END ) septiembre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='10') THEN 1 END ) octubre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='11') THEN 1 END ) noviembre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='12') THEN 1 END ) diciembre
				  
						from mini_sedi.tbl_imputado a,
						mini_sedi.tbl_imputado_delito b,
						mini_sedi.tbl_denuncia c,
						mini_sedi.tbl_delito d
					 
					where a.tpersonaid=b.tpersonaid and
						  b.tdenunciaid=c.tdenunciaid and 
						  c.tdenunciaid=a.tdenunciaid and
						  b.ndelito=d.ndelitoid
					group by d.cdescripcion";
			
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }

	
	
	public static function FrecuenciaImputadoLimite($limite=null,$orden=null)
    {
		if($orden==1){
			$sql="select d.cdescripcion cdescripcion,
				   count(*) totaldelito,
				   count(CASE   WHEN (a.cgenero='m') THEN 1 END ) totalhombres,
				   count(CASE   WHEN (a.cgenero='f') THEN 1 END ) totalmujeres ,
				   count(CASE   WHEN (a.cgenero='x') THEN 1 END ) noconsignado ,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='01') THEN 1 END ) enero,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='02') THEN 1 END ) febrero,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='03') THEN 1 END ) marzo,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='04') THEN 1 END ) abril,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='05') THEN 1 END ) mayo,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='06') THEN 1 END ) junio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='08') THEN 1 END ) agosto,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='09') THEN 1 END ) septiembre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='10') THEN 1 END ) octubre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='11') THEN 1 END ) noviembre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='12') THEN 1 END ) diciembre
				  
						from mini_sedi.tbl_imputado a,
						mini_sedi.tbl_imputado_delito b,
						mini_sedi.tbl_denuncia c,
						mini_sedi.tbl_delito d
					 
					where a.tpersonaid=b.tpersonaid and
						  b.tdenunciaid=c.tdenunciaid and 
						  c.tdenunciaid=a.tdenunciaid and
						  b.ndelito=d.ndelitoid
					group by cdescripcion
					order by totaldelito desc limit '$limite'";
			
			
		}
		else{
			$sql="select d.cdescripcion cdescripcion,
				   count(*) totaldelito,
				   count(CASE   WHEN (a.cgenero='m') THEN 1 END ) totalhombres,
				   count(CASE   WHEN (a.cgenero='f') THEN 1 END ) totalmujeres ,
				   count(CASE   WHEN (a.cgenero='x') THEN 1 END ) noconsignado ,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='01') THEN 1 END ) enero,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='02') THEN 1 END ) febrero,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='03') THEN 1 END ) marzo,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='04') THEN 1 END ) abril,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='05') THEN 1 END ) mayo,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='06') THEN 1 END ) junio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='08') THEN 1 END ) agosto,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='09') THEN 1 END ) septiembre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='10') THEN 1 END ) octubre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='11') THEN 1 END ) noviembre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='12') THEN 1 END ) diciembre
				  
						from mini_sedi.tbl_imputado a,
						mini_sedi.tbl_imputado_delito b,
						mini_sedi.tbl_denuncia c,
						mini_sedi.tbl_delito d
					 
					where a.tpersonaid=b.tpersonaid and
						  b.tdenunciaid=c.tdenunciaid and 
						  c.tdenunciaid=a.tdenunciaid and
						  b.ndelito=d.ndelitoid
					group by cdescripcion
						order by totaldelito asc limit '$limite'";
			
			
		}			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaImputadoAnio($anio=null)
    {
		
			$sql="select d.cdescripcion cdescripcion,
				   count(*) totaldelito,
				   count(CASE   WHEN (a.cgenero='m') THEN 1 END ) totalhombres,
				   count(CASE   WHEN (a.cgenero='f') THEN 1 END ) totalmujeres ,
				   count(CASE   WHEN (a.cgenero='x') THEN 1 END ) noconsignado ,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='01') THEN 1 END ) enero,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='02') THEN 1 END ) febrero,
				   count(CASE   WHEN (to_char(c.dfechahecho,'MM')='03') THEN 1 END ) marzo,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='04') THEN 1 END ) abril,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='05') THEN 1 END ) mayo,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='06') THEN 1 END ) junio,
				  count(CASE   WHEN (to_char(dfechahecho,'MM')='07') THEN 1 END ) julio,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='08') THEN 1 END ) agosto,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='09') THEN 1 END ) septiembre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='10') THEN 1 END ) octubre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='11') THEN 1 END ) noviembre,
				  count(CASE   WHEN (to_char(c.dfechahecho,'MM')='12') THEN 1 END ) diciembre
				  
						from mini_sedi.tbl_imputado a,
						mini_sedi.tbl_imputado_delito b,
						mini_sedi.tbl_denuncia c,
						mini_sedi.tbl_delito d
					 
					where a.tpersonaid=b.tpersonaid and
						  b.tdenunciaid=c.tdenunciaid and 
						  c.tdenunciaid=a.tdenunciaid and
						  b.ndelito=d.ndelitoid 
						  and to_char(c.dfechadenuncia,'YYYY')='$anio'
						  
					group by cdescripcion
					order by totaldelito desc ";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function FrecuenciaGestionResolucion()
    {
		
			$sql="select b.cdescripcion actividad, count(b.nactividadid) totalactividad
					from mini_sedi.tbl_imputado_actividad_delito a,
						 mini_sedi.tbl_actividad b,
						 mini_sedi.tbl_denuncia c
					
					where a.nactividadid=b.nactividadid and
						  a.tdenunciaid=c.tdenunciaid	

					group by b.cdescripcion ";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
		public static function FrecuenciaGestionResolucionAnio($anio)
    {
		
			$sql="select b.cdescripcion actividad, count(b.nactividadid) totalactividad
					from mini_sedi.tbl_imputado_actividad_delito a,
						 mini_sedi.tbl_actividad b,
						 mini_sedi.tbl_denuncia c
					
					where a.nactividadid=b.nactividadid and
						  a.tdenunciaid=c.tdenunciaid	and	to_char(c.dfechadenuncia,'YYYY')='$anio'

					group by b.cdescripcion ";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	
	public static function Frecuenciaetapas()
    {
		
			$sql="select b.cdescripcion etapas, count(b.nactividadid) totaletapas
					from mini_sedi.tbl_imputado_actividad_delito a,
						 mini_sedi.tbl_actividad b,
						 mini_sedi.tbl_denuncia c
					
					where a.nactividadid=b.nactividadid and
						  a.tdenunciaid=c.tdenunciaid

					group by b.cdescripcion ";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function Frecuenciaetapasanio($anio)
    {
		
			$sql="select b.cdescripcion etapas, count(b.nactividadid) totaletapas
					from mini_sedi.tbl_imputado_actividad_delito a,
						 mini_sedi.tbl_actividad b,
						 mini_sedi.tbl_denuncia c
					
					where a.nactividadid=b.nactividadid and
						  a.tdenunciaid=c.tdenunciaid	and	to_char(c.dfechadenuncia,'YYYY')='$anio'

					group by b.cdescripcion ";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
		public static function Frecuenciasubetapas()
    {
		
			$sql="select b.cdescripcion subetapas, count(b.nactividadid) totalsubetapas
					from mini_sedi.tbl_imputado_actividad_delito a,
						 mini_sedi.tbl_actividad b,
						 mini_sedi.tbl_denuncia c
					
					where a.nactividadid=b.nactividadid and
						  a.tdenunciaid=c.tdenunciaid	

					group by b.cdescripcion ";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function Frecuenciasubetapasanio($anio)
    {
		
			$sql="select b.cdescripcion subetapas, count(b.nactividadid) totalsubetapas
					from mini_sedi.tbl_imputado_actividad_delito a,
						 mini_sedi.tbl_actividad b,
						 mini_sedi.tbl_denuncia c
					
					where a.nactividadid=b.nactividadid and
						  a.tdenunciaid=c.tdenunciaid	and	to_char(c.dfechadenuncia,'YYYY')='$anio'

					group by b.cdescripcion ";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
	public static function VaciadoGestionFiscal($usuario)
    {
		
			$sql="select  mini_sedi.tbl_imputado_actividad_delito.tpersonaid personaid,
					mini_sedi.tbl_bandejas.cdescripcion fiscalia,
					mini_sedi.tbl_subbandejas.cdescripcion unidad,
					mini_sedi.tbl_etapa.cdescripcion etapa,
					mini_sedi.tbl_subetapa.cdescripcion subetapa,
					mini_sedi.tbl_actividad.cdescripcion gestionresolucion,
					concat(mini_sedi.tbl_imputado.cnombres,mini_sedi.tbl_imputado.capellidos)nombreimputado,
					mini_sedi.tbl_imputado.tdenunciaid nrodenuncia,
					mini_sedi.tbl_denuncia.thoradenuncia horagestion
					from mini_sedi.tbl_imputado_actividad_delito 
					left join  mini_sedi.tbl_etapa on mini_sedi.tbl_imputado_actividad_delito.netapa=mini_sedi.tbl_etapa.netapaid
					left join  mini_sedi.tbl_subetapa  on mini_sedi.tbl_imputado_actividad_delito.nactividadid2=mini_sedi.tbl_subetapa.nsubetapaid
					left join  mini_sedi.tbl_actividad on mini_sedi.tbl_imputado_actividad_delito.nactividadid=mini_sedi.tbl_actividad.nactividadid
					left join mini_sedi.tbl_imputado_delito on mini_sedi.tbl_imputado_actividad_delito.tpersonaid=mini_sedi.tbl_imputado_delito.tpersonaid 
					left join  mini_sedi.tbl_imputado on mini_sedi.tbl_imputado.tpersonaid=mini_sedi.tbl_imputado_delito.tpersonaid     
					left join mini_sedi.tbl_denuncia on mini_sedi.tbl_denuncia.tdenunciaid=mini_sedi.tbl_imputado.tdenunciaid
					left join  mini_sedi.tbl_bandejas on mini_sedi.tbl_denuncia.ibandejaid=mini_sedi.tbl_bandejas.ibandejaid
					left join mini_sedi.tbl_subbandejas on mini_sedi.tbl_subbandejas.ibandejaid=mini_sedi.tbl_bandejas.ibandejaid
					where mini_sedi.tbl_imputado_actividad_delito.cfiscalid=(select u.identidad from 
											mini_sedi.tbl_usuarios u where u.usuario='$usuario'
											and mini_sedi.tbl_imputado_actividad_delito.cfiscalid=u.identidad)";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
	
		public static function VaciadoGestionFiscalFechas($usuario,$fechainicio,$fechafinal)
    {
		
			$sql="select  mini_sedi.tbl_imputado_actividad_delito.tpersonaid personaid,
					mini_sedi.tbl_bandejas.cdescripcion fiscalia,
					mini_sedi.tbl_subbandejas.cdescripcion unidad,
					mini_sedi.tbl_etapa.cdescripcion etapa,
					mini_sedi.tbl_subetapa.cdescripcion subetapa,
					mini_sedi.tbl_actividad.cdescripcion gestionresolucion,
					concat(mini_sedi.tbl_imputado.cnombres,mini_sedi.tbl_imputado.capellidos)nombreimputado,
					mini_sedi.tbl_imputado.tdenunciaid nrodenuncia,
					mini_sedi.tbl_denuncia.thoradenuncia horagestion
					from mini_sedi.tbl_imputado_actividad_delito 
					left join  mini_sedi.tbl_etapa on mini_sedi.tbl_imputado_actividad_delito.netapa=mini_sedi.tbl_etapa.netapaid
					left join  mini_sedi.tbl_subetapa  on mini_sedi.tbl_imputado_actividad_delito.nactividadid2=mini_sedi.tbl_subetapa.nsubetapaid
					left join  mini_sedi.tbl_actividad on mini_sedi.tbl_imputado_actividad_delito.nactividadid=mini_sedi.tbl_actividad.nactividadid
					left join mini_sedi.tbl_imputado_delito on mini_sedi.tbl_imputado_actividad_delito.tpersonaid=mini_sedi.tbl_imputado_delito.tpersonaid 
					left join  mini_sedi.tbl_imputado on mini_sedi.tbl_imputado.tpersonaid=mini_sedi.tbl_imputado_delito.tpersonaid     
					left join mini_sedi.tbl_denuncia on mini_sedi.tbl_denuncia.tdenunciaid=mini_sedi.tbl_imputado.tdenunciaid
					left join  mini_sedi.tbl_bandejas on mini_sedi.tbl_denuncia.ibandejaid=mini_sedi.tbl_bandejas.ibandejaid
					left join mini_sedi.tbl_subbandejas on mini_sedi.tbl_subbandejas.ibandejaid=mini_sedi.tbl_bandejas.ibandejaid

					where mini_sedi.tbl_imputado_actividad_delito.cfiscalid=(select u.identidad from 
											mini_sedi.tbl_usuarios u where u.usuario='$usuario'
											and mini_sedi.tbl_imputado_actividad_delito.cfiscalid=u.identidad)
					and 
					mini_sedi.tbl_denuncia.dfechadenuncia BETWEEN '$fechainicio' AND '$fechafinal'";
			
			
		
			 
			$result = new Reportes();
			return new Resultset(null, $result, $result->getReadConnection()->query($sql));
    }
}
