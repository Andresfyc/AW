<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = '¿Viendo Película?';

function watchingPelicula() {

	$filmId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
	$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
    $pelicula = buscaPeliculaPorId($filmId);
	$prev = urldecode($prevPage);

	if ($filmId) {
		if(array_key_exists('cancelar', $_POST)) {
			header('Location: '.$prev);
		}
		else if(array_key_exists('noVer', $_POST)) {
			$app = Aplicacion::getSingleton();
			if ($app->usuarioLogueado()) {
				marcarViendoPelicula(null);
				header('Location: '.$prev);
			}
		}

		$dateReleased = substr($pelicula->date_released(), 0, 4);
		$html = <<<EOS
			<h1>Viendo:</h1>
			<p> Estás viendo {$pelicula->title()} ({$dateReleased}) ¿Quiere indicar que ya no estás viendo esta película?</p>
			<form method="post">
				<input type="submit" name="cancelar"
						class="button" value="Cancelar" />
					
				<input type="submit" name="noVer"
						class="button" value="Dejar de ver" />
			</form>
		EOS;
	} else {
		if(array_key_exists('viendo', $_POST)) {
			$peliculaViendo= $_POST['peliculaViendo'];
			marcarViendoPelicula($peliculaViendo);
			header('Location: '.$prev);
		}
		$html = '<fieldset>
        <div class="grupo-editar"><h1>Viendo película:</h1><form method="post"><select name="peliculaViendo">';
		foreach (getTodasPeliculas('title','asc') as $pelicula) {
			$html .= "<option value=\"{$pelicula->id()}\">{$pelicula->title()}</option>";
		}
		$html .= '</select><div><button type="submit" name="viendo">Confirmar</button></div></form></div>';
	}
        
	return $html;
}

$contenidoPrincipal = watchingPelicula();


require __DIR__ . '/includes/plantillas/plantilla.php';