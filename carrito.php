<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/comun/suscripcion_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$app = Aplicacion::getSingleton();

$plan = buscaMesesPorId($id);


$tituloPagina = 'Carrito';

$contenidoPrincipal = <<<EOS
        <h1 id="tpremium">¿Por qué pasarte a Premium?</h1>
            <div class="pagina-carrito">
                <fieldset>
                <legend>Plan: </legend>
                    <h3> Meses: {$plan->meses()}</h3>
                    <h3> Precio: {$plan->precio()} <i class="fa fa-eur"></i></h3>
        EOS;
$contenidoPrincipal.= pagarPaypal($plan);
$contenidoPrincipal.= '</fieldset>';
$contenidoPrincipal.= '<div>';

require __DIR__ . '/includes/plantillas/plantilla.php';