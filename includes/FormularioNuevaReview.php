<?php
namespace es\ucm\fdi\aw;

class FormularioNuevaReview extends Form
{

    private $id;

    public function __construct($id) {
        $this->id = $id;
        parent::__construct('formNuevaReview');
    }

    protected function generaCamposFormulario($datos, $errores = array())
    {
        $id = $datos['id'] ?? $this->id;
        $review = $datos['review'] ?? '';
        $rating = $datos['rating'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($errores);
        $errorReview = self::createMensajeError($errores, 'review', 'span', array('class' => 'error'));
        $errorRating = self::createMensajeError($errores, 'rating', 'span', array('class' => 'error'));

        $html = <<<EOF
            <fieldset>
                $htmlErroresGlobales
                <div class="grupo-control">
                    <input class="control" type="hidden" name="id" value="$id" readonly/>
                    <label>Review:</label> <input class="control" type="text" name="review" value="$review" />$errorReview
                    <label>Puntuación:</label> <input class="control" type="number" name="rating" value="$rating" />$errorRating
                </div>
                <div class="grupo-control"><button type="submit" name="nuevaReview">Publicar</button></div>
            </fieldset>
        EOF;
        return $html;
    }

    
    protected function procesaFormulario($datos)
    {
        $result = array();
        
        $id = $datos['id'] ?? null;

        $review = $datos['review'] ?? null;
        if ( empty($review)  ) {
            $result['review'] = "La review no puede estar vacía";
        }

        $rating = $datos['rating'] ?? null;
        if ( empty($rating) || $rating < 1 || $rating > 5 ) {
            $result['rating'] = "La puntuación debe estar entre 1 y 5";
        }
        
        if (count($result) === 0) {
            $review = Review::crea($_SESSION['nombre'], $id, $review, $rating);
            if ( ! $review ) {
                $result[] = "Error";
            } else { 
                $result = "pelicula.php?id={$id}";
            }
        }
        return $result;
    }
}