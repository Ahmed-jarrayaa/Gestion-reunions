<?php
/**
 * Routes configuration.
 */
use Cake\Core\Configure;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

return function (RouteBuilder $routes): void {
    // Configuration par défaut
    $routes->setRouteClass(DashedRoute::class);

    // Routes principales (front office)
    $routes->scope('/', function (RouteBuilder $builder): void {
        // Page d'accueil
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

        // Routes d'authentification
        $builder->connect('/connexion', ['controller' => 'Utilisateurs', 'action' => 'login']);
        $builder->connect('/deconnexion', ['controller' => 'Utilisateurs', 'action' => 'logout']);
        $builder->connect('/inscription', ['controller' => 'Utilisateurs', 'action' => 'add']);
        $builder->connect('/mon-compte', ['controller' => 'Utilisateurs', 'action' => 'view']);

        // Tableau de bord personnel
        $builder->connect('/dashboard', ['controller' => 'Utilisateurs', 'action' => 'dashboard']);

        // Pages statiques
        $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

        // Routes fonctionnelles explicites (doivent être déclarées avant fallbacks)
        $builder->connect('/calendrier', ['controller' => 'Reunions', 'action' => 'calendrier']);
        $builder->connect('/reunions/events', ['controller' => 'Reunions', 'action' => 'events']);
        $builder->connect('/reunions/mark-all-read', ['controller' => 'Reunions', 'action' => 'markAllRead']);
        $builder->connect('/planification/accepter/*', ['controller' => 'Planification', 'action' => 'accepter']);
        $builder->connect('/planification/refuser/*', ['controller' => 'Planification', 'action' => 'refuser']);

        $builder->fallbacks(DashedRoute::class);
    });

    // Routes de développement
    if (Configure::read('debug')) {
        $routes->scope('/dev', function (RouteBuilder $builder) {
            $builder->connect('/info', ['controller' => 'Pages', 'action' => 'display', 'info']);
        });
    }
};