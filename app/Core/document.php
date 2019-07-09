<?php
namespace Lucid\Core;

use Parsedown;
use Mni\FrontYAML\Parser;
use KzykHys\FrontMatter\FrontMatter;
use Symfony\Component\Finder\Finder;
use KzykHys\FrontMatter\Document as Doc;
use Auth;
/**
 *	The Document class holds all properties and methods of a single page document.
 *
 */

class Document
{
    //define an instance of the symfony clss
    //define an instance of the frontMatter class

    protected $file;

    public function __construct($file)
    {
        FileSystem::makeDir($file);
        $this->file   = $file;
    }

    public function file()
    {
        return $this->file;
    }

    //for creating markdown files
    //kjarts code here
    public function create($title, $content, $tags, $image, $extra)
    {
        date_default_timezone_set("Africa/Lagos");
        $time = date(DATE_RSS, time());
        $unix = strtotime($time);
        // Write md file
        $document = FrontMatter::parse($content);
        $md = new Parser();
        $markdown = $md->parse($document);

        $yaml = $markdown->getYAML();
        $html = $markdown->getContent();
        //$doc = FileSystem::write($this->file, $yaml . "\n" . $html);

        $yamlfile = new Doc();
        if ($title != "") {
            $yamlfile['title'] = $title;
        }
        if ($tags != "") {
            $tag = explode(",", $tags);
            $put = [];
            foreach ($tag as $value) {
                array_push($put, $value);
            }
            $yamlfile['tags'] = $put;
        }
        if (!empty($image)) {
            foreach ($image as $key => $value) {
                $decoded = base64_decode($image[$key]);
                $url = "./storage/images/" . $key;
                FileSystem::write($url, $decoded);
            }
        }

        if (!$extra) {
            $yamlfile['post_dir'] = SITE_URL . "/storage/contents/{$unix}";
        } else {
            $yamlfile['post_dir'] = SITE_URL . "/storage/drafts/{$unix}";
            //$yamlfile['image'] = "./storage/images/" . $key;
        }

        // create slug by first removing spaces
        $striped = str_replace(' ', '-', $title);
        // then removing encoded html chars
        $striped = preg_replace("/(&#[0-9]+;)/", "", $striped);
        //$yamlfile['slug'] = $striped . "-{$unix}";
        $yamlfile['slug'] = $unix;
        $yamlfile['timestamp'] = $time;
        $yamlfile->setContent($content);
        $yaml = FrontMatter::dump($yamlfile);
        $file = $this->file;
        $dir = $file . $unix . ".md";
        //return $dir; die();
        $doc = FileSystem::write($dir, $yaml);
        if (!$extra) {
            if ($doc) {
                $result = array("error" => false, "action"=>"publish", "message" => "Post published successfully");
                $this->createRSS();
            } else {
                $result = array("error" => true, "action"=>"publish", "message" => "Fail while publishing, please try again");
            }
        } else {
            if ($doc) {
                $result = array("error" => false, "action"=>"savedToDrafts", "message" => "Draft saved successfully");
            } else {
                $result = array("error" => true,"action"=>"savedToDrafts", "message" => "Fail while publishing, please try again");
            }
        }

        return $result;
    }
    //get post
    public function get()
    {
        $finder = new Finder();
        // $finder->sortByModifiedTime();
        // $finder->reverseSorting();

        // find all files in the current directory

        $finder->files()->in($this->file);

        $posts = [];
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                //$document = FileSystem::read($this->file);
                $parsedown  = new Parsedown();
                $tags = isset($yaml['tags']) ? $yaml['tags'] : '';
                $title = isset($yaml['title']) ? $parsedown->text($yaml['title']) : '';
                $slug = $parsedown->text($yaml['slug']);
                $image = isset($yaml['image']) ? $parsedown->text($yaml['image']) : '';
                $slug = preg_replace("/<[^>]+>/", '', $slug);
                $image = preg_replace("/<[^>]+>/", '', $image);
                $bd = $parsedown->text($body);
                ////
                preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $bd, $matches);
                $first_img = false;
                if (isset($matches[1])) {
                    // there are images
                    $first_img = $matches[1];
                    // strip all images from the text
                    $bd = preg_replace("/<img[^>]+\>/i", " ", $bd);
                }
                $time = $parsedown->text($yaml['timestamp']);
                $url = $parsedown->text($yaml['post_dir']);
                $content['title'] = $title;
                $content['body'] = $this->trim_words($bd, 200);
                $content['url'] = $url;
                $content['timestamp'] = $time;
                $content['tags'] = $tags;
                $content['slug'] = $this->clean($slug);
                $content['preview_img'] = $first_img;
                //content['slug'] = $slug;
                $file = explode("-", $slug);
                $filename = $file[count($file) - 1];
                $content['filename'] = $filename;
                //content['timestamp'] = $time;
                $SlugArray = explode('-',$this->clean($slug));
                $content['post_id']=end($SlugArray);
                array_pop($SlugArray);
                $content['post_title']=implode('-',array_filter(array_map('trim', $SlugArray)));
                $content['image'] = $image;
                $content['date'] = date('d M Y ', $filename);
                $content['created_at'] = date('F j, Y, g:i a',$filename);
                array_push($posts, $content);
            }
            $this->array_sort_by_column($posts,'created_at');
            return $posts;
        } else {
            return false;
        }
    }

    //kjarts code for getting and creating markdown files end here

    //trim_words used in triming strings by words
   public function trim_words($string,$limit,$break=".",$pad="...")
    {
        if (strlen($string) <= $limit) return $string;

        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }

        return $string;
    }
