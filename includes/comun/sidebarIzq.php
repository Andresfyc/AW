<?php
require_once __DIR__.'/usuarios_utils.php';

use es\ucm\fdi\aw\Aplicacion;

function mostrarActoresDirectores($actorDirector) {
	$app = Aplicacion::getSingleton();
	$user = $app->user();
	if ($app->usuarioLogueado()) {
		echo listaActoresDirectoresUser($user, 7, $actorDirector);			
	} else {
		//TODO Cambiar para que aparezcan actores y directores en general
		echo "<p>Inicia sesión para ver tus actores y directores</p>";
	}
}
?>
<aside id="sidebarIzq">
	<div id="topSide">
		<img src="img/logo1.png" alt="filmswap logo" width="140px" height="112px">
		<form id="buscador" name="buscador" method="post" action="././buscar.php">
			<input id="buscar" name="buscar" type="text" placeholder="Buscar" autofocus>
		</form>
	</div>
	<div id="contentSide">
		<h3> Tus actores favoritos </h3>
		<?php
			mostrarActoresDirectores(0);
		?>
		<h3> Tus directores favoritos </h3>
		<?php
			mostrarActoresDirectores(1);
		?>
	</div>
</aside>