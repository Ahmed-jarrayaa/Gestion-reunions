<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Authentication\Identifier\IdentifierInterface;
use Cake\Routing\Router;

/**
 * Application setup class.
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    /**
     * Bootstrap the application.
     */
    public function bootstrap(): void
    {
        parent::bootstrap();

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }

        // Charge le plugin Authentication s'il n'est pas déjà chargé
        if (!$this->plugins->has('Authentication')) {
            $this->addPlugin('Authentication');
        }
    }

    /**
     * Setup the middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new AuthenticationMiddleware($this))
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]))
            ->add(function ($request, $handler) {
            try {
                return $handler->handle($request);
            } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
                return new \Cake\Http\Response([
                    'body' => 'Réunion introuvable'
                ]);
            }
        });

        return $middlewareQueue;
    }

    /**
     * Configure the authentication service.
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();
        
        // Configure les redirections pour les utilisateurs non authentifiés
        $service->setConfig([
            'unauthenticatedRedirect' => '/connexion',
            'queryParam' => 'redirect',
        ]);

        // Charge l'authentification par session (pour maintenir la connexion)
        $service->loadAuthenticator('Authentication.Session');

        // Configure l'authentification par formulaire
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => [
                'username' => 'email',  // ou 'username' selon votre DB
                'password' => 'mot_de_passe'
            ],
            'loginUrl' => '/connexion',
        ]);

        // Configure le système d'identification
        $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email',  // doit correspondre au champ ci-dessus
                'password' => 'mot_de_passe'
            ],
            'resolver' => [
                'className' => 'Authentication.Orm',
                'userModel' => 'utilisateurs',
            ]
        ]);

        return $service;
    }

    /**
     * Register application container services.
     */
    public function services(ContainerInterface $container): void
    {
        // Vous pouvez enregistrer des services ici si nécessaire
    }
    
    

    
}