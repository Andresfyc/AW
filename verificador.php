<?php

require_once __DIR__ . '/includes/config.php';

use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\peliculas\Pelicula;
use es\ucm\fdi\aw\Aplicacion;

$tituloPagina = 'FilmSwap';

if(!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid']) ) {
    $paymentID = $_GET['paymentID'];
    $payerID = $_GET['payerID'];
    $token = $_GET['token'];
    $pid = $_GET['pid'];
    $user = $_GET['user'];

    if (!empty($_GET['meses'])) {
        $meses = $_GET['meses'];
        Usuario::acPremium($meses, $user);
        $app = Aplicacion::getSingleton();
        $app->login(Usuario::buscaUsuario($user));
    } else {
        Pelicula::addPeliculaComprada($user, $pid);
    }



$contenidoPrincipal = <<<EOS

      <script src="js/sweetAlert.js">  </script>
            <h1>Verificacion</h1>
     <div class="alert alert-success">
        <h3>Su suscripción se ha procesado correctamente.<h3>
     </div>
    <div>
        <p>Payment Id: {$paymentID} </p>
        <p>Payer Id: {$payerID} </p>
        <p>Product Id: {$pid}</p>
    </div>

   

EOS;


}


require __DIR__ . '/includes/plantillas/plantilla.php';