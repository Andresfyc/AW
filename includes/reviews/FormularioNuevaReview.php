<?php
namespace es\ucm\fdi\aw\reviews;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Form;

class FormularioNuevaReview extends Form
{
    private $id;
    
    public function __construct($id) {
        parent::__construct('formNuevaReview');
        $this->id = $id;
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


        $camposFormulario = <<<EOF
              <div class="grupo-fomulario">
                $htmlErroresGlobales
                <h1>Añadir Review</h1>
                    <input class="control" type="hidden" name="id" value="$id" readonly/>
                    
                    <textarea class="control" type="text" name="review" value="$review" placeholder="Review..." required/>$review</textarea>$errorReview
                    
                    <input class="control" type="number" name="rating" value="$rating" placeholder="Puntuación"/>$errorRating
                
                <button type="submit" name="nuevaReview">Publicar</button>
            </div>
        EOF;
        return $camposFormulario;
    }


    protected function procesaFormulario($datos)
    {
        $result = array();
        $app = Aplicacion::getSingleton();
        
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
            if ($app->usuarioLogueado())
                $review = Review::crea($app->user(), $id, $review, $rating);
                if ( ! $review ) {
                    $result[] = "El género ya existe";
                } else {
                    $result = RUTA_APP."pelicula.php?id={$id}";
                }
            }
        
        return $result;
    }
}