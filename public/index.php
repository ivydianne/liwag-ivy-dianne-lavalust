<?php

define('PREVENT_DIRECT_ACCESS', TRUE);
define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR . 'app' . DIRECTORY_SEPARATOR);
define('SYSTEM_DIR', ROOT_DIR . 'scheme' . DIRECTORY_SEPARATOR);
define('PUBLIC_DIR', ROOT_DIR . 'public' . DIRECTORY_SEPARATOR);
define('RUNTIME_DIR', ROOT_DIR . 'runtime' . DIRECTORY_SEPARATOR);

require_once SYSTEM_DIR . 'kernel/LavaLust.php';
