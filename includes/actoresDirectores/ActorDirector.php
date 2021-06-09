<?php

namespace es\ucm\fdi\aw\actoresDirectores;

use es\ucm\fdi\aw\Aplicacion as App;

class ActorDirector
{

  public static function crea($actor_director, $name, $description, $birth_date, $nationality, $image)
  {
    $image = $image ?? "actor_default.jpg";
    $actorDirector = new ActorDirector(null, $actor_director, $name, $description, $birth_date, $nationality, $image);
    return self::guarda($actorDirector);
  }

  public static function buscaPorId($id)
  {
    $result = null;
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM actores_directores WHERE id = %d", $id);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      while($fila = $rs->fetch_assoc()) {
        $result = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
      }
      $rs->free();
    }
    return $result;
  }
  
  public static function inserta($actorDirector)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query=sprintf("INSERT INTO actores_directores(actor_director, name, description, birth_date, nationality,image) VALUES(%d, '%s', '%s', '%s', '%s', '%s')"
    , $actorDirector->actor_director
    , $conn->real_escape_string($actorDirector->name)
    , $conn->real_escape_string($actorDirector->description)
    , $conn->real_escape_string($actorDirector->birth_date)
    , $conn->real_escape_string($actorDirector->nationality)
    , $conn->real_escape_string($actorDirector->image));
    $result = $conn->query($query);
    if ($result) {
      $actorDirector->id = $conn->insert_id;
      $result = $actorDirector;
    } else {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function actualiza($actorDirector)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query=sprintf("UPDATE actores_directores AD SET actor_director = %d, name='%s', description='%s', birth_date='%s', nationality='%s', image='%s' WHERE AD.id=%d"
    , $actorDirector->actor_director
    , $conn->real_escape_string($actorDirector->name)
    , $conn->real_escape_string($actorDirector->description)
    , $conn->real_escape_string($actorDirector->birth_date)
    , $conn->real_escape_string($actorDirector->nationality)
    , $conn->real_escape_string($actorDirector->image)
        , $actorDirector->id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han actualizado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function borra($actorDirector)
  {
    return self::borraPorid($actorDirector->id);
  }

  public static function borraPorId($id)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM actores_directores WHERE id = %d", $id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function editar($id, $actor_director, $name, $description, $birth_date, $nationality, $image)
  {
      $actorDirector = self::buscaPorId($id);
      $image = strlen($image) < 1 ? $actorDirector->image : $image;
      $actor_director = $actor_director ?? $actorDirector->actor_director;
      $birth_date = $birth_date ?? $actorDirector->birth_date;
      
      $actorDirector = new ActorDirector($id, $actor_director, $name, $description, $birth_date, $nationality, $image);
      
      return self::guarda($actorDirector);
  }

  public static function guarda($actorDirector)
  {
      if ($actorDirector->id !== null) {
          return self::actualiza($actorDirector);
      }
      return self::inserta($actorDirector);
  }

  public static function busqueda($search)
  {
  $result = [];

      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM actores_directores AD WHERE AD.name LIKE '%s' OR AD.description LIKE '%s' OR AD.nationality LIKE '%s'", 
      '%'.$conn->real_escape_string($search).'%',
      '%'.$conn->real_escape_string($search).'%',
      '%'.$conn->real_escape_string($search).'%');

  $rs = $conn->query($query);
  if ($rs) {
    while($fila = $rs->fetch_assoc()) {
    $result[] = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
    }
    $rs->free();
  }

  return $result;
  }
	
	public static function buscaActoresDirectoresPorUser($user, $limit=NULL, $actorDirector=NULL)
	{
		$result = [];

    $app = App::getSingleton();
    $conn = $app->conexionBd();
		$query = sprintf("SELECT actores_directores.* FROM usuarios join usuarios_actores_directores ON usuarios.user = usuarios_actores_directores.user 
		join actores_directores ON usuarios_actores_directores.actor_director_id = actores_directores.id where usuarios.user= '%s'", $user);
    if (strlen($actorDirector) > 0) {
      $query .= sprintf(" AND actores_directores.actor_director= %d", $actorDirector);
    } 		
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
		  }
		  $rs->free();
		}

		return $result;
	}

  public static function actoresDirectores($ad)
  {
		$result = [];

    $app = App::getSingleton();
    $conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM actores_directores WHERE actor_director = %d ORDER BY name ASC", $ad);

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
		  }
		  $rs->free();
		}

		return $result;
  }
	
	public static function listaActoresDirectores($limit=NULL)
	{
		$result = [];

        $app = App::getSingleton();
        $conn = $app->conexionBd();
		$query = "SELECT * FROM actores_directores";
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
		  }
		  $rs->free();
		}

		return $result;
	}

	public static function buscaActorDirectorPorPeliId ($id, $ad)
  {
		$result = [];
        
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT ad.* FROM actores_directores ad JOIN peliculas_actores_directores pad ON ad.id = pad.actor_director_id WHERE pad.film_id = %d AND ad.actor_director = %d", $id, $ad);
        
        $rs = $conn->query($query);
        $result = false;
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
		  }
		  $rs->free();
		}

		return $result;
  }

  public static function isActorDirectorFav($id, $user) 
  {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM usuarios_actores_directores WHERE actor_director_id = %d and user = '%s'", $id, $user);
    $rs = $conn->query($query);
    return $rs->num_rows;
  }

  public static function addActorDirectorFav($id, $user) 
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("INSERT INTO usuarios_actores_directores(actor_director_id, user) VALUES(%d, '%s')"
    , $id
    , $conn->real_escape_string($user));
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function delActorDirectorFav($id, $user) 
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM usuarios_actores_directores WHERE actor_director_id = %d and user = '%s'", $id, $user);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
  }

  private $id;

  private $actor_director;

  private $name;

  private $description;

  private $birth_date;

  private $nationality;

  private $image;

  private function __construct($id, $actor_director, $name, $description, $birth_date, $nationality, $image)
  {
      $this->id = $id;
      $this->image = $image ?? 'film_default.jpg';
      $this->actor_director = $actor_director;
      $this->name = $name;
      $this->description = $description;
      $this->birth_date = $birth_date;
      $this->nationality = $nationality;
  }

  public function id()
  {
      return $this->id;
  }

  public function actor_director()
  {
      return $this->actor_director;
  }

  public function name()
  {
      return $this->name;
  }

  public function description()
  {
      return $this->description;
  }

  public function birth_date()
  {
      return $this->birth_date;
  }

  public function nationality()
  {
      return $this->nationality;
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
