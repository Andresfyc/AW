<?php
require_once __DIR__.'/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

function mostrarSaludo() {
	$app = Aplicacion::getSingleton();
	$image = $app->image();
	$user = $app->user();
	if ($app->usuarioLogueado()) {
		echo "<img id=\"prof_pic\" src=\"img/usuarios/{$image}\" alt=\"user\" width=\"75\" height=\"75\"><p>Bienvenido, " . $user . "</p><a href='perfil.php'>Perfil</a> <a href='logout.php'>Salir</a>";
	} else {
		echo "<img id=\"prof_pic\" src=\"img/usuarios/user_no_logged.png\" alt=\"user\" width=\"75\" height=\"75\"><p> Usuario desconocido </p><a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
	}
}

function mostrarAmigos() {
	$app = Aplicacion::getSingleton();
	$user = $app->user();
	if ($app->usuarioLogueado()) {
		echo listaAmigos($user, 7);	
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