<?php

namespace es\ucm\fdi\aw\generos;

use es\ucm\fdi\aw\Aplicacion as App;

class Genero
{

  public static function crea($name)
  {
      $genero = self::buscaGeneroPorNombre($name);
      if ($genero) {
          return false;
      }
      $genero = new Genero(null, $name);
      return self::guarda($genero);
  }

  public static function guarda($genero)
  {
      if ($genero->id !== null) {
          return self::actualiza($genero);
      }
      return self::inserta($genero);
  }


  public static function buscaPorId($id)
  {
    $result = null;
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM generos WHERE id = %d", $id);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      while($fila = $rs->fetch_assoc()) {
        $result = new Genero($fila['id'], $fila['name']);
      }
      $rs->free();
    }
    return $result;
  }
  
  public static function inserta($genero)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query=sprintf("INSERT INTO generos(name) VALUES('%s')"
        , $conn->real_escape_string($genero->name));
    $result = $conn->query($query);
    if ($result) {
      $genero->id = $conn->insert_id;
      $result = $genero;
    } else {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function actualiza($genero)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query=sprintf("UPDATE genero SET name = '%s' WHERE id=%d"
    , $conn->real_escape_string($genero->name)
        , $genero->id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han actualizado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function borra($genero)
  {
    return self::borraPorid($genero->id);
  }

  public static function borraPorId($id)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM generos WHERE id = %d", $id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function editar($id,$name)
  {
      $genero = self::buscaPorId($id);
      $name = $name ?? $genero->name;

      $genero = new Genero($id, $name);
      
      return self::guarda($genero);
  }

  public static function buscaGeneroPorNombre($name)
  {
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM generos WHERE name = '%s'", $conn->real_escape_string($name));
      $rs = $conn->query($query);
      $result = false;
      if ($rs) {
          if ( $rs->num_rows == 1) {
              $fila = $rs->fetch_assoc();
              $genero = new Genero($fila['id'], $fila['name']);
              $result = $genero;
          }
          $rs->free();
      } else {
          echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
          exit();
      }
      return $result;
  }
	
	public static function listaGeneros($limit=NULL)
	{
		$result = [];

        $app = App::getSingleton();
        $conn = $app->conexionBd();
		$query = "SELECT * FROM generos";
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			  $result[] = new Genero($fila['id'], $fila['name']);
		  }
		  $rs->free();
		}

		return $result;
	}

  public static function buscaPorPeliId ($id)
  {
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT g.* FROM generos g JOIN peliculas_generos pg ON g.id = pg.genre_id WHERE pg.film_id = '%d'", $id);
      
      $rs = $conn->query($query);
      $result = false;
      if ($rs) {
        while($fila = $rs->fetch_assoc()) {
          $result[] = new Genero($fila['id'], $fila['name']);
        }
        $rs->free();
      }

      return $result;
}

public static function generos()
{
    $result = [];

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = "SELECT * FROM generos ORDER BY name ASC";

    $rs = $conn->query($query);
    if ($rs) {
      while($fila = $rs->fetch_assoc()) {
        $result[] = new Genero($fila['id'], $fila['name']);
      }
      $rs->free();
    }

    return $result;
}

  private $id;

  private $name;

  private function __construct($id, $name)
  {
      $this->id= $id;
      $this->name = $name;
  }

  public function id()
  {
      return $this->id;
  }

  public function name()
  {
      return $this->name;
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
