<?php
namespace es\ucm\fdi\aw\usuarios;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioEditarUsuario extends Form
{

  private $user;
  private $usuario;
  private $prevPage;
  private $isSelf;

  public function __construct($user, $prevPage, $isSelf)
  {
    parent::__construct('formEditarUsuario', $user);
    $this->user = $user;
    $this->prevPage = $prevPage;
    $this->isSelf = $isSelf;
  }

  
  protected function generaCamposFormulario($datos, $errores = array())
  {    
    $user = $datos['user'] ?? $this->user;
    $this->usuario = Usuario::buscaUsuario($user);
    $name = $datos['name'] ?? $this->usuario->name();
    $image = $datos['image'] ?? '';
    $prevPage = $datos['prevPage'] ?? $this->prevPage;
    $isSelf = $datos['isSelf'] ?? $this->isSelf;
    $app = Aplicacion::getSingleton();

    // Se generan los mensajes de error si existen.
    $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
    $errorUser = self::createMensajeError($errores, 'id', 'span', array('class' => 'error'));
    $errorName = self::createMensajeError($errores, 'name', 'span', array('class' => 'error'));
    $errorPasswordComprobar = self::createMensajeError($errores, 'passwordComprobar', 'span', array('class' => 'error'));
    $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));
    $errorPassword2 = self::createMensajeError($errores, 'password2', 'span', array('class' => 'error'));
    $errorImage= self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));


    $camposFormulario = <<<EOF
        <fieldset>
        
            <div class="grupo-editar">
            $htmlErroresGlobales
            
                <input class="control" type="hidden" name="user" value="$user"  readonly/>$errorUser
                <input class="control" type="hidden" name="prevPage" value="$prevPage" readonly/>
                <input class="control" type="hidden" name="isSelf" value="$isSelf" readonly/>
    EOF;
    if ($isSelf) {
        $camposFormulario .= <<<EOF
        
                <div class="col-25"><label>Nombre:</label> </div>
                <div class="col-75"><input class="control" type="text" name="name" value="$name" />$errorName</div>
           
                <div class="col-25"><label>Imagen:</label> </div>
                <div class="col-75"><input class="control" type="file" name="image" value="$image" />$errorImage</div>
                    <div class="col-25"><label>Password Actual:</label> </div>
                    <div class="col-75"><input  type="password" name="passwordComprobar" />$errorPasswordComprobar</div>
                
                    <div class="col-25"><label>Password Nueva:</label> </div>
                    <div class="col-75"><input  type="password" name="password" />$errorPassword</div>
                
                    <div class="col-25"><label>Repetir Password Nueva:</label> </div>
                    <div class="col-75"><input  type="password" name="password2" />$errorPassword2</div>
        EOF;
    }

    if ($app->esAdmin()) {
        $adminCheck = $this->usuario->admin() ? "checked" : "";
        $moderatorCheck = $this->usuario->moderator() ? "checked" : "";
        $managerCheck = $this->usuario->content_manager() ? "checked" : "";
        $camposFormulario .= <<<EOF
            <div class="checkboxes">
                <label><input type="checkbox" name="manager" value="1" {$managerCheck}>Cont. Manager</label>
                <label><input type="checkbox" name="moderador" value="1" {$moderatorCheck}>Moderador </label>
                <label><input type="checkbox" name="admin" value="1" {$adminCheck}>Admin </label>
            </div>
        EOF;
    }

    $camposFormulario .= <<<EOF
            
                <div><button type="submit" name="registro">Actualizar</button></div>    
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
    
    $isSelf = $datos['isSelf'] ?? null;
    
    $user = $datos['user'] ?? null;
    if ( empty($user) || mb_strlen($user) < 5 ) {
        $result['user'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
    }

    if ($isSelf) {

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
    }
            
    $prevPage = $datos['prevPage'] ?? null;

    $moderador = $datos['moderador']?? 0;
    $manager = $datos['manager']?? 0;
    $admin = $datos['admin'] ?? 0;

    if (count($result) === 0) {
        $usuario = Usuario::buscaUsuario($user);
        if (($app->usuarioLogueado() && $app->user() == $usuario->user()) || ($app->esAdmin() && !$isSelf)) {
            if ($isSelf) {
                $usuario = Usuario::editar($user, $password, $passwordComprobar, $name, $_FILES['image']['name'], $admin, $manager, $moderador, $app->esAdmin());
            } else {
                $usuario = Usuario::editar($user, null, null, null, null, $admin, $manager, $moderador, $app->esAdmin());
            }
            if ( ! $usuario  ) {
                $result[] = "El usuario ya existe";
            } else {
                if ($isSelf) {
                    $app->login($usuario);
                }
                $result = "{$prevPage}";
            }
        }
    }
    return $result;
  }
}
