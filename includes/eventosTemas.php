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
			$href = './evento.php?id=' . $evento->id() . '&nombre=' . $evento->name();

			$html .= '<div class="row">';

			$html .= '<div class="col" id="col-4-1">';
			$html .= "<p><a href=\"$href\">{$evento->name()} </a></p>";
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
			$href = './tema.php?id=' . $tema->id() . '&nombre=' . $tema->name();

			$html .= '<div class="row">';

			$html .= '<div class="col" id="col-3-1">';
			$html .= "<p><a href=\"$href\">{$tema->name()} </a></p>";
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
}