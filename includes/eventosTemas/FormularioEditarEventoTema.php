<?php

namespace es\ucm\fdi\aw\eventosTemas;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioEditarEventoTema extends Form
{

    private $id;
    private $eventoTema;
    private $prevPage;

    public function __construct($id, $prevPage)
    {
        parent::__construct('formEditarEventoTema', $id);
        $this->id = $id;
        $this->prevPage = $prevPage;
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $id = $datos['id'] ?? $this->id;
        $this->eventoTema = EventoTema::buscaPorId($id);
        $name = $datos['name'] ?? $this->eventoTema->name();
        $description = $datos['description'] ?? $this->eventoTema->description();
        $date = $datos['date'] ?? $this->eventoTema->timeDate();
        $time = $datos['time'] ?? $this->eventoTema->timeTime();
        $prevPage = $datos['prevPage'] ?? $this->prevPage;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorDescription = self::createMensajeError($errores, 'description', 'span', array('class' => 'error'));
        $errorDate = self::createMensajeError($errores, 'date', 'span', array('class' => 'error'));
        $errorTime = self::createMensajeError($errores, 'time', 'span', array('class' => 'error'));


        //TODO Añadir lo de la imagen
        $camposFormulario = <<<EOF
        <fieldset>
        <div class="grupo-editar">
            $htmlErroresGlobales
            <input class="control" type="hidden" name="id" value="$id" readonly/>
            <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
            
                <div class="col-25"><label>Evento/tema:</label> </div>
                <div class="col-75"><input class="control" type="text" name="name" value="$name" />$errorName</div>
            
            
                <div class="col-25"><label>Descripción:</label> </div>
                <div class="col-75"><textarea class="control" type="text" name="description" value="$description" />$description</textarea>$errorDescription</div>
           
            
                <div class="col-25"><label>Fecha:</label> </div>
               <div class="col-75"> <input class="control" type="date" name="date" value="$date" />$errorDate</div>
           
                <div class="col-25"><label>Hora:</label> </div>
                <div class="col-75"><input class="control" type="time" name="time" value="$time" />$errorTime</div>
            
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
        if (empty($name)) {
            $result['name'] = "El nombre del evento/tema no puede quedar vacío.";
        }

        $description = $datos['description'] ?? null;
        if (empty($description)) {
            $result['description'] = "La descripción no puede quedar vacía.";
        }
        
        $prevPage = $datos['prevPage'] ?? null;

        $date = $datos['date'] ?? null;
        $time = $datos['time'] ?? null;

        if (count($result) === 0) {
            $dateTime = (!empty($date) && empty($time)) ? $date . ' 00:00:00' : $date . ' ' . $time;
            if ($app->usuarioLogueado() && ($app->esGestor() || $app->esAdmin() || $app->esModerador())) {
                $eventoTema = EventoTema::editar($id, $name, $description, $dateTime);

                if (!$eventoTema) {
                    $result[] = "El evento/tema ya existe";
                } else {
                    $result = "{$prevPage}";
                }
            }
        }
        return $result;
    }
}
