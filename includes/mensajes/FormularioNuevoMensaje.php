<?php
namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioNuevoMensaje extends Form
{

    private $id;
    private $prevPage;
    
    public function __construct($id, $prevPage) {
        parent::__construct('formNuevoMensaje', $id);
        $this->id = $id;
        $this->prevPage = $prevPage;
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $mensaje = $datos['text'] ?? '';
        $id = $datos['id'] ?? $this->id;
        $prevPage = $datos['prevPage'] ?? $this->prevPage;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorText = self::createMensajeError($errores, 'mensaje', 'span', array('class' => 'error'));


        $camposFormulario = <<<EOF
            <div class="grupo-fomulario">
                $htmlErroresGlobales
                <h1>Añadir Mensaje</h1>
                    <input type="hidden" name="id" value="$id" readonly/>
                    <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
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

        $text = $datos['text'] ?? null;
        if ( empty($text)  ) {
            $result['text'] = "El mensaje no puede estar vacío.";
        }
        
        $prevPage = $datos['prevPage'] ?? null;

        if (count($result) === 0) {
            if ($app->usuarioLogueado())
            $mensaje = Mensaje::crea($id, $app->user(), $text);
                if ( ! $mensaje ) {
                    $result[] = "Error";
                } else {
                    $result = "{$prevPage}";
                }
            }
        
        return $result;
    }
}