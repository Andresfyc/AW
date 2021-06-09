<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\usuarios\Usuario;

/**
 * Clase que mantiene el estado global de la aplicación.
 */
class Aplicacion
{
	const ATTRIBUTO_SESSION_ATTRIBUTOS_PETICION = 'attsPeticion';

	private static $instancia;
	
	/**
	 * Devuele una instancia de {@see Aplicacion}.
	 * 
	 * @return Applicacion Obtiene la única instancia de la <code>Aplicacion</code>
	 */
	public static function getSingleton() {
		if (  !self::$instancia instanceof self) {
			self::$instancia = new self;
		}
		return self::$instancia;
	}

	/**
	 * @var array Almacena los datos de configuración de la BD
	 */
	private $bdDatosConexion;
	
	/**
	 * Almacena si la Aplicacion ya ha sido inicializada.
	 * 
	 * @var boolean
	 */
	private $inicializada = false;
	
	/**
	 * @var \mysqli Conexión de BD.
	 */
	private $conn;
	
	/**
	 * Evita que se pueda instanciar la clase directamente.
	 */
	private function __construct() {
	}
	
	/**
	 * Evita que se pueda utilizar el operador clone.
	 */
	public function __clone()
	{
		throw new Exception('No tiene sentido el clonado');
	}


	/**
	 * Evita que se pueda utilizar serialize().
	 */
	public function __sleep()
	{
		throw new Exception('No tiene sentido el serializar el objeto');
	}

	/**
	 * Evita que se pueda utilizar unserialize().
	 */
	public function __wakeup()
	{
		throw new Exception('No tiene sentido el deserializar el objeto');
	}
	
	/**
	 * Inicializa la aplicación.
	 * 
	 * @param array $bdDatosConexion datos de configuración de la BD
	 */
	public function init($bdDatosConexion)
	{
        if ( ! $this->inicializada ) {
    	    $this->bdDatosConexion = $bdDatosConexion;
    		session_start();
    		$this->inicializada = true;
        }
	}
	
	/**
	 * Cierre de la aplicación.
	 */
	public function shutdown()
	{
	    $this->compruebaInstanciaInicializada();
	    if ($this->conn !== null && ! $this->conn->connect_errno) {
	        $this->conn->close();
	    }
	}
	
	/**
	 * Comprueba si la aplicación está inicializada. Si no lo está muestra un mensaje y termina la ejecución.
	 */
	private function compruebaInstanciaInicializada()
	{
	    if (! $this->inicializada ) {
	        echo "Aplicacion no inicializa";
	        exit();
	    }
	}
	
	/**
	 * Devuelve una conexión a la BD. Se encarga de que exista como mucho una conexión a la BD por petición.
	 * 
	 * @return \mysqli Conexión a MySQL.
	 */
	public function conexionBd()
	{
	    $this->compruebaInstanciaInicializada();
		if (! $this->conn ) {
			$bdHost = $this->bdDatosConexion['host'];
			$bdUser = $this->bdDatosConexion['id'];
			$bdPass = $this->bdDatosConexion['pass'];
			$bd = $this->bdDatosConexion['bd'];
			
			$this->conn = new \mysqli($bdHost, $bdUser, $bdPass, $bd);
			if ( $this->conn->connect_errno ) {
				echo "Error de conexión a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
				exit();
			}
			if ( ! $this->conn->set_charset("utf8mb4")) {
				echo "Error al configurar la codificación de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
				exit();
			}
		}
		return $this->conn;
	}


    public function login(Usuario $usuario)
    {
      $this->compruebaInstanciaInicializada();
      $_SESSION['login'] = true;
      $_SESSION['user'] = $usuario->user();
      $_SESSION['name'] = $usuario->name();
      $_SESSION['watching'] = $usuario->watching();
	  $_SESSION['esAdmin'] = $usuario->admin();
	  $_SESSION['esGestor'] = $usuario->content_manager();
	  $_SESSION['esModerador'] = $usuario->moderator();
	  $_SESSION['esPremium'] = $usuario->premium();
	  $_SESSION['image'] = $usuario->image();
	  $_SESSION['validezPremium'] = $usuario->premiumValidity();
    }

    public function logout()
    {
      $this->compruebaInstanciaInicializada();
      //Doble seguridad: unset + destroy
      unset($_SESSION['login']);
      unset($_SESSION['user']);
      unset($_SESSION['name']);
      unset($_SESSION['watching']);
      unset($_SESSION['esAdmin']);
      unset($_SESSION['esGestor']);
      unset($_SESSION['esModerador']);
      unset($_SESSION['esPremium']);
      unset($_SESSION['image']);
	  unset($_SESSION['validezPremium']);
  
  
      session_destroy();
      session_start();
    }
  
    public function usuarioLogueado()
    {
      $this->compruebaInstanciaInicializada();
      return ($_SESSION['login'] ?? false) === true;
    }
  
    public function user()
    {
      $this->compruebaInstanciaInicializada();
      return $_SESSION['user'] ?? '';
    }
  
    public function name()
    {
      $this->compruebaInstanciaInicializada();
      return $_SESSION['name'] ?? '';
    }
  
    public function image()
    {
      $this->compruebaInstanciaInicializada();
      return $_SESSION['image'] ?? '';
    }
  
    public function watching()
    {
      $this->compruebaInstanciaInicializada();
      return $_SESSION['watching'] ?? '';
    }
  
    public function esAdmin()
    {
      $this->compruebaInstanciaInicializada();
      return $_SESSION['esAdmin'];
    }
  
    public function esModerador()
    {
      $this->compruebaInstanciaInicializada();
      return $_SESSION['esModerador'];
    }
  
    public function esGestor()
    {
      $this->compruebaInstanciaInicializada();
      return $_SESSION['esGestor'];
    }

    public function esPremium()
    {
        $this->compruebaInstanciaInicializada();
        return $_SESSION['esPremium'];

    }

    public function validezPremium()
    {
        $this->compruebaInstanciaInicializada();
        return $_SESSION['validezPremium'];

    }
}
