<?php
namespace es\ucm\fdi\aw;

class EventoTema
{

    
    public static function crea($name, $description, $time)
    {
        $eventoTema = new EventoTema(null, $name, $description, $time, null, null);
        return self::guarda($eventoTema);
    }
	
	public static function buscaPorId ($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM foro_eventos_temas  WHERE id = %d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $eventoTema = new EventoTema($fila['id'], $fila['name'], $fila['description'], $fila['time'], $fila['time_created'], $fila['num_messages']);
                $result = $eventoTema;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

        
    private static function inserta($eventoTema)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        if (empty($eventoTema->time) || $eventoTema->time == ' ') {
            $query=sprintf("INSERT INTO foro_eventos_temas(name, description, time_created) VALUES('%s', '%s', CURRENT_TIMESTAMP())"
                , $conn->real_escape_string($eventoTema->name)
                , $conn->real_escape_string($eventoTema->description));
        } else {
            $query=sprintf("INSERT INTO foro_eventos_temas(name, description, time, time_created) VALUES('%s', '%s', '%s', CURRENT_TIMESTAMP())"
                , $conn->real_escape_string($eventoTema->name)
                , $conn->real_escape_string($eventoTema->description)
                , $conn->real_escape_string($eventoTema->time));
        }
        
        if ( $conn->query($query) ) {
            $eventoTema->id = $conn->insert_id;
            $eventoTema->num_messages = $conn->insert_num_messages;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $eventoTema;
    }

    public static function editar($id, $name, $description, $time)
    {
        $eventoTema = new EventoTema($id, $name, $description, $time, null, null);
        echo "HOLA";
        return self::guarda($eventoTema);
    }

    public static function guarda($eventoTema)
    {
        echo "HOLA2";
        if ($eventoTema->id !== null) {
            echo "HOLA3";
            return self::actualiza($eventoTema);
        }
        return self::inserta($eventoTema);
    }

    private static function actualiza($eventoTema)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        
        if (empty($eventoTema->time) || $eventoTema->time == ' ') {
            $query=sprintf("UPDATE foro_eventos_temas SET name='%s', description='%s', time=null WHERE id=%d"
            , $conn->real_escape_string($eventoTema->name)
            , $conn->real_escape_string($eventoTema->description)
                , $eventoTema->id);
        } else {
            $query=sprintf("UPDATE foro_eventos_temas SET name='%s', description='%s', time='%s' WHERE id=%d"
            , $conn->real_escape_string($eventoTema->name)
            , $conn->real_escape_string($eventoTema->description)
            , $conn->real_escape_string($eventoTema->time)
                , $eventoTema->id);
        }
        echo $query;


        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el evento/tema: " . $eventoTema->name;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $eventoTema;
    }
	
	public static function buscaEventosRecientes()
	{
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query = "SELECT * FROM foro_eventos_temas WHERE time IS NOT NULL ORDER BY time DESC";

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new EventoTema($fila['id'], $fila['name'], $fila['description'], $fila['time'], $fila['time_created'], $fila['num_messages']);
		  }
		  $rs->free();
		}

		return $result;
	}
    
    public static function buscaTemas()
    {
        $result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = "SELECT * FROM foro_eventos_temas WHERE time IS NULL";

        $rs = $conn->query($query);
        if ($rs) {
          while($fila = $rs->fetch_assoc()) {
            $result[] = new EventoTema($fila['id'], $fila['name'], $fila['description'], $fila['time'], $fila['time_created'], $fila['num_messages']);
          }
          $rs->free();
        }

        return $result;
    }

    public static function borraPorId($id)
    {
        $result = false;
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM foro_eventos_temas WHERE id = %d", $id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    private $id;

    private $name;
	
	private $description;
	
	private $time;

    private $time_created;

    private $num_messages;

    private function __construct($id, $name, $description, $time, $time_created, $num_messages)
    {
        $this->id= $id;
        $this->name = $name;
        $this->description = $description;
        $this->time = $time;
        $this->time_created = $time_created;
        $this->num_messages = $num_messages;
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }

    public function time()
    {
        return $this->time;
    }

    public function timeTime()
    {
        return substr($this->time, 11, 19);
    }

    public function timeDate()
    {
        return substr($this->time, 0, 10);
    }

    public function time_created()
    {
        return $this->time_created;
    }

    public function num_messages()
    {
        return $this->num_messages;
    }
}
