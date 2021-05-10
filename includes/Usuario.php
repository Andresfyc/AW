<?php
namespace es\ucm\fdi\aw;

class Usuario
{

    public static function login($user, $password)
    {
        $usuario = self::buscaUsuario($user);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }

    public static function buscaUsuario($user)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.user = '%s'", $conn->real_escape_string($user));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $usuario = new Usuario($fila['user'], $fila['password'], $fila['name'], $fila['image'], $fila['date_joined'], $fila['watching'], $fila['admin'], $fila['content_manager'], $fila['moderator']);
                $result = $usuario;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function busqueda($search)
    {
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.user LIKE '%s' OR U.name LIKE '%s'", 
        '%'.$conn->real_escape_string($search).'%',
        '%'.$conn->real_escape_string($search).'%');

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Usuario($fila['user'], $fila['password'], $fila['name'], $fila['image'], $fila['date_joined'], $fila['watching'], $fila['admin'], $fila['content_manager'], $fila['moderator']);
		  }
		  $rs->free();
		}

		return $result;
    }
    
    public static function crea($user, $password, $name, $image, $date_joined, $watching, $admin, $content_manager, $moderator)
    {
        $usuario = self::buscaUsuario($user);
        if ($usuario) {
            return false;
        }
        $image = $image == NULL ? "user_logged.png" : $image;
        $usuario = new Usuario($user, self::hashPassword($password), $name, $image, $date_joined, $watching, $admin, $content_manager, $moderator);
        return self::guarda($usuario);
    }

    public static function editar($user, $password, $passwordComprobar, $name, $image, $admin, $content_manager, $moderator)
    {
        $usuario = self::buscaUsuario($user);
        if ($usuario && $usuario->compruebaPassword($passwordComprobar)) {
            $image = strlen($image) < 1 ? $usuario->image : $image;
            $password = strlen($password) < 1 ? $usuario->password : self::hashPassword($password);
            $admin = strlen($admin) < 1 ? $usuario->admin : $admin;
            $content_manager = strlen($content_manager) < 1 ? $usuario->content_manager : $content_manager;
            $moderator = strlen($moderator) < 1 ? $usuario->moderator : $moderator;
            $usuario = new Usuario($user, $password, $name, $image, null, null, $admin, $content_manager, $moderator);

            return self::guarda($usuario);
        }
        return false;

    }

    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function guarda($usuario)
    {
        if (self::buscaUsuario($usuario->user)) {

            return self::actualiza($usuario);
        }
        return self::inserta($usuario);
    }
    
    private static function inserta($usuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		echo "INSERTA";
        $query=sprintf("INSERT INTO Usuarios(user, password, name, date_joined) VALUES('%s', '%s', '%s', CURDATE())"
            , $conn->real_escape_string($usuario->user)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->name));
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $usuario;
    }
    
    private static function actualiza($usuario)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE usuarios U SET password='%s', name='%s', image='%s',  admin='%s', content_manager='%s', moderator='%s' WHERE U.user='%s'"
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->name)
            , $conn->real_escape_string($usuario->image)
            , $conn->real_escape_string($usuario->admin)
            , $conn->real_escape_string($usuario->content_manager)
            , $conn->real_escape_string($usuario->moderator)
            , $usuario->user);
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el usuario: " . $usuario->user;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $usuario;
    }
	
	public static function buscaAmigosPorUser($user, $limit=NULL)
	{
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query = sprintf("SELECT u2.* FROM amigos u JOIN usuarios u1 ON u1.user = u.user JOIN usuarios u2 ON u2.user = u.friend WHERE u1.user = '%s'", $conn->real_escape_string($user));
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Usuario($fila['user'], $fila['password'], $fila['name'], $fila['image'], $fila['date_joined'], $fila['watching'], $fila['admin'], $fila['content_manager'], $fila['moderator']);
		  }
		  $rs->free();
		}

		return $result;
	}

    private $user;

    private $password;
	
	private $name;

    private $image;

    private $date_joined;
	
	private $watching;

    private $admin;

    private $content_manager;
	
	private $moderator;
	
	private $film;

    private function __construct($user, $password, $name, $image, $date_joined, $watching, $admin, $content_manager, $moderator)
    {
        $this->user= $user;
        $this->password = $password;
        $this->name = $name;
        $this->image = $image;
        $this->date_joined = $date_joined;
        $this->watching = $watching;
        $this->admin = $admin;
        $this->content_manager = $content_manager;
        $this->moderator = $moderator;
		$this->film = Pelicula::buscaPorId($this->watching);
    }

    public function film()
    {
        return $this->film;
    }

    public function user()
    {
        return $this->user;
    }

    public function name()
    {
        return $this->name;
    }

    public function image()
    {
        return $this->image;
    }

    public function date_joined()
    {
        return $this->date_joined;
    }

    public function watching()
    {
        return $this->watching;
    }

    public function admin()
    {
        return $this->admin;
    }

    public function content_manager()
    {
        return $this->content_manager;
    }

    public function moderator()
    {
        return $this->moderator;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
}
