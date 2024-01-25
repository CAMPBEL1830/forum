<?php

// require 'vendor/autoload.php';

// use Prometheus\CollectorRegistry;
// use Prometheus\RenderTextFormat;
// use Prometheus\Storage\InMemory;

// Créer un registre de collecteurs avec un stockage en mémoire
//$registry = new CollectorRegistry(new InMemory());

// Définir une métrique de compteur
// $counter = $registry->registerCounter('example', 'app_requests_total', 'Total number of requests');

// Incrémenter le compteur à chaque requête
// $counter->inc();

// Exposer les métriques via un endpoint /metrics
// if ($_SERVER['REQUEST_URI'] === '/metrics') {
//     header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
//     echo (new RenderTextFormat())->render($registry);
//     exit;
// }

// Votre code d'application continue ici

