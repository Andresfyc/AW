<?php
namespace es\ucm\fdi\aw;


class AñadirPelicula extends Form
{
    public function __construct() {
        parent::__construct('formAñadirPelicula');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $nombre = $datos['nombre'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombrePelicula = self::createMensajeError($errores, 'nombrePelicula', 'span', array('class' => 'error'));
        $errorDate_released= self::createMensajeError($errores, 'date_released', 'span', array('class' => 'error'));
        $errorRating = self::createMensajeError($errores, 'rating', 'span', array('class' => 'error'));
        $errorDuration = self::createMensajeError($errores, 'duration', 'span', array('class' => 'error'));


        $this->id= $id;
        $this->title = $title;
        $this->image = $image;
        $this->date_released = $date_released;
        $this->duration = $duration;
        $this->country = $country;
        $this->plot = $plot;
        $this->rating = $rating;


        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <div class="grupo-control">
                    <label>Nombre de la película:</label> <input class="control" type="text" name="nombrePelicula" value="$nombrePelicula" />$errorNombrePelicula
                </div>
                <div class="grupo-control">
                    <label>Fecha publicación:</label> <input class="control" type="date" name="date_released" value="$date_released" />$errorDate_released
                </div>
                <div class="grupo-control">
                    <label>Duración:</label> <input class="control" type="text" name="duration" value="$duration" />$errorDuration
                </div>
                <div class="grupo-control">
                    <label>País:</label> <input class="control" type="text" name="country" value="$country"/>
                </div>
                <div class="grupo-control">
                    <label>Trama:</label> <input class="control" type="text" name="plot" value="$plot" />
                </div>
                <div class="grupo-control">
                    <label>Rating:</label> <input class="control" type="range" name="rating"  value="$rating"/>$errorRating
                </div>
                <div class="grupo-control"><button type="submit" name="añadir">Añadir</button></div>
            </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();

        $nombrePelicula = $datos['nombrePelicula'] ?? null;

        if ( empty($nombrePelicula) || mb_strlen($nombrePelicula) < 1 ) {
            $result['nombrePelicula'] = "El nombre de la película tiene que tener una longitud de al menos 1 caracter.";
        }

        $date_released = $datos['publicacion'] ?? null;
        
        if ( empty($date_released) || $date_released > date() ) {
            $result['date_released'] = "La fecha no puede ser mayor que la actual.";
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
            $pelicula = Pelicula::crea($nombrePelicula, $date_released, $duration, $country, $plot);
            if ( ! $pelicula ) {
                $result[] = "La película ya existe";
            } 
        }
        return $result;
    }
}