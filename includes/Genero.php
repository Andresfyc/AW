<?php
namespace es\ucm\fdi\aw;

class Genero
{

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
		$query = "SELECT * FROM generos";

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
