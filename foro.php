<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/foro_utils.php';

$tituloPagina = 'Foro';

$contenidoPrincipal='<h1>Foro</h1>';
if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esGestor"] == true || $_SESSION["esAdmin"] == true)) {
	$contenidoPrincipal .= '<a href="nuevoEventoTema.php">Añadir evento/tema</a>';
}

$contenidoPrincipal.= listaEventos();
$contenidoPrincipal.= listaTemas();


require __DIR__ . '/includes/plantillas/plantilla.php';