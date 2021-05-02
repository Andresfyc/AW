<?php
namespace es\ucm\fdi\aw;

class FormularioNuevoEventoTema extends Form
{
    
    public function __construct() {
        parent::__construct('formNuevoEventoTema');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $name = $datos['name'] ?? '';
        $description = $datos['description'] ?? '';
        $date = $datos['date'] ?? '';
        $time = $datos['time'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorDescription= self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
        $errorDate = self::createMensajeError($errores, 'date', 'span', array('class' => 'error'));
        $errorTime = self::createMensajeError($errores, 'time', 'span', array('class' => 'error'));


        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <div class="grupo-control">
                    <label>Nombre del evento/tema:</label> <input class="control" type="text" name="name" value="$name" />$errorName
                </div>
                <div class="grupo-control">
                    <label>Descripción:</label> <input class="control" type="text" name="description" value="$description" />$errorDescription
                </div>
                <div class="grupo-control">
                    <label>Fecha (Si es evento):</label> <input class="control" type="date" name="date" value="$date" />$errorDate
                </div>
                <div class="grupo-control">
                    <label>Hora (Si es evento):</label> <input class="control" type="time" name="time" value="$time" />$errorTime
                </div>
                <div class="grupo-control"><button type="submit" name="nueva">Añadir</button></div>
            </fieldset>
        EOF;
        return $html;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();

        $name = $datos['name'] ?? null;
        if ( empty($name) ) {
            $result['name'] = "El nombre del evento/tema no puede quedar vacío.";
        }

        $description = $datos['description'] ?? null;
        if ( empty($description) ) {
            $result['description'] = "La descripción no puede quedar vacía.";
        }

        $date = $datos['date'] ?? null;
        $time = $datos['time'] ?? null;

        if (count($result) === 0) {
            $dateTime = !empty($date) && emtpty($time) ? $date . ' 00:00:00' : $date . ' ' . $time;
            $eventoTema = EventoTema::crea($name, $description, $dateTime);
            if ( ! $eventoTema ) {
                $result[] = "El evento/tema ya existe";
            } //TODO Añadir una redirección a la página de la película
            else {
                $result = 'foro.php';
            }
        }
        return $result;
    }
}