<?php

namespace es\ucm\fdi\aw\plataformas;

use es\ucm\fdi\aw\Aplicacion as App;

class PeliculaPlataforma
{

  public static function crea($film_id, $platform_id, $link)
  {
    $peliculaPlataforma = new PeliculaPlataforma(null, $film_id, $platform_id, $link);
    return self::guarda($peliculaPlataforma);
  }
    
  public static function guarda($peliculaPlataforma)
  {
      if ($peliculaPlataforma->id !== null) {
          return self::actualiza($peliculaPlataforma);
      }
      return self::inserta($peliculaPlataforma);
  }

  public static function buscaPorId($id)
  {
    $result = null;
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM peliculas_plataformas WHERE id = %d", $id);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      while($fila = $rs->fetch_assoc()) {
        $result = new PeliculaPlataforma($fila['id'], $fila['film_id'], $fila['platform_id'], $fila['link']);
      }
      $rs->free();
    }
    return $result;
  }
  
  public static function inserta($peliculaPlataforma)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("INSERT INTO peliculas_plataformas (film_id, platform_id, link) VALUES (%d, %d, '%s')"
        , $peliculaPlataforma->film_id
        , $peliculaPlataforma->platform_id
        , $conn->real_escape_string($peliculaPlataforma->link));
    $result = $conn->query($query);
    if ($result) {
      $peliculaPlataforma->id = $conn->insert_id;
      $result = $peliculaPlataforma;
    } else {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function actualiza($peliculaPlataforma)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query=sprintf("UPDATE peliculas_plataformas P SET platform_id = '%s', link = '%s' WHERE P.id=%d"
    , $conn->real_escape_string($peliculaPlataforma->platform_id)
    , $conn->real_escape_string($peliculaPlataforma->link)
        , $peliculaPlataforma->id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han actualizado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function borra($peliculaPlataforma)
  {
    return self::borraPorid($peliculaPlataforma->id);
  }

  public static function borraPorId($id)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM peliculas_plataformas WHERE id = %d", $id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function editar($id,$film_id,$platform_id,$link)
  {
      $peliculaPlataforma = self::buscaPorId($id);
      $film_id = $film_id ?? $peliculaPlataforma->film_id;
      $platform_id = $platform_id ?? $peliculaPlataforma->platform_id;
      $link = $link ?? $peliculaPlataforma->link;

      $peliculaPlataforma = new PeliculaPlataforma($id,$film_id,$platform_id,$link);
      
      return self::guarda($peliculaPlataforma);
  }

  public static function buscaPeliculaPlataformaPorIdPelicula($id)
  {
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM peliculas_plataformas pp WHERE pp.film_id = %d", $id);
      
      $rs = $conn->query($query);
      $result = false;
  if ($rs) {
    while($fila = $rs->fetch_assoc()) {
      $result[] = new PeliculaPlataforma($fila['id'], $fila['film_id'], $fila['platform_id'], $fila['link']);
    }
    $rs->free();
  }

  return $result;
  }

  private $id;

  private $film_id;
  
  private $platform_id;

  private $link;

  private $platform;
  

  private function __construct($id, $film_id, $platform_id, $link)
  {
      $this->id = $id;
      $this->film_id = $film_id;
      $this->platform_id = $platform_id;
      $this->link = $link;
      $this->platform = Plataforma::buscaPorId($platform_id);
  }

  public function id()
  {
      return $this->id;
  }

  public function film_id()
  {
      return $this->film_id;
  }

  public function platform_id()
  {
      return $this->platform_id;
  }
  
  public function link()
  {
      return $this->link;
  }
  
  public function platform()
  {
      return $this->platform;
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
