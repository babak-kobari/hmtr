<?php

// Define path to application directory

defined('APPLICATION_PATH') || 
        define('APPLICATION_PATH', 
                realpath(dirname(__FILE__) . '/../application'));

defined('IMAGE_PATH') ||
       ( define('IMAGE_PATH',
        $_SERVER['DOCUMENT_ROOT']."/uploads"));
        
        // Define application environment
defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Define path to public directory
defined('PUBLIC_PATH') || define('PUBLIC_PATH', dirname(__FILE__));

// Define short alias for DIRECTORY_SEPARATOR
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

// Define short alias for DIRECTORY_SEPARATOR
defined('START_TIMER') || define('START_TIMER', microtime(true));

// Ensure library/ is on include_path
set_include_path(
    implode(PATH_SEPARATOR,
            array(realpath(APPLICATION_PATH . '/../library'),
            get_include_path(),)));

register_shutdown_function('errorHandler');

function errorHandler() 
{
    $error = error_get_last();
    if (!is_array($error)
            || !in_array($error['type'], array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR))) 
    {
        return;
    }
    include_once 'error.php';
}
    


require_once 'Zend/Application.php';
try {
    $config = APPLICATION_PATH . '/configs/application.yaml';

        require_once 'Zend/Config/Yaml.php';
        require_once 'Core/Config/Yaml.php';
        $result = new Core_Config_Yaml($config, APPLICATION_ENV);
        $result = $result->toArray();
        $config = $result;
        // Create application, bootstrap, and run
        $application = new Zend_Application(
            APPLICATION_ENV,
            $config
    );

    $application->bootstrap()
    ->run();
} catch (Exception $exception) {
    include_once 'error.php';
}
