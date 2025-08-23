<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-logs', function () {

    \Log::info('Test Logs', [
        'user_id' => 1,
        'data'    => [
            'name' => 'ZZZZZZZZZZZZZZZ',
            'age'  => 25,
        ],
    ]);

    return 'Test logs stored';
});
