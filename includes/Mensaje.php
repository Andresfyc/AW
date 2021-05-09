<?php
namespace es\ucm\fdi\aw;

class Mensaje
{
    
    public static function crea($eventoTema, $user, $text)
    {
        $mensaje = new Mensaje(null, $eventoTema, $user, $text, '');
        return self::guarda($mensaje);
    }
    
    public static function guarda($mensaje)
    {
        if ($mensaje->id !== null) {
            return self::actualiza($mensaje);
        }
        return self::inserta($mensaje);
    }
    
    private static function inserta($mensaje)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO foro_mensajes (evento_tema, user, text, time_created) VALUES (%d, '%s','%s', CURRENT_TIMESTAMP())"
            , $conn->real_escape_string($mensaje->evento_tema)
            , $conn->real_escape_string($mensaje->user)
            , $conn->real_escape_string($mensaje->text));
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
            $usuario->time_created = $conn->insert_time_created;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $mensaje;
    }

    private static function actualiza($mensaje)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE foro_mensajes M SET text = '%s' WHERE M.id=%d"
        , $conn->real_escape_string($mensaje->text)
            , $mensaje->id);
        echo $query;
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el mensaje: " . $mensaje->text;
                //exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $mensaje;
    }
    
    public static function buscaMensajesPorIdEventoTema($id)
    {
        $result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM foro_mensajes WHERE evento_tema = '%d' ORDER BY time_created DESC", $id);

        $rs = $conn->query($query);
        if ($rs) {
          while($fila = $rs->fetch_assoc()) {
            $result[] = new Mensaje($fila['id'], $fila['evento_tema'], $fila['user'], $fila['text'], $fila['time_created']);
          }
          $rs->free();
        }

        return $result;
    }
    public static function buscaPorId($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM foro_mensajes WHERE id = %d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $mensaje = new Mensaje($fila['id'], $fila['evento_tema'], $fila['user'], $fila['text'], $fila['time_created']);
                $result = $mensaje;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }


    public static function borraPorId($id)
    {
        $result = false;

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM foro_mensajes WHERE id = %d", $id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public static function editar($id,$evento_tema,$user,$text,$time_created)
    {
        $mensaje = self::buscaPorId($id);
        $evento_tema = strlen($evento_tema) < 1 ? $mensaje->evento_tema : $evento_tema;
        $user = strlen($user) < 1 ? $mensaje->user : $user;
        $text = strlen($text) < 1 ? $mensaje->text : $text;
        $time_created = strlen($time_created) < 1 ? $mensaje->time_created : $time_created;
        $mensaje = new Mensaje($id,$evento_tema,$user,$text,$time_created);
        
        return self::guarda($mensaje);
    }


    private $id;

    private $evento_tema;
	
	private $user;
	
	private $text;

    private $time_created;
    
    private $evento_tema_obj;

    private function __construct($id, $evento_tema, $user, $text, $time_created)
    {
        $this->id = $id;
        $this->evento_tema = $evento_tema;
        $this->user = $user;
        $this->text = $text;
        $this->time_created = $time_created;
		$this->evento_tema_obj = EventoTema::buscaPorId($this->evento_tema);
    }

    public function id()
    {
        return $this->id;
    }

    public function evento_tema()
    {
        return $this->evento_tema;
    }

    public function user()
    {
        return $this->user;
    }

    public function text()
    {
        return $this->text;
    }

    public function time_created()
    {
        return $this->time_created;
    }

    public function evento_tema_obj()
    {
        return $this->evento_tema_obj;
    }
}
