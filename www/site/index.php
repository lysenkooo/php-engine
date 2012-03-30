<?php

$config = require('config.php');

define('WWW_DIR', dirname(__FILE__));
define('ROOT_DIR', realpath(WWW_DIR . $config['relative_root']));

set_include_path(ROOT_DIR . PATH_SEPARATOR . WWW_DIR);

require(ROOT_DIR . '/FW/Application.php');

new FW\Application($config);