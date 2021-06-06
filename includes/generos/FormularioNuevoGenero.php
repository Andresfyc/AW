<?php
namespace es\ucm\fdi\aw\generos;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioNuevoGenero extends Form
{
    private $prevPage;
    
    public function __construct($prevPage) {
        parent::__construct('formNuevoGenero');
        $this->prevPage = $prevPage;
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $name = $datos['name'] ?? '';
        $prevPage = $datos['prevPage'] ?? $this->prevPage;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));


        $camposFormulario = <<<EOF
            <div class="grupo-fomulario">
                $htmlErroresGlobales
                <h1>Añadir Género</h1>
                <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
                
             
                    <input class="control" type="text" name="name" value="$name" placeholder="Género..." required />$errorName
                <button type="submit" name="nueva">Añadir</button>
                
           </div>
        EOF;
        return $camposFormulario;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();
        $app = Aplicacion::getSingleton();

        $name = $datos['name'] ?? null;
        if ( empty($name) ) {
            $result['name'] = "El nombre del género no puede quedar vacío.";
        }

        $prevPage = $datos['prevPage'] ?? null;

        if (count($result) === 0) {
            if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin()))
            {
                $genero = Genero::crea($name);
                if ( ! $genero ) {
                    $result[] = "El género ya existe";
                } else {
                    $result = "{$prevPage}";
                }
            }
        }
        return $result;
    }
}