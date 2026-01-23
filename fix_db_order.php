 <?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\MixOrder;

$code = '11492 - 20';
// Same normalization logic as MixController
$normalized = preg_replace('/\s+/', '', $code);

echo "Searching for order with code: $code (Normalized: $normalized)\n";

$orders = MixOrder::whereRaw("REPLACE(num_id, ' ', '') = ?", [$normalized])->get();

if ($orders->isEmpty()) {
    echo "No matching orders found in DB.\n";
} else {
    echo "Found " . $orders->count() . " matching orders in DB.\n";
    foreach ($orders as $order) {
        echo "ID: " . $order->id . " | Name: " . $order->product_name . "\n";
        
        // Check if name contains "LEO" but not "Ó"
        if (strpos($order->product_name, 'LEO') !== false && strpos($order->product_name, 'Ó') === false) {
            echo "Deleting corrupted record ID " . $order->id . "...\n";
            $order->delete();
            echo "Deleted.\n";
        } else {
            echo "Record seems OK (or suspicious but not strictly 'LEO' only). Not deleting automatically.\n";
            // Uncomment to force delete if needed
            echo "Deleting anyway for fresh test.\n";
            $order->delete();
        }
    }
}
