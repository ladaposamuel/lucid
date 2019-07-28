<?php

namespace Lucid\Http\Controllers;

use Illuminate\Http\Request;
use Lucid\ext_rss;
use Auth;
class ExtRssController extends Controller
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
  public function addRss(Request $request)
  {
    $user = Auth::user();
    $username = $user->username;
    $rss = $request->rss;
  //dd($rss);
  //$url = "https://www.feedforall.com//sample-feed.xml";
    $data = new \Lucid\Core\Subscribe();
          $feed = $data->extract($rss);
          // print_r($feed);

     return redirect($username.'/')->with('rss', 'You have subscribed to '.$request.' channel' );

  }
  public function addExtRss(Request $request)
  {
    $user = Auth::user();
    $username = $user->username;
    $rss = $request->rss;
  //dd($rss);
  //$url = "https://www.feedforall.com//sample-feed.xml";
    $data = new \Lucid\Core\Subscribe();
          $feed = $data->extractPub($rss);
          print_r($feed);

     return redirect($username.'/microblog')->with('rss', 'You have subscribed to '.$request.' channel' );

  }
}
