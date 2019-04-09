<?php
declare(strict_types=1);

// Vérification des dépendances 
if (file_exists(ROOT_PATH.'/vendor/autoload.php') === false) {
    echo "run this command first: composer install";
    exit();
}
require_once ROOT_PATH.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

// Déclaration de l'application
$app = new Application();

// Set du header
$app->after(function (Request $request, Response $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
});

// Debug de l'application
$app['debug'] = true;

// Réponse à l'appel sur route /
$app->get('/', function () use ($app) {
    return 'Status OK';
});

// Réponse à l'appel sur route /surveys
$app->mount('/surveys', include 'stage1.php');

// Réponse à l'appel sur route /surveys/{id}
$app->mount('/surveys/{id}', include 'stage2.php');

// Lancement de l'application
$app->run();

return $app;

?>