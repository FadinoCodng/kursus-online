<?php

// Pastikan direktori writable untuk cache Blade & Session di serverless Vercel
$storageDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Salin database SQLite yang sudah di-migrate dan di-seed ke /tmp
$tmpDb = '/tmp/database.sqlite';
$sourceDb = __DIR__ . '/../database/database.sqlite';

if (!file_exists($tmpDb) || filesize($tmpDb) === 0) {
    if (file_exists($sourceDb) && filesize($sourceDb) > 0) {
        copy($sourceDb, $tmpDb);
    } else {
        touch($tmpDb);
    }
}

putenv("DB_DATABASE={$tmpDb}");
$_ENV['DB_DATABASE'] = $tmpDb;
$_SERVER['DB_DATABASE'] = $tmpDb;

// Jalankan Laravel
require __DIR__ . '/../public/index.php';
