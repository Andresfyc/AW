<?php
namespace es\ucm\fdi\aw;

class actoresDirectores
{

	function listaActoresDirectores($user = NULL, $limit = NULL, $actorDirector)
	{		
		$html = '<div>';
		$actores = ActorDirector::buscaActoresDirectoresPorUser($user, $limit, $actorDirector);
		foreach($actores as $actor) {
			$href = './actoresDirectores.php?id=' . $actor->id();
			$html .= '<div class="div-actoresDirectores">';
			$html .= "<img id=\"prof_pic\" src=\"img/actores_directores/{$actor->image()}\" alt=\"actor/director\" width=\"60\" height=\"90\">";
			$html .= '<div>';
			$html .= "<p><a href=\"$href\">{$actor->name()}</a></p>";
			$year = substr($actor->birth_date(), 0, 4);
			$html .= "<p>{$year}</p>";
			$html .= '</div>';
			$html .= '</div>';
		}
		$html .= '</div>';

		return $html;
	}

    function busqueda($search)
    {
		$actoresDirectores = ActorDirector::busqueda($search);
		$html = '';
		if (!empty($actoresDirectores)) {
			$html .= '<h3> Actores y Directores: </h3>';
			$html .= '<ul>';
			foreach($actoresDirectores as $actorDirector) {
				$text = substr($actorDirector->birth_date(), 0, 4);
				$html .= "<p><a href=\"./actorDirector.php?id={$actorDirector->id()}\">{$actorDirector->name()} ({$text})</a></p>";
			}
			$html .= '</ul>';
		}

		return $html;
    }
}