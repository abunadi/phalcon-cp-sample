<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Session as SessionMetaData;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger\Adapter\File as FileAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();
$di->setInternalEventsManager(new EventsManager);

/**
 * We register the events manager
 */
$di->set('dispatcher', function () use ($di) {
    /**
     * Check if the user is allowed to access certain action using the SecurityPlugin
     */
    $di->getInternalEventsManager()->attach('dispatch:beforeDispatch', new SecurityPlugin);
    /**
     * Handle exceptions and not-found exceptions using NotFoundPlugin
     */
    $di->getInternalEventsManager()->attach('dispatch:beforeException', new NotFoundPlugin);
    $dispatcher = new Dispatcher;
    $dispatcher->setEventsManager($di->getInternalEventsManager());
    return $dispatcher;
});


/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt'  => function ($view, $di) use ($config) {
            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath'      => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));
            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($config, $di) {
    $di->getInternalEventsManager()->attach('db', new DBListener());
    $dbConfig = $config->database->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;
    $conn = new $class($dbConfig);
    $conn->setEventsManager($di->getInternalEventsManager());
    return $conn;
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    $metaData = new SessionMetaData(array("prefix" => "cp_cache"));
    return $metaData;
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
});

// Register the flash service with custom CSS classes
$di->set('flash', function () {
    $flash = new FlashDirect(
        array(
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice'  => 'alert alert-info',
            'warning' => 'alert alert-warning'
        )
    );
    return $flash;
});

// Register the config servise
$di->set('config', function () use ($config) {
    return $config;
}, true);

// Register the logging servise
$di->setShared('logger', function () {
    return new Logs(array('db' => APP_PATH . '/app/logs/db.log', 'cp' => APP_PATH . '/app/logs/controlpanel.log'));
});
