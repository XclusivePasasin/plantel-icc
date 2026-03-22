<?php

$host = '127.0.0.1';
$port = '3307';
$db   = 'plantel_unilever';
$user = 'plantel_unilever';
$pass = 'hd1dNDMbNZ0jKHfI';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt2 = $pdo->query("SELECT id, num_id, recepcion_retorno_json FROM packings ORDER BY updated_at DESC LIMIT 5");
    $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($rows as $row) {
        echo "ID: " . $row['id'] . " | num_id: " . $row['num_id'] . "\n";
        echo "  RAW VALUE: " . $row['recepcion_retorno_json'] . "\n";
        $decoded = json_decode($row['recepcion_retorno_json'], true);
        echo "  DECODED (PHP): ";
        print_r($decoded);
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
