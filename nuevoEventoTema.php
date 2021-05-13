<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\eventosTemas\FormularioNuevoEventoTema();
$htmlFormNuevoEventoTema = $form->gestiona();

$tituloPagina = 'Añadir Evento/Tema';

$contenidoPrincipal = <<<EOS
    <h1>Añadir evento/tema</h1>
    $htmlFormNuevoEventoTema
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';