<?php
$lines = file('storage/logs/laravel.log');
$errors = array_filter($lines, function($l) {
    return strpos($l, 'local.ERROR') !== false;
});
print_r(array_slice($errors, -3));
