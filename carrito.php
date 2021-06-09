<?php

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/comun/suscripcion_utils.php';
require_once __DIR__ . '/includes/comun/peliculas_utils.php';

use es\ucm\fdi\aw\Aplicacion;

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$tipo = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_STRING);

$app = Aplicacion::getSingleton();
$usuario = $app->usuarioLogueado();

if ($tipo == "plan"){
    $plan = buscaMesesPorId($id);

    $contenidoPrincipal = <<<EOS
            <div class="grupo-fomulario">
            <h1>Plan</h1>  
                <label> Meses: {$plan->meses()} </label> 
                <label> Precio: {$plan->precio()} <i class="fa fa-eur"></i></label>
    EOS;

} else if ($tipo == "pelicula"){
    $pelicula = buscaPeliculaPorId($id);

    $contenidoPrincipal = <<<EOS
            <div class="grupo-fomulario">
            <h1>Película</h1>  
                <label> Título: {$pelicula->title()} </label> 
                <label> Precio: {$pelicula->price()} <i class="fa fa-eur"></i></label>
    EOS;
}


$tituloPagina = 'Carrito';

$prevLink = urlencode($_SERVER['REQUEST_URI']);
if($app->usuarioLogueado()) 
{
    if ($tipo == "plan") {
        $contenidoPrincipal.= pagarPaypalPlan($plan);
    } else if ($tipo == "pelicula") {
        $contenidoPrincipal.= pagarPaypalPelicula($pelicula);
    }
}else{
    header("location:login.php?prevPage={$prevLink}");
}
$contenidoPrincipal .=  '<div>';


require __DIR__ . '/includes/plantillas/plantilla.php';