<?php
namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioEditarMensaje extends Form
{

  private $id;
  private $mensaje;

  public function __construct($id)
  {
    parent::__construct('formEditarMensaje', $id);
    $this->id = $id;
  }
  
  protected function generaCamposFormulario($datos, $errores = array())
  {
    $id = $datos['id'] ?? $this->id;
    $this->mensaje = Mensaje::buscaPorId($id);
    $id2 = $datos['id2'] ?? $this->mensaje->evento_tema_obj()->id();
    $name = $datos['name'] ?? $this->mensaje->evento_tema_obj()->name();
    $time = $datos['time'] ?? $this->mensaje->evento_tema_obj()->time();
    $text = $datos['text'] ?? $this->mensaje->text();
      

    // Se generan los mensajes de error si existen.
    $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    $errorText = self::createMensajeError($errores, 'text', 'span', array('class' => 'error'));


    //TODO Añadir lo de la imagen
    $camposFormulario = <<<EOF
      <fieldset>
          $htmlErroresGlobales
          <input class="control" type="hidden" name="id" value="$id" readonly/>
          <input class="control" type="hidden" name="id2" value="$id2" readonly/>
          <input class="control" type="hidden" name="name" value="$name" readonly/>
          <input class="control" type="hidden" name="time" value="$time" readonly/>
          <div class="grupo-control">
              <label>Mensaje:</label> <textarea class="control" type="text" name="text" value="$text" />$text</textarea>$errorText
          </div>
          
          <div class="grupo-control"><button type="submit" name="editar">Confirmar</button></div>
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
    $id2 = $datos['id2'] ?? null;
    $name = $datos['name'] ?? null;
    $time = $datos['time'] ?? null;

    $text = $datos['text'] ?? null;
    if ( empty($text) ) {
        $result['text'] = "El mensaje no puede quedar vacío.";
    }

    if (count($result) === 0) {
        $mensaje = Mensaje::buscaPorId($id);
        if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin()) || $mensaje->user() == $app->user()) {
            $mensaje = Mensaje::editar($id,null,null,$text,null);
            
            if ( ! $mensaje ) {
                $result[] = "El mensaje ya existe";
            } else {
                $result = RUTA_APP."eventoTema.php?id={$id2}&nombre={$name}&time={$time}";
            }
        }
    }
    return $result;
  }
}
