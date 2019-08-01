<?php
namespace Lucid\Core;
use Auth;
use Storage;
use Lucid\ext_rss;
use DB;

/**
 *
 */
class Subscribe
{
  var $name;
  var $rss;
  var $img;
  var $desc;
  var $link;

  protected $user;

  public function __construct($user)
  {

      $this->user  = $user;
  }

  public function file()
  {
      return $this->file;
  }


  public function setSubName($value)
  {
    $this->name = $value;
  }
  public function setSubRss($value)
  {
    $this->rss = $value;
  }
  public function setSubDesc($value)
  {
    $this->desc = $value;
  }
  public function setSubLink($value)
  {
    $this->link = $value;
  }
  public function setSubImg($value)
  {
    $this->img = $value;
  }
public function extract($url)
{
  $rss = new \DOMDocument();
//dd(storage_path('app/'.$url."/rss/rss.xml"));
  if (!file_exists(storage_path('app/'.$url."/rss/rss.xml"))) {
      } else {

        //$url = storage_path('app/'.$url."/rss/rss.xml");

      $rss->load(trim(storage_path('app/'.$url."/rss/rss.xml")));
     //   dd($rss );
      foreach ($rss->getElementsByTagName('channel') as $r) {
        $title = $r->getElementsByTagName('title')->item(0)->nodeValue;
        $link = $r->getElementsByTagName('link')->item(0)->nodeValue;
        $description = $r->getElementsByTagName('description')->item(0)->nodeValue;

        $image = isset($r->getElementsByTagName('url')->item(0)->nodeValue) ?
                  $r->getElementsByTagName('url')->item(0)->nodeValue : '';

        $lastbuild = $r->getElementsByTagName('lastBuildDate')->item(0)->nodeValue;


      }

              $this->setSubName($title);
              $this->setSubRss($url);
              $this->setSubDesc($description);
              $this->setSubImg($image);
              $this->setSubLink($link);

                $this->findOrCreateRss(
                  $this->name,
                  storage_path('app/'.$url."/rss/rss.xml"),
                  $this->desc,
                  $this->link,
                  $this->img,
                  $lastbuild

                );

              }
  }

  public function extractPub($url)
  {
    $rss = new \DOMDocument();

    //if (!$url = file_get_contents($url)) {
    //  return false;
      //  } else {

          //$url = storage_path('app/'.$url."/rss/rss.xml");

        echo ($url);
        $rss->load(trim($url));
        foreach ($rss->getElementsByTagName('channel') as $r) {
          $title = $r->getElementsByTagName('title')->item(0)->nodeValue;

          $link = $r->getElementsByTagName('link')->item(0)->nodeValue;
          $description = $r->getElementsByTagName('description')->item(0)->nodeValue;

          $image = isset($r->getElementsByTagName('url')->item(0)->nodeValue) ?
                    $r->getElementsByTagName('url')->item(0)->nodeValue : '';

          $lastbuild =isset( $r->getElementsByTagName('lastBuildDate')->item(0)->nodeValue ) ?
                        $r->getElementsByTagName('lastBuildDate')->item(0)->nodeValue : '';


        }

                $this->setSubName($title);
                $this->setSubRss($url);
                $this->setSubDesc($description);
                $this->setSubImg($image);
                $this->setSubLink($link);

                  $this->findOrCreateRss(
                    $this->name,
                    $url,
                    $this->desc,
                    $this->link,
                    $this->img,
                    $lastbuild

                  );

              //  }
    }

  public function findOrCreateRss($name, $url, $desc, $link, $img,$lastbuild){
      //$rss       =   ext_rss::where('title', $name)->first();
     // if($rss){
    //      return $rss;
     // }
      $user = Auth::user();

          return ext_rss::insert([
              'user_id'          => $user['id'],
              'title'            => $name,
              'url'              => $url,
              'description'      => $desc,
              'image'            => $img,
              'link'             => $link,
              'lastBuildDate'    => $lastbuild
          ]);

          return $rss;
  }



  public function subc($url)
  {
    $rss = new \DOMDocument();


        $rss->load(trim($url));
        foreach ($rss->getElementsByTagName('channel') as $r) {
          $title = $r->getElementsByTagName('title')->item(0)->nodeValue;
          $link = $r->getElementsByTagName('link')->item(0)->nodeValue;
          $description = $r->getElementsByTagName('description')->item(0)->nodeValue;
          if (is_null($r->getElementsByTagName('image')->item(0)->nodeValue)) {
          $image ="resources/themes/ghost/assets/img/bubbles.png";
        }else {
          $image = $r->getElementsByTagName('url')->item(0)->nodeValue;

        }

        }


                $db = "storage/rss/subscriber.json";

                $file = FileSystem::read($db);
                $data=json_decode($file, true);
                unset($file);

                if (count($data) >= 1) {

                foreach ($data as $key => $value) {
                   if ($value["name"] == $title) {

                     $message= "false";

                     break;
                   }else {
                     $message= "true";

                   }


                }
                if ($message == "true") {

                //  $db_json = file_get_contents("storage/rss/subscriber.json");

                  $time = date("Y-m-d h:i:sa");
                    $img = $image;
                    $sub[] = array('name'=> $title, 'rss'=>$url,'desc'=>$description, 'link'=>$link, 'img'=> $image, 'time' => $time);

                    $json_db = "storage/rss/subscriber.json";
                    $file = file_get_contents($db);
                    $prev_sub = json_decode($file);
                    $new =array_merge($sub, $prev_sub);
                    $new = json_encode($new);
                    $doc = FileSystem::write($json_db, $new);
  }
                }else {
                $time = date("Y-m-d h:i:sa");
                $img = $image;
                $sub[] = array('name'=> $title, 'rss'=>$url,'desc'=>$description, 'link'=>$link, 'img'=> $image, 'time' => $time);

                $json_db = "storage/rss/subscriber.json";
                $file = file_get_contents($db);
                $prev_sub = json_decode($file);

                $new = array_merge($sub, $prev_sub);
                $new = json_encode($new);
                $doc = FileSystem::write($json_db, $new);


            }
            //header("loaction: /subscriptions");
    }
  public function unfollow($del)
  {
    $user = Auth::user();

//$file= ext_rss::select('select * from users where user_id = :user_id and title = :title', [
//  "user_id" => $user->id,
  //"title" => $del]);

  $file= DB::table('ext_rsses')->where('user_id', $user->id)->where('title', $del)->delete();

return $file;

  }
  public function count()
  {

    $user= DB::table('users')->where('username', $this->user)->get();

    foreach($user as $key => $user){

  $file= ext_rss::where('title', $user->name)->get();
}
    $data=json_decode($file,true);
    if(!empty($data)){
      unset($file);
      return $data;
    }
  }
  public function fcount()
  {
  //  $user = Auth::user();
      $user= DB::table('users')->where('username', $this->user)->get();
      //extract();
      foreach($user as $key => $user){

    $file= ext_rss::where('user_id', $user->id)->get();
}
    $data=json_decode($file,true);

    if(!empty($data)){
      unset($file);
      return count($data);

    }


  }
}
