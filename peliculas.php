<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;

function mostrarPeliculas() {
	$app = Aplicacion::getSingleton();
	$html = "<h1>Películas</h1>";	
	if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
		$html .= '<a href="nuevaPelicula.php">Añadir película</a>';
	}
	

		if(isset($_POST['desplegable'])){
		$tipoorden= $_POST['desplegable'];
		switch ($tipoorden) {
            case 1:
                $html .= listaPeliculas('title', 'ASC', null);
                break;
            case 2:
                $html .= listaPeliculas('date_released', 'DESC', null);
                break;
            case 3:
                $html .= listaPeliculas('rating', 'DESC', null);
                break;
            case 4:
                $html .= listaPeliculas('duration', 'DESC', null);
                break;
}
		
	}
	else{
		$html .= listaPeliculas('title', 'ASC', null);
		
	}

	return $html;
}
function dropdown_ordenacion() {
	$html = <<<EOS
        <form action="" method="post">
            <select name="desplegable">
            <option value="1">Por orden alfabético</option>
            <option value="2">Por fecha de estreno</option>
            <option value="3">Por valoración</option>
            <option value="4">Por duración</option>
            </select>
            <input type="submit" value="Submit">
        </form>
    EOS;
return $html;
}

$tituloPagina = 'Películas';
$contenidoPrincipal= dropdown_ordenacion();
$contenidoPrincipal.=mostrarPeliculas();


require __DIR__ . '/includes/plantillas/plantilla.php';