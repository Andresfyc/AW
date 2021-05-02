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
        $id = $datos['id'] ?? $this->eventoTema->id();
        $name = $datos['name'] ?? $this->eventoTema->name();
        $description = $datos['description'] ?? $this->eventoTema->description();
        $time = $datos['time'] ?? $this->eventoTema->time();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'title', 'span', array('class' => 'error'));
        $errorDescription= self::createMensajeError($errores, 'date_released', 'span', array('class' => 'error'));
        $errorTime = self::createMensajeError($errores, 'duration', 'span', array('class' => 'error'));


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
                    <label>Fecha y hora:</label> <input class="control" type="datetime" name="time" value="$time" />$errorTime
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

        $time = $datos['time'] ?? null;
        if ( empty($time) ) {
            $result['time'] = "La fecha y hora no pueden quedar vacíos.";
        }

        if (count($result) === 0) {
            //TODO Añadir lo de la imagen
            $eventoTema = EventoTema::editar($id, $name, $description, $time);
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