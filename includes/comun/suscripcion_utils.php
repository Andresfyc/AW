<?php

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\suscripcion\Suscripcion;


function getDivPlanes($planes)
{
    $app = Aplicacion::getSingleton();

    $html = '<div class="planes">';
    $prevLink = urlencode($_SERVER['REQUEST_URI']);

    foreach ($planes as $plan) {
        $html .= '<div class="plan">';
        if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
            $html .=<<<EOS
			<a class="editar" href="./editarPlan.php?id={$plan->id()}&prevPage={$prevLink}">Editar</a>
			<a class="eliminar" href="./eliminarPlan.php?id={$plan->id()}&prevPage={$prevLink}">Eliminar</a>
		EOS;
        } else {
            $html .= '<h1>Suscríbete</h1>';
        }
        $textMeses = $plan->meses();
        $textMeses = strlen($textMeses) > 40 ? substr($textMeses, 0, 40) . '...' : $textMeses;
        $textPrecio = $plan->precio();
        $textPrecio = strlen($textPrecio) > 40 ? substr($textPrecio, 0, 40) . '...' : $textPrecio;
        $html .= <<<EOS
            <h1>$textMeses Meses</h1>
            <h3>$textPrecio <i class="fa fa-eur"></i></h3>
            <a class="empezar" href="carrito.php?id={$plan->id()}&tipo=plan"><i class="fa fa-paypal" ></i> Empezar </a>
            </div>
            
           EOS;

    }
    $html .= '</div>';

    return $html;
}

function listadoPlanes()
{
	$app = Aplicacion::getSingleton();
    $prevLink = urlencode($_SERVER['REQUEST_URI']);
    $html = '<a href="'.RUTA_APP.'nuevoPlan.php?prevPage='.$prevLink.'">Añadir plan</a>';
    $planes = Suscripcion::listaPlanes();
    foreach($planes as $plan) {
    
        $html .= '<div class="row-item">';
        $html .= "<p>Meses: {$plan->meses()} ({$plan->precio()}) ";
        if ($app->usuarioLogueado() && ($app->esAdmin() || $app->esGestor())) {
            $html .= '<a href="'.RUTA_APP.'editarPlan.php?id='.$plan->id().'&prevPage='.$prevLink.'">Editar</a>';
            $html .= '<a href="'.RUTA_APP.'eliminarPlan.php?id='.$plan->id().'&prevPage='.$prevLink.'"> Eliminar</a>';
        }
        $html .= '</p></div>';
    }

    return $html;
}


function listaPlanes()
{
    $planes = Suscripcion::listaPlanes();
    return getDivPlanes($planes);
}

function buscaMesesPorId($id)
{
    $plan = Suscripcion::buscaPorId($id);
    return $plan;
}

function eliminarPlanPorId($id)
{
    return Suscripcion::borraPorId($id);
}


function pagarPaypalPlan($plan)
{
    $app = Aplicacion::getSingleton();
    $total = $plan->precio();
    $meses = $plan->meses();
    $user = $app->user();
    $productId = $plan->id();
    $RUTA_APP = RUTA_APP;

    $html = '<div id="paypal-button"></div>';


        $html .= <<<EOS
        
        <script>
            paypal.Button.render({
            // Configure environment
        env: 'sandbox',
        client: {
        sandbox: 'ARQl_tpu0jLSamyry95i9aHyXWF3O6byxfEfrUq_KGHVHNp9othxvOYoPSQcDXOm2sDHwrJWH450V405',
        production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'es_ES',
        style: {
            size: 'small',
            color: 'gold',
            shape: 'pill',
        },

           // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
          return actions.payment.create({
            transactions: [{
              amount: {
                total: '$total',
                currency: 'EUR'
              },
            }]
          });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
          return actions.payment.execute().then(function() {
            // Show a confirmation message to the buyer
            window.location="{$RUTA_APP}verificador.php?paymentID="+data.paymentID+"&payerID="+data.payerID+"&token="+data.paymentToken+"&pid={$productId}&meses={$meses}&user={$user}";
            }); 
             } 
         }, "#paypal-button"); 
      </script> 
    EOS;

        return $html;

}