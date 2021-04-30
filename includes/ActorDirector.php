<?php
namespace es\ucm\fdi\aw;

class ActorDirector
{
	
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
