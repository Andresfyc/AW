<?php

require_once 'includes/config.php';

function mostrarActoresDirectores($actorDirector) {
	$actoresDirectores = new es\ucm\fdi\aw\actoresDirectores();
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		echo $actoresDirectores->listaActoresDirectores($_SESSION["nombre"], 7, $actorDirector);			
	} else {
		//TODO Cambiar para que aparezcan actores y directores en general
		echo "<p>Inicia sesión para ver tus actores y directores</p>";
	}
}
?>
<aside id="sidebarIzq">
	<div id="topSide">
		<img src="img/logo1.png" alt="filmswap logo" width="100%" height="100%">
		<form id="buscador" name="buscador" method="post" action="buscar.php">
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