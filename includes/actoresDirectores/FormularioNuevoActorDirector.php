<?php
namespace es\ucm\fdi\aw\actoresDirectores;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioNuevoActorDirector extends Form
{
    private $actor_director;
    private $prevPage;
    
    public function __construct($actor_director, $prevPage) {
        parent::__construct('formNuevoActorDirector');
        $this->actor_director = $actor_director;
        $this->prevPage = $prevPage;
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $actor_director = $datos['actor_director'] ?? $this->actor_director;
        $name = $datos['name'] ?? '';
        $description = $datos['description'] ?? '';
        $birth_date = $datos['birth_date'] ?? '';
        $nationality = $datos['nationality'] ?? '';
        $image = $datos['image'] ?? '';
        $prevPage = $datos['prevPage'] ?? $this->prevPage;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorImage= self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));
        $errorDescription= self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
        $errorBirth_date = self::createMensajeError($errores, 'birth_date', 'span', array('class' => 'error'));
        $errorNationality = self::createMensajeError($errores, 'nationality', 'span', array('class' => 'error'));
        $errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));

        
        if ($actor_director == 0) {
            $adString = 'Actor';
        } else {
            $adString = 'Director';
        }


        $camposFormulario = <<<EOF
        <fieldset>
            $htmlErroresGlobales
            <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
            <input class="control" type="hidden" name="actor_director" value="$actor_director" readonly/>
            <div class="grupo-control">
                <label>Nombre del $adString:</label> <input class="control" type="text" name="name" value="$name" />$errorName
            </div>
            <div class="grupo-control">
                <label>Imagen:</label> <input class="control" type="file" name="image" value="$image" />$errorImage
            </div>
            <div class="grupo-control">
                <label>Descripción:</label> <textarea class="control" type="text" name="description" value="$description" />$description</textarea>$errorDescription
            </div>
            <div class="grupo-control">
                <label>Fecha de nacimiento:</label> <input class="control" type="date" name="birth_date" value="$birth_date" />$errorBirth_date
            </div>
            <div class="grupo-control">
                <label>Nacionalidad:</label> <input class="control" type="text" name="nationality" value="$nationality"/>$errorNationality
            </div>
            <div class="grupo-control"><button type="submit" name="editar">Confirmar</button></div>
        </fieldset>
        EOF;
        return $camposFormulario;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();
        $app = Aplicacion::getSingleton();

        $actor_director = $datos['actor_director'] ?? null;

        $name = $datos['name'] ?? null;
        if ( empty($name) ) {
            $result['name'] = "El nombre del actor/director no puede quedar vacío";
        }

        $description = $datos['description'] ?? null;
        if ( empty($description) ) {
            $result['description'] = "La descripción no puede quedar vacía";
        }

        $birth_date = $datos['birth_date'] ?? null;
        if ( empty($birth_date) ) {
            $result['birth_date'] = "La fecha no puede quedar vacía";
        }
        $nationality = $datos['nationality'] ?? null;
        if ( empty($nationality)) {
            $result['nationality'] = "La nacionalidad no puede quedar vacía";
        }
        
        $prevPage = $datos['prevPage'] ?? null;

        $image = $datos['image'] ?? null;
        $dir_subida = './img/actores_directores/';
        $fichero_subido = $dir_subida . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $fichero_subido) && !empty($_FILES['image']['name'])) {
            $result['image'] = $_FILES['image']['name']."El fichero no se ha podido subir correctamente";
        }

        if (count($result) === 0) {
            if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin()))
                $actorDirector = ActorDirector::crea($actor_director, $name, $description, $birth_date, $nationality, $_FILES['image']['name']);
                if ( ! $actorDirector ) {
                    $result[] = "El actor/director ya existe";
                } else {
                    $result = "{$prevPage}";
                }
            }
        
        return $result;
    }
}