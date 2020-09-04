/*
se agregó campo crol, para conocer el rol del usuario y facilitar
las tareas de administración de usuario
*/
begin transaction;

update tbl_usuarios set crol = 'fiscal'
where usuario in (select usuario
		from tbl_usr_rol
		where rolid in (select rolid from tbl_rol_tarea where tarea= 5));

update tbl_usuarios set crol = 'receptor'
where usuario in (select usuario
		from tbl_usr_rol
		where rolid not in (select rolid from tbl_rol_tarea where tarea= 5));		
select * from tbl_usuarios;

commit transaction;
rollback transaction;
	