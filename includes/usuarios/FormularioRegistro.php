<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Form;
use es\ucm\fdi\aw\Aplicacion;

class FormularioRegistro extends Form
{
    public function __construct() {
        parent::__construct('formRegistro');
    }
    
    protected function generaCamposFormulario($datos, $errores = array())
    {
        $user = $datos['user'] ?? '';
        $name = $datos['name'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorUser = self::createMensajeError($errores, 'user', 'span', array('class' => 'error'));
        $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'password2', 'span', array('class' => 'error'));

        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <div class="grupo-control">
                    <label>Nombre de usuario:</label> <input class="control" type="text" name="user" value="$user" />$errorUser
                </div>
                <div class="grupo-control">
                    <label>Nombre completo:</label> <input class="control" type="text" name="name" value="$name" />$errorName
                </div>
                <div class="grupo-control">
                    <label>Password:</label> <input class="control" type="password" name="password" />$errorPassword
                </div>
                <div class="grupo-control">
                    <label>Vuelve a introducir el Password:</label> <input class="control" type="password" name="password2" />$errorPassword2
                </div>
                <div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
            </fieldset>
        EOF;
        return $html;
    }
    

    protected function procesaFormulario($datos)
    {
        $result = array();

        $user = $datos['user'] ?? null;
        if ( empty($user) || mb_strlen($user) < 5 ) {
            $result['user'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }

        $name = $datos['name'] ?? null;
        if ( empty($name) || mb_strlen($name) < 5 ) {
            $result['name'] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }

        $password = $datos['password'] ?? null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $result['password'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = $datos['password2'] ?? null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $result['password2'] = "Los passwords deben coincidir";
        }
        
        if (count($result) === 0) {
            $usuario = Usuario::crea($user, $password, $name, '', '', null, 0, 0, 0,0);
            if ( ! $usuario ) {
                $result[] = "El usuario ya existe";
            } else {
                $app = Aplicacion::getSingleton();
                $app->login($usuario);
                $result = RUTA_APP.'index.php';
            }
        }
        return $result;
    }
}