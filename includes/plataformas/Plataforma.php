<?php

namespace es\ucm\fdi\aw\plataformas;

use es\ucm\fdi\aw\Aplicacion as App;

class Plataforma
{

  public static function crea($name, $image)
  {
    $image = $image == NULL ? "blank.png" : $image;
    $plataforma = new Plataforma(null, $name, $image);
    return self::guarda($plataforma);
  }
    
  public static function guarda($plataforma)
  {
      if ($plataforma->id !== null) {
          return self::actualiza($plataforma);
      }
      return self::inserta($plataforma);
  }

  public static function buscaPorId($id)
  {
    $result = null;
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM plataformas WHERE id = %d", $id);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      while($fila = $rs->fetch_assoc()) {
        $result = new Plataforma($fila['id'], $fila['name'], $fila['image']);
      }
      $rs->free();
    }
    return $result;
  }
  
  public static function inserta($plataforma)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("INSERT INTO plataformas (name, image) VALUES (%d, '%s')"
        , $conn->real_escape_string($plataforma->name)
        , $conn->real_escape_string($plataforma->image));
    $result = $conn->query($query);
    if ($result) {
      $plataforma->id = $conn->insert_id;
      $result = $plataforma;
    } else {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function actualiza($plataforma)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query=sprintf("UPDATE plataformas P SET name = '%s' WHERE P.id=%d"
    , $conn->real_escape_string($plataforma->name)
        , $plataforma->id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han actualizado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function borra($plataforma)
  {
    return self::borraPorid($plataforma->id);
  }

  public static function borraPorId($id)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM plataformas WHERE id = %d", $id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function editar($id,$name,$image)
  {
      $plataforma = self::buscaPorId($id);
      $name = $name ?? $plataforma->name;
      $image = $image ?? $plataforma->image;

      $plataforma = new Plataforma($id,$name,$image);
      
      return self::guarda($plataforma);
  }

  public static function buscaPlataformaPorIdPelicula($id)
  {
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT p.* FROM plataformas p JOIN peliculas_plataformas pp ON p.id = pp.platform_id WHERE pp.film_id = %d", $id);
      
      $rs = $conn->query($query);
      $result = false;
  if ($rs) {
    while($fila = $rs->fetch_assoc()) {
    $result[] = new Plataforma($fila['id'], $fila['name'], $fila['image']);
    }
    $rs->free();
  }

  return $result;
}
	
	public static function listaPlataformas($limit=NULL)
	{
		$result = [];

    $app = App::getSingleton();
    $conn = $app->conexionBd();
		$query = "SELECT * FROM plataformas";
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Plataforma($fila['id'], $fila['name'], $fila['image']);
		  }
		  $rs->free();
		}

		return $result;
	}

  public static function plataformas()
  {
      $result = [];
  
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = "SELECT * FROM plataformas ORDER BY name ASC";
  
      $rs = $conn->query($query);
      if ($rs) {
        while($fila = $rs->fetch_assoc()) {
          $result[] = new Plataforma($fila['id'], $fila['name'], $fila['image']);
        }
        $rs->free();
      }
  
      return $result;
  }

  private $id;

  private $name;
  
  private $image;
  

  private function __construct($id, $name, $image)
  {
      $this->id = $id;
      $this->name = $name;
      $this->image = $image;
  }

  public function id()
  {
      return $this->id;
  }

  public function name()
  {
      return $this->name;
  }

  public function image()
  {
      return $this->image;
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
