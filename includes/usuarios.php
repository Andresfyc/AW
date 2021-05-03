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


    function getDivUsuario() {
        if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
            $html = ' <fieldset>';
            $html .= '<div>';
            $html .= "<img id=\"film_pic\" src=\"img/{$_SESSION["imagen"]}\" alt=\"imagen\" width=\"300\" height=\"300\">";
            $html .= '</div>';
            $html .= '<div>';
            $html .= "<label><h3>Nombre:</h3></label>{$_SESSION["nombre"]} ";
            $html .= '</div>';
            $html .= ' </fieldset>';
            return $html;
        }


    }

    function getUsuarioPorUser($user)
    {
        return Usuario::buscaUsuario($user);
    }

}