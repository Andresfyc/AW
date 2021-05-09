<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class usuarios
{

	function listaAmigos($user = NULL, $limit = NULL)
	{
		$html = '<div>';
		$usuarios = Usuario::buscaAmigosPorUser($user, $limit);
		foreach($usuarios as $usuario) {
			$href = './usuarios.php?id=' . $usuario->user();
			$html .= '<div class="div-usuarios">';
			$html .= '<div class="usuarios">';
			$html .= "<img id=\"prof_pic\" src=\"img/usuarios/{$usuario->image()}\" alt=\"user\" width=\"60\" height=\"60\">";
			$html .= '<div>';
			$html .= "<p><a href=\"$href\">{$usuario->user()} </a></p>";
			$html .= "<p>{$usuario->name()} </p>";
			$html .= '</div>';
			$html .= '</div>';
			$html .= '<div>';
			$peliculaWatching = $usuario->film();
			if ($peliculaWatching) {
				$html .= "<p><a href=> Viendo: {$peliculaWatching->title()} </a></p>";
			}
			$html .= '</div>';
			$html .= '</div>';
		}
		$html .= '</div>';

		return $html;
	}


    function getDivUsuario() {
		$usuario = self::getUsuarioPorUser($_SESSION["nombre"]);
        if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
            $html = '<div class="div-perfil">';
            $html .= "<img id=\"film_pic\" src=\"img/usuarios/{$_SESSION["imagen"]}\" alt=\"user\" width=\"150\" height=\"150\">";
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