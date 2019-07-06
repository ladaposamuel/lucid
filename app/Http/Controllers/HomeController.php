<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $directory = storage_path('/contents/');
            $ziki = new \App\Core\Document($directory);
            $feed = $ziki->fetchRss();

        return view('home', ['posts' => $feed]);
    }
}
