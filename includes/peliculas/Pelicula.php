<?php

namespace es\ucm\fdi\aw\peliculas;

use es\ucm\fdi\aw\Aplicacion as App;
use es\ucm\fdi\aw\generos\Genero;
use es\ucm\fdi\aw\plataformas\Plataforma;
use es\ucm\fdi\aw\plataformas\PeliculaPlataforma;
use es\ucm\fdi\aw\actoresDirectores\ActorDirector;
use es\ucm\fdi\aw\reviews\Review;

class Pelicula
{

  public static function crea($title, $image=NULL, $date_released, $duration, $country, $plot, $link, $price)
  {
    $image = $image == NULL ? "film_default.jpg" : $image;
    $pelicula = new Pelicula(null, $title, $image ,$date_released, $duration, $country, $plot, null, $link, $price);
    return self::guarda($pelicula);
  }

  

  public static function buscaPelicula($pelicula)
  {
      $app = App::getSingleton();
      $conn = $app->conexionBd();
      $query = sprintf("SELECT * FROM peliculas P WHERE P.id = '%s'", $conn->real_escape_string($pelicula));
      $rs = $conn->query($query);
      $result = false;
      if ($rs) {
          if ( $rs->num_rows == 1) {
              $fila = $rs->fetch_assoc();
              $pelicula = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
              $result = $pelicula;
          }
          $rs->free();
      } else {
          echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
          exit();
      }
      return $result;
  }

  public static function buscaPorId($idPelicula)
  {
    $result = null;
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf('SELECT * FROM peliculas WHERE id = %d', $idPelicula);
    $rs = $conn->query($query);
    if ($rs && $rs->num_rows == 1) {
      while($fila = $rs->fetch_assoc()) {
        $result = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
      }
      $rs->free();
    }
    return $result;
  }
  
  public static function inserta($pelicula)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();

    if (!$pelicula->link || $pelicula->price) {
      $query = sprintf("INSERT INTO peliculas (title, image, date_released, duration,country,plot) VALUES('%s', '%s','%s', %d, '%s','%s')"
      , $conn->real_escape_string($pelicula->title)
      , $conn->real_escape_string($pelicula->image)
      , $conn->real_escape_string($pelicula->date_released)
      , $pelicula->duration
      , $conn->real_escape_string($pelicula->country)
      , $conn->real_escape_string($pelicula->plot));
    } else {
      $query = sprintf("INSERT INTO peliculas (title, image, date_released, duration,country,plot,link,price) VALUES('%s', '%s','%s', %d, '%s','%s','%s',%g)"
      , $conn->real_escape_string($pelicula->title)
      , $conn->real_escape_string($pelicula->image)
      , $conn->real_escape_string($pelicula->date_released)
      , $pelicula->duration
      , $conn->real_escape_string($pelicula->country)
      , $conn->real_escape_string($pelicula->plot)
      , $conn->real_escape_string($pelicula->link)
      , $pelicula->price);
    }
    $result = $conn->query($query);
    if ($result) {
      $pelicula->id = $conn->insert_id;
      $result = $pelicula;
    } else {
      error_log($conn->error);  
    }

