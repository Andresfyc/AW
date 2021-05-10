<?php
namespace es\ucm\fdi\aw;

//require_once __DIR__.'/config.php';

class plataformas
{
	function listaPlataformasPelicula($id)
	{
		$html = '';
		$plataformas = Plataforma::buscaPlataformaPorIdPelicula($id);
		foreach($plataformas as $plataforma) {
		
			$html .= '<div class="row-plataforma">';
			$html .= "{$plataforma->nombre()} ({$plataforma->image()})";
			$html .= '</div>';
		}

		return $html;
	}
	function getPlataformaPorId($id)
	{
		return Plataforma::buscaPorId($id);
	}

	function eliminarPlataformaPorId($id)
	{
		return Plataforma::borraPorId($id);
	}
}