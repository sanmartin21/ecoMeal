<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/routes.php';
require __DIR__ . '/config.php';

$sContent = render(
    $_GET['pg'] ??= 'home'
);

echo $sContent;
