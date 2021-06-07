<?php
namespace es\ucm\fdi\aw\notificaciones;

use es\ucm\fdi\aw\Aplicacion as App;
use es\ucm\fdi\aw\usuarios\Usuario;
use es\ucm\fdi\aw\reviews\Review;


class Notificacion
{

    public static function crea($user_review, $user_notify, $film_id, $review_id=null)
    {
      $notificacion = new Notificacion(null, $user_review, $user_notify, $film_id, '', $review_id);
      return self::guarda($notificacion);
    }
      
    public static function guarda($notificacion)
    {
        if ($notificacion->id == null) {
            return self::inserta($notificacion);
        }
        return false;
    }
  
    public static function buscaPorId($id)
    {
      $result = null;
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM notificaciones WHERE id = %d", $id);
      $rs = $conn->query($query);
      if ($rs && $rs->num_rows == 1) {
        while($fila = $rs->fetch_assoc()) {
          $result = new Notificacion($fila['id'], $fila['user_review'], $fila['user_notify'], $fila['film_id'], $fila['date_created'], $fila['review_id']);
        }
        $rs->free();
      }
      return $result;
    }
    
    public static function inserta($notificacion)
    {
      $result = false;
  
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      if (!$notificacion->review_id) {
        $query = sprintf("INSERT INTO notificaciones (user_review, user_notify, film_id, date_created) VALUES ('%s','%s',%d,CURDATE())"
            , $conn->real_escape_string($notificacion->user_review)
            , $conn->real_escape_string($notificacion->user_notify)
            , $notificacion->film_id);
      }
      $result = $conn->query($query);
      if ($result) {
        $notificacion->id = $conn->insert_id;
        $result = $notificacion;
      } else {
        error_log($conn->error);  
      }
  
      return $result;
    }
  
    public static function borra($notificacion)
    {
      return self::borraPorid($notificacion->id);
    }
  
    public static function borraPorId($id)
    {
      $result = false;
  
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("DELETE FROM notificaciones WHERE id = %d", $id);
      $result = $conn->query($query);
      if (!$result) {
        error_log($conn->error);
      } else if ($conn->affected_rows != 1) {
        error_log("Se han borrado '$conn->affected_rows' !");
      }
  
      return $result;
    }

    public static function getNotificacionesCompletadas($user)
    {
      $result = [];

      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM notificaciones WHERE user_notify = '%s' AND review_id IS NOT NULL ORDER BY date_created DESC", $user);
      $rs = $conn->query($query);
      $result = false;
      if ($rs) {
        while($fila = $rs->fetch_assoc()) {
          $result[] = new Notificacion($fila['id'], $fila['user_review'], $fila['user_notify'], $fila['film_id'], $fila['date_created'], $fila['review_id']);
        }
        $rs->free();
      }

      return $result;
    }

    public static function getNotificacion($user_notify, $user_review, $film_id)
    {
        $result = null;
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM notificaciones WHERE user_notify = '%s' AND user_review = '%s' AND film_id = %d"
            , $conn->real_escape_string($user_notify)
            , $conn->real_escape_string($user_review)
            , $film_id);
        $rs = $conn->query($query);
        if ($rs && $rs->num_rows == 1) {
          while($fila = $rs->fetch_assoc()) {
            $result = new Notificacion($fila['id'], $fila['user_review'], $fila['user_notify'], $fila['film_id'], $fila['date_created'], $fila['review_id']);
          }
          $rs->free();
        }
        return $result;
    }
  
  
    private $id;
  
    private $user_review;
    
    private $user_notify;
    
    private $film_id;
    
    private $date_created;
  
    private $review_id;
  
    private function __construct($id, $user_review, $user_notify, $film_id, $date_created, $review_id)
    {
        $this->id = $id;
        $this->user_review = $user_review;
        $this->user_notify = $user_notify;
        $this->film_id = $film_id;
        $this->date_created = $date_created;
        $this->review_id = $review_id;
    }
  
    public function id()
    {
        return $this->id;
    }
  
    public function user_review()
    {
        return $this->user_review;
    }
  
    public function user_notify()
    {
        return $this->user_notify;
    }
  
    public function film_id()
    {
        return $this->film_id;
    }
  
    public function date_created()
    {
        return $this->date_created;
    }
  
    public function review_id()
    {
        return $this->review_id;
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
  