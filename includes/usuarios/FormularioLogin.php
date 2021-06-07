<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\Aplicacion;

class FormularioLogin extends Form
{

    private $prevPage;

    public function __construct($prevPage) {
        parent::__construct('formLogin');
        $this->prevPage = $prevPage;
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $user =$datos['user'] ?? '';
        $prevPage = $datos['prevPage'] ?? $this->prevPage;

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorUser = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
            <div class="grupo-fomulario">
                $htmlErroresGlobales
                <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
                <img id="imgLogin" src="img/film.gif" alt="logo login" >
                <input  type="text" name="user" placeholder="Usuario" value="$user" required/>$errorUser
                <input type="password" placeholder="Password" name="password" required/>$errorPassword
                <button type="submit" name="login">Entrar</button>
            </div>
        
        EOF;

        return $html;
    }
    

    protected function procesaFormulario($datos)
    {
        $result = array();

        $user =$datos['user'] ?? null;
        if ( empty($user) ) {
            $result['user'] = "El nombre de usuario no puede estar vacío";
        }

        $password = $datos['password'] ?? null;
        if ( empty($password) ) {
            $result['password'] = "El password no puede estar vacío.";
        }
        
        $prevPage = $datos['prevPage'] ?? null;
        
        if (count($result) === 0) {
            $usuario = Usuario::login($user, $password);
            if ( ! $usuario ) {
                // No se da pistas a un posible atacante
                $result[] = "El usuario o el password no coinciden";
            } else {
                $app = Aplicacion::getSingleton();
                $app->login($usuario);
                $result = "{$prevPage}";
            }
        }
        return $result;
    }
}
