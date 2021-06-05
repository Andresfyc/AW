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
                <div class="grupo-fomulario">
                $htmlErroresGlobales
                <h1>Regístrate</h1>
                
                     <input  type="text" name="user" value="$user" placeholder="Usuario" required/>$errorUser
                
                     <input  type="text" name="name" value="$name"  placeholder="Nombre" required/>$errorName
              
                    <input  type="password" name="password" placeholder="Password" required/>$errorPassword
                
                    <input  type="password" name="password2" placeholder="Password" required/>$errorPassword2
         EOF;

        $app = Aplicacion::getSingleton();
        if ($app->usuarioLogueado() && $app->esAdmin()) {
            $html .= <<<EOF
                      <div class="checkboxes">
                        <label><input type="checkbox" name="manager" value="1">Cont. Manager</label>
                        <label><input type="checkbox" name="moderador"value="1">Moderador </label>
                        <label><input type="checkbox" name="admin" value="1">Admin </label>
                     </div>
            EOF;

        }

        $html .= <<<EOF
                <button type="submit" name="registro">Registrar</button>
           </div>
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

        $moderador = $datos['moderador']?? null;;
        if ( empty($moderador) ) {
            $moderador = 0;
        }

        $manager = $datos['manager']?? null;;
        if ( empty($manager) ) {
            $manager = 0;
        }

        $admin = $datos['admin'] ?? null;;
        if ( empty($admin) ) {
            $admin = 0;
        }


        if (count($result) === 0) {

            $usuario = Usuario::crea($user, $password, $name, '', '', null, $admin, $manager, $moderador,0);
            if ( ! $usuario ) {
                $result[] = "El usuario ya existe";
            } else {
                $app = Aplicacion::getSingleton();
                if($app->esAdmin()){
                    $result = RUTA_APP.'index.php';
                }else{
                    $app->login($usuario);
                    $result = RUTA_APP.'index.php';
                }

            }
        }
        return $result;
    }
}