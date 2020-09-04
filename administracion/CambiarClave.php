<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        
        <style>
        /* Style all input fields */
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
        }

        /* Style the submit button */
        input[type=submit] {
            background-color: #4CAF50;
            color: white;
        }

        /* Style the container for inputs */
        .container {
            background-color: #f1f1f1;
            padding: 20px;
        }

        /* The message box is shown when the user clicks on the password field */
        #message {
            display:none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 20px;
            margin-top: 10px;
        }

        #message p {
            padding: 10px 35px;
            font-size: 18px;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        /* Add a red text color and an "x" when the requirements are wrong */
        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }
        </style>        
    </head>
    <body>
    <FORM action="ProcesaCambiarClave.php" method="POST">
	<div align="center"><strong><h2>Cambiar Clave de Acceso</h2></strong></div>
	<br><br><br>
	<table align="center" border="1">
	<TR><TD>
	<table align="center">
	<tbody align="left">
	<tr>
	<td><strong>Clave actual:</strong></td>
	<td><INPUT type="input" name="PassActual" size="20" maxlength="50"></td>
	</tr>
	<tr>
	<td><strong>Clave nueva:</strong></td>
	<td><INPUT type="input" name="PassNueva" id="PassNueva" size="20" maxlength="50" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"></td>
	</tr>
	<tr>
	<td><strong>Repita nueva:</strong></td>
	<td><INPUT type="input" name="PassRepita" size="20" maxlength="50"></td>
	</tr>
	<tr><TD colspan="2"><hr></TD></tr>	
	<TR>
	<TD colspan="2" align="center">
	<INPUT type="submit" name="Cambiar" value="Cambiar">
	<INPUT type="reset" name="Cancelar" value="Cancelar"></TD>
	</TR>
	</tbody>
	</table>
	</TD></TR>
	</table>
        
        <div id="message">
          <h3>La clave debe cumplir las siguientes reglas:</h3>
          <p id="minuscula" class="invalid">Una <b>letra minúscula</b></p>
          <p id="mayuscula" class="invalid">Una <b>Letra mayúscula</b></p>
          <p id="numero" class="invalid">Un <b>número</b></p>
          <p id="longitud" class="invalid">Minimo <b>8 caractéres</b></p>
        </div>        
				
        <script>
        var clave = document.getElementById("PassNueva");
        var minuscula = document.getElementById("minuscula");
        var mayuscula = document.getElementById("mayuscula");
        var numero = document.getElementById("numero");
        var longitud = document.getElementById("longitud");

        // When the user clicks on the password field, show the message box
        PassNueva.onfocus = function() {
            document.getElementById("message").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        PassNueva.onblur = function() {
            document.getElementById("message").style.display = "none";
        }

        // When the user starts to type something inside the password field
        PassNueva.onkeyup = function() {
          // Validate lowercase letters
          var lowerCaseLetters = /[a-z]/g;
          if(PassNueva.value.match(lowerCaseLetters)) {  
            minuscula.classList.remove("invalid");
            minuscula.classList.add("valid");
          } else {
            minuscula.classList.remove("valid");
            minuscula.classList.add("invalid");
          }

          // Validate capital letters
          var upperCaseLetters = /[A-Z]/g;
          if(PassNueva.value.match(upperCaseLetters)) {  
            mayuscula.classList.remove("invalid");
            mayuscula.classList.add("valid");
          } else {
            mayuscula.classList.remove("valid");
            mayuscula.classList.add("invalid");
          }

          // Validate numbers
          var numbers = /[0-9]/g;
          if(PassNueva.value.match(numbers)) {  
            numero.classList.remove("invalid");
            numero.classList.add("valid");
          } else {
            numero.classList.remove("valid");
            numero.classList.add("invalid");
          }

          // Validate length
          if(PassNueva.value.length >= 8) {
            longitud.classList.remove("invalid");
            longitud.classList.add("valid");
          } else {
            longitud.classList.remove("valid");
            longitud.classList.add("invalid");
          }
        }
        </script>        
    </FORM>
        <?php
        // put your code here
        ?>
    </body>
</html>
