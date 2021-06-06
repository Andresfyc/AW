<?php

require_once __DIR__ . '/includes/config.php';

$tituloPagina = 'FilmSwap';

if(!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid']) ) {
    $paymentID = $_GET['paymentID'];
    $payerID = $_GET['payerID'];
    $token = $_GET['token'];
    $pid = $_GET['pid'];

$contenidoPrincipal = <<<EOS
    <h1>Verificacion</h1>
     <div class="alert alert-success">
        <strong>Success!</strong> Your order processed successfully.
     </div>
    <table>
        <tr>
            <td>Payment Id: {$paymentID} </td>
            <td>Payer Id: {$payerID} </td>
            <td>product Id: {$pid}</td>
        </tr>
    </table
EOS;
}


require __DIR__ . '/includes/plantillas/plantilla.php';