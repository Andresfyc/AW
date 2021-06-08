<?php

require_once __DIR__.'/includes/config.php';

$idEventoTema = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$form = new es\ucm\fdi\aw\mensajes\FormularioNuevoMensaje($idEventoTema, urldecode($prevPage));
$htmlFormNuevoMensaje = $form->gestiona();

$tituloPagina = 'Añadir Mensaje';

$contenidoPrincipal = <<<EOS
<!--    <h4>Añadir Mensaje</h4>-->
    $htmlFormNuevoMensaje
EOS;

require __DIR__ . '/includes/plantillas/plantilla.php';