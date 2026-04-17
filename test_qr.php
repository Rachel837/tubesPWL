<?php
require 'vendor/autoload.php';
use SimpleSoftwareIO\QrCode\Facades\QrCode;

try {
    $data = QrCode::format('png')->size(300)->generate('test');
    echo "Success: PNG generated";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
