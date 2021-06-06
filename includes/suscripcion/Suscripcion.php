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

    private static function inserta($plan)
    {
        $app = App::getSingleton();
        $conn = $app->conexionBd();
        $query=sprintf(" INSERT INTO planes(meses, precio) VALUES (%d,%d)"
            , $plan->meses
            , $conn->real_escape_string($plan->precio));
        if ( $conn->query($query) ) {
            $plan->id = $conn->insert_id;
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
        return $plan;
    }

    public static function actualiza($plan)
    {
        $app = App::getSingleton();
        $conn = $app->conexionBd();

        $query = sprintf("UPDATE planes P SET meses = %d, precio=%g WHERE P.id=%d"
            , $plan->meses
            , $plan->precio
            , $plan->id);
        if ($conn->query($query)) {
            if ( $conn->affected_rows != 1) {
                echo "No se ha podido actualizar el plan de meses: " . $plan->meses;
                exit();
            }
        } else {
            echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
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

        echo "BD- Guardar";

        if ($plan->id !== null) {
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