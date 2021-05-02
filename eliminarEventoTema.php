<?php

require_once __DIR__.'/includes/config.php';

$idEventoTema = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$eventosTemas = new es\ucm\fdi\aw\eventosTemas();
$eventoTema = $eventosTemas->getEventoTemaPorId($idEventoTema);

$tituloPagina = 'Eliminar Evento/Tema';

if(array_key_exists('cancelar', $_POST)) {
    header('Location: foro.php');
}
else if(array_key_exists('eliminar', $_POST)) {
    $eventosTemas->eliminarEventoTemaPorId($idEventoTema);
    header('Location: foro.php');
}

$contenidoPrincipal = <<<EOS
<h1>Eliminar evento/tema</h1>
<p> ¿Quiere eliminar definitivamente el evento/tema {$eventoTema->name()}?</p>
<form method="post">
    <input type="submit" name="cancelar"
            class="button" value="Cancelar" />
        
    <input type="submit" name="eliminar"
            class="button" value="Eliminar" />
</form>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';