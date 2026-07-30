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

        // Route personnalisée pour /dashboard vers UtilisateursController::dashboard
        $builder->connect('/dashboard', ['controller' => 'Utilisateurs', 'action' => 'dashboard']);

        // Route pour le dashboard (tableau de bord) du DashboardController (si besoin)
        $builder->connect('/dashboard', [
            'controller' => 'Dashboard', 
            'action' => 'index'
        ]);

        // Pages statiques
        $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

        $builder->fallbacks(DashedRoute::class);
    });

    // Routes de développement
    if (Configure::read('debug')) {
        $routes->scope('/dev', function (RouteBuilder $builder) {
            $builder->connect('/info', ['controller' => 'Pages', 'action' => 'display', 'info']);
        });
    }

    // Zone administrateur
    $routes->prefix('Admin', function (RouteBuilder $builder) {
        $builder->connect('/', ['controller' => 'Dashboard', 'action' => 'admin']);
        $builder->fallbacks(DashedRoute::class);
    });

    // API REST
    $routes->scope('/api', function (RouteBuilder $builder) {
        $builder->setExtensions(['json']);
        $builder->resources('Utilisateurs');
        $builder->connect('/dashboard', [
            'controller' => 'Dashboard',
            'action' => 'index'
        ]);
    });


$routes->connect('/calendrier', ['controller' => 'Reunions', 'action' => 'calendrier']);
$routes->connect('/reunions/events', ['controller' => 'Reunions', 'action' => 'events']);
$routes->connect('/reunions/markAllRead', ['controller' => 'Reunions', 'action' => 'markAllRead']);
$routes->connect('/planification/approve/*', ['controller' => 'Planification', 'action' => 'approve'], ['_method' => 'POST']);
$routes->connect('/planification/reject/*',  ['controller' => 'Planification', 'action' => 'reject'],  ['_method' => 'POST']);


};
