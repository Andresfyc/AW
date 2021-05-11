<?php
namespace es\ucm\fdi\aw;

class Review
{
    
    public static function crea($user, $filmId, $review, $stars)
    {
        $review = new Review(null, $user, $filmId, $review, $stars, '');
        return self::guarda($review);
    }
    
    public static function guarda($review)
    {
        if ($review->id !== null) {
            return self::actualiza($review);
        }
        return self::inserta($review);
    }
    
    private static function inserta($review)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO reviews (user, film_id, review, stars, time_created) VALUES ('%s', %d,'%s',%d, CURRENT_TIMESTAMP()) ON DUPLICATE KEY UPDATE review='%s', stars=%d"
            , $conn->real_escape_string($review->user)
            , $conn->real_escape_string($review->film_id)
            , $conn->real_escape_string($review->review)
            , $conn->real_escape_string($review->stars)
            , $conn->real_escape_string($review->review)
            , $conn->real_escape_string($review->stars));

        echo $query;
        if ( $conn->query($query) ) {
            $usuario->id = $conn->insert_id;
            $usuario->time_created = $conn->insert_time_created;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $review;
    }

    private static function actualiza($review)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE reviews R SET review = '%s', stars = %d WHERE R.id=%d"
        , $conn->real_escape_string($review->review)
        , $conn->real_escape_string($review->stars)
            , $review->id);
        echo $query;
        if ( $conn->query($query) ) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar la review: " . $review->review;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        
        return $review;
    }


    public static function buscaPorId($id)
    {
        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM reviews WHERE id = %d", $id);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $review = new Review($fila['id'], $fila['user'], $fila['film_id'], $fila['review'], $fila['stars'], $fila['time_created']);
                $result = $review;
            }
            $rs->free();
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $result;
    }


    public static function borraPorId($id)
    {
        $result = false;

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM reviews WHERE id = %d", $id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }
    
    public static function buscaReviewsPorIdPeli($id)
    {
		$result = [];

        $app = Aplicacion::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM reviews WHERE film_id = %d ORDER BY time_created DESC", $id);
        
        $rs = $conn->query($query);
        $result = false;
		if ($rs) {
		  while($fila = $rs->fetch_assoc()) {
            $result[] = new Review($fila['id'], $fila['user'], $fila['film_id'], $fila['review'], $fila['stars'], $fila['time_created']);
		  }
		  $rs->free();
		}

		return $result;
    }

    public static function editar($id,$film_id,$user,$reviewStr,$stars,$time_created)
    {
        $review = self::buscaPorId($id);
        $user = strlen($user) < 1 ? $review->user : $user;
        $film_id = strlen($film_id) < 1 ? $review->film_id : $film_id;
        $reviewStr = strlen($reviewStr) < 1 ? $review->review : $reviewStr;
        $stars = strlen($stars) < 1 ? $review->stars : $stars;
        $time_created = strlen($time_created) < 1 ? $review->time_created : $time_created;
        $review = new Review($id,$user,$film_id,$reviewStr,$stars,$time_created);
        
        return self::guarda($review);
    }


    private $id;

    private $film_id;
	
	private $user;
	
	private $review;
	
	private $stars;

    private $time_created;

    private function __construct($id, $user, $film_id, $review, $stars, $time_created)
    {
        $this->id = $id;
        $this->user = $user;
        $this->film_id = $film_id;
        $this->review = $review;
        $this->stars = $stars;
        $this->time_created = $time_created;
    }

    public function id()
    {
        return $this->id;
    }

    public function film_id()
    {
        return $this->film_id;
    }

    public function user()
    {
        return $this->user;
    }

    public function review()
    {
        return $this->review;
    }

    public function stars()
    {
        return $this->stars;
    }

    public function time_created()
    {
        return $this->time_created;
    }
}
