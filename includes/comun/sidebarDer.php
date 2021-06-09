<?php
require_once __DIR__.'/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\peliculas\Pelicula;

function mostrarSaludo() {
	$app = Aplicacion::getSingleton();
	$image = $app->image();
	$user = $app->user();
	$prevLink = urlencode($_SERVER['REQUEST_URI']);
	if ($app->usuarioLogueado()) {
		if (strlen($app->watching() < 1)){
			echo "<img id=\"prof_pic\" src=\"img/usuarios/{$image}\" alt=\"{$user}\" ><p>" . $user . ": <a href='watching.php?prevPage={$prevLink}'> ¿Estás viendo alguna película? </a></p><a href='usuario.php'><i class='fa fa-user' ></i></a> <a href='logout.php'><i class='fa fa-sign-out' ></i></a> ";
		} else {
			$titulo = Pelicula::buscaPorId($app->watching())->title();
			echo "<img id=\"prof_pic\" src=\"img/usuarios/{$image}\" alt=\"{$user}\" ><p>" . $user . ": <a href='watching.php?id={$app->watching()}&prevPage={$prevLink}'> Viendo ". $titulo ." </a></p><a href='usuario.php'><i class='fa fa-user' ></i></a> <a href='logout.php'><i class='fa fa-sign-out' ></i></a> ";
		}
		$notificacionesCompletadas = getNotificacionesCompletadas($app->user());
		if ($notificacionesCompletadas) {
			$numNotifs = count($notificacionesCompletadas);
			echo "<a id='noti' href='notificaciones.php?id={$app->user()}'><i class='fa fa-bell' ></i><span class='badge'>{$numNotifs}</span></a>";
		} else {
			echo "<a href='notificaciones.php?id={$app->user()}'><i class='fa fa-bell' ></i></a>";
		}
	} else {
		echo "<img id=\"prof_pic\" src=\"img/usuarios/user_no_logged.png\" alt=\"Usuario no logueado\" ><p> Usuario desconocido </p><a href='login.php?prevPage=$prevLink'>Login</a> <a href='registro.php'>Registro</a>";
	}
}

function mostrarAmigos() {
	$app = Aplicacion::getSingleton();
	$user = $app->user();
	if ($app->usuarioLogueado()) {
		echo listaAmigos($user, 7);	
		echo "<p><a href='swappers.php?id={$user}'> Ver todos tus swappers</a></p>";
		echo "<p><a href='reviews.php'> Ver reviews de tus swappers</a></p>";
	} else {
		echo "<p>Inicia sesión para ver la actividad de tus amigos</p>";
	}
}
?>
<aside id="sidebarDer">
	<!--<div class="saludo">-->
	<div id="topSide">
		<?php
			mostrarSaludo();
		?>
	</div>
	<div id="contentSide">
		<h3> Tus swappers </h3>
		<?php
			mostrarAmigos();
		?>
	</div>
</aside>