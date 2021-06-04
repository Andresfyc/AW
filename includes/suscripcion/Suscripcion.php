<?php

namespace es\ucm\fdi\aw\suscripcion;

use es\ucm\fdi\aw\Aplicacion as App;


class Suscripcion
{
    public static function crea($meses, $precio)
    {
        $plan = new Suscripcion(null, $meses, $precio);
        return self::guarda($plan);
    }

    public static function listaPlanes()
    {
        $result = [];

        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("SELECT * FROM planes ORDER BY meses ASC");

        $rs = $conn->query($query);
        if ($rs) {
            while($fila = $rs->fetch_assoc()) {
                $result[] = new Suscripcion($fila['id'], $fila['meses'], $fila['precio']);
            }
            $rs->free();
        }

        return $result;
    }

    public static function inserta($plan)
    {
        $result = false;
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("INSERT INTO planes (meses, precio) VALUES('%d', '%d')"
            , $plan->meses
            , $plan->precio);
        $result = $conn->query($query);
        if ($result) {
            $plan->meses = $conn->insert_id;
            $plan->rating = $conn->insert_rating; //TODO Arreglar
            $result = $plan;
        } else {
            error_log($conn->error);
        }

        return $result;
    }

    public static function actualiza($plan)
    {
        $app = App::getSingleton();
        $conn = $app->conexionBd();

        echo "$plan->id";
        $query = sprintf("UPDATE planes P SET meses = %d, precio=%d WHERE P.id=%d"
            , $plan->meses
            , $plan->precio
            , $plan->id);
        if (!$conn->query($query)) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han actualizado '$conn->affected_rows' !");
        }

        return $plan;
    }

    public static function editar($id, $meses, $precio)
    {
        $plan = new Suscripcion($id, $meses, $precio);
        return self::guarda($plan);
    }

    public static function guarda($plan)
    {
        echo "$plan->id";
        echo "$plan->meses";
        if ($plan->meses !== null) {
            return self::actualiza($plan);
        }
        return self::inserta($plan);
    }

    public static function borra($id)
    {
        return self::borraPorid($id->id);
    }

    public static function borraPorId($id)
    {
        $result = false;

        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf("DELETE FROM planes WHERE id = %d", $id);
        $result = $conn->query($query);
        if (!$result) {
            error_log($conn->error);
        } else if ($conn->affected_rows != 1) {
            error_log("Se han borrado '$conn->affected_rows' !");
        }

        return $result;
    }

    public static function buscaPorId($idPlan)
    {
        $result = null;
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query = sprintf('SELECT * FROM planes WHERE id = %d', $idPlan);
        $rs = $conn->query($query);
            while($fila = $rs->fetch_assoc()) {
                $result = new Suscripcion($fila['id'],$fila['meses'], $fila['precio']);
            }
            $rs->free();

        return $result;
    }

    private $id;

    private $meses;

    private $precio;

    private function __construct($id, $meses, $precio)
    {
        $this->id= $id;
        $this->meses = $meses;
        $this->precio = $precio;
    }

    public function id()
    {
        return $this->id;
    }

    public function meses()
    {
        return $this->meses;
    }

    public function precio()
    {
        return $this->precio;
    }


}