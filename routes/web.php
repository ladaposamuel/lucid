<?php
use Illuminate\Http\Request; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});

$directory = "../storage/contents/";
$ziki = new App\Core\Document($directory);
$posts = $ziki->get();
if (empty($posts)) {
    $posts = [];
}
$user = file_get_contents("../app/config/auth.json");
$user = json_decode($user, true);
$username = str_replace(' ', '', $user['name']);
$GLOBALS['username'] = $username;
Route::get('/', function () {
  $directory = "../storage";
        $ziki = new App\Core\Document($directory);
        $feed = $ziki->fetchRss();
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
      //  $host = $user->hash($url);
      $host = "";
        // Render our view
        //print_r($feed);
        $count = new App\Core\Subscribe();
        $setting = new App\Core\Setting();
        $settings = $setting->getSetting();
        $fcount = $count->fcount();
        $count = $count->count();
      //  $rss = SITE_URL.'/'.$GLOBALS['username'];
        $rss = "";
   return View::make('index',['posts' => $feed, 'host' => $host, 'count' => $count, 'fcount' => $fcount, 'rss' => $rss]);
});

foreach ($posts as $post) {
    if (empty($post['post_title'])) {
        Route::get('/post/{post_id}', function (Request $request, $post_id) {

            $directory = "../storage/contents/";
            $ziki = new App\Core\Document($directory);
            $setting = new App\Core\Setting();
            $settings = $setting->getSetting();
            $data = $request->getBody();
            //echo $data;
            $result = $ziki->getEach($post_id);
            $count = new App\Core\Subscribe();
            $fcount = $count->fcount();
            $count = $count->count();
            if (isset($_GET['d'])) {

                $url = isset($_GET['d']) ? $_GET['d'] : '';
                //echo $url;
                $url = isset($_GET['d']) ? trim(base64_decode($_GET['d'])) : "";
                //echo $url;
                $url = $url . "/storage/rss/rss.xml";
                $rss = App\Core\Subscribe::subc($url);
                //echo $url;
            }

            $post_details = $ziki->getPost($post_id);
            $tags = [];
            if (isset($post_details['tags'])) {
                foreach ($post_details['tags'] as $tag) {
                    $tags[] = '#' . $tag;
                }
            }
            $siteUrl = SITE_URL;
            $relatedPosts = $ziki->getRelatedPost(4, $tags, $post_id);
            return View::make('blog-details', ['result' => $result, 'count' => $count, 'fcount' => $fcount, 'post' => $post_details, 'relatedPosts' => $relatedPosts, 'siteUrl' => $siteUrl]);
        });
    } else {
        Route::get('/post/{post_id}/{post_title}', function (Request $request, $post_id) {

            $directory = "../storage/contents/";
            $ziki = new App\Core\Document($directory);
            $setting = new App\Core\Setting();
            $settings = $setting->getSetting();
            $data = $request->getBody();
            //echo $data;
            $result = $ziki->getEach($post_id);
            $count = new App\Core\Subscribe();
            $fcount = $count->fcount();
            $count = $count->count();
            if (isset($_GET['d'])) {

                $url = isset($_GET['d']) ? $_GET['d'] : '';
                //echo $url;
                $url = isset($_GET['d']) ? trim(base64_decode($_GET['d'])) : "";
                //echo $url;
                $url = $url . "/storage/rss/rss.xml";
                $rss = App\Core\Subscribe::subc($url);
                //echo $url;
            }
            $post_id = explode(',', $post_id);
            $post_details = $ziki->getPost($post_id[0]);
            $tags = [];
            if (isset($post_details['tags'])) {
                foreach ($post_details['tags'] as $tag) {
                    $tags[] = '#' . $tag;
                }
            }
            $siteUrl = SITE_URL;
            $relatedPosts = $ziki->getRelatedPost(4, $tags, $post_id[0]);
            return View::make('blog-details', ['result' => $result, 'count' => $count, 'fcount' => $fcount, 'post' => $post_details, 'relatedPosts' => $relatedPosts, 'siteUrl' => $siteUrl]);
        });
    }
}

