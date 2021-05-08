<?php
namespace es\ucm\fdi\aw;

class FormularioEditarMensaje extends Form
{

    private $mensaje;

    public function __construct($mensaje) {
        $this->mensaje = $mensaje;
        parent::__construct('formEditarMensaje');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        //echo substr($this->eventoTema->time(), 0, 10);
        $text = $datos['text'] ?? $this->mensaje->text();
      

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorText = self::createMensajeError($errores, 'text', 'span', array('class' => 'error'));


        //TODO Añadir lo de la imagen
        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <input class="control" type="hidden" name="id" value="$id" readonly/>
                <div class="grupo-control">
                <label>$text</label>
                    <label>Mensaje:</label> <input class="control" type="text" name="text" value="$text" />$errorText
                </div>
                
                <div class="grupo-control"><button type="submit" name="editar">Confirmar</button></div>
            </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();
        
        $id = $datos['id'] ?? null;
        $evento_tema=$datos['evento_tema'] ?? null;
        $user=$datos['user'] ?? null;
        $time_created=$datos['time_created'] ?? null;

        $text = $datos['text'] ?? null;
        if ( empty($text) ) {
            $result['text'] = "El mensaje no puede quedar vacío.";
        }

        if (count($result) === 0) {
            //TODO Añadir lo de la imagen
            $mensaje = Mensaje::editar($id,$evento_tema,$user,$text,$time_created);
            if ( !$mensaje ) {
                $result[] = "El mensaje ya existe";
            } //TODO Añadir una redirección a la página de la película
            else {
                $result = 'foro.php';
            }
        }
        return $result;
    }
}