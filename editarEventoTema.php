<?php

require_once __DIR__.'/includes/config.php';

$idEventoTema = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$eventosTemas = new es\ucm\fdi\aw\eventosTemas();
$eventoTema = $eventosTemas->getEventoTemaPorId($idEventoTema);

$form = new es\ucm\fdi\aw\FormularioEditarEventoTema($eventoTema);
$htmlFormEditarEventoTema = $form->gestiona();

$tituloPagina = 'Editar Evento/Tema';

$contenidoPrincipal = <<<EOS
<h1>Editar Evento/Tema</h1>
$htmlFormEditarEventoTema
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';