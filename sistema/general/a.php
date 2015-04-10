<?php

$ruta = dirname("../sistema/")."/";

$codificacion = "ISO-8859-1";

//Vemos si hay algo en el GET
if (isset($_GET)){
    foreach($_GET as $campo=>$valor){
        switch ($campo) {
            //Obtenemos una ruta, carpeta o archivo
            case "una-ruta":
                $ruta = htmlspecialchars($valor, ENT_QUOTES);
                if (get_magic_quotes_gpc() == 1) $ruta = stripslashes($ruta);
                break;
            //Vemos la codificación
            case "una-codificacion":
                $codificacion = htmlspecialchars($valor, ENT_QUOTES);
                if (get_magic_quotes_gpc() == 1) $codificacion = stripslashes($codificacion);
                break;

        }
    }
}

//Si la ruta es vacía, pone la del presente script
if ($ruta == "") $ruta = dirname("sistema/pacientes/")."/";

//Esta variable contendrá la lista de nodos (carpetas y archivos)
$presenta_nodos = "";

//Esta variable es para el contenido del archivo
$presenta_archivo = "";

//Si la ruta es una carpeta, la exploramos. Si es un archivo
//sacamos también el contenido del archivo.
if (is_dir($ruta)){//ES UNA CARPETA
    //Con realpath convertimos los /../ y /./ en la ruta real
    $ruta = realpath($ruta)."/";
    //exploramos los nodos de la carpeta
    $presenta_nodos = explora_ruta($ruta);
} else {//ES UN ARCHIVO
    $ruta = realpath($ruta);
    //Sacamos también los nodos de la carpeta
    $presenta_nodos = explora_ruta(dirname($ruta)."/");
    //Y sacamos el contenido del archivo
    $presenta_archivo = "<br />CONTENIDO DEL ARCHIVO: ".
    $ruta."<pre>";
}
//Función para explorar los nodos de una carpeta
//El signo @ hace que no se muestren los errores de restricción cuando
//por ejemplo open_basedir restringue el acceso a algún sitio
function explora_ruta($ruta){
    //En esta cadena haremos una lista de nodos
    $cadena = "";
    //Para agregar una barra al final si es una carpeta
    $barra = "";
    //Este es el manejador del explorador
    $manejador = @dir($ruta);
    while ($recurso = $manejador->read()){
        //El recurso sera un archivo o una carpeta
        $nombre = "$ruta$recurso";
        if (@is_dir($nombre)) {//ES UNA CARPETA
            //Agregamos la barra al final
            $barra = "/";
            $cadena .= "CARPETA: ";

        }else {//ES UN ARCHIVO
            //No agregamos barra
            $barra = "";
            $cadena .= "ARCHIVO: ";
        }
        //Vemos si el recurso existe y se puede leer
        if (@is_readable($nombre)){
            $cadena .= "<a href=\"".$_SERVER["PHP_SELF"].
            "?una-ruta=$nombre$barra\">$recurso$barra</a>";
        } else {
            $cadena .= "$recurso$barra";
        }
        $cadena .= "<br />";
    }
    $manejador->close();
    return $cadena;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
    <title>Wiggle</title>
    <meta charset="utf-8">

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> <!-- Integramos jQuery-->
    <script src="script.js"></script> <!-- Integramos nuestro script que contendra nuestras funciones Javascript-->

</head>

<style type="text/css">
        body{
            background: rgba(255,0,255,.3);
            font-size: 16px;
            text-align: center;
            width: 500px;
            margin: 0 auto;
 
        }
        .mensage{
            border:dashed 1px blue;
            background-color:#7CFC00;
            color: #000000;
            padding: 10px;
            text-align: left;
            margin: 10px auto; 
            display: none;//Al cargar el documento el contenido del mensaje debe estar oculto
        }
    </style>

<body>
    <h3>Exploración</h3>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="get">
        Ruta <small></small>
        <br /><textarea rows="4" cols="70" name="Ruta"
        ><?php echo $ruta; ?></textarea><br />
        
    </form>
    <?php
        echo "<br />$presenta_nodos";
        echo "<br />$presenta_archivo";
        echo "<b>$ruta</b>";
    ?>
    <h4>------- ------- ----- ------</h4>
    <h1>Subir Multiples Archivos</h1>
        <!-- Formulario para subir los archivos -->
            <div class="mensage"> </div>      
            <table align="center">
                <tr>
                    <td>Archivo</td>
                    <td><input type="file"  multiple="multiple" id="archivos"></td><!-- Este es nuestro campo input File-->
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><button id="enviar">Enviar</button></td>
                </tr>    
            </table>
</body>
</html>  