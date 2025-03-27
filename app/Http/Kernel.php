<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckEditor;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'admin' => CheckAdmin::class,
        'editor' => CheckEditor::class,
    ];
}