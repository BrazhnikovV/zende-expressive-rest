<?php

declare(strict_types=1);

use User\Handler\Permission\CreatePermissionHandler;
use User\Handler\Permission\GetPermissionHandler;
use User\Handler\Permission\UpdatePermissionHandler;
use Zend\Expressive\Application;
use User\Handler\Role\RoleHandler;
use User\Handler\Role\GetRoleHandler;
use Psr\Container\ContainerInterface;
use Zend\Expressive\MiddlewareFactory;
use User\Handler\Role\CreateRoleHandler;
use User\Handler\Role\UpdateRoleHandler;
use Auth\Handler\Rbac\AuthorizationHandler;
use Auth\Handler\Auth\AuthenticationHandler;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->post('/login', Auth\Handler\Login\LoginHandler::class, 'login');
    $app->get('/api/ping',
    [
        AuthenticationHandler::class,
        AuthorizationHandler::class,
        App\Handler\PingHandler::class
    ], 'api.ping');

    $app->get('/api/roles', [GetRoleHandler::class], 'api.roles');
    $app->post('/api/create-role', [CreateRoleHandler::class], 'api.create-role');
    $app->put('/api/update-role/{id}', [UpdateRoleHandler::class], 'api.update-role');

    $app->get('/api/permissions', [GetPermissionHandler::class], 'api.permissions');
    $app->post('/api/create-permission', [CreatePermissionHandler::class], 'api.create-permission');
    $app->put('/api/update-permission/{id}', [UpdatePermissionHandler::class], 'api.update-permission');
};
