<?php
function getEnvVariable($key) {
    $lines = file(__DIR__ . '/config.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        list($envKey, $envValue) = explode('=', $line, 2);
        if ($envKey === $key) {
            return trim($envValue);
        }
    }
    return null;
}

// Contoh cara mengambil key
$MIDTRANS_SERVER_KEY = getEnvVariable('MIDTRANS_SERVER_KEY');
$MIDTRANS_CLIENT_KEY = getEnvVariable('MIDTRANS_CLIENT_KEY');
?>
