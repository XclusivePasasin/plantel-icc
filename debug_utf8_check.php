<?php
// Script to debug specific byte sequence for MZ DOVE SH ...
$url = 'https://data.industriascuscatlan.com:7322/wsPlantel/mezcla.php';
$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);
echo "Downloading...\n";
$body = file_get_contents($url, false, $context);

if ($body === false) {
    die("Error fetching URL.\n");
}

echo "Total bytes: " . strlen($body) . "\n";

$search = "MZ DOVE SH";
$pos = strpos($body, $search);

if ($pos === false) {
    die("String '$search' NOT FOUND.\n");
}

echo "Found '$search' at position $pos.\n";

// Get a chunk of 40 bytes starting from found position
// Expecting: MZ DOVE SH ÓLEO...
$length = 40;
$chunk = substr($body, $pos, $length);

echo "Chunk (hex):\n";
for ($i = 0; $i < strlen($chunk); $i++) {
    $byte = ord($chunk[$i]);
    printf("%02X ", $byte);
}
echo "\n";

echo "Chunk (chars):\n";
for ($i = 0; $i < strlen($chunk); $i++) {
    $byte = ord($chunk[$i]);
    if ($byte >= 32 && $byte <= 126) {
        echo $chunk[$i] . "  ";
    } else {
        echo ".  ";
    }
}
echo "\n";

// Specific check for byte D3 (Ó in ISO-8859-1) or C3 93 (Ó in UTF-8)
if (strpos($chunk, "\xD3") !== false) {
    echo "DETECTED LATIN-1 'Ó' (0xD3)!\n";
} elseif (strpos($chunk, "\xC3\x93") !== false) {
    echo "DETECTED UTF-8 'Ó' (0xC3 0x93)!\n";
} else {
    echo "NO 'Ó' DETECTED in the chunk.\n";
}
