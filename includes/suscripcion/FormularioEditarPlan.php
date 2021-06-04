<?php


namespace es\ucm\fdi\aw\suscripcion;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioEditarPlan extends Form
{

    private $id;
    private $plan;

    public function __construct($id)
    {
        parent::__construct('formEditarPlan', $id);
        $this->id = $id;
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {

        $id = $datos['id'] ?? $this->id;
        $this->plan = Suscripcion::buscaPorId($id);
        $meses = $datos['meses'] ?? $this->plan->meses();
        $precio = $datos['precio'] ?? $this->plan->precio();;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorMeses = self::createMensajeError($errores, 'meses', 'span', array('class' => 'error'));
        $errorPrecio = self::createMensajeError($errores, 'precio', 'span', array('class' => 'error'));



        $camposFormulario = <<<EOF
        <fieldset>
            $htmlErroresGlobales
                 <input class="control" type="hidden" name="id" value="$id" readonly/>
            <div class="grupo-control">
                <label>Meses:</label> <input class="control" type="text" name="meses" value="$meses" />$errorMeses
            </div>
            <div class="grupo-control">
                <label>Precio:</label> <input class="control" type="text" name="precio" value="$precio" /> $errorPrecio
            </div>
         
            <div class="grupo-control"><button type="submit" name="registro">Actualizar</button></div>
        </fieldset>
    EOF;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario($datos)
    {

        $result = array();
        $app = Aplicacion::getSingleton();

        $id = $datos['id'] ?? null;

        $meses = $datos['meses'] ?? null;
        if ( empty($meses) || mb_strlen($meses) < 1 ) {
            $result['meses'] = "Los meses tiene que tener una longitud de al menos 1 caracteres.";
        }

        $precio = $datos['precio'] ?? null;
        if ( empty($precio) || mb_strlen($precio) < 1 ) {
            $result['precio'] = "El precio tiene que tener una longitud de al menos 1 caracteres.";
        }


        if (count($result) === 0) {
            //$plan = Suscripcion::buscaPorId($meses);
            if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
                echo "$id";
                $plan = Suscripcion::editar($id, $meses, $precio);
                if ( ! $plan  ) {
                    $result[] = "El plan ya existe";
                } else {
//                    $app->login($usuario);
                    $result = RUTA_APP."premium.php";
                }
            }
        }
        return $result;
    }
}