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
        $id = $datos['id'] ?? $this->mensaje->id();
        $id2 = $datos['id2'] ?? $this->mensaje->evento_tema_obj()->id();
        $name = $datos['name'] ?? $this->mensaje->evento_tema_obj()->name();
        $time = $datos['time'] ?? $this->mensaje->evento_tema_obj()->time();
        $text = $datos['text'] ?? $this->mensaje->text();
      

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorText = self::createMensajeError($errores, 'text', 'span', array('class' => 'error'));


        //TODO Añadir lo de la imagen
        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <input class="control" type="hidden" name="id" value="$id" readonly/>
                <input class="control" type="hidden" name="id2" value="$id2" readonly/>
                <input class="control" type="hidden" name="name" value="$name" readonly/>
                <input class="control" type="hidden" name="time" value="$time" readonly/>
                <div class="grupo-control">
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
        $id2 = $datos['id2'] ?? null;
        $name = $datos['name'] ?? null;
        $time = $datos['time'] ?? null;

        $text = $datos['text'] ?? null;
        if ( empty($text) ) {
            $result['text'] = "El mensaje no puede quedar vacío.";
        }

        if (count($result) === 0) {
            //TODO Añadir lo de la imagen
            $mensaje = Mensaje::editar($id,null,null,$text,null);
            if ( !$mensaje ) {
                $result[] = "El mensaje ya existe";
            } //TODO Añadir una redirección a la página de la película
            else {
                $result = "eventoTema.php?id={$id2}&nombre={$name}&time={$time}";
            }
        }
        return $result;
    }
}