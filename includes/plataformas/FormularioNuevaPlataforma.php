<?php
namespace es\ucm\fdi\aw\plataformas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\plataformas\Plataforma;

class FormularioNuevaPlataforma extends Form
{
    private $prevPage;
    
    public function __construct($prevPage) {
        parent::__construct('formNuevaPlataforma');
        $this->prevPage = $prevPage;
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $name = $datos['name'] ?? '';
        $image = $datos['image'] ?? '';
        $prevPage = $datos['prevPage'] ?? $this->prevPage;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorImage= self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));


        $camposFormulario = <<<EOF
            <fieldset>
                <div class="grupo-editar">
                $htmlErroresGlobales
                
                    <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
                     <div class="col-25"><label>Plataforma:</label> </div>
                    <div class="col-75"><input class="control" type="text" name="name" value="$name" placeholder="Nombre..."/>$errorName</div>
          
                
                     <div class="col-25"><label>Imagen:</label> </div>
                    <div class="col-75"><input class="control" type="file" name="image" value="$image" />$errorImage</div>

                    <div><button type="submit" name="editar">Confirmar</button></div>
                </div>
            </fieldset>
        EOF;


        return $camposFormulario;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();
        $app = Aplicacion::getSingleton();

        $name = $datos['name'] ?? null;
        if ( empty($name) ) {
            $result['name'] = "El nombre de la plataforma no puede quedar vacío.";
        }

        $image = $datos['image'] ?? null;
        $dir_subida = './img/plataformas/';
        $fichero_subido = $dir_subida . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $fichero_subido) && !empty($_FILES['image']['name'])) {
            $result['image'] = $_FILES['image']['name']."El fichero no se ha podido subir correctamente";
        }
        
        $prevPage = $datos['prevPage'] ?? null;

        if (count($result) === 0) {
            if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin()))
                $plataforma = Plataforma::crea($name, $_FILES['image']['name']);
                if ( ! $plataforma ) {
                    $result[] = "La plataforma ya existe";
                } else {
                    $result = "{$prevPage}";
                }
            }
        
        return $result;
    }
}