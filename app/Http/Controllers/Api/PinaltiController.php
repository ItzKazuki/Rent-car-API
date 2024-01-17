<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PinaltiController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }
}
