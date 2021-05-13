<?php
require_once __DIR__.'/includes/config.php';

$app->logout();
header('Location: index.php');

require __DIR__.'/includes/plantillas/plantilla.php';