<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class peliculas
{

	
	function listaUltimasPeliculasEstrenadas($limit = NULL)
	{
		$html = '<ul>';
		$peliculas = Pelicula::ultimasPeliculasEstrenadas($limit);
		foreach($peliculas as $pelicula) {
			$href = './peliculas.php?id=' . $pelicula->id();
			$html .= '<li>';
			$html .= "<a href=\"$href\">{$pelicula->title()}</a>";
			$html .= '</li>';
		}
		$html .= '</ul>';

		return $html;
	}
	
	function listaUltimasPeliculasAnadidas($limit = NULL)
	{
		$html = '<ul>';
		$peliculas = Pelicula::ultimasPeliculasAnadidas($limit);
		foreach($peliculas as $pelicula) {
			$href = './peliculas.php?id=' . $pelicula->id();
			$html .= '<li>';
			$html .= "<a href=\"$href\">{$pelicula->title()}</a>";
			$html .= '</li>';
		}
		$html .= '</ul>';

		return $html;
	}
}