    return $result;
  }
  
  public static function addPeliculaComprada($user, $id)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();

    $query = sprintf("INSERT INTO usuarios_peliculas_compradas (user, film_id) VALUES('%s', %d)"
    , $conn->real_escape_string($user)
    , $id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);  
    }
  }

  public static function actualiza($pelicula)
  {
    $app = App::getSingleton();
    $conn = $app->conexionBd();

    if (!$pelicula->link || !$pelicula->price) {
      $query = sprintf("UPDATE peliculas P SET title = '%s', image='%s', date_released='%s', duration=%d, country='%s', plot='%s', link=null, price=null WHERE P.id=%d"
      , $conn->real_escape_string($pelicula->title)
      , $conn->real_escape_string($pelicula->image)
      , $conn->real_escape_string($pelicula->date_released)
      , $pelicula->duration
      , $conn->real_escape_string($pelicula->country)
      , $conn->real_escape_string($pelicula->plot)
          , $pelicula->id);
    } else {
      $query = sprintf("UPDATE peliculas P SET title = '%s', image='%s', date_released='%s', duration=%d, country='%s', plot='%s', link='%s', price=%g WHERE P.id=%d"
      , $conn->real_escape_string($pelicula->title)
      , $conn->real_escape_string($pelicula->image)
      , $conn->real_escape_string($pelicula->date_released)
      , $pelicula->duration
      , $conn->real_escape_string($pelicula->country)
      , $conn->real_escape_string($pelicula->plot)
      , $conn->real_escape_string($pelicula->link)
      , $pelicula->price
          , $pelicula->id);
    }
    if (!$conn->query($query)) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han actualizado '$conn->affected_rows' !");
    }

    return $pelicula;
  }

  public static function editar($id, $title, $image, $date_released, $duration, $country, $plot, $link, $price)
  {
      $pelicula = self::buscaPorId($id);
      $image = strlen($image) < 1 ? $pelicula->image : $image;

      $pelicula = new Pelicula($id, $title, $image ,$date_released, $duration, $country, $plot, null, $link, $price);
      
      return self::guarda($pelicula);
  }

  public static function guarda($pelicula)
  {
      if ($pelicula->id !== null) {
          return self::actualiza($pelicula);
      }
      return self::inserta($pelicula);
  }

  public static function borra($pelicula)
  {
    return self::borraPorid($pelicula->id);
  }

  public static function borraPorId($id)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM peliculas WHERE id = %d", $id);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
  }
  
	
	public static function listaPeliculas($order, $ascdesc, $limit=NULL)
	{
    $ascdesc = $ascdesc ?? 'ASC';
		$result = [];

    $app = App::getSingleton();
    $conn = $app->conexionBd();
		$query = sprintf("SELECT * FROM peliculas ORDER BY %s %s", $order, $ascdesc);
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

		return $result;
	}
	
	public static function listaPeliculasVer($order, $ascdesc,$user, $limit=NULL)
	{
    $ascdesc = $ascdesc ?? 'ASC';
	$result = [];
    $app = App::getSingleton();
    $conn = $app->conexionBd();
		$query = sprintf("SELECT p.* FROM peliculas p JOIN usuarios_peliculas_ver v ON p.id = v.film_id WHERE v.user = '%s'  ORDER BY %s %s", $user,$order, $ascdesc);
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

		return $result;
	}	
	
	public static function listaPeliculasCompradas($order, $ascdesc,$user, $limit=NULL)
	{
    $ascdesc = $ascdesc ?? 'ASC';
	$result = [];
    $app = App::getSingleton();
    $conn = $app->conexionBd();
		$query = sprintf("SELECT p.* FROM peliculas p JOIN usuarios_peliculas_compradas v ON p.id = v.film_id WHERE v.user = '%s'  ORDER BY %s %s", $user,$order, $ascdesc);
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

		return $result;
	}	
	
	public static function listaPeliculasGen($order, $ascdesc, $id, $limit=NULL)
	{
    $ascdesc = $ascdesc ?? 'ASC';

	  $result = [];
    $app = App::getSingleton();
    $conn = $app->conexionBd();

		$query = sprintf("SELECT p.* FROM peliculas p JOIN peliculas_generos v ON p.id = v.film_id WHERE v.genre_id = '%s' ORDER BY %s %s", $id, $order, $ascdesc);
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}

		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

		return $result;
	}
	
	public static function listaPeliculasGen2($order, $ascdesc, $genres, $limit=NULL)
	{
    $ascdesc = $ascdesc ?? 'ASC';

	  $result = [];
    $app = App::getSingleton();
    $conn = $app->conexionBd();

		$query = "SELECT DISTINCT p.* FROM peliculas p JOIN peliculas_generos v ON p.id = v.film_id WHERE "; 
    foreach($genres as $genre) {
      $query .= sprintf(" v.genre_id = %d OR ", $genre->id());
    } 
    $query .= sprintf(" 1=0 ORDER BY %s %s ", $order, $ascdesc);
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

		return $result;
	}

  public static function peliculasPorActorDirectorId ($order, $ascdesc,$id)
  {
    $ascdesc = $ascdesc ?? 'ASC';
		$result = [];

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT p.* FROM peliculas p JOIN peliculas_actores_directores pad ON p.id = pad.film_id WHERE pad.actor_director_id = %d ORDER BY %s %s" , $id, $order, $ascdesc);
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			  $result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

    return $result;
  }

  public static function peliculasPorActorDirectorId2 ($order, $ascdesc, $ads)
  {
    $ascdesc = $ascdesc ?? 'ASC';
		$result = [];

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = "SELECT DISTINCT p.* FROM peliculas p JOIN peliculas_actores_directores pad ON p.id = pad.film_id WHERE ";
    foreach ($ads as $ad){
      $query .= sprintf("pad.actor_director_id = %d OR ", $ad->id());
    }
    $query .= sprintf("1=0 ORDER BY %s %s" , $order, $ascdesc);
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			  $result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

    return $result;
  }
	
	public static function ultimaPeliculaWatchedMejorRating($user, $limit=NULL)
	{

	$result = [];
    $app = App::getSingleton();
    $conn = $app->conexionBd();

		$query = sprintf("SELECT p.* FROM peliculas p JOIN usuarios_peliculas_vistas v ON p.id = v.film_id WHERE v.user = '%s' AND v.rating NOT LIKE '0' ORDER BY v.rating DESC, v.id DESC", $user);
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

		return $result;
	}
	
	public static function ultimaPeliculaWatched($user, $limit=NULL)
	{

	$result = [];
    $app = App::getSingleton();
    $conn = $app->conexionBd();

		$query = sprintf("SELECT p.* FROM peliculas p JOIN usuarios_peliculas_vistas v ON p.id = v.film_id WHERE v.user = '%s'  ORDER BY v.id DESC", $user);
		if($limit) {
		  $query = $query . ' LIMIT %d';
		  $query = sprintf($query, $limit);
		}
		$rs = $conn->query($query);
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
			$result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
		  }
		  $rs->free();
		}

		return $result;
	}


  public static function actualizarGeneros($peliculaIn, $generos)
  {
      $result = false;

      $app = App::getSingleton();
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

      $app = App::getSingleton();
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
          if ( !$conn->query($query) ) {
              echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
              exit();
          }
      }

      foreach($directores as $director) {
          $query=sprintf("INSERT INTO peliculas_actores_directores(film_id, actor_director_id) VALUES(%d, %d)"
              , $conn->real_escape_string($peliculaIn->id)
              , $conn->real_escape_string($director));
          if ( !$conn->query($query) ) {
              echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
              exit();
          }
      }

      return $result;
  }

  public static function busqueda($search)
  {
    $result = [];

        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM peliculas P WHERE P.title LIKE '%s' OR P.country LIKE '%s' OR P.plot LIKE '%s'", 
        '%'.$conn->real_escape_string($search).'%',
        '%'.$conn->real_escape_string($search).'%',
        '%'.$conn->real_escape_string($search).'%');

    $rs = $conn->query($query);
    if ($rs) {
      while($fila = $rs->fetch_assoc()) {
      $result[] = new Pelicula($fila['id'], $fila['title'], $fila['image'], $fila['date_released'], $fila['duration'], $fila['country'], $fila['plot'], $fila['rating'], $fila['link'], $fila['price']);
      }
      $rs->free();
    }

    return $result;
  }

  public static function isPeliculaEnLista($id, $user)
  {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM usuarios_peliculas_ver WHERE film_id = %d and user = '%s'", $id, $user);
    $rs = $conn->query($query);
    return $rs->num_rows;
  }

  public static function addListaVer($id, $user)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("INSERT INTO usuarios_peliculas_ver(film_id, user) VALUES(%d, '%s')"
    , $id
    , $conn->real_escape_string($user));
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);  
    }

    return $result;
  }

  public static function delListaVer($id, $user)
  {
    $result = false;

    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("DELETE FROM usuarios_peliculas_ver WHERE film_id = %d and user = '%s'", $id, $user);
    $result = $conn->query($query);
    if (!$result) {
      error_log($conn->error);
    } else if ($conn->affected_rows != 1) {
      error_log("Se han borrado '$conn->affected_rows' !");
    }

    return $result;
  }

  public static function existeReviewUsuarioPelicula($id, $user)
  {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM reviews WHERE film_id = %d and user = '%s'", $id, $user);
    $rs = $conn->query($query);
    return $rs->num_rows;
  }

  public static function isPeliculaCompradaPorUsuario($user, $id) 
  {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("SELECT * FROM usuarios_peliculas_compradas WHERE film_id = %d and user = '%s'", $id, $user);
    $rs = $conn->query($query);
    return $rs->num_rows;
  }

  private $id;

  private $title;
	
	private $image;
	
	private $date_released;

  private $duration;

  private $country;
	
	private $plot;

  private $rating;

  private $link;

  private $price;

  private $genres;

  private $actors;

  private $directors;

  private $plataformas;

  private $reviews;

  private $peliculasPlataformas;

  private function __construct($id, $title, $image, $date_released, $duration, $country, $plot, $rating, $link, $price)
  {   
    $this->id= $id;
    $this->title = $title;
    $this->image = $image ?? 'film_default.jpg';
    $this->date_released = $date_released;
    $this->duration = $duration;
    $this->country = $country;
    $this->plot = $plot;
    $this->rating = $rating;
    $this->link = $link;
    $this->price = $price;
    $this->genres = Genero::buscaPorPeliId($id);
    $this->actors = ActorDirector::buscaActorDirectorPorPeliId($id,0);
    $this->directors = ActorDirector::buscaActorDirectorPorPeliId($id,1);
    $this->plataformas = Plataforma::buscaPlataformaPorIdPelicula($id);
    $this->reviews = Review::buscaReviewsPorIdPeli($id);
    $this->peliculasPlataformas = PeliculaPlataforma::buscaPeliculaPlataformaPorIdPelicula($id);
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

  public function link()
  {
      return $this->link;
  }

  public function price()
  {
      return $this->price;
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
