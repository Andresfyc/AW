<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__ . '/includes/comun/suscripcion_utils.php';

use es\ucm\fdi\aw\Aplicacion;


function mostrarPlanes() {

    $app = Aplicacion::getSingleton();

    if ($app->usuarioLogueado() && ($app->esPremium())) {
        $html = "<h1>Socio</h1>";
        $html .= "<a class='premium' ><i class='fa fa-star' ></i> Premium </a>";

    }else{
        $html = "<h1>Planes</h1>";
        $html .= listaPlanes();
    }
//    $html .= listaPlanes();

    return $html;
}



$tituloPagina = 'Premium';
$contenidoPrincipal=mostrarPlanes();


require __DIR__ . '/includes/plantillas/plantilla.php';