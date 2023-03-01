<?php

define('URL', 'http://infobasehost.com/shipping-calculator/');
define('ASSETS', URL . 'assets/');
define('CSS', ASSETS . 'css/');
define('JS', ASSETS . 'js/');
define('FONTS', ASSETS . 'fonts/');
define('IMGS', ASSETS . 'images/');

define('PATH', __DIR__ . '/');
define('LIBRARY', PATH . 'library/');

require LIBRARY . 'config.php';
require LIBRARY . 'functions.php';
require LIBRARY . 'auth.php';
require LIBRARY . 'fedex.php';
require LIBRARY . 'ups.php';
require LIBRARY . 'ems.php';
