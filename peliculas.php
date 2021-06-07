<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;

function mostrarPeliculas() {
	
	$table = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);
	$value = filter_input(INPUT_GET, 'value', FILTER_SANITIZE_STRING);

	$app = Aplicacion::getSingleton();
	$html = "<h1>Películas</h1>";	
	$prevLink = urlencode($_SERVER['REQUEST_URI']);
	if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
		$html .= '<a href="'.RUTA_APP.'nuevaPelicula.php?prevPage='.$prevLink.'">Añadir película</a>';
	}
		if(isset($_POST['desplegable'])){
			$tipoorden= $_POST['desplegable'];

			switch ($tipoorden) {
				case 1:
					$order='title';
					break;
				case 2:
					$order='date_released';
					break;
				case 3:
					$order='rating';
					break;
				case 4:
					$order='duration';
					break;
			}
			$html .= ordenar($order,$table,$value);
		}
		else{
			$html .= ordenar($value,$table,$value);
		}

	return $html;
}

function ordenar($aux,$table,$value){
	
	switch($table){
		case 'genero':
			return listaPeliculasGen('title', 'ASC', $value, null);
			break;
		case 'peliculas':
			if($value=='title'){
				return listaPeliculas($aux, 'ASC',null, $table,$value);
			} else{
				return listaPeliculas($aux, null,null, $table,$value);
			}
			break;
		case 'ver_tarde':

			if($aux==$value){
				return  listaPeliculasVer('title','ASC',$value, null);
			} else {
				if($aux=='title'){
					return listaPeliculasVer('title','ASC',$value, null);
				} else{
					return listaPeliculasVer($aux,null,$value, null);
				}
			}	
			break;

		default:
			if($aux==null){
				return listaPeliculas('title', null,null, null,null);
			} else{
				if($aux=='title'){
					return listaPeliculas($aux, 'ASC',null, null,null);
				} else{
					return listaPeliculas($aux, null ,null, null,null);
				}
			}	
			break;
		}
}
function dropdown_ordenacion() {

    $html='<form action="" method="post" id ="myForm">';

		$html.='<select name="desplegable" onChange="this.form.submit()";>';
			$html.='<option value="1">Por orden alfabético</option>';
			$html.='<option value="2">Por fecha de estreno</option>';
			$html.='<option value="3">Por valoración</option>';
			$html.='<option value="4">Por duración</option>';
		$html.='</select>';

	//$html.='<input type="submit" value="Submit">';
	$html.= '</form>';
	
	
return $html;
}

$tituloPagina = 'Películas';
$contenidoPrincipal= dropdown_ordenacion();
$contenidoPrincipal.=mostrarPeliculas();


require __DIR__ . '/includes/plantillas/plantilla.php';
