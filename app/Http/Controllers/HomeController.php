<?php

namespace Lucid\Http\Controllers;

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
            $ziki = new \Lucid\Core\Document($directory);
            $feed = $ziki->fetchRss();

        return view('home', ['posts' => $feed]);

    }
    public function timeline()
    {
            $directory = storage_path('/contents/');

            $ziki = new \Lucid\Core\Document($directory);
            $post = $ziki->fetchAllRss();
            //$count = new Ziki\Core\Subscribe();
            //$fcount = $count->fcount();
            //$count = $count->count();
//print_r(
  //$post
//);
        return view('timeline', ['posts' => $post]);

    }
}
