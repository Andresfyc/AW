<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class reviews
{



	function listaReviews($id)
	{
		$html = '';
		$reviews = Review::buscaReviewsPorIdPeli($id);
		foreach($reviews as $review) {
		
			$html .= '<div class="row-mensaje">';
			$html .= "Puntuación: {$review->stars()}/5";
			$html .= "{$review->review()} ({$review->user()}) [{$review->time_created()}]  ";
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esModerador"] == true || $_SESSION["esAdmin"] == true || $review->user() == $_SESSION['nombre'])) {
				$html .= "<a href=\"./editarReview.php?id={$review->id()}\">Editar</a>";
				$html .= "<a href=\"./eliminarReview.php?id={$review->id()}\"> Eliminar</a>";
			}
			$html .= '</div>';
		}

		return $html;
	}
    
	function getReviewPorId($id)
	{
		return Review::buscaPorId($id);
	}

	function eliminarReviewPorId($id)
	{
		return Review::borraPorId($id);
	}
}