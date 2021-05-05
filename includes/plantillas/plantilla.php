<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <link rel="shortcut icon" href="img/icono1.ico" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $tituloPagina ?></title>
</head>
<body>
<!--<div id="contenedor">-->
    <?php
    require("includes/comun/sidebarIzq.php");
    ?>
    <main>
		<?php
		require("includes/comun/cabecera.php");
		?>
        <article>
            <?= $contenidoPrincipal ?>
        </article>
    </main>
    <?php
    require("includes/comun/sidebarDer.php");
    ?>
<!--</div>-->
</body>
</html>