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
        $time = $datos['time'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorDescription= self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
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
                    <label>Fecha y hora (Si es evento):</label> <input class="control" type="datetime" name="time" value="$time" />$errorTime
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

        $time = $datos['time'] ?? null;

        if (count($result) === 0) {
            $eventoTema = EventoTema::crea($name, $description, $time);
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