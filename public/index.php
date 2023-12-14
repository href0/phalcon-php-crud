<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager as EventsManager;
error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    // Setup events manager
    $eventsManager = new EventsManager();
    
    // Tambahkan handler untuk event beforeHandleRequest
    $eventsManager->attach(
        'application:beforeHandleRequest',
        function ($event, $application) {
            // Lakukan logika middleware Cors di sini
            $request = $application->request;
            $response = $application->response;
            
            if ($request->getMethod() == 'OPTIONS') {
             
                $response->setHeader('Access-Control-Allow-Origin', '*');
                $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
                $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
                $response->send();
                return false; // Stop further handling of the request
            }
            $response = $application->response;
            // $response->setHeader('Access-Control-Allow-Origin', '*');
            // $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            // $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
    );
    $application->setEventsManager($eventsManager);
    
    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
