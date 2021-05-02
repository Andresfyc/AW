<?php
namespace es\ucm\fdi\aw;

class Pelicula
{
    public static function crea($title, $date_released, $duration, $country, $plot)
    {
        $pelicula = self::buscaPelicula($nombrePelicula);
        if ($pelicula) {
            return false;
        }
        $pelicula = new Pelicula($title, NULL ,$date_released, $duration, $country, $plot);
        return self::guarda($pelicula);
    }

    public static function buscaPelicula($pelicula)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas P WHERE P.title = '%s'", $conn->real_escape_string($pelicula));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $pelicula = new Pelicula($fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating']);
                $pelicula->title = $fila['title'];
                $result = $pelicula;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }

        
    private static function inserta($pelicula)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
		echo "INSERTA";
        $query=sprintf("INSERT INTO Peliculas(title, NULL, date_released, duration,country,plot,rating) VALUES('%s', '%s','%s', '%s', '%s','%s','%s')"
            , $conn->real_escape_string($pelicula->title)
            , $conn->real_escape_string($pelicula->image)
            , $conn->real_escape_string($pelicula->date_released)
            , $conn->real_escape_string($pelicula->duration)
            , $conn->real_escape_string($pelicula->country)
            , $conn->real_escape_string($pelicula->plot)
            , $conn->real_escape_string($pelicula->rating));
        if ( $conn->query($query) ) {
            $pelicula->id = $conn->insert_id;
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
        $query=sprintf("UPDATE peliculas P SET image='%s', date_released='%s', duration='%s', country='%s', plot='%s', rating='%s' WHERE P.title='%s'"
        , $conn->real_escape_string($pelicula->title)
        , $conn->real_escape_string($pelicula->image)
        , $conn->real_escape_string($pelicula->date_released)
        , $conn->real_escape_string($pelicula->duration)
        , $conn->real_escape_string($pelicula->country)
        , $conn->real_escape_string($pelicula->plot)
        , $conn->real_escape_string($pelicula->rating)
            , $pelicula->title);

        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la pelicula: " . $pelicula->title;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $pelicula;
    }

    public static function guarda($pelicula)
    {
        if (self::buscapelicula($pelicula->title)) {
            return self::actualiza($pelicula);
        }
        return self::inserta($pelicula);
    }

	public static function buscaPorId ($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas P WHERE P.id = '%d'", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $pelicula = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating']);
                $pelicula->id = $fila['id'];
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

    private $id;

    private $title;
	
	private $image;
	
	private $date_released;

    private $duration;

    private $country;
	
	private $plot;

    private $rating;

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
}
