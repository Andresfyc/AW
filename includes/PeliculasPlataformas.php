<?php
namespace es\ucm\fdi\aw;

class PeliculasPlataformas
{
    public static function crea($pelicula, $plataforma,$link)
    {
        $peliculaPlataforma = new PeliculaPlataforma($pelicula, $plataforma,$link);
        return self::guarda($peliculaPlataforma);
    }
    
    public static function guarda($peliculaPlataforma)
    {
        if ($peliculaPlataforma->id !== null) {
            return self::actualiza($peliculaPlataforma);
        }
        return self::inserta($peliculaPlataforma);
    }
    
    private static function inserta($peliculaPlataforma)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO peliculas_plataformas (pelicula, plataforma,link) VALUES (%d, %d,%d)"
            , $conn->real_escape_string($peliculaPlataforma->pelicula)
            , $conn->real_escape_string($peliculaPlataforma->plataforma)
            , $conn->real_escape_string($peliculaPlataforma->link));
        if ($conn->query($query) ) {
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $peliculaPlataforma;
    }

    private static function actualiza($peliculaPlataforma)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE peliculas_plataformas pp SET text = '%s' WHERE pp.id=%d"
        , $conn->real_escape_string($peliculaPlataforma->pelicula)
            , $peliculaPlataforma->plataforma,$peliculaPlataforma->link);
        echo $query;
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la pelicula: " . $peliculaPlataforma->pelicula;
                //exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $mensaje;
    }
    
    public static function buscaPeliculaPlataformaPorId($id)
    {
        $result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas_plataformas WHERE id = '%d' ", $id);

        $rs = $conn->query($query);
        if ($rs) {
          while($fila = $rs->fetch_assoc()) {
            $result[] = new PeliculasPlataformas($fila['id'], $fila['pelicula'], $fila['plataforma'], $fila['link']);
          }
          $rs->free();
        }

        return $result;
    }

    public static function buscaPeliculaPlataformaPorIdPelicula($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas_plataformas pp WHERE pp.pelicula = '%d'", $id);
        
        $rs = $conn->query($query);
        $result = false;
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new PeliculasPlataformas($fila['id'], $fila['pelicula'], $fila['plataforma'], $fila['link']);
		  }
		  $rs->free();
		}

		return $result;
    }

    public static function buscaPeliculaPlataformaPorIdPlataforma($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas_plataformas pp WHERE pp.plataforma = '%d'", $id);
        
        $rs = $conn->query($query);
        $result = false;
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new PeliculasPlataformas($fila['id'], $fila['pelicula'], $fila['plataforma'], $fila['link']);
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
        $query = sprintf("DELETE FROM peliculas_plataformas WHERE id = %d", $id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public static function editar($id,$pelicula,$plataforma,$link)
    {
        $peliculaPlataforma = self::buscaPorId($id);

        $peliculaPlataforma = new PeliculasPlataformas($id,$pelicula,$plataforma,$link);
        
        return self::guarda($peliculaPlataforma);
    }


    private $id;

    private $pelicula;
	
	private $plataforma;

    private $link;
	

    private function __construct($id, $pelicula, $plataforma,$link)
    {
        $this->id = $id;
        $this->pelicula = $pelicula;
        $this->plataforma = $plataforma;
        $this->link = $link;
    }

    public function id()
    {
        return $this->id;
    }

    public function pelicula()
    {
        return $this->pelicula;
    }

    public function plataforma()
    {
        return $this->plataforma;
    }
    public function link()
    {
        return $this->link;
    }

}
