<?php
namespace es\ucm\fdi\aw;

class FormularioNuevoMensaje extends Form
{

    private $id;
    private $name;
    private $time;

    public function __construct($id, $name, $time) {
        $this->id = $id;
        $this->name = $name;
        $this->time = $time;
        parent::__construct('formNuevoMensaje');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $mensaje = $datos['mensaje'] ?? '';
        $id = $datos['id'] ?? $this->id;
        $name = $datos['name'] ?? $this->name;
        $time = $datos['time'] ?? $this->time;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorMensaje = self::createMensajeError($errores, 'mensaje', 'span', array('class' => 'error'));

        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <div class="grupo-control">
                    <input class="control" type="hidden" name="id" value="$id" readonly/>
                    <input class="control" type="hidden" name="name" value="$name" readonly/>
                    <input class="control" type="hidden" name="time" value="$time" readonly/>
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
        
        $id = $datos['id'] ?? null;
        $name = $datos['name'] ?? null;
        $time = $datos['time'] ?? null;

        $mensaje = $datos['mensaje'] ?? null;
        if ( empty($mensaje)  ) {
            $result['mensaje'] = "El mensaje no puede estar vacío.";
        }

        if (count($result) === 0) {
            $mensaje = Mensaje::crea($id, $_SESSION['nombre'], $mensaje);
            if ( ! $mensaje ) {
                $result[] = "Error";
            } else { //TODO Añadir una redirección al tema/evento
                $result = "eventoTema.php?id={$id}&nombre={$name}&time={$time}";
            }
        }
        return $result;
    }
}