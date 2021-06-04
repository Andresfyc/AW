<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <link rel="shortcut icon" href="img/icono1.ico" />
    <!-- Load an icon library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $tituloPagina ?></title>
</head>
<body>
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
</body>
</html>