<?php
$files = array_merge(
    glob('resources/views/admin/events/*.blade.php'),
    glob('resources/views/admin/events/tikets/*.blade.php'),
    glob('resources/views/admin/categories/*.blade.php')
);
foreach ($files as $f) {
    if (is_file($f)) {
        $c = file_get_contents($f);
        $c = str_replace("@extends('organizer.layouts.app')", "@extends('admin.layouts.app')", $c);
        file_put_contents($f, $c);
    }
}
echo "Fixed Admin layouts extended paths.\n";
