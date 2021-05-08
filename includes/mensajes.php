<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class mensajes
{



	function listaMensajes($id)
	{
		$html = '';
		$mensajes = Mensaje::buscaMensajesPorIdEventoTema($id);
		foreach($mensajes as $mensaje) {
		
			$html .= '<div class="row-mensaje">';
			$html .= "{$mensaje->text()} ({$mensaje->user()}) [{$mensaje->time_created()}]  ";
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esGestor"] == true || $_SESSION["esAdmin"] == true)) {
				$html .= "<a href=\"./FormularioEditarMensaje.php?id={$mensaje->id()}\">Editar</a>";
				$html .= "<a href=\"./eliminarMensaje.php?id={$mensaje->id()}\"> Eliminar</a>";
			}
			$html .= '</div>';
		}

		return $html;
	}
	function getMensajePorId($id)
	{
		return Mensaje::buscaPorId($id);
	}

	function eliminarMensajePorId($id)
	{
		return Mensaje::borraPorId($id);
	}
}