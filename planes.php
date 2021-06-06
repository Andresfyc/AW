<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/suscripcion_utils.php';

$tituloPagina = 'Planes';
$contenidoPrincipal='<h1>Planes</h1>';

function mostrarPlanes() {

	$html= listadoPlanes();
        
	return $html;
}

$contenidoPrincipal.= mostrarPlanes();


require __DIR__ . '/includes/plantillas/plantilla.php';