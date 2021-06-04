<?php
namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioNuevoMensaje extends Form
{

    private $id;
    private $name;
    private $time;
    
    public function __construct($id, $name, $time) {
        parent::__construct('formNuevoMensaje', $id);
        $this->id = $id;
        $this->name = $name;
        $this->time = $time;
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $mensaje = $datos['text'] ?? '';
        $id = $datos['id'] ?? $this->id;
        $name = $datos['name'] ?? $this->name;
        $time = $datos['time'] ?? $this->time;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorText = self::createMensajeError($errores, 'mensaje', 'span', array('class' => 'error'));


        $camposFormulario = <<<EOF
            <div class="grupo-fomulario">
                $htmlErroresGlobales
                <h1>Añadir Mensaje</h1>
                    <input type="hidden" name="id" value="$id" readonly/>
                    <input  type="hidden" name="name" value="$name" readonly/>
                    <input  type="hidden" name="time" value="$time" readonly/>
                    <textarea class="control" type="text" name="text" value="$mensaje" placeholder="Mensaje..." required />$mensaje</textarea>$errorText
                
                <button type="submit" name="nuevoMensaje">Publicar</button>
                </div>
            
        EOF;
        return $camposFormulario;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();
        $app = Aplicacion::getSingleton();
        
        $id = $datos['id'] ?? null;
        $name = $datos['name'] ?? null;
        $time = $datos['time'] ?? null;

        $text = $datos['text'] ?? null;
        if ( empty($text)  ) {
            $result['text'] = "El mensaje no puede estar vacío.";
        }

        if (count($result) === 0) {
            if ($app->usuarioLogueado())
            $mensaje = Mensaje::crea($id, $app->user(), $text);
                if ( ! $mensaje ) {
                    $result[] = "Error";
                } else {
                    $result = RUTA_APP."eventoTema.php?id={$id}&name={$name}&time={$time}";
                }
            }
        
        return $result;
    }
}