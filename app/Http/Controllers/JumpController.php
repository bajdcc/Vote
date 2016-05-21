<?php

namespace App\Http\Controllers;

use App\Http\Requests;

/**
 * Class JumpController
 * @Controller(prefix="/jump", as="service.jump")
 * @Middleware("jump")
 * @package App\Http\Controllers
 */
class JumpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     * @Get("/", as="service.jump.index")
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jump.index');
    }
}
