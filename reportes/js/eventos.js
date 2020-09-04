/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function buscar_rpt1(denuncia){
	 	if (denuncia=='---'){
            alert('Indique una denuncia para realizar la busqueda')
        }
        else{
			var url="clases/mostrarReporte.php?opcion=1&denuncia="+denuncia
			//alert(url)
			muestraRpt(url)
        }
}
 
function buscar_rpt2(fechaIni, fechaFin, sede){
        if ((fechaIni=='') || (fechaFin=='') || (sede=='---')){
            alert('Indique al menos un filtro para realizar la busqueda')
        }
        else{
			var url
			var tbl=document.getElementById('tabla')
			var numFiltros=tbl.rows.length
			var i=0
			
			url="clases/mostrarReporte.php?opcion=2&"
			for (i=1;i<numFiltros;i++){
				url=url+"fechaIni"+i+"="+document.getElementById('fechaIni'+i).value+"&fechaFin"+i+"="+document.getElementById('fechaFin'+i).value+"&sede"+i+"="+document.getElementById('sede'+i).value
				url=url+"&"
			}
			url=url+"numFiltros="+(numFiltros-1)
			//alert(url)
			muestraRpt(url)
        }
}

function buscar_rpt3(fechaIni, fechaFin, sede, usuario){
        if ((fechaIni=='') || (fechaFin=='') || (sede=='---') || (usuario=='---')){
            alert('Indique al menos un filtro para realizar la busqueda')
        }
        else{
			var url
			var tbl=document.getElementById('tabla')
			var numFiltros=tbl.rows.length
			var i=0
			
			url="clases/mostrarReporte.php?opcion=3&"
			for (i=1;i<numFiltros;i++){
				url=url+"fechaIni"+i+"="+document.getElementById('fechaIni'+i).value+"&fechaFin"+i+"="+document.getElementById('fechaFin'+i).value+"&sede"+i+"="+document.getElementById('sede'+i).value+"&usuario"+i+"="+document.getElementById('usuario'+i).value
				url=url+"&"
			}
			url=url+"numFiltros="+(numFiltros-1)
			//alert(url)
			muestraRpt(url)
        }
}

function buscar_rpt4(fechaIni, fechaFin, estado, fiscalia){
        if ((fechaIni=='') || (fechaFin=='') || (estado=='---') || (fiscalia=='---')){
            alert('Indique al menos un filtro para realizar la busqueda')
        }
        else{
			var url
			var tbl=document.getElementById('tabla')
			var numFiltros=tbl.rows.length
			var i=0
			
			url="clases/mostrarReporte.php?opcion=4&"
			for (i=1;i<numFiltros;i++){
				url=url+"fechaIni"+i+"="+document.getElementById('fechaIni'+i).value+"&fechaFin"+i+"="+document.getElementById('fechaFin'+i).value+"&estado"+i+"="+document.getElementById('estado'+i).value+"&fiscalia"+i+"="+document.getElementById('fiscalia'+i).value
				url=url+"&"
			}
			url=url+"numFiltros="+(numFiltros-1)
			//alert(url)
			muestraRpt(url)
        }
}

function buscar_rpt5(fechaIni, fechaFin, estado, fiscalia, fiscal){
    alert(fechaIni + "/" + fechaFin + "/" + estado + "/" + fiscalia + "/" + fiscal);
        if ((fechaIni=='') || (fechaFin=='') || (estado=='---') || (fiscalia=='---') || (fiscal=='---')){
            alert('Indique al menos un filtro para realizar la busqueda')
        }
        else{
			var url
			var tbl=document.getElementById('tabla')
			var numFiltros=tbl.rows.length
			var i=0
			
			url="clases/mostrarReporte.php?opcion=5&"
			for (i=1;i<numFiltros;i++){
				url=url+"fechaIni"+i+"="+document.getElementById('fechaIni'+i).value+"&fechaFin"+i+"="+document.getElementById('fechaFin'+i).value+"&estado"+i+"="+document.getElementById('estado'+i).value+"&fiscalia"+i+"="+document.getElementById('fiscalia'+i).value+"&fiscal"+i+"="+document.getElementById('fiscal'+i).value
				url=url+"&"
			}
			url=url+"numFiltros="+(numFiltros-1)
			//alert(url)
			muestraRpt(url)
        }
}

function buscar_rpt6(denuncia){
	 	if (denuncia=='---'){
            alert('Indique una denuncia para realizar la busqueda')
        }
        else{
			var url="clases/mostrarReporte.php?opcion=6&denuncia="+denuncia
			//alert(url)
			muestraRpt(url)
        }
}

function buscar_rpt7(denuncia){
	 	if (denuncia=='---'){
            alert('Indique una denuncia para realizar la busqueda')
        }
        else{
			var url="clases/mostrarReporte.php?opcion=7&denuncia="+denuncia
			//alert(url)
			muestraRpt(url)
        }
}


function muestraRpt(url){
		var xmlhttp=varAjax();
        xmlhttp.open("GET", url, true);
        xmlhttp.send(null);
}

function varAjax(){
    if (window.XMLHttpRequest)
    {	// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {	// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById("1").innerHTML=xmlhttp.responseText;
        }
    }
    return xmlhttp;
}

function llena_cboFiscal(fiscalia, id){
	if (fiscalia!='---'){
		var numDiv=parseInt(id.substring(8,id.length))+1;
		var combo=parseInt(id.substring(8,id.length));
		if (fiscalia=='todas'){
			var xmlhttp=varAjax2(numDiv);
			xmlhttp.open("GET", "clases/llena_combo.php?combo="+combo+"&opcion=1", true);
			xmlhttp.send(null);
		}else{
			var xmlhttp=varAjax2(numDiv);
			xmlhttp.open("GET", "clases/llena_combo.php?combo="+combo+"&opcion=2&fiscaliaid="+fiscalia, true);
			xmlhttp.send(null);
		}
	}
}

function varAjax2(numDiv){
    if (window.XMLHttpRequest)
    {	// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {	// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById(numDiv).innerHTML=xmlhttp.responseText;
        }
    }
    return xmlhttp;
}