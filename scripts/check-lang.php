<?php

$dirs = [
    __DIR__ . '/../lang/es',
    __DIR__ . '/../resources/lang/es',
    __DIR__ . '/../lang/vendor',
    __DIR__ . '/../lang/vendor/livewire-tables',
];


foreach ($dirs as $dir) {
    if (!is_dir($dir)) continue;
    echo "\n🔍 Revisando: {$dir}\n";
    foreach (glob($dir . '/**/*.php') as $file) {
        try {
            $value = require $file;
            if (!is_array($value)) {
                echo "❌ {$file} -> NO retorna array (".gettype($value).")\n";
            } else {
                echo "✅ {$file}\n";
            }
        } catch (Throwable $e) {
            echo "💥 {$file} -> ".$e->getMessage()."\n";
        }
    }
}
