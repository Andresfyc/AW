<?php
namespace es\ucm\fdi\aw\peliculas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\generos\Genero;
use es\ucm\fdi\aw\actoresDirectores\ActorDirector;

class FormularioEditarPelicula extends Form
{

  private $id;
  private $prevPage;
  private $pelicula;

  public function __construct($id, $prevPage)
  {
    parent::__construct('formEditarPelicula', $id);
    $this->id = $id;
    $this->prevPage = $prevPage;
  }

  protected function genres()
  {
      $html = '';
      foreach (Genero::generos() as $genre) {
          $genres = [];
          if ($this->pelicula->genres() != null) {
              foreach ($this->pelicula->genres() as $genre2) {
                  $genres[] = $genre2->name();
              }
          }
          if (in_array($genre->name(), $genres)) {
              $html .= "<option value=\"{$genre->id()}\" selected=\"selected\">{$genre->name()}</option>";
          } else {
              $html .= "<option value=\"{$genre->id()}\">{$genre->name()}</option>";
          }
      }
      return $html;
  }

  protected function actors()
  {
      $html = '';
      foreach (ActorDirector::actoresDirectores(0) as $actor) {
          $actors = [];
          if ($this->pelicula->actors() != null) {
              foreach ($this->pelicula->actors() as $actor2) {
                  $actors[] = $actor2->name();
              }
          }
          if (in_array($actor->name(), $actors)) {
              $html .= "<option value=\"{$actor->id()}\" selected=\"selected\">{$actor->name()}</option>";
          } else {
              $html .= "<option value=\"{$actor->id()}\">{$actor->name()}</option>";
          }
      }
      return $html;
  }

  protected function directors()
  {
      $html = '';
      foreach (ActorDirector::actoresDirectores(1) as $director) {
          $directors = [];
          if ($this->pelicula->directors() != null) {
              foreach ($this->pelicula->directors() as $director2) {
                  $directors[] = $director2->name();
              }
          }
          if (in_array($director->name(), $directors)) {
              $html .= "<option value=\"{$director->id()}\" selected=\"selected\">{$director->name()}</option>";
          } else {
              $html .= "<option value=\"{$director->id()}\">{$director->name()}</option>";
          }
      }
      return $html;
  }

