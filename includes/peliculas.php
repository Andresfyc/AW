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


	function listaActoresDirectores($actoresDirectores, $ad)
	{
		$html = '';
		if (!empty($actoresDirectores)) {
			if (!$ad){
				$html .= '<h3> Actores: </h3>';
			} else {
				$html .= '<h3> Directores: </h3>';
			}
			$html .= '<div class="div-actoresDirectoresPeli">';
			foreach($actoresDirectores as $actorDirector) {
				$html .= '<div class="div-actorDirectorPeli">';
				$html .= "<img id=\"film_pic\" src=\"img/actores_directores/{$actorDirector->image()}\" alt=\"imagen\" width=\"100\" height=\"150\">";
				$text = $actorDirector->name();
				$text = strlen($text) > 25 ? substr($text, 0, 25).'...' : $text;
				$html .= "<p><a href=\"./actorDirector.php?id={$actorDirector->id()}\">{$text}</a></p>";
				$html .= '</div>';
			}
			$html .= '</div>';
		}

		return $html;
	}

	function listaPlataformas($plataformas){
		$html = '';
		if (!empty($plataformas)) {
			
			$html .= '<h3> Plataforma: </h3>';
			
			$html .= '<div class="div-plataformasPeli">';
			foreach($plataformas as $plataforma) {
				$html .= '<div class="div-plataformaPeli">';
				$html .= "<img id=\"film_pic\" src=\"img/plataformas/{$plataforma->image()}\" alt=\"imagen\" width=\"40\" height=\"40\">";
				$html .= "<p><a href=>{$plataforma->nombre()}</a></p>";
				$html .= '</div>';
			}
			$html .= '</div>';
		}

		return $html;
	}
	
	function listaReviews($reviews, $href)
	{

		$html = '';
		if (!empty($reviews)) {
			
			$html = "<h3> Reviews: {$href}</h3>";
			$html .= '<div>';
			foreach($reviews as $review) {
				$html .= '<div class="div-reviewsPeli">';
				$html .= '<div>';
				$html .= "<p>Puntuación: {$review->stars()}/5</p>";
				$html .= "<p>{$review->time_created()}</p>";
				$html .= "<p>{$review->user()}</p><p>";
				if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esModerador"] == true || $_SESSION["esAdmin"] == true || $review->user() == $_SESSION['nombre'])) {
					$html .= "<a href=\"./editarReview.php?id={$review->id()}\">Editar</a>";
					$html .= "<a href=\"./eliminarReview.php?id={$review->id()}\"> Eliminar</a>";
				}
				$html .= '</p></div>';
				$html .= "<p>{$review->review()}</p>";
				$html .= '</div>';
			}
			$html .= '</div>';
		}

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

    function busqueda($search)
    {
		$peliculas = Pelicula::busqueda($search);
		$html = '';
		if (!empty($peliculas)) {
			$html .= '<h3> Películas: </h3>';
			$html .= '<ul>';
			foreach($peliculas as $pelicula) {
				$text = substr($pelicula->date_released(), 0, 4);
				$html .= "<p><a href=\"./pelicula.php?id={$pelicula->id()}\">{$pelicula->title()} ({$text})</a></p>";
			}
			$html .= '</ul>';
		}

		return $html;
    }
}