<?php
namespace es\ucm\fdi\aw;

class EventoTema
{
	
	/*public static function buscaPorId ($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas P WHERE P.id = '%d'", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $eventoTema = new EventoTema($fila['id'], $fila['name'], $fila['description'], $fila['time'], $fila['time_created'], $fila['num_messages']);
                $eventoTema->id = $fila['id'];
                $result = $eventoTema;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }*/
	
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

    public function time_created()
    {
        return $this->time_created;
    }

    public function num_messages()
    {
        return $this->num_messages;
    }
}
