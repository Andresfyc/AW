<?php
namespace es\ucm\fdi\aw;

class FormularioNuevaPelicula extends Form
{
    public function __construct() {
        parent::__construct('formNuevaPelicula');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $title = $datos['title'] ?? '';
        $image = $datos['image'] ?? '';
        $date_released = $datos['date_released'] ?? '';
        $duration = $datos['duration'] ?? '';
        $country = $datos['country'] ?? '';
        $plot = $datos['plot'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorTitle = self::createMensajeError($errores, 'title', 'span', array('class' => 'error'));
        $errorImage= self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));
        $errorDate_released= self::createMensajeError($errores, 'date_released', 'span', array('class' => 'error'));
        $errorDuration = self::createMensajeError($errores, 'duration', 'span', array('class' => 'error'));
        $errorCountry = self::createMensajeError($errores, 'country', 'span', array('class' => 'error'));
        $errorPlot = self::createMensajeError($errores, 'plot', 'span', array('class' => 'error'));


        //TODO Añadir lo de la imagen
        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <div class="grupo-control">
                    <label>Nombre de la película:</label> <input class="control" type="text" name="title" value="$title" />$errorTitle
                </div>
                <div class="grupo-control">
                    <label>Imagen:</label> <input class="control" type="file" name="image" value="$image" />$errorImage
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
                <div class="grupo-control"><button type="submit" name="nueva">Añadir</button></div>
            </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();

        $title = $datos['title'] ?? null;
        if ( empty($title) ) {
            $result['title'] = "El nombre de la película no puede quedar vacío.";
        }

        $image = $datos['image'] ?? null;

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
            echo $image;
            $pelicula = Pelicula::crea($title, $image, $date_released, $duration, $country, $plot);
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