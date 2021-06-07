<?php
namespace es\ucm\fdi\aw\generos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioEditarGenero extends Form
{

  private $id;
  private $genero;
  private $prevPage;

  public function __construct($id, $prevPage)
  {
    parent::__construct('formEditarGenero', $id);
    $this->id = $id;
    $this->prevPage = $prevPage;
  }

  
  protected function generaCamposFormulario($datos, $errores = array())
  {    
    $id = $datos['id'] ?? $this->id;
    $this->genero = Genero::buscaPorId($id);
    $generoName = $datos['generoName'] ?? $this->genero->name();
    $prevPage = $datos['prevPage'] ?? $this->prevPage;
      

    // Se generan los mensajes de error si existen.
    $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    $errorGeneroName = self::createMensajeError($errores, 'generoName', 'span', array('class' => 'error'));


    $camposFormulario = <<<EOF
    <fieldset>
        <div class="grupo-editar">
        $htmlErroresGlobales
        <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
        <input class="control" type="hidden" name="id" value="$id" readonly/>
            
             <div class="col-25"><label>Género:</label> </div>
             <div class="col-75"><input class="control" type="text" name="generoName" value="$generoName" />$errorGeneroName</div>
       
        
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

    $generoName = $datos['generoName'] ?? null;
    if ( empty($generoName) ) {
        $result['generoName'] = "El género no puede quedar vacío";
    }
        
    $prevPage = $datos['prevPage'] ?? null;

    if (count($result) === 0) {
        if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
            $genero = Genero::editar($id,$generoName);
            if ( ! $genero  ) {
                $result[] = "El género ya existe";
            } else {
              $result = "{$prevPage}";
            }
        }
    }
    return $result;
  }
}
