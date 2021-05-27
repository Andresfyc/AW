<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';
require_once __DIR__.'/includes/reviews/Review.php';

use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Reviews';
$contenidoPrincipal='<h1>Reviews</h1>';

function mostrarReviewsUser() {

	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
	$Usuario = getUsuarioPorUser($id);
	$html="";
	$html .= listaReviewsUser($Usuario->user());
        
	return $html;
}

$contenidoPrincipal.= mostrarReviewsUser();


require __DIR__ . '/includes/plantillas/plantilla.php';