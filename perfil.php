<?php

require_once __DIR__.'/includes/config.php';

function mostrarPerfil() {
    $usuario = new es\ucm\fdi\aw\usuarios();
    $result = "<h1>". $_SESSION["nombre"] ."</h1>";
    if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
        $result .= '<a href="editarPerfil.php">Editar Perfil</a>';

    }
    $result .= $usuario->getDivUsuario();
    return $result;
}

$tituloPagina = 'Usuario';

$contenidoPrincipal=mostrarPerfil();

require __DIR__ . '/includes/plantillas/plantilla.php';