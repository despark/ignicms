<?php

namespace Despark\Http\Controllers;

use Illuminate\Http\Request;

use Despark\Http\Requests;
use Despark\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }
}
