<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'demo',
        'password'    => 'demo',
        'dbname'      => 'cp_db_demo',
        'charset'     => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
	    'formsDir' 	     => APP_PATH . '/app/forms/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'baseUri'        => '/Phalcon-CP-Sample/controlpanel/',
	'domain'	 => 'Your Domain',
	'filesPath'	 => 'Your images folder',
	'filesBaseUri'	 => 'Your images URI'
    )
));
