<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\peliculas\FormularioNuevaPelicula();
$htmlFormNuevaPelícula = $form->gestiona();

$tituloPagina = 'Añadir Película';

$contenidoPrincipal = <<<EOS
    <h1>Añadir Película</h1>
    $htmlFormNuevaPelícula
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';