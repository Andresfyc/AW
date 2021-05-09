<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

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
}