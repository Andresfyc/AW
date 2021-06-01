<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;



function mostrarPeliculas() {
	
	$table = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);
	$value = filter_input(INPUT_GET, 'value', FILTER_SANITIZE_STRING);

	$app = Aplicacion::getSingleton();
	$html = "<h1>Películas</h1>";	
	if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
		$html .= '<a href="'.RUTA_APP.'nuevaPelicula.php">Añadir película</a>';
	}

		if(isset($_POST['desplegable'])){
		$tipoorden= $_POST['desplegable'];
		switch ($tipoorden) {
            case 1:
                $html .= listaPeliculas('title', 'ASC', null, $table, $value);
                break;
            case 2:
                $html .= listaPeliculas('date_released', 'DESC', null, $table, $value);
                break;
            case 3:
                $html .= listaPeliculas('rating', 'DESC', null, $table, $value);
                break;
            case 4:
                $html .= listaPeliculas('duration', 'DESC', null, $table, $value);
                break;
		}
		
		}
		else{
		
		$html .= listaPeliculas('title', 'ASC', null, null, null);
		
		}

	return $html;
}
function dropdown_ordenacion() {

    $html='<form action="" method="post" id ="myForm">';

		$html.='<select name="desplegable">';
			$html.='<option value="1">Por orden alfabético</option>';
			$html.='<option value="2">Por fecha de estreno</option>';
			$html.='<option value="3">Por valoración</option>';
			$html.='<option value="4">Por duración</option>';
		$html.='</select>';

	$html.='<input type="submit" value="Submit">';
	$html.= '</form>';
	
	
return $html;
}

$tituloPagina = 'Películas';
$contenidoPrincipal= dropdown_ordenacion();
$contenidoPrincipal.=mostrarPeliculas();


require __DIR__ . '/includes/plantillas/plantilla.php';