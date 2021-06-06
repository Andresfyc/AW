<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__ . '/includes/comun/suscripcion_utils.php';

use es\ucm\fdi\aw\Aplicacion;


function mostrarPlanes() {

    $app = Aplicacion::getSingleton();

    if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
        $html = "<h1>Planes</h1>";
        $html .= '<a href="'.RUTA_APP.'nuevoPlan.php">Añadir Plan</a>';
        $html .= listaPlanes();
    }
    if ($app->usuarioLogueado() && ($app->esPremium())) {
        $html .= "<a class='premium' ><i class='fa fa-star' ></i> Premium </a>";

    }
    else{
        $html = "<h1>Planes</h1>";
        $html .= listaPlanes();
    }
//    $html .= listaPlanes();

    return $html;
}



$tituloPagina = 'Premium';
$contenidoPrincipal=mostrarPlanes();


require __DIR__ . '/includes/plantillas/plantilla.php';