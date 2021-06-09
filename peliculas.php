<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;

function mostrarPeliculas() {
	
	$table = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);
	$value = filter_input(INPUT_GET, 'value', FILTER_SANITIZE_STRING);
	$order = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING);
	$ascdesc = filter_input(INPUT_GET, 'ascdesc', FILTER_SANITIZE_STRING);
	$dropdown1 = filter_input(INPUT_GET, 'dropdown1', FILTER_SANITIZE_NUMBER_INT);
	$dropdown1 = $dropdown1 ?? 0;
	$dropdown2 = filter_input(INPUT_GET, 'dropdown2', FILTER_SANITIZE_NUMBER_INT);
	$dropdown2 = $dropdown2 ?? 0;
	$dropdown3 = filter_input(INPUT_GET, 'dropdown3', FILTER_SANITIZE_NUMBER_INT);
	$dropdown3 = $dropdown3 ?? 0;

	$order = $order ?? 'title';
	$ascdesc = $ascdesc ?? 'asc';
	$value = $value ?? null;

	$app = Aplicacion::getSingleton();
	$html = "<h1>Películas</h1>";	
	$prevLink = urlencode($_SERVER['REQUEST_URI']);
	if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
		$html .= '<a href="'.RUTA_APP.'nuevaPelicula.php?prevPage='.$prevLink.'">Añadir película</a>';
	}

	if(isset($_POST['desplegable1'])){
		$tipoorden= $_POST['desplegable1'];

		switch ($tipoorden) {
			case 1:
				$orderD='title';
				$ascdescD='asc';
				break;
			case 2:
				$orderD='title';
				$ascdescD='desc';
				break;
			case 3:
				$orderD='date_released';
				$ascdescD='asc';
				break;
			case 4:
				$orderD='date_released';
				$ascdescD='desc';
				break;
			case 5:
				$orderD='rating';
				$ascdescD='desc';
				break;
			case 6:
				$orderD='rating';
				$ascdescD='asc';
				break;
			case 7:
				$orderD='duration';
				$ascdescD='desc';
				break;
			case 8:
				$orderD='duration';
				$ascdescD='asc';
				break;
		}
		header("Location: peliculas.php?table={$table}&value={$value}&order={$orderD}&ascdesc={$ascdescD}&dropdown1={$tipoorden}&dropdown2={$dropdown2}&dropdown3={$dropdown3}");
	}
	

	if(isset($_POST['desplegable2'])){
		$dropdown1 = filter_input(INPUT_GET, 'dropdown1', FILTER_SANITIZE_NUMBER_INT);
		$dropdown1 = $dropdown1 ?? 0;
		$tipoorden2= $_POST['desplegable2'];

		switch ($tipoorden2) {
			case 1:
				$tableD='genre';
				break;
			case 2:
				$tableD='actor';
				break;
			case 3:
				$tableD='director';
				break;
		}
		header("Location: peliculas.php?table={$tableD}&order={$order}&ascdesc={$ascdesc}&dropdown1={$dropdown1}&dropdown2={$tipoorden2}");
	}

	if(isset($_POST['desplegable3'])){
		$dropdown1 = filter_input(INPUT_GET, 'dropdown1', FILTER_SANITIZE_NUMBER_INT);
		$dropdown1 = $dropdown1 ?? 0;
		$dropdown2 = filter_input(INPUT_GET, 'dropdown2', FILTER_SANITIZE_NUMBER_INT);
		$dropdown2 = $dropdown2 ?? 0;
		$tipoorden3= $_POST['desplegable3'];
		header("Location: peliculas.php?table={$table}&order={$order}&ascdesc={$ascdesc}&value={$tipoorden3}&dropdown1={$dropdown1}&dropdown2={$dropdown2}&dropdown3={$tipoorden3}");
	}

	return ordenar($order, $ascdesc, $table, $value);
}

function ordenar($order, $ascdesc, $table,$value){
	
	switch($table){
		case 'genre':
			return listaPeliculasGen($order, $ascdesc, $value, null);
			break;
		case 'peliculas':
			return listaPeliculas($order,$ascdesc,$value, $table,$value);
			break;
		case 'ver_tarde':
			return listaPeliculasVer($order,$ascdesc,$value, null);
			break;
		case 'actor':
			return listadoPelisActoresDirectores($order, $ascdesc, $value, null);	
			break;	
		case 'director':
			return listadoPelisActoresDirectores($order, $ascdesc, $value, null);
			break;

		default:
			if($order==null){
				return listaPeliculas('title', null,null, null,null);
			} else{
				if($order=='title'){
					return listaPeliculas($order, $ascdesc,null, null,null);
				} else{
					return listaPeliculas($order, $ascdesc ,null, null,null);
				}
			}	
			break;
		}
}

