<?php

require_once __DIR__.'/includes/config.php';

$idMensaje = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\mensajes\FormularioEditarMensaje($idMensaje, urldecode($prevPage));
$FormularioEditarmensaje = $form->gestiona();

$tituloPagina = 'Editar Mensaje';

$contenidoPrincipal = <<<EOS
	<h1>Editar Mensaje</h1>
	$FormularioEditarmensaje
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';