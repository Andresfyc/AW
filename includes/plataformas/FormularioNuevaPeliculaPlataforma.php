<?php
namespace es\ucm\fdi\aw\plataformas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioNuevaPeliculaPlataforma extends Form
{
    private $prevPage;
    private $filmId;
    
    public function __construct($prevPage, $filmId) {
        parent::__construct('formNuevaPeliculaPlataforma');
        $this->prevPage = $prevPage;
        $this->filmId = $filmId;
    }

    protected function platforms()
    {
        $html = '';
        foreach (Plataforma::plataformas() as $platform) {
            $html .= "<option value=\"{$platform->id()}\">{$platform->name()}</option>";
        }
        return $html;
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $filmId = $datos['id'] ?? $this->filmId;
        $link = $datos['link'] ?? '';
        $prevPage = $datos['prevPage'] ?? $this->prevPage;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorLink = self::createMensajeError($errores, 'link', 'span', array('class' => 'error'));


        $camposFormulario = <<<EOF
            <fieldset>
             <div class="grupo-editar">
                $htmlErroresGlobales
                <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
                <input class="control" type="hidden" name="filmId" value="$filmId" readonly/>
            
               
                <div class="col-25"><label>Plataforma:</label> </div>
                <div class="col-75"><select name="platform">
        EOF;
    
        $camposFormulario .= self::platforms();
    
        $camposFormulario .= <<<EOF
                </select>
                </div>
                
                    <div class="col-25"><label>Link:</label> </div>
                    <div class="col-75"><input class="control" type="text" name="link" value="$link" />$errorLink</div>
                
                    <div><button type="submit" name="nueva">Añadir</button></div>
                </div>
            </fieldset>
        EOF;
        return $camposFormulario;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();
        $app = Aplicacion::getSingleton();
        
        $filmId = $datos['filmId'] ?? null;

        $link = $datos['link'] ?? null;
        if ( empty($link) ) {
            $result['link'] = "El link no puede quedar vacío.";
        }

        $platform = $datos['platform'] ?? null;

        $prevPage = $datos['prevPage'] ?? null;

        if (count($result) === 0) {
            if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin()))
                $peliculaPlataforma = PeliculaPlataforma::crea($filmId, $platform, $link);
                if ( ! $peliculaPlataforma ) {
                    $result[] = "El link ya existe";
                } else {
                    $result = "{$prevPage}";
                }
            }
        
        return $result;
    }
}