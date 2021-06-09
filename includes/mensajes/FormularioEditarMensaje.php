<?php
namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioEditarMensaje extends Form
{

  private $id;
  private $mensaje;
  private $prevPage;

  public function __construct($id, $prevPage)
  {
    parent::__construct('formEditarMensaje', $id);
    $this->id = $id;
    $this->prevPage = $prevPage;
  }
  
  protected function generaCamposFormulario($datos, $errores = array())
  {
    $id = $datos['id'] ?? $this->id;
    $this->mensaje = Mensaje::buscaPorId($id);
    $text = $datos['text'] ?? $this->mensaje->text();
    $prevPage = $datos['prevPage'] ?? $this->prevPage;
      

    // Se generan los mensajes de error si existen.
    $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    $errorText = self::createMensajeError($errores, 'text', 'span', array('class' => 'error'));


    $camposFormulario = <<<EOF
      <fieldset>
        <div class="grupo-editar">
          $htmlErroresGlobales
          <input class="control" type="hidden" name="id" value="$id" readonly/>
          <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
          
             <div class="col-25"><label>Mensaje:</label> </div>
             <div class="col-75"> <textarea class="control" type="text" name="text" value="$text" />$text</textarea>$errorText</div>

                <div><button type="submit" name="editar">Confirmar</button></div>
          </div>
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

    $text = $datos['text'] ?? null;
    if ( empty($text) ) {
        $result['text'] = "El mensaje no puede quedar vacío.";
    }
        
    $prevPage = $datos['prevPage'] ?? null;

    if (count($result) === 0) {
        $mensaje = Mensaje::buscaPorId($id);
        if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin()) || $mensaje->user() == $app->user()) {
            $mensaje = Mensaje::editar($id,null,null,$text,null);
            
            if ( ! $mensaje ) {
                $result[] = "El mensaje ya existe";
            } else {
              $result = "{$prevPage}";
            }
        }
    }
    return $result;
  }
}
