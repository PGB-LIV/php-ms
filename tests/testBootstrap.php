<?php
/**
 * Copyright (c) University of Liverpool. All rights reserved.
 * @author Andrew Collins
 */
$envTestConf = getenv('PHPUNIT_MASCOT_PATH');

if (file_exists('tests/config.php')) {
    require_once 'config.php';
} elseif ($envTestConf !== false && file_exists($envTestConf)) {
    require_once $envTestConf;
} else {
    var_dump($envTestConf);
    die('ERROR: Tests config missing');
}