<?php
namespace es\ucm\fdi\aw;

class Pelicula
{
    public static function crea($title, $image, $date_released, $duration, $country, $plot)
    {
        $image = $image == NULL ? "film_default.jpg" : $image;
        $pelicula = new Pelicula(null, $title, $image ,$date_released, $duration, $country, $plot, null);
        return self::guarda($pelicula);
    }

    public static function buscaPelicula($pelicula)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas P WHERE P.id = '%s'", $conn->real_escape_string($pelicula));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $pelicula = new Pelicula($fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating']);
                $result = $pelicula;
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
        $query = sprintf("SELECT * FROM peliculas P WHERE P.title LIKE '%s' OR P.country LIKE '%s' OR P.plot LIKE '%s'", 
        '%'.$conn->real_escape_string($search).'%',
        '%'.$conn->real_escape_string($search).'%',
        '%'.$conn->real_escape_string($search).'%');

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating']);
		  }
		  $rs->free();
		}

		return $result;
    }

        
    private static function inserta($pelicula)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $query=sprintf("INSERT INTO Peliculas(title, image, date_released, duration,country,plot) VALUES('%s', '%s','%s', '%s', '%s','%s')"
            , $conn->real_escape_string($pelicula->title)
            , $conn->real_escape_string($pelicula->image)
            , $conn->real_escape_string($pelicula->date_released)
            , $conn->real_escape_string($pelicula->duration)
            , $conn->real_escape_string($pelicula->country)
            , $conn->real_escape_string($pelicula->plot));
        
        echo $query;
        
        if ( $conn->query($query) ) {
            $pelicula->id = $conn->insert_id;
            $pelicula->rating = $conn->insert_rating;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }

        return $pelicula;
    }
    
    private static function actualiza($pelicula)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE peliculas P SET title = '%s', image='%s', date_released='%s', duration=%d, country='%s', plot='%s' WHERE P.id=%d"
        , $conn->real_escape_string($pelicula->title)
        , $conn->real_escape_string($pelicula->image)
        , $conn->real_escape_string($pelicula->date_released)
        , $conn->real_escape_string($pelicula->duration)
        , $conn->real_escape_string($pelicula->country)
        , $conn->real_escape_string($pelicula->plot)
            , $pelicula->id);

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la pelicula: " . $pelicula->title;
                //exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $pelicula;
    }

    public static function editar($id, $title, $image, $date_released, $duration, $country, $plot)
    {
        $pelicula = self::buscaPorId($id);
        $image = strlen($image) < 1 ? $pelicula->image : $image;
        $pelicula = new Pelicula($id, $title, $image ,$date_released, $duration, $country, $plot, null);
        
        return self::guarda($pelicula);
    }

    public static function guarda($pelicula)
    {
        if ($pelicula->id !== null) {
            return self::actualiza($pelicula);
        }
        return self::inserta($pelicula);
    }

	public static function buscaPorId ($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas WHERE id = %d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $pelicula = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating']);
                $result = $pelicula;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }
	
	public static function ultimasPeliculasAnadidas($limit=NULL)
	{
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query = "SELECT * FROM peliculas ORDER BY id DESC";
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating']);
		  }
		  $rs->free();
		}

		return $result;
	}
	
	public static function ultimasPeliculasEstrenadas($limit=NULL)
	{
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query = "SELECT * FROM peliculas ORDER BY date_released DESC";
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating']);
		  }
		  $rs->free();
		}

		return $result;
	}
	
	public static function peliculasOrdenAlfabetico($limit=NULL)
	{
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		$query = "SELECT * FROM peliculas ORDER BY title ASC";
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating']);
		  }
		  $rs->free();
		}

		return $result;
	}

    public static function borraPorId($id)
    {
        $result = false;

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM Peliculas WHERE id = %d", $id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public static function actualizarGeneros($peliculaIn, $generos)
    {
        $result = false;

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("DELETE FROM peliculas_generos WHERE film_id = %d", $peliculaIn->id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        foreach($generos as $genero) {
            $query=sprintf("INSERT INTO peliculas_generos(film_id, genre_id) VALUES(%d, %d)"
                , $conn->real_escape_string($peliculaIn->id)
                , $conn->real_escape_string($genero));
            
            echo $query;
            
            if ( !$conn->query($query) ) {
                echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }

        return $result;
    }

    public static function actualizarActoresDirectores($peliculaIn, $actores, $directores)
    {
        $result = false;

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("DELETE FROM peliculas_actores_directores WHERE film_id = %d", $peliculaIn->id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        foreach($actores as $actor) {
            $query=sprintf("INSERT INTO peliculas_actores_directores(film_id, actor_director_id) VALUES(%d, %d)"
                , $conn->real_escape_string($peliculaIn->id)
                , $conn->real_escape_string($actor));
            
            echo $query;
            
            if ( !$conn->query($query) ) {
                echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }

        foreach($directores as $director) {
            $query=sprintf("INSERT INTO peliculas_actores_directores(film_id, actor_director_id) VALUES(%d, %d)"
                , $conn->real_escape_string($peliculaIn->id)
                , $conn->real_escape_string($director));
            
            echo $query;
            
            if ( !$conn->query($query) ) {
                echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
        }

        return $result;
    }

    private $id;

    private $title;
	
	private $image;
	
	private $date_released;

    private $duration;

    private $country;
	
	private $plot;

    private $rating;

    private $genres;

    private $actors;

    private $directors;

    private $plataformas;

    private $reviews;

    private $peliculasPlataformas;

    private function __construct($id, $title, $image, $date_released, $duration, $country, $plot, $rating)
    {
        $this->id= $id;
        $this->title = $title;
        $this->image = $image;
        $this->date_released = $date_released;
        $this->duration = $duration;
        $this->country = $country;
        $this->plot = $plot;
        $this->rating = $rating;
        $this->genres = Genero::buscaPorPeliId($id);
        $this->actors = ActorDirector::buscaActorPorPeliId($id);
        $this->directors = ActorDirector::buscaDirectorPorPeliId($id);
        $this->plataformas = Plataforma::buscaPlataformaPorIdPelicula($id);
        $this->reviews = Review::buscaReviewsPorIdPeli($id);
        $this->peliculasPlataformas = PeliculasPlataformas::buscaPeliculaPlataformaPorIdPelicula($id);
    }

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function image()
    {
        return $this->image;
    }

    public function date_released()
    {
        return $this->date_released;
    }

    public function duration()
    {
        return $this->duration;
    }

    public function country()
    {
        return $this->country;
    }

    public function plot()
    {
        return $this->plot;
    }

    public function rating()
    {
        return $this->rating;
    }

    public function genres()
    {
        return $this->genres;
    }

    public function actors()
    {
        return $this->actors;
    }

    public function directors()
    {
        return $this->directors;
    }
    
    public function plataformas()
    {
        return $this->plataformas;
    }
    
    public function reviews()
    {
        return $this->reviews;
    }

    public function peliculasPlataformas()
    {
        return $this->peliculasPlataformas;
    }
}
