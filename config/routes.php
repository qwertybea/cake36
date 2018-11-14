<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::extensions(['json', 'xml', 'pdf']);

Cake\Core\Configure::write('CakePdf', [
    'engine' => [
        'className' => 'CakePdf.WkHtmlToPdf',
        'binary' => 'C:\\wkhtmltopdf\\bin\\wkhtmltopdf.exe'
    ],
    'margin' => [
        'bottom' => 15,
        'left' => 30,
        'right' => 30,
        'top' => 30
    ],
    'orientation' => 'portrait',
    // 'download' => true
]);
// define('DOMPDF_ENABLE_AUTOLOAD', false);
// define('DOMPDF_ENABLE_HTML5PARSER', true);
// define('DOMPDF_ENABLE_REMOTE', true);

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::prefix('api', function ($routes) {
    $routes->extensions(['json', 'xml']);
    // http://www.bravo-kernel.com/2015/04/how-to-build-a-cakephp-3-rest-api-in-minutes#3-Enable-the-API
    // 3.a) expose one or more controllers
    $routes->resources('Regions');
    $routes->resources('Users');
    Router::connect('/api/users/register', ['controller' => 'Users', 'action' => 'add', 'prefix' => 'api']);
    $routes->fallbacks('InflectedRoute');
});

Router::prefix('Admin', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'myhome', 'home']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login', 'Log in']);
    $routes->connect('/signup', ['controller' => 'Users', 'action' => 'add', 'Sign up']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout', 'Log out']);

    $routes->connect('/admin', ['controller' => 'regions', 'action' => 'index', 'home', 'prefix' => 'admin']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

Plugin::routes();
