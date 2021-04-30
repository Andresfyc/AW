<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class actoresDirectores
{

	function listaActoresDirectores($user = NULL, $limit = NULL, $actorDirector)
	{
		$html = '<ul>';
		$actores = ActorDirector::buscaActoresDirectoresPorUser($user, $limit, $actorDirector);
		foreach($actores as $actor) {
			$href = './actoresDirectores.php?id=' . $actor->id();
			$html .= '<li>';
			$html .= "<a href=\"$href\">{$actor->name()}</a>";
			$html .= '</li>';
		}
		$html .= '</ul>';

		return $html;
	}
}