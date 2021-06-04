<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__ . '/includes/comun/suscripcion_utils.php';

use es\ucm\fdi\aw\Aplicacion;



function mostrarPlanes() {

    $table = filter_input(INPUT_GET, 'table', FILTER_SANITIZE_STRING);
    $value = filter_input(INPUT_GET, 'value', FILTER_SANITIZE_STRING);

    $app = Aplicacion::getSingleton();
    $html = "<h1>Planes</h1>";
    if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
    }
    $html .= listaPlanes();

    return $html;
}
function dropdown_ordenacion() {


}

$tituloPagina = 'Premium';
$contenidoPrincipal=mostrarPlanes();


require __DIR__ . '/includes/plantillas/plantilla.php';