Route::post('/edit-post', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/contents/";
    $request = $request->getBody();
    $title = isset($request['title']) ? $request['title'] : '';
    $body = $request['postVal'];
    $tags = $request['tags'];
    $postSlug = explode('-', $request['postId']);
    $post_id = end($postSlug);
    // filter out non-image data
    $initial_images = array_filter($request, function ($key) {
        return preg_match('/^img-\w*$/', $key);
    }, ARRAY_FILTER_USE_KEY);
    // PHP automatically converts the '.' of the extension to an underscore
    // undo this

    $images = [];
    foreach ($initial_images as $key => $value) {
        $newKey = preg_replace('/_/', '.', $key);
        $images[$newKey] = $value;
    }
    $extra = "";
    //return json_encode([$images]);
    $ziki = new App\Core\Document($directory);
    $result = $ziki->update_Post($title, $body, $tags, $images, $extra, $post_id);
    return json_encode($result);
});

Route::get('/timeline', function () {
    $user = new App\Core\Auth();
    //if (!$user->is_logged_in() || !$user->is_admin()) {
      //  return $user->redirect('/');
    //}
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $post = $ziki->fetchAllRss();
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    $user = new App\Core\Auth();
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    $host =  $_SERVER['REQUEST_URI'];
    return View::make('timeline', ['posts' => $post, 'count' => $count, 'host' => $host, 'fcount' => $fcount]);
});

Route::get($username, function (Request $request) {

  header('Content-Type: application/xml');
    include '../storage/rss/rss.xml';

});

Route::get('/tags/{id}', function (Request $request, $id) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $result = $ziki->tagPosts($id);
    $twig_vars = ['posts' => $result, 'tag' => $id];
    return View::make('tags', $twig_vars);
});
Route::post('/publish', function () {
  return "string";
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }

    $directory = "../storage/contents/";
    $data = $request->getBody();
    $title = isset($data['title']) ? $data['title'] : '';
    $body = $data['postVal'];
    $tags = $data['tags'];
    // filter out non-image data
    $initial_images = array_filter($data, function ($key) {
        return preg_match('/^img-\w*$/', $key);
    }, ARRAY_FILTER_USE_KEY);
    // PHP automatically converts the '.' of the extension to an underscore
    // undo this
    $images = [];
    foreach ($initial_images as $key => $value) {
        $newKey = preg_replace('/_/', '.', $key);
        $images[$newKey] = $value;
    }
    //return json_encode([$images]);
    $extra = "";
    $ziki = new App\Core\Document($directory);
    $result = $ziki->create($title, $body, $tags, $images, $extra);
    return json_encode($result);
});
//this are some stupid working code written by porh please don't edit
//without notifying me
Route::get('/about', function () {
    include "../app/core/SendMail.php";
    $checkifOwnersMailIsprovided = new  SendContactMail();
    $checkifOwnersMailIsprovided->getOwnerEmail();
    $aboutContent = $checkifOwnersMailIsprovided->getPage();
    $message = [];
    if (empty($checkifOwnersMailIsprovided->getOwnerEmail())) {
        $message['ownerEmailNotProvided'] = true;
    }
    if (isset($_SESSION['messages'])) {
        $message = $_SESSION['messages'];
        unset($_SESSION['messages']);
    }
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('about', ['message' => $message, 'about' => $aboutContent, 'count' => $count, 'fcount' => $fcount]);
});
Route::post('/send', function (Request $request) {
    include "../app/core/SendMail.php";
    $request = $request->getBody();
    $SendMail = new SendContactMail();
    $SendMail->mailBody = View::make('mail-template', ['guestName' => $request['guestName'], 'guestEmail' => $request['guestEmail'], 'guestMsg' => $request['guestMsg']]);
    $response = $SendMail->sendMail($request);

    return json_encode($response);
});
Route::post('/setcontactemail', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    include "../app/core/SendMail.php";
    $request = $request->getBody();
    $SetContactEmail = new SendContactMail();
    $SetContactEmail->setContactEmail($request);
    $SetContactEmail->clientMessage();
    return $SetContactEmail->redirect('/profile');
});
Route::post('/updateabout', function (Request $request) {
    $user = new App\Core\Auth();
    $update = new App\Core\Profile();
    $request = $request->getBody();
    $profile = $update->updateProfile($request);
    $_SESSION['alert']=$profile;
    return $user->redirect('/profile');
});
Route::post('/edit-about', function (Request $request) {
    $request = $request->getBody();
    $page = new App\Core\Page();
    $response = $page->setAboutPage($request);
    return json_encode($response);
});
Route::get('/deletepost/{postId}', function (Request $request, $postId) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $postid = explode('-', $postId);
    $post = end($postid);
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $ziki->deletePost($post);
    return $user->redirect('/published-posts');
});
Route::get('/deletedraft/{postId}', function (Request $request, $postId) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $postid = explode('-', $postId);
    $post = end($postid);
    $directory = "../storage/drafts/";
    $ziki = new App\Core\Document($directory);
    $ziki->deletePost($post);
    return $user->redirect('/drafts');
});
//the stupid codes ends here
Route::get('delete/{id}', function (Request $request, $id) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return new RedirectResponse("/");
    }
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $result = $ziki->delete($id);
    return View::make('timeline', ['delete' => $result]);
});
Route::get('/published-posts', function ($request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $posts = $ziki->get();
    return View::make('published-posts', ['posts' => $posts]);
});

