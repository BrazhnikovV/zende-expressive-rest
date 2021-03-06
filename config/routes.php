<?php

declare(strict_types=1);

use User\Handler\Permission\CreatePermissionHandler;
use User\Handler\Permission\DeletePermissionHandler;
use User\Handler\Permission\GetPermissionByIdHandler;
use User\Handler\Permission\GetPermissionHandler;
use User\Handler\Permission\UpdatePermissionHandler;
use User\Handler\Role\DeleteRoleHandler;
use User\Handler\Role\GetRoleByIdHandler;
use User\Handler\User\ChangePasswordHandler;
use User\Handler\User\CreateUserHandler;
use User\Handler\User\DeleteUserHandler;
use User\Handler\User\GetUserByIdHandler;
use User\Handler\User\GetUsersHandler;
use User\Handler\User\UpdateUserHandler;
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

    $app->get('/api/roles', [AuthenticationHandler::class,AuthorizationHandler::class,GetRoleHandler::class], 'role.get');
    $app->get('/api/role/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,GetRoleByIdHandler::class], 'role.get-by-id');
    $app->post('/api/create-role', [AuthenticationHandler::class,AuthorizationHandler::class,CreateRoleHandler::class], 'role.create');
    $app->put('/api/update-role/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,UpdateRoleHandler::class], 'role.update');
    $app->delete('/api/delete-role/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,DeleteRoleHandler::class], 'role.delete');

    $app->get('/api/permissions', [AuthenticationHandler::class,AuthorizationHandler::class,GetPermissionHandler::class], 'permission.get');
    $app->get('/api/permission/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,GetPermissionByIdHandler::class], 'permission.get-by-id');
    $app->post('/api/create-permission', [AuthenticationHandler::class,AuthorizationHandler::class,CreatePermissionHandler::class], 'permission.create');
    $app->put('/api/update-permission/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,UpdatePermissionHandler::class], 'permission.update');
    $app->delete('/api/delete-permission/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,DeletePermissionHandler::class], 'permission.delete');

    $app->get('/api/users', [AuthenticationHandler::class,AuthorizationHandler::class,GetUsersHandler::class], 'user.get');
    $app->get('/api/user/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,GetUserByIdHandler::class], 'user.get-by-id');
    $app->post('/api/create-user', [AuthenticationHandler::class,AuthorizationHandler::class,CreateUserHandler::class], 'user.create');
    $app->put('/api/update-user/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,UpdateUserHandler::class], 'user.update');
    $app->delete('/api/delete-user/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,DeleteUserHandler::class], 'user.delete');
    $app->put('/api/change-password-user/{id}', [AuthenticationHandler::class,AuthorizationHandler::class,ChangePasswordHandler::class], 'user.change-password');
};
