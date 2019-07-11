<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Lucid\ext_rss;
class ExtRssController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function add()
  {

  //  $url = $_POST['domain'];
  $url = "https://www.feedforall.com//sample-feed.xml";
    $data = new \Lucid\Core\Subscribe();
          $feed = $data->extract($url);
          print_r($feed);

    //  return view('home', ['posts' => $feed]);

  }
}
