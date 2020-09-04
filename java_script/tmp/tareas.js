
function ConocerTareas(usuario)
{
	document.write(
	"<FORM action='clases/tareas_procesar.php' method='POST' name='segphp' id='segphp'>" +
	"<INPUT type='text' name='acc' id='acc'>" +
	"<INPUT type='text' name='usuario' id='usuario'>" +
	"</form>"
	);
	document.getElementById("acc").value= "crear";
	document.getElementById("usuario").value= usuario;
	document.segphp.submit();
}

function PuedeEntrar(usuario)
{
alert(usuario);

}