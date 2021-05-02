<?php
namespace es\ucm\fdi\aw;

class FormularioEditarEventoTema extends Form
{

    private $eventoTema;

    public function __construct($eventoTema) {
        $this->eventoTema = $eventoTema;
        parent::__construct('formEditarEventoTema');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        //echo substr($this->eventoTema->time(), 0, 10);
        $id = $datos['id'] ?? $this->eventoTema->id();
        $name = $datos['name'] ?? $this->eventoTema->name();
        $description = $datos['description'] ?? $this->eventoTema->description();
        $date = $datos['date'] ?? $this->eventoTema->timeDate();
        $time = $datos['time'] ?? $this->eventoTema->timeTime();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorDescription= self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
        $errorDate = self::createMensajeError($errores, 'date', 'span', array('class' => 'error'));
        $errorTime = self::createMensajeError($errores, 'time', 'span', array('class' => 'error'));


        //TODO Añadir lo de la imagen
        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <input class="control" type="hidden" name="id" value="$id" readonly/>
                <div class="grupo-control">
                    <label>Nombre del evento/tema:</label> <input class="control" type="text" name="name" value="$name" />$errorName
                </div>
                <div class="grupo-control">
                    <label>Descripción:</label> <input class="control" type="text" name="description" value="$description" />$errorDescription
                </div>
                <div class="grupo-control">
                    <label>Fecha y hora:</label> <input class="control" type="date" name="date" value="$date" />$errorDate
                </div>
                <div class="grupo-control">
                    <label>Fecha y hora:</label> <input class="control" type="time" name="time" value="$time" />$errorTime
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
            //TODO Añadir lo de la imagen
            $dateTime = (!empty($date) && empty($time)) ? $date . ' 00:00:00' : $date . ' ' . $time;
            $eventoTema = EventoTema::editar($id, $name, $description, $dateTime);
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