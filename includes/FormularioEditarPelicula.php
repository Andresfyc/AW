<?php
namespace es\ucm\fdi\aw;

class FormularioEditarPelicula extends Form
{

    private $pelicula;

    public function __construct($pelicula) {
        $this->pelicula = $pelicula;
        parent::__construct('formEditarPelicula');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $id = $datos['id'] ?? $this->pelicula->id();
        $title = $datos['title'] ?? $this->pelicula->title();
        $image = $datos['image'] ?? $this->pelicula->image();
        $date_released = $datos['date_released'] ?? $this->pelicula->date_released();
        $duration = $datos['duration'] ?? $this->pelicula->duration();
        $country = $datos['country'] ?? $this->pelicula->country();
        $plot = $datos['plot'] ?? $this->pelicula->plot();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorTitle = self::createMensajeError($errores, 'title', 'span', array('class' => 'error'));
        $errorImage = self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));
        $errorDate_released= self::createMensajeError($errores, 'date_released', 'span', array('class' => 'error'));
        $errorDuration = self::createMensajeError($errores, 'duration', 'span', array('class' => 'error'));
        $errorCountry = self::createMensajeError($errores, 'country', 'span', array('class' => 'error'));
        $errorPlot = self::createMensajeError($errores, 'plot', 'span', array('class' => 'error'));


        //TODO Añadir lo de la imagen
        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <input class="control" type="hidden" name="id" value="$id" readonly/>
                <div class="grupo-control">
                    <label>Nombre de la película:</label> <input class="control" type="text" name="title" value="$title" />$errorTitle
                </div>
                <div class="grupo-control">
                    <label>Imagen de la película:</label> <input class="control" type="text" name="image" value="$image" />$errorImage
                </div>
                <div class="grupo-control">
                    <label>Fecha publicación:</label> <input class="control" type="date" name="date_released" value="$date_released" />$errorDate_released
                </div>
                <div class="grupo-control">
                    <label>Duración:</label> <input class="control" type="text" name="duration" value="$duration" />$errorDuration
                </div>
                <div class="grupo-control">
                    <label>País:</label> <input class="control" type="text" name="country" value="$country"/>$errorCountry
                </div>
                <div class="grupo-control">
                    <label>Trama:</label> <input class="control" type="text" name="plot" value="$plot" />$errorPlot
                </div>
                <div class="grupo-control"><button type="submit" name="editar">Confirmar</button></div>
            </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();
        
        $id = $datos['id'] ?? null;

        $title = $datos['title'] ?? null;
        if ( empty($title) ) {
            $result['title'] = "El nombre de la película no puede quedar vacío.";
        }
        
        $image = $datos['image'] ?? null;
        if ( empty($image) ) {
            $result['image'] = "La imagen no puede quedar vacía.";
        }

        //Podemos añadir películas sin estrenar aunque todavía no haya opción de descargar
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

        if (count($result) === 0) {
            //TODO Añadir lo de la imagen
            $pelicula = Pelicula::editar($id, $title, $image, $date_released, $duration, $country, $plot);
            unset($_SESSION["tempIdPelicula"]);
            if ( ! $pelicula ) {
                $result[] = "La película ya existe";
            } //TODO Añadir una redirección a la página de la película
            else {
                $result = 'peliculas.php';
            }
        }
        return $result;
    }
}