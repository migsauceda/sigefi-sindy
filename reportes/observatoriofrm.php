<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <br><br>
        <form name="campos" method="POST" action="observatorio.php">        
        <input type="button" value="Cancelar"> <input type="submit" name="generar" value="Generar reporte">            
        <hr>
        <table align="center" cellspacing="0px">
            <caption><strong>Seleccione la información a incluir</strong></caption>
            <tr>
                <th>Generales</th> 
                <th>Denunciante</th> 
                <th>Denuciado</th> 
                <th>Ofendido</th> 
            </tr>
            <tr>
                <td style="width: 250px">
                    <input type="checkbox" name="chkGenerales[]" value="tdenunciaid">Número Denuncia<br>                    
                    <input type="checkbox" name="chkGenerales[]" value="dfechadenuncia">Fecha Denuncia<br>                    
                    <input type="checkbox" name="chkGenerales[]" value="thoradenuncia">Hora Denuncia<br>                       
                    <input type="checkbox" name="chkGenerales[]" value="dfechahecho">Fecha Hecho<br>
                    <input type="checkbox" name="chkGenerales[]" value="thorahecho">Fecha Hecho<br>
                    <input type="checkbox" name="chkGenerales[]" value="depto_den">Depto. país de recepción<br>
                    <input type="checkbox" name="chkGenerales[]" value="municipio_den">Municipio de recepción<br>
                    <input type="checkbox" name="chkGenerales[]" value="deptohechos">Depto. hecho<br>
                    <input type="checkbox" name="chkGenerales[]" value="municipiohechos">Municipio hecho<br>
                    <input type="checkbox" name="chkGenerales[]" value="aldeahechos">Aldea o ciudad hecho<br>
                    <input type="checkbox" name="chkGenerales[]" value="barriohechos">Barrio hecho<br>
                    <input type="checkbox" name="chkGenerales[]" value="claselugar">Lugar hecho<br>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                </td>
                <td style="width: 250px">
                    <input type="checkbox" name="chkDenunciante[]" value="genero_den">Genero<br>
                    <input type="checkbox" name="chkDenunciante[]" value="sexo_den">Sexo<br>
                    <input type="checkbox" name="chkDenunciante[]" value="lgbti_den">Comunidad LGBTI<br>
                    <input type="checkbox" name="chkDenunciante[]" value="nombreasumido_den">Nombre Asumido<br>                    
                    <input type="checkbox" name="chkDenunciante[]" value="nombre_den">Nombre<br>        
                    <input type="checkbox" name="chkDenunciante[]" value="apellido_den">Apellido<br>
                    <input type="checkbox" name="chkDenunciante[]" value="escolaridad_den">Escolaridad<br>
                    <input type="checkbox" name="chkDenunciante[]" value="profesion_den">Profesion u oficio<br>
                    <input type="checkbox" name="chkDenunciante[]" value="ocupacion_den">Ocupación<br>
                    <input type="checkbox" name="chkDenunciante[]" value="edad_den">Edad<br>              
                    <input type="checkbox" name="chkDenunciante[]" value="depto_imp">Deptartamento<br>
                    <input type="checkbox" name="chkDenunciante[]" value="municipio_imp">Municipio<br>
                    <input type="checkbox" name="chkDenunciante[]" value="ciudad_den">Aldea o ciudad<br>
                    <input type="checkbox" name="chkDenunciante[]" value="barrio_den">Barrio o colonia<br>                    
                    <input type="checkbox" name="chkDenunciante[]" value="etnia_den">Pueblo indígena<br>
                    <input type="checkbox" name="chkDenunciante[]" value="discapacidad_den">Discapacidad<br>                  
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                </td>
                <td style="width: 250px">
                    <input type="checkbox" name="chkDenunciado[]" value="sexo_imp">Sexo<br>
                    <input type="checkbox" name="chkDenunciado[]" value="genero_imp">Genero<br>
                    <input type="checkbox" name="chkDenunciado[]" value="lgbti_imp">Comunidad LGBTI<br>
                    <input type="checkbox" name="chkDenunciado[]" value="nombreasumido_imp">Nombre Asumido<br>                    
                    <input type="checkbox" name="chkDenunciado[]" value="nombre_imp">Nombre<br>        
                    <input type="checkbox" name="chkDenunciado[]" value="apellido_imp">Apellido<br>
                    <input type="checkbox" name="chkDenunciado[]" value="escolaridad_imp">Escolaridad<br>
                    <input type="checkbox" name="chkDenunciado[]" value="profesion_imp">Profesion u oficio<br>
                    <input type="checkbox" name="chkDenunciado[]" value="ocupacion_imp">Ocupación<br>
                    <input type="checkbox" name="chkDenunciado[]" value="edad_imp">Edad<br>
                    <input type="checkbox" name="chkDenunciado[]" value="depto_imp">Deptartamento<br>
                    <input type="checkbox" name="chkDenunciado[]" value="municipio_imp">Municipio<br>
                    <input type="checkbox" name="chkDenunciado[]" value="ciudad_imp">Aldea o ciudad<br>
                    <input type="checkbox" name="chkDenunciado[]" value="barrio_imp">Barrio o colonia<br>                    
                    <input type="checkbox" name="chkDenunciado[]" value="etnia_imp">Pueblo indígena<br>
                    <input type="checkbox" name="chkDenunciado[]" value="discapacidad_imp">Discapacidad<br>                     
                    <input type="checkbox" name="chkDenunciado[]" value="delito">Delito**<br>
                    <input type="checkbox" name="chkDenunciado[]" value="Arma">Tipo de arma**<br>
                    <input type="checkbox" name="chkDenunciado[]" value="Transporte">Transporte usado**<br>
                    <input type="checkbox" name="chkDenunciado[]" value="Movil">Movil segun denunciante<br>
                    <input type="checkbox" name="chkDenunciado[]" value="Condicion">Condicion mental<br>
                    <input type="checkbox" name="chkDenunciado[]" value="Remunerado">Trabajo remunerado<br>
                    <input type="checkbox" name="chkDenunciado[]" value="Estudios">Asiste centro estudio<br>     
                    <br><br><br><br><br><br><br><br><br>
                </td>
                <td>
                    <input type="checkbox" name="chkOfendido[]" value="genero_ofe">Genero<br>
                    <input type="checkbox" name="chkOfendido[]" value="sexo_ofe">Sexo<br>
                    <input type="checkbox" name="chkOfendido[]" value="lgbti_ofe">Comunidad LGBTI<br>
                    <input type="checkbox" name="chkOfendido[]" value="nombreasumido_ofe">Nombre Asumido<br>                    
                    <input type="checkbox" name="chkOfendido[]" value="nombre_ofe">Nombre<br>        
                    <input type="checkbox" name="chkOfendido[]" value="apellido_ofe">Apellido<br>
                    <input type="checkbox" name="chkOfendido[]" value="escolaridad_ofe">Escolaridad<br>
                    <input type="checkbox" name="chkOfendido[]" value="profesion_ofe">Profesion u oficio<br>
                    <input type="checkbox" name="chkOfendido[]" value="ocupacion_ofe">Ocupación<br>
                    <input type="checkbox" name="chkOfendido[]" value="edad_ofe">Edad<br>                                      
                    <input type="checkbox" name="chkOfendido[]" value="depto_ofe">Deptartamento<br>
                    <input type="checkbox" name="chkOfendido[]" value="municipio_ofe">Municipio<br>
                    <input type="checkbox" name="chkOfendido[]" value="ciudad_ofe">Aldea o ciudad<br>
                    <input type="checkbox" name="chkOfendido[]" value="barrio_ofe">Barrio o colonia<br>                    
                    <input type="checkbox" name="chkOfendido[]" value="etnia_ofe">Pueblo indígena<br>
                    <input type="checkbox" name="chkOfendido[]" value="discapacidad_ofe">Discapacidad<br>  
                    <input type="checkbox" name="chkOfendido[]" value="embarazo_ofe">Embarazada<br>  
                    <input type="checkbox" name="chkOfendido[]" value="cantidadhijos_ofe">Cantidad de hijos<br>  
                    <input type="checkbox" name="chkOfendido[]" value="frecuencia_ofe">Frecuencia<br>  
                    <input type="checkbox" name="chkOfendido[]" value="trabajoremunerado_ofe">Trabajo remunerado<br>  
                    <input type="checkbox" name="chkOfendido[]" value="estudia_ofe">Asiste centro estudio<br>  
                    <input type="checkbox" name="chkOfendido[]" value="intentosuicidio_ofe">Intentos de suicidio<br>  
                    <input type="checkbox" name="chkOfendido[]" value="enfermedadmental_ofe">Enfermedad mental<br>  
                    <input type="checkbox" name="chkOfendido[]" value="mecanismomuerte_ofe">Mecanismo suicidio<br>  
                    <br><br><br><br><br><br><br><br>
                </td>
            </tr>
        </table>        
        <hr>
        <input type="button" value="Cancelar"> <input type="submit" name="generar" value="Generar reporte">
        </form>
        <?php

        ?>
    </body>
</html>
