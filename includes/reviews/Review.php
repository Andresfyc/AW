<?php

namespace es\ucm\fdi\aw\reviews;

use es\ucm\fdi\aw\Aplicacion as App;

class Review
{

  public static function crea($user, $filmId, $review, $stars)
  {
    $review = new Review(null, $user, $filmId, $review, $stars, '');
    return self::guarda($review);
  }
    
  public static function guarda($review)
  {
      if ($review->id !== null) {
          return self::actualiza($review);
      }
      return self::inserta($review);
  }

  public static function buscaPorId($id)
  {
    $result = null;
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM reviews WHERE id = %d", $id);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      while($fila = $rs->fetch_assoc()) {
        $result = new Review($fila['id'], $fila['user'], $fila['film_id'], $fila['review'], $fila['stars'], $fila['time_created']);
      }
      $rs->free();
    }
    return $result;
  }
  
  public static function inserta($review)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("INSERT INTO reviews (user, film_id, review, stars, time_created) VALUES ('%s', %d,'%s',%d, CURRENT_TIMESTAMP()) ON DUPLICATE KEY UPDATE review='%s', stars=%d"
        , $conn->real_escape_string($review->user)
        , $conn->real_escape_string($review->film_id)
        , $conn->real_escape_string($review->review)
        , $conn->real_escape_string($review->stars)
        , $conn->real_escape_string($review->review)
        , $conn->real_escape_string($review->stars));
    $result = $conn->query($query);
    if ($result) {
      $review->id = $conn->insert_id;
      $review->time_created = $conn->insert_time_created;
      $result = $review;
    } else {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function actualiza($review)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query=sprintf("UPDATE reviews R SET review = '%s', stars = %d WHERE R.id=%d"
    , $conn->real_escape_string($review->review)
    , $conn->real_escape_string($review->stars)
        , $review->id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han actualizado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function borra($review)
  {
    return self::borraPorid($review->id);
  }

  public static function borraPorId($id)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM reviews WHERE id = %d", $id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function editar($id,$film_id,$user,$reviewStr,$stars,$time_created)
  {
    $review = self::buscaPorId($id);
    $user = $user ?? $review->user;
    $film_id = $film_id ?? $review->film_id;
    $reviewStr = $reviewStr ?? $review->review;
    $stars = $stars ?? $review->stars;
    $time_created = $time_created ?? $review->time_created;

    $review = new Review($id,$user,$film_id,$reviewStr,$stars,$time_created);
    
    return self::guarda($review);
  }
    
  public static function buscaReviewsPorIdPeli($id)
  {
      $result = [];

      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM reviews WHERE film_id = %d ORDER BY time_created DESC", $id);
      
      $rs = $conn->query($query);
      $result = false;
      if ($rs) {
        while($fila = $rs->fetch_assoc()) {
          $result[] = new Review($fila['id'], $fila['user'], $fila['film_id'], $fila['review'], $fila['stars'], $fila['time_created']);
        }
        $rs->free();
      }

      return $result;
  }
   public static function buscaReviewsPorIdUser($id)
  {
      $result = [];

      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM reviews WHERE user = '%s' ORDER BY time_created DESC", $id);
	  
      $rs = $conn->query($query);
      $result = false;
      if ($rs) {
        while($fila = $rs->fetch_assoc()) {
          $result[] = new Review($fila['id'], $fila['user'], $fila['film_id'], $fila['review'], $fila['stars'], $fila['time_created']);
        }
        $rs->free();
      }

      return $result;
  }


  private $id;

  private $film_id;
  
  private $user;
  
  private $review;
  
  private $stars;

  private $time_created;

  private function __construct($id, $user, $film_id, $review, $stars, $time_created)
  {
      $this->id = $id;
      $this->user = $user;
      $this->film_id = $film_id;
      $this->review = $review;
      $this->stars = $stars;
      $this->time_created = $time_created;
  }

  public function id()
  {
      return $this->id;
  }

  public function film_id()
  {
      return $this->film_id;
  }

  public function user()
  {
      return $this->user;
  }

  public function review()
  {
      return $this->review;
  }

  public function stars()
  {
      return $this->stars;
  }

  public function time_created()
  {
      return $this->time_created;
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
