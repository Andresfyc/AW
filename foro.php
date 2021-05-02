<?php

require_once __DIR__.'/includes/config.php';

$eventosTemas = new es\ucm\fdi\aw\eventosTemas();

$tituloPagina = 'Foro';

$contenidoPrincipal='<h1>Foro</h1>';
if (isset($_SESSION["login"]) && ($_SESSION["login"]===true) && ($_SESSION["esGestor"] == true || $_SESSION["esAdmin"] == true)) {
	$contenidoPrincipal .= '<a href="NuevoEventoTema.php">Añadir evento/tema</a>';
}

$contenidoPrincipal.=<<<EOS
	<h3>Eventos</h3>
	<div class="row-top">
		<div class="col" id="col-4-1">
			<p>Nombre</p>
		</div>
		<div class="col" id="col-4-2">
			<p>Descripción</p>
		</div>
		<div class="col" id="col-4-3">
			<p>Fecha y/o Hora</p>
		</div>
		<div class="col" id="col-4-4">
			<p>#Mensajes</p>
		</div>
	</div>
EOS;
$contenidoPrincipal .= $eventosTemas->listaEventos();

$contenidoPrincipal.=<<<EOS
	<h3>Temas</h3>
	<div class="row-top">
		<div class="col" id="col-3-1">
			<p>Nombre</p>
		</div>
		<div class="col" id="col-3-2">
			<p>Descripción</p>
		</div>
		<div class="col" id="col-3-3">
			<p>#Mensajes</p>
		</div>
	</div>
EOS;
$contenidoPrincipal .= $eventosTemas->listaTemas();


require __DIR__ . '/includes/plantillas/plantilla.php';