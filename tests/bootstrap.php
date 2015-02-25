<?php
/*
 * This file is part of the DateTime2 package.
 *
 * (c) Vladimir Khramov <quant13@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('Quantum13\\', __DIR__.'/Quantum13');
date_default_timezone_set('UTC');