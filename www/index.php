<?php
// ROOT directory
define('ROOT', dirname(dirname(__FILE__)));

require_once ROOT . '/library/Dispatcher.php';

use \Library\Dispatcher;
\Library\Dispatcher::startup();
