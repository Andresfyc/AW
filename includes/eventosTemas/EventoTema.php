<?php

namespace es\ucm\fdi\aw\eventosTemas;

use es\ucm\fdi\aw\Aplicacion as App;

class EventoTema
{

  public static function crea($name, $description, $time)
  {
    $eventoTema = new EventoTema(null, $name, $description, $time, null, null);

    return self::guarda($eventoTema);
  }

  public static function buscaPorId($id)
  {
    $result = null;
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM foro_eventos_temas  WHERE id = %d", $id);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      while($fila = $rs->fetch_assoc()) {
        $result = new EventoTema($fila['id'], $fila['name'], $fila['description'], $fila['time'], $fila['time_created'], $fila['num_messages']);
      }
      $rs->free();
    }
    return $result;
  }
  
  public static function inserta($eventoTema)
  { //TODO Intentar hacer sin if else
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    

    if (strlen($eventoTema->time()) <= 10) {
        $query=sprintf("INSERT INTO foro_eventos_temas(name, description, time_created) VALUES('%s', '%s', CURRENT_TIMESTAMP())"
            , $conn->real_escape_string($eventoTema->name)
            , $conn->real_escape_string($eventoTema->description));
    } else {
        $query=sprintf("INSERT INTO foro_eventos_temas(name, description, time, time_created) VALUES('%s', '%s', '%s', CURRENT_TIMESTAMP())"
            , $conn->real_escape_string($eventoTema->name)
            , $conn->real_escape_string($eventoTema->description)
            , $conn->real_escape_string($eventoTema->time));
    }

    $result = $conn->query($query);
    if ($result) {
        $eventoTema->id = $conn->insert_id;
        $result = $eventoTema;
    } else {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function editar($id, $name, $description, $time)
  {
      $eventoTema = new EventoTema($id, $name, $description, $time, null, null);
      
      return self::guarda($eventoTema);
  }

  public static function guarda($eventoTema)
  {
      if ($eventoTema->id !== null) {
          return self::actualiza($eventoTema);
      }
      return self::inserta($eventoTema);
  }

  public static function actualiza($eventoTema)
  { //TODO Intentar hacer sin if else
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
        
    if (strlen($eventoTema->time()) <= 10) {
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
    
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han actualizado '$conn->affected_rows' !");
    }

    return $result;
  }
	
  public static function buscaEventosRecientes()
  {
      $result = [];

      $app = App::getSingleton();
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

      $app = App::getSingleton();
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

  public static function borra($eventoTema)
  {
    return self::borraPorid($eventoTema->id);
  }

  public static function borraPorId($id)
  {
      $result = false;
      $app = App::getSingleton();
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

  /* Métodos mágicos para que si existen métodos setPropiedad / getPropiedad se pueda hacer:
   *   $var->propiedad, que equivale a $var->getPropiedad()
   *   $var->propiedad = $valor, que equivale a $var->setPropiedad($valor)
   */
  public function __get($property)
  {
    $methodName = 'get'. ucfirst($property);
    if (method_exists($this, $methodName)) {
      return $this->$methodName();
    } else if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function __set($property, $value)
  {
    $methodName = 'set'. ucfirst($property);
    if (method_exists($this, $methodName)) {
      $this->$methodName($value);
    } else if (property_exists($this, $property)) {
      $this->$property = $value;
    }
  }

}
