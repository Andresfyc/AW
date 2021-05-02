<?php
namespace es\ucm\fdi\aw;

class FormularioNuevoMensaje extends Form
{


    public function __construct() {
        parent::__construct('formNuevoMensaje');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $mensaje = $datos['mensaje'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorMensaje = self::createMensajeError($errores, 'mensaje', 'span', array('class' => 'error'));

        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <div class="grupo-control">
                    <label>Mensaje:</label> <input class="control" type="text" name="mensaje" value="$mensaje" />$errorMensaje
                </div>
                <div class="grupo-control"><button type="submit" name="nuevoMensaje">Publicar</button></div>
            </fieldset>
        EOF;
        return $html;
    }

    
    protected function procesaFormulario($datos)
    {
        $result = array();

        $mensaje = $datos['mensaje'] ?? null;
        if ( empty($mensaje)  ) {
            $result['mensaje'] = "El mensaje no puede estar vacío.";
        }

        if (count($result) === 0) {
            $mensaje = Mensaje::crea($_SESSION["tempIdEventoTema"], $_SESSION['nombre'], $mensaje);
            if ( ! $mensaje ) {
                $result[] = "Error";
            } else {
                $result = 'foro.php';
            }
        }
        return $result;
    }
}