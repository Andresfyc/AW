<?php
namespace es\ucm\fdi\aw;

class Plataforma
{
    public static function crea($nombre, $img)
    {
        $plataforma = new Plataforma($nombre, $img);
        return self::guarda($plataforma);
    }
    
    public static function guarda($plataforma)
    {
        if ($plataforma->id !== null) {
            return self::actualiza($plataforma);
        }
        return self::inserta($plataforma);
    }
    
    private static function inserta($plataforma)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO plataformas (nombre, image) VALUES (%d, '%s')"
            , $conn->real_escape_string($plataforma->nombre)
            , $conn->real_escape_string($plataforma->image));
        if ($conn->query($query) ) {
            $usuario->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $plataforma;
    }

    private static function actualiza($plataforma)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE plataformas P SET text = '%s' WHERE P.id=%d"
        , $conn->real_escape_string($plataforma->nombre)
            , $plataforma->id);
        echo $query;
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el mensaje: " . $plataforma->nombre;
                //exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $mensaje;
    }
    
    public static function buscaPlataformasPorId($id)
    {
        $result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM plataformas WHERE id = '%d' ", $id);

        $rs = $conn->query($query);
        if ($rs) {
          while($fila = $rs->fetch_assoc()) {
            $result[] = new Plataforma($fila['id'], $fila['nombre'], $fila['image']);
          }
          $rs->free();
        }

        return $result;
    }

    public static function buscaPlataformaPorIdPelicula($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT p.* FROM plataformas p JOIN peliculas_plataformas pp ON p.id = pp.plataforma WHERE pp.pelicula = '%d'", $id);
        
        $rs = $conn->query($query);
        $result = false;
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Plataforma($fila['id'], $fila['nombre'], $fila['image']);
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
        $query = sprintf("DELETE FROM plataformas WHERE id = %d", $id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public static function editar($id,$nombre,$image)
    {
        $plataforma = self::buscaPorId($id);

        $plataforma = new Plataforma($id,$nombre,$image);
        
        return self::guarda($plataforma);
    }


    private $id;

    private $nombre;
	
	private $image;
	

    private function __construct($id, $nombre, $image)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->image = $image;
    }

    public function id()
    {
        return $this->id;
    }

    public function nombre()
    {
        return $this->nombre;
    }

    public function image()
    {
        return $this->image;
    }

}
