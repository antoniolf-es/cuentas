<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/lib/Env.php';
Env::load(ROOT_PATH . '/.env');

$config = require ROOT_PATH . '/config/app.php';

require ROOT_PATH . '/lib/helpers.php';

define('APP_ENV', $config['env']);
define('BASE_URL', $config['base_url'] !== '' ? rtrim($config['base_url'], '/') : detect_base_url());

date_default_timezone_set($config['timezone']);

if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', '0');
}

require ROOT_PATH . '/lib/Database.php';
require ROOT_PATH . '/lib/Session.php';
require ROOT_PATH . '/lib/View.php';
require ROOT_PATH . '/lib/Router.php';

spl_autoload_register(static function (string $class): void {
    foreach (['models', 'controllers', 'lib'] as $dir) {
        $file = ROOT_PATH . '/' . $dir . '/' . $class . '.php';

        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

Session::start();
View::init($config['views_path']);
