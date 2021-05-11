<?php
namespace es\ucm\fdi\aw;
class plataformas
{
	function listaPlataformasPelicula($id)
	{
		$html = '';
		$plataformas = Plataforma::buscaPlataformaPorIdPelicula($id);
        $link = Plataforma::buscaEnlacePorPlataformaPorIdPelicula($id);
		foreach($plataformas as $plataforma) {
		
			$html .= '<div class="row-plataforma">';
			$html .= "{$plataforma->nombre()} ({$plataforma->image()} ({$link})";
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