/// sort post method added by problemSolved (@porh)
   public function array_sort_by_column(&$arr,$col,$sortMethod =SORT_DESC )
    {
        $sort_col = array();

        foreach ($arr as $key=>$row)
        {
            $sort_col[$key] = strtotime($row[$col]);
        }

        array_multisort($sort_col,$sortMethod,$arr);
    }

    ///use to clean slug special chars by problemSolved
   public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function fetchAllRss()
    {
        $xml = file_get_contents(storage_path("/rss/rss.xml"));
        $feed = [];
        if (strlen($xml != "")) {
            $rss = new \DOMDocument();

            $data = file_get_contents(storage_path("/rss/subscription.json"));
            $urlArray = json_decode($data, true);
            $user = Auth::user();
            $urlArray2 = array(
                array('name' => $user['name'], 'rss' => storage_path('/rss/rss.xml'), 'desc' => '', 'link' => '', 'img' => $user['image'], 'time' => ''),
                //                array('name' => 'Sample',  'url' => 'rss/rss.xml')
            );

            $result = array_merge($urlArray, $urlArray2);
            //  print_r($result);
            foreach ($result as $url) {
                $rss->load($url['rss']);

                foreach ($rss->getElementsByTagName('item') as $node) {
                    if (!isset($node->getElementsByTagName('image')->item(0)->nodeValue)) {

                        $item = array(
                            'site'  => $url['name'],
                            'img'  => $url['img'],
                            'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                            'desc'  => $node->getElementsByTagName('description')->item(0)->nodeValue,
                            //'link'  => $node->getElementsByTagName('link')->item(0)->nodeValue . "?d=" . base64_encode(SITE_URL),
                            'link'  => $node->getElementsByTagName('link')->item(0)->nodeValue,
                            'date'  => date("F j, Y, g:i a", strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue)),

                        );
                    } else {
                        $item = array(
                            'site'  => $url['name'],
                            'img'  => $url['img'],
                            'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                            'desc'  => $node->getElementsByTagName('description')->item(0)->nodeValue,
                            'link'  => $node->getElementsByTagName('link')->item(0)->nodeValue,
                            'date'  => date("F j, Y, g:i a", strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue)),
                            'image'  => $node->getElementsByTagName('image')->item(0)->nodeValue,
                        );
                    }
                    array_push($feed, $item);
                }
            }
            krsort($feed);
            return $feed;
        } else {
            return false;
        }
    }
    //RSS designed By DMAtrix;
    public function fetchRss()
    {

        $xml = file_get_contents("../storage/rss/rss.xml");

        if (strlen($xml !== "")) {
            $feed = [];
            $rss = new \DOMDocument();
            $user = Auth::user();
            $urlArray = array(
                array('name' => $user['name'], 'url' => '../storage/rss/rss.xml', 'img' => $user['image']),
            );

            foreach ($urlArray as $url) {
                $rss->load($url['url']);

                foreach ($rss->getElementsByTagName('item') as $node) {
                    $item = array(
                        'site'  => $url['name'],
                        'img'  => $url['img'],
                        'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                        'desc'  => $node->getElementsByTagName('description')->item(0)->nodeValue,
                        'link'  => $node->getElementsByTagName('link')->item(0)->nodeValue,
                        'date'  => date("F j, Y, g:i a", strtotime($node->getElementsByTagName('pubDate')->item(0)->nodeValue)),
                        'image'  => $node->getElementsByTagName('image')->item(0)->nodeValue,
                    );
                    array_push($feed, $item);
                }
            }
            krsort($feed);
            return $feed;
        } else {
            return false;
        }
        krsort($feed);
        return $feed;
    }
    //store rss By DMAtrix
    public function createRSS()
    {
        $user = file_get_contents("./src/config/auth.json");
        $user = json_decode($user, true);

          date_default_timezone_set("Africa/Lagos");
        $Feed = new RSS2;
        // Setting some basic channel elements. These three elements are mandatory.
        $Feed->setTitle($user['name']);
        $Feed->setLink(SITE_URL);
        $Feed->setDescription("");

        // Image title and link must match with the 'title' and 'link' channel elements for RSS 2.0,
        // which were set above.
        $Feed->setImage($user['name'], '', $user['image']);

        $Feed->setChannelElement('language', 'en-US');
        $Feed->setDate(date(DATE_RSS, time()));
        $Feed->setChannelElement('pubDate', date(\DATE_RSS, strtotime('2013-04-06')));


        $Feed->setSelfLink(SITE_URL . 'storage/rss/rss.xml');
        $Feed->setAtomLink('http://pubsubhubbub.appspot.com', 'hub');

        $Feed->addNamespace('creativeCommons', 'http://backend.userland.com/creativeCommonsRssModule');
        $Feed->setChannelElement('creativeCommons:license', 'http://www.creativecommons.org/licenses/by/1.0');

        $Feed->addGenerator();

        $finder = new Finder();
        $finder->files()->in($this->file);
        //print_r($finder->hasResults());
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();

                $parsedown  = new Parsedown();

                $title = isset($yaml['title']) ? $parsedown->text($yaml['title']) : '';
                $slug = $parsedown->text($yaml['slug']);
                $image = isset($yaml['image']) ? $parsedown->text($yaml['image']) : '';
                $slug = preg_replace("/<[^>]+>/", '', $slug);
                $image = preg_replace("/<[^>]+>/", '', $image);
                $bd = $parsedown->text($body);

                preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $bd, $matches);
                $first_img = false;
                if (isset($matches[1])) {
                    // there are images
                    $first_img = $matches[1];
                    // strip all images from the text
                    $bd = preg_replace("/<img[^>]+\>/i", "", $bd);
                }
                $time = $parsedown->text($yaml['timestamp']);
                $url = $parsedown->text($yaml['post_dir']);
                $newItem = $Feed->createNewItem();
                $newItem->setTitle(strip_tags($title));
                $newItem->setLink("/post/" . strtolower($slug));
                $newItem->setDescription(substr(strip_tags($bd), 0, 100));
                $newItem->setDate(date(\DateTime::RSS, strtotime($yaml['timestamp'])));

                $newItem->setAuthor($user['name'], $user['email']);
                $newItem->setId($url, true);
                $newItem->addElement('source', $user['name'] . '\'s page', array('url' => SITE_URL));

                $newItem->addElement('image', $first_img);

                $Feed->addItem($newItem);
            }
            $myFeed = $Feed->generateFeed();
            $handle = "./storage/rss/rss.xml";
            $doc = FileSystem::write($handle, $myFeed);
            //        fwrite($handle, $myFeed);
            //      fclose($handle);
           // $strxml = $Feed->printFeed();
        } else {
            return false;
        }
    }

    //RSS designed By DMAtrix;
    public function getRss()
    {
        $user = file_get_contents("./src/config/auth.json");
        $user = json_decode($user, true);

        date_default_timezone_set('UTC');
        $Feed = new RSS2;
        // Setting some basic channel elements. These three elements are mandatory.
        $Feed->setTitle($user['name']);
        $Feed->setLink(SITE_URL);
        $Feed->setDescription("");

        // Image title and link must match with the 'title' and 'link' channel elements for RSS 2.0,
        // which were set above.
        $Feed->setImage($user['name'], '', $user['image']);

        $Feed->setChannelElement('language', 'en-US');
        $Feed->setDate(date(DATE_RSS, time()));
        $Feed->setChannelElement('pubDate', date(\DATE_RSS, strtotime('2013-04-06')));


        $Feed->setSelfLink(SITE_URL . 'storage/rss/rss.xml');
        $Feed->setAtomLink('http://pubsubhubbub.appspot.com', 'hub');

        $Feed->addNamespace('creativeCommons', 'http://backend.userland.com/creativeCommonsRssModule');
        $Feed->setChannelElement('creativeCommons:license', 'http://www.creativecommons.org/licenses/by/1.0');

        $Feed->addGenerator();

        $finder = new Finder();
        $finder->files()->in($this->file);

        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();

                $parsedown  = new Parsedown();

                $title = $parsedown->text($yaml['title']);
                $slug = $parsedown->text($yaml['slug']);
                $slug = preg_replace("/<[^>]+>/", '', $slug);
                $bd = $parsedown->text($body);
                $time = $parsedown->text(time());
                $url = $parsedown->text($yaml['post_dir']);

                $newItem = $Feed->createNewItem();
                $newItem->setTitle(strip_tags($title));
                $newItem->setLink($slug);
                $newItem->setDescription(substr(strip_tags($bd), 0, 100));
                $newItem->setDate("2013-04-07 00:50:30");

                $newItem->setAuthor($user['name'], $user['email']);
                $newItem->setId($url, true);
                $newItem->addElement('source', $user['name'] . '\'s page', array('url' => SITE_URL));
                $Feed->addItem($newItem);
            }
            $myFeed = $Feed->generateFeed();

            $strxml = $Feed->printFeed();
        } else {
            return false;
        }
    }
    public function subscriber()
    {
        $db = "./storage/rss/subscriber.json";
        $file = FileSystem::read($db);
        $data = json_decode($file, true);
        if (count($data) >= 1) {
            unset($file);
            $posts = [];
            foreach ($data as $key => $value) {

                $content['name'] = $value['name'];
                $content['img'] = $value['img'];
                $content['time'] = $value['time'];
                $content['desc'] = $value['desc'];
                $content['link'] = $value['link'];
                array_push($posts, $content);
            }
            return $posts;
        }
    }
    public function subscription()
    {
        $db = "./storage/rss/subscription.json";
        $file = FileSystem::read($db);
        $data = json_decode($file, true);
        unset($file);
        $posts = [];
        foreach ($data as $key => $value) {

            $content['name'] = $value['name'];
            $content['img'] = $value['img'];
            $content['time'] = $value['time'];
            $content['desc'] = $value['desc'];
            $content['link'] = $value['link'];
            array_push($posts, $content);
        }
        return $posts;
    }
    //code for returnng details of each codes
    public function getEach($id)
    {
        $finder = new Finder();
        // find all files in the current directory
        $finder->files()->in($this->file);
        $posts = [];
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                //$document = FileSystem::read($this->file);
                $parsedown  = new Parsedown();
                $slug = $parsedown->text($yaml['slug']);
                $slug = preg_replace("/<[^>]+>/", '', $slug);
                if ($slug == $id) {
                    $title = isset($yaml['title']) ? $parsedown->text($yaml['title']) : '';;
                    $bd = $parsedown->text($body);
                    $time = $parsedown->text($yaml['timestamp']);
                    $url = $parsedown->text($yaml['post_dir']);
                    $content['title'] = $title;
                    $content['body'] = $bd;
                    $content['url'] = $url;
                    $content['timestamp'] = $time;
                    array_push($posts, $content);
                }
            }
            return $posts;
        }
    }
    //end of get a post function

    // post
    public function tagPosts($id)
    {
        $finder = new Finder();
        // find all files in the current directory
        $finder->files()->in($this->file);
        $posts = [];
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                //$document = FileSystem::read($this->file);
                $parsedown  = new Parsedown();
                // skip this document if it has no tags
                if (!isset($yaml['tags'])) {
                    continue;
                }
                $tags = $yaml['tags'];
                for ($i = 0; $i < count($tags); $i++) {
                    // strip away the leading "#" of the tag name
                    if (substr($tags[$i], 1) == $id) {
                        $slug = $parsedown->text($yaml['slug']);
                        $bd = $parsedown->text($body);

                        // get the first image in the post body
                        // it will serve as the preview image
                        preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $bd, $matches);
                        $first_img = false;
                        if (isset($matches[1])) {
                            // there are images
                            $first_img = $matches[1];
                            // strip all images from the text
                            $bd = preg_replace("/<img[^>]+\>/i", " ", $bd);
                        }
                        $time = $parsedown->text($yaml['timestamp']);
                        $url = $parsedown->text($yaml['post_dir']);
                        if (isset($yaml['title'])) {
                            $title = $parsedown->text($yaml['title']);
                            $content['title'] = $title;
                        }
                        $content['body'] = $bd;
                        $content['url'] = $url;
                        $content['timestamp'] = $time;
                        $content['tags'] = $tags;
                        $content['slug'] = $yaml['slug'];
                        $content['preview_img'] = $first_img;
                        array_push($posts, $content);
                    }
                }
            }
        }
        return $posts;
    }

    //kjarts code for deleting post
    public function delete($id, $extra)
    {
        $finder = new Finder();
        // find all files in the current directory
        $finder->files()->in($this->file);
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                $parsedown  = new Parsedown();
                $slug = $parsedown->text($yaml['slug']);
                $slug = preg_replace("/<[^>]+>/", '', $slug);
                if ($slug == $id) {
                    unlink($file);
                    $delete = "File deleted successfully";
                }
            }
            if (!$extra) {
                $this->createRSS();
            }
            return $delete;
        }
    }
    //deleteapOST by ProblemSolved;
    public function deletePost($post)
    {
        $finder = new Finder();
        // find post in the current directory
        $finder->files()->in($this->file)->name($post . '.md');
        if (!$finder->hasResults()) {
            return $this->redirect('/404');
        } else {
            ///coming back for some modifications
            unlink($this->file.$post.'.md');
            $this->createRSS();
        }
    }

    //get single post

    public function getPost($post)
    {
        $finder = new Finder();
        // find post in the current directory
        $finder->files()->in($this->file)->name($post . '.md');
        $content = [];
        if (!$finder->hasResults()) {
            return $this->redirect('/404');
        } else {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                $parsedown  = new Parsedown();
                $yamlTag = isset($yaml['tags']) ? $yaml['tags'] : [];
                $tags = [];
                foreach ($yamlTag as $tag) {
                    $removeHashTag = explode('#', $tag);
                    $tags[] = trim(end($removeHashTag));
                }

                $slug = $parsedown->text($yaml['slug']);
                $slug = preg_replace("/<[^>]+>/", '', $slug);
                $title = isset($yaml['title']) ? $parsedown->text($yaml['title']) : '';
                $bd = $parsedown->text($body);
                preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $bd, $matches);
                $first_img = '';
                if (isset($matches[1])) {
                    $first_img = $matches[1];
                }
                $time = $parsedown->text($yaml['timestamp']);
                $url = $parsedown->text($yaml['post_dir']);
                $content['tags'] = $tags;
                $content['title'] = $title;
                $content['body'] = $bd;
                $content['url'] = $url;
                $content['timestamp'] = $time;
                $content['date'] = date('d M Y ', $post);
                $content['crawlerImage'] = $first_img;
                $content['slug'] = $this->clean($slug);
                $SlugArray = explode('-',$this->clean($slug));
                $content['post_id']=end($SlugArray);
                array_pop($SlugArray);
                $content['post_title']=implode('-',array_filter(array_map('trim', $SlugArray)));
            }
            return $content;
        }
    }

    public function update_Post($title, $content, $tags, $image, $extra,$post_id)
    {
        $time = date(DATE_RSS, time());
        $unix = strtotime($time);
        // Write md file
        $document = FrontMatter::parse($content);
        $md = new Parser();
        $markdown = $md->parse($document);

        $yaml = $markdown->getYAML();
        $html = $markdown->getContent();
        //$doc = FileSystem::write($this->file, $yaml . "\n" . $html);

        $yamlfile = new Doc();
        if($title != ""){
        $yamlfile['title'] = $title;
        }
        if ($tags != "") {
            $tag = explode(",", $tags);
            $put = [];
            foreach ($tag as $value) {
                array_push($put, $value);
            }
            $yamlfile['tags'] = $put;
        }
        if (!empty($image)) {
            foreach ($image as $key => $value) {
                $decoded = base64_decode($image[$key]);
                $url = "./storage/images/" . $key;
                FileSystem::write($url, $decoded);
            }
        }

        if (!$extra) {
            $yamlfile['post_dir'] = SITE_URL . "/storage/contents/{$post_id}";
        } else {
            $yamlfile['post_dir'] = SITE_URL . "/storage/drafts/{$post_id}";
            $yamlfile['image'] = "./storage/images/" . $key;
        }

        // create slug by first removing spaces
        $striped = str_replace(' ', '-', $title);
        // then removing encoded html chars
        $striped = preg_replace("/(&#[0-9]+;)/", "", $striped);
        $yamlfile['slug'] = $striped . "-{$post_id}";
        $yamlfile['timestamp'] = $time;
        $yamlfile->setContent($content);
        $yaml = FrontMatter::dump($yamlfile);
        $dir = $this->file.$post_id.'.md';
        $explodeSChars = explode('&#10;',$yaml);
        $fopen = fopen($dir,'w');
        foreach($explodeSChars as $yamlTextContent )
        {
            $doc = fwrite($fopen, $yamlTextContent.PHP_EOL);
        }

        if (!$extra) {
            if ($doc) {
                $result =  array("error" => false, "action"=>"update", "message" => "Post Updated successfully");
                $this->createRSS();
            } else {
                $result = array("error" => true,"action"=>"update", "message" => "Fail while Updating, please try again");
            }
        } else {
            if ($doc) {
                $result = array("error" => false, "action"=>"save_draft", "message" => "Draft saved successfully");
            } else {
                $result = array("error" => true, "action"=>"save_draft", "message" => "Fail while updating, please try again");
            }
        }

        return $result;


    }


    public function redirect($location)
    {
        header('Location:' . $location);
    }

    public function getRelatedPost($limit = 4, $tags, $skip_post)
    {

        $finder = new Finder();
        // find post in the current directory
        $finder->files()->in($this->file)->notName($skip_post . '.md')->contains($tags);
        $posts = [];
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                //$document = FileSystem::read($this->file);
                $parsedown  = new Parsedown();
                if (!isset($yaml['tags'])) {
                    continue;
                }
                $tags = $yaml['tags'];

                $slug = $parsedown->text($yaml['slug']);
                $image = isset($yaml['image']) ? $parsedown->text($yaml['image']) : '';
                $slug = preg_replace("/<[^>]+>/", '', $slug);
                $image = preg_replace("/<[^>]+>/", '', $image);
                $bd = $parsedown->text($body);
                preg_match('/<img[^>]+src="((\/|\w|-)+\.[a-z]+)"[^>]*\>/i', $bd, $matches);
                $first_img = false;
                if (isset($matches[1])) {
                    // there are images
                    $first_img = $matches[1];
                    // strip all images from the text
                    $bd = preg_replace("/<img[^>]+\>/i", " ", $bd);
                }
                $time = $parsedown->text($yaml['timestamp']);
                $url = $parsedown->text($yaml['post_dir']);
                if (isset($yaml['title'])) {
                    $title = $parsedown->text($yaml['title']);
                    $content['title'] = $title;
                }
                $content['url'] = $url;
                $content['timestamp'] = $time;
                $content['tags'] = str_replace('#', '', implode(',', $tags));
                $content['slug'] = $this->clean($slug);
                $content['preview_img'] = $first_img;
                //content['slug'] = $slug;
                $file = explode("-", $slug);
                $filename = $file[count($file) - 1];
                $content['filename'] = $filename;
                //content['timestamp'] = $time;
                $SlugArray = explode('-',$this->clean($slug));
                $content['post_id']=end($SlugArray);
                array_pop($SlugArray);
                $content['post_title']=implode('-',array_filter(array_map('trim', $SlugArray)));
                $content['image'] = $image;
                $content['date'] = date('d M Y ', $filename);
                $content['created_at'] = date('F j, Y, g:i a',$filename);
                array_push($posts, $content);
            }
            $this->array_sort_by_column($posts,'created_at');
            $countPosts = count($posts);
            if ($countPosts > $limit)
                array_shift($posts);
            return $posts;
        } else {
            return false;
        }
    }
    //stupid code by problemSolved ends here

    /**
     * updates a post stored in an md file
     * and echos a json object;
     *
     * @param [type] $mdfile
     * @param [type] $title
     * @param [type] $content
     * @param [type] $tags
     * @param [type] $image
     * @return void
     */
    public function updatePost($mdfile, $title, $content, $tags, $image)
    {
        $text = file_get_contents($mdfile);
        $document = FrontMatter::parse($text);
        $date = date("F j, Y, g:i a");
        // var_dump($document);
        // var_dump($document->getConfig());
        // var_dump($document->getContent());
        // var_dump($document['tags']);
        $document = new Doc();
        $tmp_title = explode(' ', $title);
        $slug = implode('-', $tmp_title);
        $document['title'] = $title;
        $document['slug'] = $slug;
        $document['timestamp'] = $date;
        $document['tags'] = explode(',', $tags);
        $hashedTags = [];
        // adding hash to the tags before storage
        foreach ($document['tags'] as $tag) {
            $hashedTags[] = '#' . $tag;
        }
        $document['tags'] = $hashedTags;
        $document['image'] = $image;
        $document->setContent($content);
        $yamlText = FrontMatter::dump($document);
        // var_dump($yamlText);
        $doc = FileSystem::write($mdfile, $yamlText);
        if ($doc) {
            $result = array("error" => false, "message" => "Post published successfully");
        } else {
            $result = array("error" => true, "message" => "Fail while publishing, please try again");
        }
        echo json_encode($result);
    }

    public function getSinglePost($id)
    {
        $directory = "./storage/contents/${id}.md";
        // var_dump($directory);
        $document = FrontMatter::parse(file_get_contents($directory));
        // var_dump($document);
        $content['title'] = $document['title'];
        $content['body'] = $document->getContent();
        // $content['url'] = $url;
        $content['timestamp'] = $document['timestamp'];

        return $content;
    }

    public function addVideo($url, $title, $content)
    {
        $time = date("F j, Y, g:i a");
        $unix = strtotime($time);
        // Write md file
        $document = FrontMatter::parse($content);
        $md = new Parser();
        $markdown = $md->parse($document);

        $yaml = $markdown->getYAML();
        $html = $markdown->getContent();
        //$doc = FileSystem::write($this->file, $yaml . "\n" . $html);

        $yamlfile = new Doc();
        $yamlfile['title'] = $title;
        $yamlfile['url'] = $url;

        $striped = str_replace(' ', '-', $title);
        $yamlfile['slug'] = $striped . "-{$unix}";
        $yamlfile['timestamp'] = $time;
        $yamlfile->setContent($content);
        $yaml = FrontMatter::dump($yamlfile);
        $file = $this->file;
        $dir = $file . $unix . ".md";
        //return $dir; die();
        $doc = FileSystem::write($dir, $yaml);
        if ($doc) {
            return true;
        }
        return false;
    }

    //get video
    public function getVideo()
    {
        $finder = new Finder();

        // find all files in the current directory
        $finder->files()->in($this->file);
        $videos = [];
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                //$document = FileSystem::read($this->file);
                $parsedown  = new Parsedown();
                $title = $parsedown->text($yaml['title']);
                $bd = $parsedown->text($body);
                $time = $parsedown->text($yaml['timestamp']);
                $url = $parsedown->text($yaml['url']);
                $content['title'] = $title;
                $content['description'] = $bd;
                $content['domain'] = $url;
                $content['timestamp'] = $time;
                array_push($videos, $content);
            }
            return $videos;
        } else {
            return $videos;
        }
    }
}
