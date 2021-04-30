<?php
namespace es\ucm\fdi\aw;

class Mensaje
{
    
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
        $this->id= $id;
        $this->evento_tema = $evento_tema;
        $this->user = $user;
        $this->text = $text;
        $this->time_created = $time_created;
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
}
