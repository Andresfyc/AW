<?php
namespace es\ucm\fdi\aw;

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

        
  private static function inserta($genero)
  {
      $app = Aplicacion::getSingleton();
      $conn = $app->conexionBd();

      $query=sprintf("INSERT INTO Generos(name) VALUES('%s')"
          , $conn->real_escape_string($genero->name));
      
      echo $query;
      
      if ( $conn->query($query) ) {
          $genero->id = $conn->insert_id;
      } else {
          echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
          exit();
      }

      return $genero;
  }

  public static function buscaGeneroPorNombre($name)
  {
      $app = Aplicacion::getSingleton();
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

	public static function buscaPorPeliId ($id)
    {
        $app = Aplicacion::getSingleton();
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

        $app = Aplicacion::getSingleton();
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
}
