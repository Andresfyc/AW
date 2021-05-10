<?php
namespace es\ucm\fdi\aw;

class ActorDirector
{
    public static function crea($actor_director, $name, $description, $birth_date, $nationality, $image)
    {
        $image = $image == NULL ? "actor_default.jpg" : $image;
        $actorDirector = new ActorDirector(null, $actor_director, $name, $description, $birth_date, $nationality, $image);
        return self::guarda($actorDirector);
    }

    public static function editar($id, $actor_director, $name, $description, $birth_date, $nationality, $image)
    {
        $actorDirector = self::buscaPorId($id);
        $image = strlen($image) < 1 ? $actorDirector->image : $image;
        $actor_director = strlen($actor_director) < 1 ? $actorDirector->actor_director : $actor_director;
        $birth_date = strlen($birth_date) < 1 ? $actorDirector->birth_date : $birth_date;
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

	public static function buscaPorId ($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM actores_directores WHERE id = %d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $actorDirector = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
                $result = $actorDirector;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

    public static function busqueda($search)
    {
		$result = [];

        $app = Aplicacion::getSingleton();
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
    
    private static function actualiza($actorDirector)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE actores_directores AD SET actor_director = %d, name='%s', description='%s', birth_date='%s', nationality='%s', image='%s' WHERE AD.id=%d"
        , $conn->real_escape_string($actorDirector->actor_director)
        , $conn->real_escape_string($actorDirector->name)
        , $conn->real_escape_string($actorDirector->description)
        , $conn->real_escape_string($actorDirector->birth_date)
        , $conn->real_escape_string($actorDirector->nationality)
        , $conn->real_escape_string($actorDirector->image)
            , $actorDirector->id);

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el actor/director: " . $actorDirector->name;
                //exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $actorDirector;
    }

        
    private static function inserta($actorDirector)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $query=sprintf("INSERT INTO actores_directores(actor_director, name, description, birth_date, nationality,image) VALUES(%d, '%s', '%s', '%s', '%s', '%s')"
        , $conn->real_escape_string($actorDirector->actor_director)
        , $conn->real_escape_string($actorDirector->name)
        , $conn->real_escape_string($actorDirector->description)
        , $conn->real_escape_string($actorDirector->birth_date)
        , $conn->real_escape_string($actorDirector->nationality)
        , $conn->real_escape_string($actorDirector->image));
        
        echo $query;
        
        if ( $conn->query($query) ) {
            $actorDirector->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $actorDirector;
    }
	
	public static function buscaActoresDirectoresPorUser($user, $limit=NULL, $actorDirector)
	{
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query = sprintf("SELECT actores_directores.* FROM usuarios join usuarios_actores_directores ON usuarios.user = usuarios_actores_directores.user 
		join actores_directores ON usuarios_actores_directores.actores_directores_id = actores_directores.id where usuarios.user= '%s' AND 
		actores_directores.actor_director= '%d'", $user, $actorDirector);
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

    public static function actores()
    {
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query = "SELECT * FROM actores_directores WHERE actor_director = 0 ORDER BY name ASC";

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
		  }
		  $rs->free();
		}

		return $result;
    }

    public static function directores()
    {
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query = "SELECT * FROM actores_directores WHERE actor_director = 1 ORDER BY name ASC";

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new ActorDirector($fila['id'], $fila['actor_director'], $fila['name'], $fila['description'], $fila['birth_date'], $fila['nationality'], $fila['image']);
		  }
		  $rs->free();
		}

		return $result;
    }

	public static function buscaActorPorPeliId ($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT ad.* FROM actores_directores ad JOIN peliculas_actores_directores pad ON ad.id = pad.actor_director_id WHERE pad.film_id = %d AND ad.actor_director = 0", $id);
        
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

	public static function buscaDirectorPorPeliId ($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT ad.* FROM actores_directores ad JOIN peliculas_actores_directores pad ON ad.id = pad.actor_director_id WHERE pad.film_id = %d AND ad.actor_director = 1", $id);
        
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

    private $id;

    private $actor_director;
	
	private $name;

    private $description;

    private $birth_date;
	
	private $nationality;

    private $image;

    private function __construct($id, $actor_director, $name, $description, $birth_date, $nationality, $image)
    {
        $this->id= $id;
        $this->actor_director = $actor_director;
        $this->name = $name;
        $this->description = $description;
        $this->birth_date = $birth_date;
        $this->nationality = $nationality;
        $this->image = $image;
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
}
