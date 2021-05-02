<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class eventosTemas
{

	function listaEventos()
	{
		$html = '';
		$eventos = EventoTema::buscaEventosRecientes();
		foreach($eventos as $evento) {
			$href = './eventoTema.php?id=' . $evento->id() . '&nombre=' . $evento->name() . '&time=' . $evento->time();

			$html .= '<div class="row">';

			$html .= '<div class="col" id="col-4-1">';
			$html .= "<p><a href=\"$href\">{$evento->name()} </a></p>";
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esGestor"] == true || $_SESSION["esAdmin"] == true)) {
				$html .= "<p><a href=\"./editarEventoTema.php?id={$evento->id()}\">Editar</a> <a href=\"./eliminarEventoTema.php?id={$evento->id()}\">Eliminar</a></p>";
			}
			$html .= '</div>';

			$html .= '<div class="col" id="col-4-2">';
			$html .= "<p>{$evento->description()}</p>";
			$html .= '</div>';

			$html .= '<div class="col" id="col-4-3">';
			$html .= "<p>{$evento->time()}</p>";
			$html .= '</div>';

			$html .= '<div class="col" id="col-4-4">';
			$html .= "<p>{$evento->num_messages()}</p>";
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;
	}

	function listaTemas()
	{
		$html = '';
		$temas = EventoTema::buscaTemas();
		foreach($temas as $tema) {
			$href = './eventoTema.php?id=' . $tema->id() . '&nombre=' . $tema->name() . '&time=' . $tema->time();

			$html .= '<div class="row">';

			$html .= '<div class="col" id="col-3-1">';
			$html .= "<p><a href=\"$href\">{$tema->name()} </a></p>";
			if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esGestor"] == true || $_SESSION["esAdmin"] == true)) {
				$html .= "<p><a href=\"./editarEventoTema.php?id={$tema->id()}\">Editar</a> <a href=\"./eliminarEventoTema.php?id={$tema->id()}\">Eliminar</a></p>";
			}
			$html .= '</div>';

			$html .= '<div class="col" id="col-3-2">';
			$html .= "<p>{$tema->description()}</p>";
			$html .= '</div>';

			$html .= '<div class="col" id="col-3-3">';
			$html .= "<p>{$tema->num_messages()}</p>";
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;
	}

	function getEventoTemaPorId($id)
	{
		return EventoTema::buscaPorId($id);
	}

	function eliminarEventoTemaPorId($id)
	{
		return EventoTema::borraPorId($id);
	}
}