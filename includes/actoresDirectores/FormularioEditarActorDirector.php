<?php
namespace es\ucm\fdi\aw\actoresDirectores;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\actoresDirectores\ActorDirector;

class FormularioEditarActorDirector extends Form
{

  private $id;
  private $prevPage;
  private $actorDirector;

  public function __construct($id, $prevPage)
  {
    parent::__construct('formEditarActorDirector', $id);
    $this->id = $id;
    $this->prevPage = $prevPage;
  }
  
  protected function generaCamposFormulario($datos, $errores = array())
  {    
    $id = $datos['id'] ?? $this->id;
    $this->actorDirector = ActorDirector::buscaPorId($id);
    $name = $datos['name'] ?? $this->actorDirector->name();
    $description = $datos['description'] ?? $this->actorDirector->description();
    $birth_date = $datos['birth_date'] ?? $this->actorDirector->birth_date();
    $nationality = $datos['nationality'] ?? $this->actorDirector->nationality();
    $image = $datos['image'] ?? '';
    $prevPage = $datos['prevPage'] ?? $this->prevPage;

    // Se generan los mensajes de error si existen.
    $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
    $errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
    $errorBirth_date= self::createMensajeError($errores, 'birth_date', 'span', array('class' => 'error'));
    $errorNationality = self::createMensajeError($errores, 'nationality', 'span', array('class' => 'error'));
    $errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));


    $camposFormulario = <<<EOF
        <fieldset>
            <div class="grupo-editar">
            $htmlErroresGlobales
            <input class="control" type="hidden" name="id" value="$id" readonly/>
            <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
            
                <div class="col-25"><label>Nombre:</label> </div>
                <div class="col-75"><input class="control" type="text" name="name" value="$name" />$errorName </div>
          
            
                <div class="col-25"><label>Imagen:</label> </div>
                <div class="col-75"><input class="control" type="file" name="image" value="$image" />$errorImage</div>
           
                <div class="col-25"><label>Descripción:</label></div>
                <div class="col-75"><textarea class="control" type="text" name="description" value="$description" />$description</textarea>$errorDescription </div>
            
                <div class="col-25"><label>Fecha de nacimiento:</label> </div>
               <div class="col-75"> <input class="control" type="date" name="birth_date" value="$birth_date" />$errorBirth_date</div>
          
                <div class="col-25"><label>Nacionalidad:</label></div>
                 <div class="col-75"><input class="control" type="text" name="nationality" value="$nationality"/>$errorNationality</div>

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

    $name = $datos['name'] ?? null;
    if ( empty($name) ) {
        $result['name'] = "El nombre del actor/director no puede quedar vacío.";
    }

    $description = $datos['description'] ?? null;
    if ( empty($description)) {
        $result['description'] = "El actor/director debe tener descripción";
    }

    $birth_date = $datos['birth_date'] ?? null;
	$fecha_actual = strtotime(date("Y-m-d"));
		$fecha_entrada= strtotime($birth_date);
    if ( empty($birth_date) ) {
        $result['birth_date'] = "La fecha de nacimiento no puede quedar vacía.";
    }else if($fecha_entrada > $fecha_actual){
			$result['birth_date'] ="La fecha no puede ser posterior a la actual.";
		}

    $nationality = $datos['nationality'] ?? null;
    if ( empty($nationality)) {
        $result['nationality'] = "La nacionalidad no puede quedar vacía";
    }

    $image = $datos['image'] ?? null;
    $dir_subida = './img/actores_directores/';
    $fichero_subido = $dir_subida . basename($_FILES['image']['name']);
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $fichero_subido) && !empty($_FILES['image']['name'])) {
        $result['image'] = $_FILES['image']['name']."El fichero no se ha podido subir correctamente";
    }
        
    $prevPage = $datos['prevPage'] ?? null;

    if (count($result) === 0) {
        if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
            $actorDirector = ActorDirector::editar($id, null, $name, $description, $birth_date, $nationality, $_FILES['image']['name']);
            if ( ! $actorDirector  ) {
                $result[] = "El actor/director ya existe";
            } else {
                $result = "{$prevPage}";
            }
        }
    }
    return $result;
  }
}
