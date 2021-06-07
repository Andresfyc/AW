<?php

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/comun/suscripcion_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$idPlan = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$prevPage = filter_input(INPUT_GET, 'prevPage', FILTER_SANITIZE_STRING);

$plan = buscaMesesPorId($idPlan);

$tituloPagina = 'Eliminar Plan';

$precio= substr($plan->precio(), 0, 4);

$prev = urldecode($prevPage);
if(array_key_exists('cancelar', $_POST)) {
    header('Location: '.$prev);
}
else if(array_key_exists('eliminar', $_POST)) {
    $app = Aplicacion::getSingleton();
    if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
        eliminarPlanPorId($idPlan);
        header('Location: '.$prev);
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