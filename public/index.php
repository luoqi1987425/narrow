<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

define('APPLICATION_PUBLIC_PATH', realpath(dirname(__FILE__) ) );  
    
// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

    
define('DS', DIRECTORY_SEPARATOR);

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/library'),
    get_include_path(),
)));

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('WeFlex');
$autoloader->registerNamespace('Narrow');
$autoloader->registerNamespace('Zend');




/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

/**
 * application bootstrap;
 */
$application->bootstrap();

/**
 * WeFlex Start
 */
WeFlex_Application::GetInstance()->start( APPLICATION_ENV , APPLICATION_PATH . '/configs/sms.ini' );

/**
 * Narrow Init
 */
Narrow::GetInstance()->init();

/**
 * application run
 */
$application->run();