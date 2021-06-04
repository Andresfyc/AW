<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/suscripcion_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$idPlan = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPag = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);
$prevPageId = filter_input(INPUT_GET, 'prevId', FILTER_SANITIZE_NUMBER_INT);

if (strlen($prevPageId) > 0) {
    $prev = RUTA_APP . $prevPag . ".php?id=" . $prevPageId;
} else {
    $prev = RUTA_APP . $prevPag . ".php";
}

$plan = buscaMesesPorId($idPlan);

$tituloPagina = 'Eliminar Plan';

$precio= substr($plan->precio(), 0, 4);

if(array_key_exists('cancelar', $_POST)) {
    header('Location: '.$prev);
}
else if(array_key_exists('eliminar', $_POST)) {
    $app = Aplicacion::getSingleton();
    if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
        eliminarPlanPorId($idPlan);
        header('Location: '.RUTA_APP.'premium.php');
    }
}

$contenidoPrincipal = <<<EOS
    <h1>Eliminar Plan</h1>
    <p> ¿Quiere eliminar definitivamente el plan "{$plan->meses()} de {$precio} Euros"?</p>
    <form method="post">
        <input type="submit" name="cancelar"
                class="button" value="Cancelar" />
            
        <input type="submit" name="eliminar"
                class="button" value="Eliminar" />
    </form>
EOS;

require __DIR__.'/includes/plantillas/plantilla.php';