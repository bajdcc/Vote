<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @Common
 * @Controller(prefix="/")
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     * @Get("/", as="home")
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