  protected function platforms()
  {
      $RUTA_APP = RUTA_APP;
      $html = '';
      if ($this->pelicula->peliculasPlataformas()) {
        $prevLink = urlencode($_SERVER['REQUEST_URI']);
        foreach ($this->pelicula->peliculasPlataformas() as $filmPlatform) {
            $html .= <<<EOS
                <li> {$filmPlatform->platform()->name()}
                <a href="{$RUTA_APP}editarPeliculaPlataforma.php?id={$filmPlatform->id()}&prevPage={$prevLink}">Editar</a>
                <a href="{$RUTA_APP}eliminarPeliculaPlataforma.php?id={$filmPlatform->id()}&prevPage={$prevLink}"> Eliminar</a></li>
            EOS;
        }
      }
      return $html;
  }

  
  protected function generaCamposFormulario($datos, $errores = array())
  {    
    $RUTA_APP = RUTA_APP;
    $id = $datos['id'] ?? $this->id;
    $this->pelicula = Pelicula::buscaPorId($id);
    $title = $datos['title'] ?? $this->pelicula->title();
    $image = $datos['image'] ?? '';
    $date_released = $datos['date_released'] ?? $this->pelicula->date_released();
    $duration = $datos['duration'] ?? $this->pelicula->duration();
    $country = $datos['country'] ?? $this->pelicula->country();
    $plot = $datos['plot'] ?? $this->pelicula->plot();
    $prevPage = $datos['prevPage'] ?? $this->prevPage;
    $genres = $datos['genres'] ?? $this->pelicula->genres();
    $actors = $datos['actors'] ?? $this->pelicula->actors();
    $directors = $datos['directors'] ?? $this->pelicula->directors();
    $prevLink = urlencode($_SERVER['REQUEST_URI']);

    // Se generan los mensajes de error si existen.
    $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    $errorTitle = self::createMensajeError($errores, 'title', 'span', array('class' => 'error'));
    $errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));
    $errorDate_released= self::createMensajeError($errores, 'date_released', 'span', array('class' => 'error'));
    $errorDuration = self::createMensajeError($errores, 'duration', 'span', array('class' => 'error'));
    $errorCountry = self::createMensajeError($errores, 'country', 'span', array('class' => 'error'));
    $errorPlot = self::createMensajeError($errores, 'plot', 'span', array('class' => 'error'));


    $camposFormulario = <<<EOF
        <fieldset>
            <div class="grupo-editar">
            $htmlErroresGlobales
            <input class="control" type="hidden" name="id" value="$id" readonly/>
            <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
            
                <div class="col-25"><label>Película:</label> </div>
                <div class="col-75"><input class="control" type="text" name="title" value="$title" />$errorTitle </div>
          
            
                <div class="col-25"><label>Imagen:</label> </div>
                 <div class="col-75"><input class="control" type="file" name="image" value="$image" />$errorImage</div>
         
               <div class="col-25"> <label>Publicación:</label> </div>
               <div class="col-75"><input class="control" type="date" name="date_released" value="$date_released" />$errorDate_released</div>
            
                <div class="col-25"><label>Duración:</label> </div>
                <div class="col-75"><input class="control" type="text" name="duration" value="$duration" />$errorDuration</div>
          
                <div class="col-25"><label>País:</label></div>
                 <div class="col-75"><input class="control" type="text" name="country" value="$country"/>$errorCountry</div>
           
                <div class="col-25"><label>Trama:</label></div>
                <div class="col-75"><textarea class="control" type="text" name="plot" value="$plot" />$plot</textarea>$errorPlot </div>
           
               <div class="col-25"> <label>Plataformas:</label></div>
               <div class="col-75"> <ul>
    EOF;

    $camposFormulario .= self::platforms();

    $camposFormulario .= <<<EOF
                </ul>
           
                 <div><a href="{$RUTA_APP}nuevaPeliculaPlataforma.php?id=$id&prevPage={$prevLink}">Añadir Plataforma</a> </div></div>
            
                <div class="col-25"><label>Géneros:</label></div> 
                <div class="col-75"><select name="genres[]" multiple>
    EOF;

    $camposFormulario .= self::genres();

    $camposFormulario .= <<<EOF
                </select>
            
                <div><a href="{$RUTA_APP}nuevoGenero.php?prevPage={$prevLink}">Añadir Género</a></div></div>
           
               <div class="col-25"> <label>Actores:</label></div> 
               <div class="col-75"><select name="actors[]" multiple>
    EOF;

    $camposFormulario .= self::actors();

    $camposFormulario .= <<<EOF
                </select>
           
                 <div><a href="{$RUTA_APP}nuevoActorDirector.php?ad=0&prevPage={$prevLink}">Añadir Actor</a></div></div>
            
            
                <div class="col-25"><label>Directores:</label> </div>
                <div class="col-75"><select name="directors[]" multiple>
    EOF;

    $camposFormulario .= self::directors();

    $camposFormulario .= <<<EOF
                </select>
                 <div> <a href="{$RUTA_APP}nuevoActorDirector.php?ad=1&prevPage={$prevLink}">Añadir Director</a></div></div>
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

    $title = $datos['title'] ?? null;
    if ( empty($title) ) {
        $result['title'] = "El nombre de la película no puede quedar vacío.";
    }

    $date_released = $datos['date_released'] ?? null;
    if ( empty($date_released) ) {
        $result['date_released'] = "La fecha no puede quedar vacía.";
    }

    $duration = $datos['duration'] ?? null;
    if ( empty($duration) || $duration < 0 ) {
        $result['duration'] = "La película debe tener una duración positiva";
    }

    $country = $datos['country'] ?? null;
    if ( empty($country)) {
        $result['country'] = "El país no puede quedar vacío";
    }

    $plot = $datos['plot'] ?? null;
    if ( empty($plot)) {
        $result['plot'] = "La película debe tener una trama";
    }

    $image = $datos['image'] ?? null;
    $dir_subida = './img/peliculas/';
    $fichero_subido = $dir_subida . basename($_FILES['image']['name']);
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $fichero_subido) && !empty($_FILES['image']['name'])) {
        $result['image'] = $_FILES['image']['name']."El fichero no se ha podido subir correctamente";
    }

    $genres = $datos['genres'] ?? null;

    $actors = $datos['actors'] ?? null;

    $directors = $datos['directors'] ?? null;
        
    $prevPage = $datos['prevPage'] ?? null;

    if (count($result) === 0) {
        if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin())) {
            $pelicula = Pelicula::editar($id, $title, $_FILES['image']['name'], $date_released, $duration, $country, $plot);

            Pelicula::actualizarGeneros($pelicula, $genres);

            Pelicula::actualizarActoresDirectores($pelicula, $actors, $directors);
            if ( ! $pelicula  ) {
                $result[] = "La película ya existe";
            } else {
                $result = "{$prevPage}";
            }
        }
    }
    return $result;
  }
}
