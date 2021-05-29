<?php
namespace es\ucm\fdi\aw\plataformas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\plataformas\Plataforma;
use es\ucm\fdi\aw\plataformas\PeliculaPlataforma;

class FormularioEditarPeliculaPlataforma extends Form
{

  private $id;
  private $prevPage;
  private $peliculaPlataforma;

  public function __construct($id, $prevPage)
  {
    parent::__construct('formEditarPeliculaPlataforma', $id);
    $this->id = $id;
    $this->prevPage = $prevPage;
  }

  protected function platforms()
  {
      $html = '';
      foreach (Plataforma::plataformas() as $platform) {
          $currentPlatform = $this->peliculaPlataforma->platform()->name();
          if ($platform->name() == $currentPlatform) {
              $html .= "<option value=\"{$platform->id()}\" selected=\"selected\">{$platform->name()}</option>";
          } else {
              $html .= "<option value=\"{$platform->id()}\">{$platform->name()}</option>";
          }
      }
      return $html;
  }

  
  protected function generaCamposFormulario($datos, $errores = array())
  {    
    $id = $datos['id'] ?? $this->id;
    $this->peliculaPlataforma = PeliculaPlataforma::buscaPorId($id);
    $link = $datos['link'] ?? $this->peliculaPlataforma->link();
    $prevPage = $datos['prevPage'] ?? $this->prevPage;
      

    // Se generan los mensajes de error si existen.
    $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    $errorLink = self::createMensajeError($errores, 'link', 'span', array('class' => 'error'));


    $camposFormulario = <<<EOF
        <fieldset>
            $htmlErroresGlobales
            <input class="control" type="hidden" name="id" value="$id" readonly/>
            <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
            
            <div class="grupo-control">
            <label>Plataforma:</label> <select name="platform">
    EOF;

    $camposFormulario .= self::platforms();

    $camposFormulario .= <<<EOF
            </select>
            </div>
            <div class="grupo-control">
                <label>Link:</label> <input class="control" type="text" name="link" value="$link" />$errorLink
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

    $link = $datos['link'] ?? null;
    if ( empty($link) ) {
        $result['link'] = "El link no puede estar vacío";
    }

    $platform = $datos['platform'] ?? null;
        
    $prevPage = $datos['prevPage'] ?? null;

    if (count($result) === 0) {
        if ($app->usuarioLogueado() && ($app->esModerador() || $app->esAdmin())) {
            $peliculaPlataforma = PeliculaPlataforma::editar($id,null,$platform,$link);
            if ( ! $peliculaPlataforma  ) {
                $result[] = "El link a la plataforma ya existe";
            } else {
                $result = "{$prevPage}";
            }
        }
    }
    return $result;
  }
}
