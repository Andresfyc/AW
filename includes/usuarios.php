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
		$usuario = self::getUsuarioPorUser($_SESSION["nombre"]);
        if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
            $html = '<div class="div-perfil">';
            $html .= "<img id=\"film_pic\" src=\"img/usuarios/{$_SESSION["imagen"]}\" alt=\"imagen\" width=\"150\" height=\"150\">";
            $html .= '<div>';
			$html .= "<p>Usuario: {$usuario->user()}</p>";
			$html .= "<p>Nombre completo: {$usuario->name()}</p>";
			$html .= "<p>Correo electrónico: </p>";
			$html .= "<p>Fecha de registro: {$usuario->date_joined()}</p>";
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
				$html .= '<p><a href="editarPerfil.php">Editar Perfil</a></p>';
			}
            $html .= '</div>';
            $html .= '</div>';
            return $html;
        }


    }

    function getUsuarioPorUser($user)
    {
        return Usuario::buscaUsuario($user);
    }

}