function dropdown_ordenacion() {
	$dropdown1 = filter_input(INPUT_GET, 'dropdown1', FILTER_SANITIZE_NUMBER_INT);
	$dropdown1 = $dropdown1 ?? 0;

    $html='<form class="filtros" action=""  method="post" id ="myForm">';
		$html.='<select name="desplegable1"  onChange="this.form.submit()";>';
			if ($dropdown1 == 0) {
				$html.='<option value="0" selected>Ordenar por...</option>';
			} else {
				$html.='<option value="0"></option>';
			}
			if ($dropdown1 == 1) {
				$html.='<option value="1" selected>Por orden alfabético (Ascendiente)</option>';
			} else {
				$html.='<option value="1">Por orden alfabético (Ascendiente)</option>';
			}
			if ($dropdown1 == 2) {
				$html.='<option value="2" selected>Por orden alfabético (Descendiente)</option>';
			} else {
				$html.='<option value="2">Por orden alfabético (Descendiente)</option>';
			}
			if ($dropdown1 == 3) {
				$html.='<option value="3" selected>Por fecha de estreno (Más antigua a más reciente)</option>';
			} else {
				$html.='<option value="3">Por fecha de estreno (Más antigua a más reciente)</option>';
			}
			if ($dropdown1 == 4) {
				$html.='<option value="4" selected>Por fecha de estreno (Más reciente a más antigua)</option>';
			} else {
				$html.='<option value="4">Por fecha de estreno (Más reciente a más antigua)</option>';
			}
			if ($dropdown1 == 5) {
				$html.='<option value="5" selected>Por valoración (Descendiente)</option>';
			} else {
				$html.='<option value="5">Por valoración (Descendiente)</option>';
			}
			if ($dropdown1 == 6) {
				$html.='<option value="6" selected>Por valoración (Ascendiente)</option>';
			} else {
				$html.='<option value="6">Por valoración (Ascendiente)</option>';
			}
			if ($dropdown1 == 7) {
				$html.='<option value="7" selected>Por duración (De mayor a menor)</option>';
			} else {
				$html.='<option value="7">Por duración (De mayor a menor)</option>';
			}
			if ($dropdown1 == 8) {
				$html.='<option value="8" selected>Por duración (De menor a mayor)</option>';
			}
		$html.='</select>';

	$html.= '</form>';

	return $html;
}

function dropdown_filtro1() {
	$dropdown2 = filter_input(INPUT_GET, 'dropdown2', FILTER_SANITIZE_NUMBER_INT);
	$dropdown2 = $dropdown2 ?? 0;

    $html='<form class="filtros" action="" method="post" id ="myForm">';
		$html.='<select name="desplegable2" onChange="this.form.submit()";>';
			if ($dropdown2 == 0) {
				$html.='<option value="0" selected>Filtrar por...</option>';
			} else {
				$html.='<option value="0"></option>';
			}
			if ($dropdown2 == 1) {
				$html.='<option value="1" selected>Género</option>';
			} else {
				$html.='<option value="1">Género</option>';
			}
			if ($dropdown2 == 2) {
				$html.='<option value="2" selected>Actor</option>';
			} else {
				$html.='<option value="2">Actor</option>';
			}
			if ($dropdown2 == 3) {
				$html.='<option value="3" selected>Director</option>';
			} else {
				$html.='<option value="3">Director</option>';
			}
		$html.='</select>';

	$html.= '</form>';

	return $html;
}

function dropdown_filtro2() {
	$dropdown3 = filter_input(INPUT_GET, 'dropdown3', FILTER_SANITIZE_NUMBER_INT);
	$table = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);
	$dropdown3 = $dropdown3 ?? 0;
	$table = $table ?? null;

	if ($table) {
		switch ($table) {
			case 'genre':
				$data = generos();
				break;
			case 'actor':
				$data = actores();
				break;
			case 'director':
				$data = directores();
				break;
			default:
				$data = null;
				break;
		}

		$html='<form class="filtros" action="" method="post" id ="myForm">';
		$html.='<select name="desplegable3" onChange="this.form.submit()";>';
		$html.='<option value="0" selected>Selecciona para filtrar...</option>';
		if ($data) {
			foreach($data as $dato) {
				if ($dropdown3 == $dato->id()) {
					$html.='<option value="'.$dato->id().'" selected>'.$dato->name().'</option>';
				} else {
					$html.='<option value="'.$dato->id().'">'.$dato->name().'</option>';
				}
			}
		}
		$html.='</select>';

		$html.= '</form>';

		return $html;
	}

    
}

$tituloPagina = 'Películas';


$contenidoPrincipal= dropdown_ordenacion();
$contenidoPrincipal.= dropdown_filtro1();
$contenidoPrincipal.= dropdown_filtro2();
$contenidoPrincipal.=mostrarPeliculas();


require __DIR__ . '/includes/plantillas/plantilla.php';
