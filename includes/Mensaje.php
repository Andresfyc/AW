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

    //TODO Añadir actualiza()
    
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

    private $id;

    private $evento_tema;
	
	private $user;
	
	private $text;

    private $time_created;

    private function __construct($id, $evento_tema, $user, $text, $time_created)
    {
        $this->id = $id;
        $this->evento_tema = $evento_tema;
        $this->user = $user;
        $this->text = $text;
        $this->time_created = $time_created;
    }

    /*private function __construct($evento_tema, $user, $text, $time_created)
    {
        $this->evento_tema = $evento_tema;
        $this->user = $user;
        $this->text = $text;
        $this->time_created = $time_created;
    }*/

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
}
