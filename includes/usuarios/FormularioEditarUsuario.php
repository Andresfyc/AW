<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioEditarUsuario extends Form
{

  private $user;
  private $usuario;

  public function __construct($user)
  {
    parent::__construct('formEditarUsuario', $user);
    $this->user = $user;
  }

  
  protected function generaCamposFormulario($datos, $errores = array())
  {    
    $user = $datos['user'] ?? $this->user;
    $this->usuario = Usuario::buscaUsuario($user);
    $name = $datos['name'] ?? $this->usuario->name();
    $image = $datos['image'] ?? '';

    // Se generan los mensajes de error si existen.
    $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    $errorUser = self::createMensajeError($errores, 'user', 'span', array('class' => 'error'));
    $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
    $errorPasswordComprobar = self::createMensajeError($errores, 'passwordComprobar', 'span', array('class' => 'error'));
    $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));
    $errorPassword2 = self::createMensajeError($errores, 'password2', 'span', array('class' => 'error'));
    $errorImage= self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));


    $camposFormulario = <<<EOF
        <fieldset>
            $htmlErroresGlobales
            
                <input class="control" type="hidden" name="user" value="$user"  readonly/>$errorUser
        
            <div class="grupo-control">
                <label>Nombre completo:</label> <input class="control" type="text" name="name" value="$name" />$errorName
            </div>
            <div class="grupo-control">
                <label>Imagen:</label> <input class="control" type="file" name="image" value="$image" />$errorImage
            </div>
            <div class="grupo-control">
                <label>Password Actual:</label> <input class="control" type="password" name="passwordComprobar" />$errorPasswordComprobar
            </div>
            <div class="grupo-control">
                <label>Password Nueva:</label> <input class="control" type="password" name="password" />$errorPassword
            </div>
            <div class="grupo-control">
                <label>Repetir Password Nueva:</label> <input class="control" type="password" name="password2" />$errorPassword2
            </div>
            <div class="grupo-control"><button type="submit" name="registro">Actualizar</button></div>
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

    $user = $datos['user'] ?? null;
    if ( empty($user) || mb_strlen($user) < 5 ) {
        $result['user'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
    }

    $name = $datos['name'] ?? null;
    if ( empty($name) || mb_strlen($name) < 5 ) {
        $result['name'] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
    }

    $passwordComprobar = $datos['passwordComprobar'] ?? null;
    if ( empty($passwordComprobar) || mb_strlen($passwordComprobar) < 5 ) {
        $result['passwordComprobar'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
    }

    $password = $datos['password'] ?? null;
    if ( !empty($password) && mb_strlen($password) < 5 ) {
        $result['password'] = "El password tiene que tener una longitud de al menos 5 caracteres.";
    }
    $password2 = $datos['password2'] ?? null;
    if ( strcmp($password, $password2) !== 0 ) {
        $result['password2'] = "Los passwords deben coincidir";
    }

    $image = $datos['image'] ?? null;
    $dir_subida = './img/usuarios/';
    $fichero_subido = $dir_subida . basename($_FILES['image']['name']);
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $fichero_subido) && !empty($_FILES['image']['name'])) {
        $result['image'] = $_FILES['image']['name']."El fichero no se ha podido subir correctamente";
    }

    if (count($result) === 0) {
        $usuario = Usuario::buscaUsuario($user);
        if ($app->usuarioLogueado() && $app->user() == $usuario->user()) {
            $usuario = Usuario::editar($user, $password, $passwordComprobar, $name, $_FILES['image']['name'], null, null, null);
            if ( ! $usuario  ) {
                $result[] = "El usuario ya existe";
            } else {
                $app->login($usuario);
                $result = RUTA_APP."usuario.php";
            }
        }
    }
    return $result;
  }
}
