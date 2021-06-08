<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/foro_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'Foro';

$contenidoPrincipal='<h1>Foro</h1>';
$app = Aplicacion::getSingleton();
$prevLink = urlencode($_SERVER['REQUEST_URI']);
if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin() || $app->esModerador())) {
	$contenidoPrincipal .= '<a href="'.RUTA_APP.'nuevoEventoTema.php?prevPage='.$prevLink.'">Añadir evento/tema</a>';
} else if ($app->usuarioLogueado()) {
	$contenidoPrincipal .= '<a href="'.RUTA_APP.'nuevoEventoTema.php?prevPage='.$prevLink.'">Añadir tema</a>';
}

$contenidoPrincipal.= listaEventos();
$contenidoPrincipal.= listaTemas();


require __DIR__ . '/includes/plantillas/plantilla.php';