// Kuforiji' codes start here

// Start- Portfolio_expanded page
Route::get('/portfolio-expanded', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('portfolio-expanded');
});
// End- Portfolio_expanded

// logic for creating a new portfolio
Route::post('/newportfolio', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/portfolio/";
    $data = $request->getBody();
    $title = $data['title'];
    $body = $data['postVal'];
    // filter out non-image data
    $initial_images = array_filter($data, function ($key) {
        return preg_match('/^img-\w*$/', $key);
    }, ARRAY_FILTER_USE_KEY);
    // PHP automatically converts the '.' of the extension to an underscore
    // undo this
    $images = [];
    foreach ($initial_images as $key => $value) {
        $newKey = preg_replace('/_/', '.', $key);
        $images[$newKey] = $value;
    }
    //return json_encode([$images]);
    $portfolio = new App\Core\Portfolio($directory);
    $result = $portfolio->createportfolio($title, $body, $images);
    return View::make('portfolio');
});

// route to create-portfolio page
Route::get('/portfolio', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    $directory = "../storage/portfolio/";
    $portfolio = new App\Core\Portfolio($directory);
    $portfolio = $portfolio->getportfolio();
    return View::make('portfolio', ['portf' => $portfolio]);
});

// get portfolio expanded details
Route::get('/portfolio/{post_id}', function (Request $request, $port_id) {

    $directory = "../storage/portfolio/";
    $portfolio = new App\Core\Portfolio($directory);

    //echo $data;
    $result = $portfolio->getEachPortfolio($port_id);
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    if (isset($_GET['d'])) {

        $url = isset($_GET['d']) ? $_GET['d'] : '';
        //echo $url;
        $url = isset($_GET['d']) ? trim(base64_decode($_GET['d'])) : "";
        //echo $url;
        $url = $url . "storage/rss/rss.xml";
        $rss = App\Core\Subscribe::subc($url);
        //echo $url;
    }
    $port_id = explode('-', $port_id);
    $post = end($port_id);
    $portfolio_details = $portfolio->getOnePortfolio($post);

    return View::make('portfolio-expanded', ['result' => $result, 'count' => $count, 'fcount' => $fcount, 'post' => $portfolio_details]);
});

Route::get('/deleteportfolio/{portfolioId}', function (Request $request, $portfolioId) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $portfolioId = explode('-', $portfolioId);
    $portf = end($portfolioId);
    $directory = "../storage/portfolio/";
    $portfolio = new App\Core\Portfolio($directory);
    $portfolio->deletePortfolio($portf);
    return $user->redirect('/portfolio');
});

Route::get('delete/{id}', function ($request, $id) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return new RedirectResponse("/");
    }
    $directory = "../storage/portfolio/";
    $portfolio = new App\Core\Portfolio($directory);
    $result = $portfolio->delete($id);
    return View::make('portfolio', ['delete' => $result]);
});

// Kuforiji' codes end here


// ahmzyjazzy add this (^_^) : setting page
Route::get('/settings', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('settings');
});

// ahmzyjazzy add this (^_^) : setting api
Route::post('/appsetting', function (Request $request) {

    $data = $request->getBody();
    $field = $data['field']; //field to update in  app.json
    $value = $data['value']; //value for setting field in app.json

    $setting = new App\Core\Setting();

    try {
        $result = $setting->updateSetting($field, $value);
        if ($result) {
            echo json_encode(array("msg" => "Setting updated successfully", "status" => "success", "data" => $result));
        } else {
            if ($field === 'THEME') {
                echo json_encode(array("msg" => "Theme does not exist", "status" => "error", "data" => null));
            } else {
                echo json_encode(array("msg" => "Unable to update setting, please try again", "status" => "error", "data" => null));
            }
        }
    } catch (Exception $e) {
        echo json_encode(array("msg" => "Caught exception: ",  $e->getMessage(), "\n", "status" => "error", "data" => null));
    }
});


