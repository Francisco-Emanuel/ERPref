<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var \Illuminate\Foundation\Auth\Access\AuthorizesRequests
     * @var \Illuminate\Foundation\Validation\ValidatesRequests
     */

    // A linha abaixo é a que importa. Ela "injeta" a funcionalidade de autorização.
    use AuthorizesRequests, ValidatesRequests;
}