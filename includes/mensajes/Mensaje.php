<?php

namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion as App;
use es\ucm\fdi\aw\eventosTemas\EventoTema;

class Mensaje
{

  public static function crea($eventoTema, $user, $text)
  {
    $mensaje = new Mensaje(null, $eventoTema, $user, $text, '');
    return self::guarda($mensaje);
  }


  public static function buscaPorId($id)
  {
    $result = null;
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM foro_mensajes WHERE id = %d", $id);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      while($fila = $rs->fetch_assoc()) {
        $result = new Mensaje($fila['id'], $fila['evento_tema'], $fila['user'], $fila['text'], $fila['time_created']);
      }
      $rs->free();
    }
    return $result;
  }
  
  public static function inserta($mensaje)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("INSERT INTO foro_mensajes (evento_tema, user, text, time_created) VALUES (%d, '%s','%s', CURRENT_TIMESTAMP())"
        , $mensaje->evento_tema
        , $conn->real_escape_string($mensaje->user)
        , $conn->real_escape_string($mensaje->text));
    $result = $conn->query($query);
    if ($result) {
      $mensaje->id = $conn->insert_id;
      $result = $mensaje;
    } else {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function actualiza($mensaje)
  {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query=sprintf("UPDATE foro_mensajes M SET text = '%s' WHERE M.id=%d"
    , $conn->real_escape_string($mensaje->text)
        , $mensaje->id);
    if (!$conn->query($query)) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han actualizado '$conn->affected_rows' !");
    }

    return $mensaje;
  }

  public static function borra($mensaje)
  {
    return self::borraPorid($mensaje->id);
  }

  public static function borraPorId($id)
  {
    $result = false;

    $app = App::getSingleton();
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
      $evento_tema = $evento_tema ?? $mensaje->evento_tema;
      $user = $user ?? $mensaje->user;
      $text = $text ?? $mensaje->text;
      $time_created = $time_created ?? $mensaje->time_created;

      $mensaje = new Mensaje($id,$evento_tema,$user,$text,$time_created);
      
      return self::guarda($mensaje);
  }

  public static function guarda($mensaje)
  {
      if ($mensaje->id !== null) {
          return self::actualiza($mensaje);
      }
      return self::inserta($mensaje);
  }
    
  public static function buscaMensajesPorIdEventoTema($id)
  {
      $result = [];

      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM foro_mensajes WHERE evento_tema = %d ORDER BY time_created DESC", $id);

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
