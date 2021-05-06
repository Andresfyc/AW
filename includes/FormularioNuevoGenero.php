<?php
namespace es\ucm\fdi\aw;

class FormularioNuevoGenero extends Form
{
    private $prevPage;

    public function __construct($prevPage) {
        $this->prevPage = $prevPage;
        parent::__construct('formNuevoGenero');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $name = $datos['name'] ?? '';
        $prevPage = $datos['prevPage'] ?? $this->prevPage;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));


        //TODO Añadir lo de la imagen
        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
                <div class="grupo-control">
                    <label>Nombre del género:</label> <input class="control" type="text" name="name" value="$name" />$errorName
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
            $result['name'] = "El nombre del género no puede quedar vacío.";
        }

        $prevPage = $datos['prevPage'] ?? null;

        if (count($result) === 0) {
            //TODO Añadir lo de la imagen
            $genero = Genero::crea($name);
            if ( ! $genero ) {
                $result[] = "El género ya existe";
            } //TODO Añadir una redirección a la página de la película
            else {
                $result = "{$prevPage}";
            }
        }
        return $result;
    }
}