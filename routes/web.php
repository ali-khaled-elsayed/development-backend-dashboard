<?php

use Illuminate\Support\Facades\Route;

// Route::get('/{any}', function () {
//     return view('index');
// })->where('any', '^(?!api)(.*)$');

Route::prefix('api')->group(base_path('routes/api.php'));

Route::view('/{any}', 'index')
    ->where('any', '^(?!api|admin|filament|login|logout|register|storage/).*$');