//profile fullname and short bio update
Route::post('/sidebar ', function (Request $request) {
    include "../app/core/profile.php";
    $user = new App\Core\Auth();
    $instantiateClass = new App\Core\profileUpdate();
    $getUserInfo = $instantiateClass->getPage();
    //  $fullName = $this->fullname;
    //  $shortBio = $this->shortbio;
    //this gets the page content
    //   $getAboutPageContent = $userSiteDetails->getPage();
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    //this for error and successs messages
    $message = [];
    if (isset($_SESSION['messages'])) {
        $message = $_SESSION['messages'];
        unset($_SESSION['messages']);
    }
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();

    return View::make('sidebar', ['fullName' => $getUserInfo, 'shortBio' => $getUserInfo]);
});

// profile page
Route::get('/profile', function (Request $request) {
    ///please don't remove or change the included path
    include "../app/core/SendMail.php";
    //please don't rename the variables
    //$userSiteDetails = new  SendContactMail();
    //this  gets the owners email address
    // $userEmailAddr = $userSiteDetails->getOwnerEmail();
    //this gets the page content
    //$getAboutPageContent = $userSiteDetails->getPage();
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    //this for error and successs messages
    $alert = [];
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('profile',['alert'=>$alert]);
});

// following page
Route::get('/following', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $list = $ziki->subscription();
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();

    return View::make('following', ['sub' => $list, 'count' => $count, 'fcount' => $fcount]);
});

// followers page
Route::get('/followers', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "./storage/contents/";
    $ziki = new App\Core\Document($directory);
    $list = $ziki->subscriber();
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();

    return View::make('followers', ['sub' => $list, 'count' => $count, 'fcount' => $fcount]);
});

// Subscription page
Route::post('/subscriptions', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $list = $ziki->subscription();

    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();


    return View::make('subscriptions', ['sub' => $list, 'count' => $count, 'fcount' => $fcount]);
});

// Subscribers page
Route::get('/subscribers', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $list = $ziki->subscriber();
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();

    return View::make('subscribers', ['sub' => $list, 'count' => $count, 'fcount' => $fcount]);
});
Route::get('/unsubscribe', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }

    $id = $_GET['n'];
    $ziki = new App\Core\Subscribe();
    $list = $ziki->unfollow($id);
    return $user->redirect('/subscriptions');
});

//stupid code by problemSolved

foreach ($posts as $post) {
    if (empty($post['post_title'])) {
        Route::get('/editor/{post_id}', function (Request $request, $post_id) {
            $user = new App\Core\Auth();
            if (!$user->is_logged_in() || !$user->is_admin()) {
                return $user->redirect('/');
            }
            $directory = "../storage/contents/";
            $ziki = new App\Core\Document($directory);
            $post_details = $ziki->getPost($post_id);
            return View::make('editor', ['post' => $post_details]);
        });
    } else {
        Route::get('/editor/{post_id}/{post_title}', function ($request, $post_id) {
            $user = new App\Core\Auth();
            if (!$user->is_logged_in() || !$user->is_admin()) {
                return $user->redirect('/');
            }
            $directory = "../storage/contents/";
            $ziki = new App\Core\Document($directory);
            $getId = explode(',', $post_id);
            $post_details = $ziki->getPost($getId[0]);
            return View::make('editor', ['post' => $post_details]);
        });
    }
}


//ends here again;
// 404 page
Route::get('/404', function (Request $request) {
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('404', ['count' => $count, 'fcount' => $fcount]);
});

//blog-details
Route::get('/blog-details', function (Request $request) {
    $setting = new App\Core\Setting();
    $settings = $setting->getSetting();
    return View::make('blog-details', $settings);
});

// Start- followers page

Route::get('/followers', function (Request $request) {

    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('followers',  ['count' => $count, 'fcount' => $fcount]);
});
// End- followers page

// Start- following page

Route::get('/following', function (Request $request) {

    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/contents/";
    $ziki = new App\Core\Document($directory);
    $list = $ziki->subscription();
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('following', ['sub' => $list, 'count' => $count, 'fcount' => $fcount]);
});
// End- following page


