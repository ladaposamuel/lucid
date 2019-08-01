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
    $data = new \Lucid\Core\Subscribe($username);
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
    $data = new \Lucid\Core\Subscribe($username);
          $feed = $data->extractPub($rss);
          print_r($feed);

     return redirect($username.'/microblog')->with('rss', 'You have subscribed to '.$request.' channel' );

  }
  public function unfollow(Request $request)
  {
    $user = Auth::user();
    $username = $user->username;
    $rss = $request->rss;
  //dd($rss);
  //$url = "https://www.feedforall.com//sample-feed.xml";
    $data = new \Lucid\Core\Subscribe($username);
          $feed = $data->unfollow($rss);
          if ($feed == 1) {
            return redirect($username)->with('UnFollow', 'You have successfully unfollowed '.$request);
          }else {
            return redirect($username)->with('UnFollow', 'there was an error unfollowing '.$request);

          }

  //   return redirect($username.'/microblog')->with('rss', 'You have subscribed to '.$request.' channel' );

  }
}
