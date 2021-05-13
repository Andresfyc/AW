<?php
namespace es\ucm\fdi\aw;

/**
 * Resultado asociado a la gestión de un formulario {@code Form}.
 *
 */
class ResultadoGestionFormulario
{

    private $enviado;

    private $htmlFormulario;

    private $errores;

    private $resultado;


    /**
     * 
     * @param bool $enviado `true`si el formulario ha sido enviado o `false` en otro caso.
     * @param string $htmlFormulario (opcional) HTML asociado al formulario si el formulario *no* ha sido enviado o ha habido errores al procesarlo.
     * @param string[] $errores (opcional) Array con los mensajes de error como resultado de procesar el formulario
     * @param any $resultado (opcional) Resultado de procesar el formulario.
     */
    public function __construct($enviado = false, $htmlFormulario = '', $errores = null, $resultado = null)
    {
        $this->enviado = $enviado;
        $this->htmlFormulario = $htmlFormulario;
        $this->errores = $errores;
        $this->resultado = $resultado;
    }
    public function getEnviado()
    {
        return $this->enviado;
    }

    public function setEnviado($enviado)
    {
        $this->enviado = $enviado;
    }

    public function getHtmlFormulario()
    {
        return $this->htmlFormulario;
    }

    public function setHtmlFormulario($htmlFormulario)
    {
        $this->htmlFormulario = $htmlFormulario;
    }

    public function getErrores()
    {
        return $this->errores;
    }

    public function setErrores($errores)
    {
        $this->errores = $errores;
    }

    public function getResultado()
    {
        return $this->resultado;
    }

    public function setResultado($resultado)
    {
        $this->resultado = $resultado;
    }

    /* Métodos mágicos para que si existen métodos setPropiedad / getPropiedad se pueda hacer:
    *   $var->propiedad, que equivale a $var->getPropiedad()
    *   $var->propiedad = $valor, que equivale a $var->setPropiedad($valor)
    */
    public function __get($property)
    {
        $methodName = 'get'. ucfirst($property);
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        } else if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new Exception("La propiedad '$property' no está definida");
        }
    }

    public function __set($property, $value)
    {
        $methodName = 'set'. ucfirst($property);
        if (method_exists($this, $methodName)) {
            $this->$methodName($value);
        } else if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new Exception("La propiedad '$property' no está definida");
        }
    }
}