/* Devmohy working on draft */
/* Save draft*/
Route::post('/saveDraft', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/drafts/";
    $data = $request->getBody();
    $title = isset($data['title']) ? $data['title'] : '';
    $body = $data['postVal'];
    $tags = $data['tags'];
    $initial_images = array_filter($data, function ($key) {
        return preg_match('/^img-\w*$/', $key);
    }, ARRAY_FILTER_USE_KEY);
    // PHP automatically converts the '.' of the extension to an underscore
    // undo this
    $images = [];
    foreach ($initial_images as $key => $value) {
        $newKey = preg_replace('/_/', '.', $key);
        $images[$newKey] = $value;
    }
    $ziki = new App\Core\Document($directory);
    $result = $ziki->create($title, $body, $tags, $images, true);
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return json_encode($result);
});

/* Save draft */
/* Get all saved draft */
Route::get('/drafts', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "../storage/drafts/";
    $ziki = new App\Core\Document($directory);
    $draft = $ziki->get();
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('drafts', ['drafts' => $draft]);
});

//videos page
Route::get('/videos', function (Request $request) {

    $directory = "../storage/videos/";
    $ziki = new App\Core\Document($directory);
    $Videos = $ziki->getVideo();
    //print_r($Videos);
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('videos', ['videos' => $Videos, 'count' => $count, 'fcount' => $fcount]);
});
Route::get('/microblog', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    //print_r($Videos);
    $count = new App\Core\Subscribe();
    $fcount = $count->fcount();
    $count = $count->count();
    return View::make('microblog',  ['count' => $count, 'fcount' => $fcount]);
});



// Route::get('/about', function ($request) {
//     return View::make('about-us');
// });

//download page
Route::get('/download', function (Request $request) {
    return View::make('download');
});

Route::get('/auth/{provider}/{token}', function (Request $request, $token) {
    $user = new App\Core\Auth();
    $check = $user->validateAuth($token);
    if ($_SESSION['login_user']['role'] == 'guest') {
        return $user->redirect('/');
    } else {
        return $user->redirect('/timeline');
    }
});

Route::get('/setup/{provider}/{token}', function (Request $request, $token) {
    $user = new App\Core\Auth();
    $check = $user->validateAuth($token);
    if ($_SESSION['login_user']['role'] == 'guest') {
        return $user->redirect('/');
    } else {
        return $user->redirect('/profile');
    }
});

Route::get('/logout', function (Request $request) {
    $user = new App\Core\Auth();
    $user->log_out();
    return $user->redirect('/');
});
Route::get('/api/images', function () {
    return (new App\Core\UploadImage)->getAllImages();
});
Route::post('/api/upload-image', function () {
    return (new App\Core\UploadImage)->upload();
});

Route::post('/setup', function ($request) {
    $data = $request->getBody();
    $user = new App\Core\Auth();
    $setup = $user->setup($data);
    if ($setup == true) {
        return $user->redirect('/timeline');
    } else {
        return $user->redirect('/install');
    }
});

Route::post('/setup/email/login/{address}', function (Request $request) {
    $user = new App\Core\Auth();
    die("good");
});

Route::get('/install', function (Request $request) {
    $user = new App\Core\Auth();
    $system = new App\Core\System();
    if ($user::isInstalled() == false) {
        return $user->redirect('/');
    } else {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $host = $user->hash($url);
        $checks = $system->checkSystem();
        if ($checks) {
            return $this->installer->render('install', ['host' => $host, 'domain' => $url]);
        } else {
            die(json_encode($checks));
        }
    }
});

Route::post('/addrss', function (Request $request) {
    $r = new App\Core\Auth();
    $data = $request->getBody();
    $url = $_POST['domain'];
    $ziki = new App\Core\Subscribe();
    $result = $ziki->extract($url);
    return $r->redirect('/subscriptions');
});

/* Add Video*/
Route::post('/addvideo', function (Request $request) {
    $user = new App\Core\Auth();
    if (!$user->is_logged_in() || !$user->is_admin()) {
        return $user->redirect('/');
    }
    $directory = "./storage/videos/";
    $data = $request->getBody();

    //Get youtube url id for embed
    parse_str(parse_url($data['domain'], PHP_URL_QUERY), $YouTubeId);
    $video_url = "https://www.youtube.com/embed/" . $YouTubeId['v'];
    $video_title = $data['title'];
    $video_about = $data['description'];
    $ziki = new App\Core\Document($directory);
    $ziki->addVideo($video_url, $video_title, $video_about);
    return $user->redirect('/videos');
});
