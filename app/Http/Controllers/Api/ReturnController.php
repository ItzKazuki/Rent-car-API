<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }
}
