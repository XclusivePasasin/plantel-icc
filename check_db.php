<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
if (Schema::hasColumn('packings', 'recepcion_retorno_json')) {
    echo "COLUMN_EXISTS";
} else {
    echo "COLUMN_MISSING";
}
