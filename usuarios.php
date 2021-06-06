<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/usuarios_utils.php';

$tituloPagina = 'Usuarios';
$contenidoPrincipal='<h1>Usuarios</h1>';

function mostrarUsuarios() {

	$html= listadoUsuarios();
        
	return $html;
}

$contenidoPrincipal.= mostrarUsuarios();


require __DIR__ . '/includes/plantillas/plantilla.php';