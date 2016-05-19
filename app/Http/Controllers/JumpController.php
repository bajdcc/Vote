<?php

namespace App\Http\Controllers;

use App\Http\Requests;

/**
 * Class JumpController
 * @Middleware("jump")
 * @Controller(prefix="/jump", as="service.jump")
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
        $this->middleware('jump');
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
