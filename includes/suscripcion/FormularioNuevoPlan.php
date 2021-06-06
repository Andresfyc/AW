<?php

namespace es\ucm\fdi\aw\suscripcion;

use es\ucm\fdi\aw\Form;


class FormularioNuevoPlan extends Form
{

    public function __construct() {
        parent::__construct('formNuevoPlan');

    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $meses = $datos['meses'] ?? '';
        $precio = $datos['precio'] ?? '';


        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorMeses = self::createMensajeError($errores, 'meses', 'span', array('class' => 'error'));
        $errorPrecio = self::createMensajeError($errores, 'precio', 'span', array('class' => 'error'));


        $html = <<<EOF
                <div class="grupo-fomulario">
                $htmlErroresGlobales
                <h1>Nuevo PLan</h1>
                
                     <input  type="text" name="meses" value="$meses" placeholder="Meses..." required/>$errorMeses
                
                     <input  type="text" name="precio" value="$precio"  placeholder="Precio..." required/>$errorPrecio
              
                     <button type="submit" name="registro">Agregar</button>
                </div>
         EOF;

        return $html;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();

        $meses = $datos['meses'] ?? null;
        if ( empty($meses) ) {
            $result['meses'] = "Los meses deben ser mayor o igual a 1.";
        }

        $precio = $datos['precio'] ?? null;
        if ( empty($precio) ) {
            $result['precio'] = "El precio de ser mayor que 0.";
        }


        if (count($result) === 0) {

            $plan = Suscripcion::crea($meses, $precio);
            if ( ! $plan ) {
                $result[] = "El Plan ya existe";
            } else {
                $result = RUTA_APP.'premium.php';
            }
        }
        return $result;
    }
}