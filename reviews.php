<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$tituloPagina = 'Reviews';
$contenidoPrincipal='<h1>Reviews</h1>';

function mostrarReviewsUser() {

	$userIn = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	$html="";
	$html .= listaReviewsUser($userIn);
        
	return $html;
}

$contenidoPrincipal.= mostrarReviewsUser();


require __DIR__ . '/includes/plantillas/plantilla.php';