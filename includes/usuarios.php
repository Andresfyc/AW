<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class usuarios
{

	function listaAmigos($user = NULL, $limit = NULL)
	{
		$html = '<ul>';
		$usuarios = Usuario::buscaAmigosPorUser($user, $limit);
		foreach($usuarios as $usuario) {
			$href = './actoresDirectores.php?id=' . $usuario->user();
			$html .= '<li>';
			$peliculaWatching = $usuario->film();
			if (!$peliculaWatching) {
				$html .= "<a href=\"$href\">{$usuario->user()} </a>";
			} else {
				$html .= "<a href=\"$href\">{$usuario->user()} (Viendo: {$peliculaWatching->title()})</a>";
			}
			$html .= '</li>';
		}
		$html .= '</ul>';

		return $html;
	}
}