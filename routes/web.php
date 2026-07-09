<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/robots.txt', function () {
    return response(
        "User-agent: *\nAllow: /\n\nSitemap: ".config('app.url')."/sitemap.xml\n",
        200,
        ['Content-Type' => 'text/plain']
    );
});

Route::get('/sitemap.xml', function () {
    $base = config('app.url');
    $lastmod = now()->toDateString();

    $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{$base}/</loc>
        <lastmod>{$lastmod}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{$base}/login</loc>
        <lastmod>{$lastmod}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{$base}/register</loc>
        <lastmod>{$lastmod}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
</urlset>
XML;

    return response($xml, 200, ['Content-Type' => 'application/xml']);
});

Route::redirect('/dashboard', '/todos');

Route::view('todos', 'todos.index')
    ->middleware(['auth'])
    ->name('todos');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
