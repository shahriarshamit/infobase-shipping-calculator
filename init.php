<?php

define('URL', 'http://shipping-calculator.test/');
define('ASSETS', URL . 'assets/');
define('CSS', ASSETS . 'css/');
define('JS', ASSETS . 'js/');
define('FONTS', ASSETS . 'fonts/');
define('IMAGES', ASSETS . 'images/');
define('ICONS', ASSETS . 'icons/');

define('PATH', __DIR__ . '/');
define('LIBRARY', PATH . 'library/');

require LIBRARY . 'config.php';
require LIBRARY . 'functions.php';
require LIBRARY . 'auth.php';
require LIBRARY . 'fedex.php';
require LIBRARY . 'ups.php';
require LIBRARY . 'ems.php';
