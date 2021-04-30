<?php
function mostrarSaludo() {
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		echo "<img id=\"prof_pic\" src=\"img/{$_SESSION["imagen"]}\" alt=\"imagen\" width=\"50\" height=\"50\"><p>Bienvenido, " . $_SESSION['nombre'] . "</p><a href='logout.php'>Salir</a>";
	} else {
		echo "<img id=\"prof_pic\" src=\"img/user_no_logged.png\" alt=\"imagen\" width=\"50\" height=\"50\"><p> Usuario desconocido </p><a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
	}
}

function mostrarAmigos() {
	$usuarios = new es\ucm\fdi\aw\usuarios();
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		echo $usuarios->listaAmigos($_SESSION["nombre"], 7);	
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