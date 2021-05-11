<?php

require_once __DIR__.'/includes/config.php';

function mostrarPeliculas() {
	$peliculas = new es\ucm\fdi\aw\peliculas();
	$result = "<h1>Películas</h1>";	
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esGestor"] == true || $_SESSION["esAdmin"] == true)) {
		$result .= '<a href="nuevaPelicula.php">Añadir película</a>';
	}
	

		if(isset($_POST['desplegable'])){
		$tipoorden= $_POST['desplegable'];
		switch ($tipoorden) {
		case 1:
			$result .= $peliculas->listaPeliculas();
			break;
		case 2:
			$result .= $peliculas->listaPeliculasFecha();
			break;
		case 3:
			$result .= $peliculas->listaPeliculasRating();
			break;
		case 4:
			$result .= $peliculas->listaPeliculasDuration();
			break;
}
		
	}
	else{
		$result .= $peliculas->listaPeliculas();
		
	}

	return $result;
}
function dropdown_ordenacion() {
	
	
	$html='<form action="" method="post">';

  $html.='<select name="desplegable">';
    $html.='<option value="1">Por orden alfabético</option>';
    $html.='<option value="2">Por fecha de estreno</option>';
    $html.='<option value="3">Por valoración</option>';
	$html.='<option value="4">Por duración</option>';
	$html.='</select>';
	
$html.='<input type="submit" value="Submit">	';
$html.= '</form>';
return $html;
}

$tituloPagina = 'Películas';
$contenidoPrincipal= dropdown_ordenacion();
$contenidoPrincipal.=mostrarPeliculas();


require __DIR__ . '/includes/plantillas/plantilla.php';
