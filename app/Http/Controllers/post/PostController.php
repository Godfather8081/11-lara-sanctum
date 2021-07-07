<?php

namespace App\Http\Controllers\post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function index()
    {
        return 'index hit';
    }

    public function store()
    {
        return 'store hit';
    }
}
