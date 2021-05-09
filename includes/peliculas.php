<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class peliculas
{


	function getDivPeliculas($peliculas, $all=FALSE) {
		$html = '<div class="div-peliculas">';
		foreach($peliculas as $pelicula) {
			$html .= '<div class="div-pelicula">';
			if ($all && isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esGestor"] == true || $_SESSION["esAdmin"] == true)) {
				$html .= "<p><a href=\"./editarPelicula.php?id={$pelicula->id()}\">Editar</a></p>";
				$html .= "<p><a href=\"./eliminarPelicula.php?id={$pelicula->id()}\">Eliminar</a></p>";
				$html .= "<img id=\"film_pic\" src=\"img/peliculas/{$pelicula->image()}\" alt=\"imagen\" width=\"100\" height=\"150\">";
			} else {
				$html .= "<img id=\"film_pic\" src=\"img/peliculas/{$pelicula->image()}\" alt=\"imagen\" width=\"150\" height=\"225\">";
			}
			$text = $pelicula->title();
			$text = strlen($text) > 40 ? substr($text, 0, 40).'...' : $text;
			$html .= "<p><a href=\"./pelicula.php?id={$pelicula->id()}\">{$text}</a></p>";
			$html .= '</div>';
		}

		if (!$all) {
			$html .= '<div class="div-pelicula-last">';
			$html .= '<p><a href="./peliculas.php">Ver todas</a></p>';
			$html .= '</div>';
		}
		$html .= '</div>';

		return $html;
	}

	
	function listaUltimasPeliculasEstrenadas($limit = NULL)
	{
		$peliculas = Pelicula::ultimasPeliculasEstrenadas($limit);

		return self::getDivPeliculas($peliculas);
	}
	
	function listaUltimasPeliculasAnadidas($limit = NULL)
	{
		$peliculas = Pelicula::ultimasPeliculasAnadidas($limit);

		return self::getDivPeliculas($peliculas);
	}
	
	function listaPeliculas($limit = NULL)
	{
		$peliculas = Pelicula::peliculasOrdenAlfabetico($limit);

		return self::getDivPeliculas($peliculas, TRUE);
	}

	function getPeliculaPorId($id)
	{
		return Pelicula::buscaPorId($id);
	}

	function eliminarPeliculaPorId($id)
	{
		return Pelicula::borraPorId($id);
	}
}