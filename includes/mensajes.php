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
			$html .= "<p>{$mensaje->text()} ({$mensaje->user()}) [{$mensaje->time_created()}]</p>";
			$html .= '</div>';
		}

		return $html;
	}
}