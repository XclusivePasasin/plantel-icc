<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
use Illuminate\Support\Facades\DB;
$columns = DB::select('SHOW COLUMNS FROM materials');
foreach ($columns as $c) {
    if ($c->Field == 'entrega_duplicada1') {
        echo "YES - column exists\n";
    }
}
