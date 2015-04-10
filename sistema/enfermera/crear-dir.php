<?php
	$msg= null;
	if (isset($_POST["drectorio"])){
		$carpetas = htmlspecialchars($_POST["carpetas"]);
		$directorio = $carpetas;

		if(!is_dir($directorio)){

			$crear = mkdir("../pacientes/" . $directorio,0777,true);
			
			if($crear){
				$msg = "Directorio $directorio creado correctamente";
			}

			elseif ($crear == "") {
				$msg = "ERROR, No se introdujo nombre de la carpeta";
			}

			else{
				$msg = "Ha ocurrido un error al crear el directorio";
			}
		}
		else{
				$msg = "El directorio que intentas crear ya existe";
			}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>

<style type="text/css">
body{
	background: rgba(255,0,255,.2);
}
</style>

<body>
	<center><h1>Carpetas de pacientes</h1>
	<p><big>En esta sección se crearán carpetas con el nombre del paciente para subir 
	sus estudios posteriormente por el médico general</big></p></center>
	<strong><?php echo $msg ?></strong>
	<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
		<table>
			<tr>
				<td>Carpeta del paciente</td>
				<td><input type="text" name="carpetas"></td>
			</tr>
		</table>
		<input type="hidden" name="drectorio">
		<input type="submit" value="Crear">
	</form>
</body>

<!-- https://www.youtube.com/watch?v=8z-u68mB2rk -->

</html>