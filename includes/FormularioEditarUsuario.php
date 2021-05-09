<?php


namespace es\ucm\fdi\aw;


class FormularioEditarUsuario extends Form
{

    private $usuario;

    public function __construct($usuario) {
        $this->usuario = $usuario;
        parent::__construct('formEditarPerfil');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $user = $datos['user'] ?? $this->usuario->user();
        $nombre = $datos['nombre'] ?? $this->usuario->name();
        $image = $datos['image'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorUser = self::createMensajeError($errores, 'user', 'span', array('class' => 'error'));
        $errorNombre = self::createMensajeError($errores, 'nombre', 'span', array('class' => 'error'));
        $errorPasswordComprobar = self::createMensajeError($errores, 'passwordComprobar', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password', 'span', array('class' => 'error'));
        $errorPassword2 = self::createMensajeError($errores, 'password2', 'span', array('class' => 'error'));
        $errorImage= self::createMensajeError($errores, 'image', 'span', array('class' => 'error'));

        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                
                     <input class="control" type="hidden" name="user" value="$user"  readonly/>$errorUser
               
                <div class="grupo-control">
                    <label>Nombre completo:</label> <input class="control" type="text" name="nombre" value="$nombre" />$errorNombre
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
        return $html;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();

        $user = $datos['user'] ?? null;
        if ( empty($user) || mb_strlen($user) < 5 ) {
            $result['user'] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }

        $nombre = $datos['nombre'] ?? null;
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $result['nombre'] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
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
            $usuario = Usuario::editar($user, $password, $passwordComprobar, $nombre, $_FILES['image']['name'], null, null, null);
            if ( ! $usuario ) {
                $result[] = "Contraseña errónea";
            } 
            else {
                $_SESSION['login'] = true;
                $_SESSION['nombre'] = $usuario->user();
                $_SESSION['nombreCompleto'] = $usuario->name();
                $_SESSION['esAdmin'] = $usuario->admin();
                $_SESSION['esGestor'] = $usuario->content_manager();
                $_SESSION['esModerador'] = $usuario->moderator();
                $_SESSION['imagen'] = $usuario->image();
                $result = 'perfil.php';
            }
        }
        return $result;
    }
}