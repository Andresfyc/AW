<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/comun/suscripcion_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$app = Aplicacion::getSingleton();

$plan = buscaMesesPorId($id);

$usuario = $app->usuarioLogueado();

$tituloPagina = 'Carrito';

$contenidoPrincipal = <<<EOS
            <!--        <h1 id="tpremium">¿Por qué pasarte a Premium?</h1>-->
                <div class="grupo-fomulario">
                <h1>Plan</h1>  
                    <label> Meses: {$plan->meses()} </label> 
                    <label> Precio: {$plan->precio()} <i class="fa fa-eur"></i></label>
        EOS;

        $prevLink = urlencode($_SERVER['REQUEST_URI']);

if($app->usuarioLogueado()) 
{
    $contenidoPrincipal.= pagarPaypal($plan);
}else{

    header("location:login.php?prevPage={$prevLink}");

}
$contenidoPrincipal .=  '<div>';


require __DIR__ . '/includes/plantillas/plantilla.php';