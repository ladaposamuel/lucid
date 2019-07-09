<?php
namespace Lucid\Core;

use Parsedown;
use Mni\FrontYAML\Parser;
use KzykHys\FrontMatter\FrontMatter;
use Symfony\Component\Finder\Finder;
use KzykHys\FrontMatter\Document as Doc;


/**
 *	The document class holds all properties and methods of a single page document.
 *
 */

class Portfolio
{

    //define an instance of the symfony clss
    //define an instance of the frontMatter class

    protected $file;

    public function __construct($file)
    {
        $this->file       = $file;
    }

    public function file()
    {
        return $this->file;
    }

    //for creating markdown files
    public function createportfolio($title, $content, $image)
    {
        $time = date(DATE_RSS, time());
        $unix = strtotime($time);
        // Write md file
        $document = FrontMatter::parse($content);
        $md = new Parser();
        $markdown = $md->parse($document);

        $yaml = $markdown->getYAML();
        $html = $markdown->getContent();

        $yamlfile = new Doc();
        if ($title != "") {
            $yamlfile['title'] = $title;
        }
        if (!empty($image)) {
            foreach ($image as $key => $value) {
                $decoded = base64_decode($image[$key]);
                $url = "./storage/portfolio-images/" . $key;
                FileSystem::write($url, $decoded);
            }
        }
        $yamlfile['post_dir'] = SITE_URL . "/storage/portfolio/{$unix}";


        // create slug by first removing spaces
        $striped = str_replace(' ', '-', $title);
        // then removing encoded html chars
        $striped = preg_replace("/(&#[0-9]+;)/", "", $striped);
        $yamlfile['slug'] = $striped . "-{$unix}";
        $yamlfile['timestamp'] = $time;
        $yamlfile->setContent($content);
        $yaml = FrontMatter::dump($yamlfile);
        $file = $this->file;
        $dir = $file . $unix . ".md";
        //return $dir; die();
        $doc = FileSystem::write($dir, $yaml);
        if ($doc) {
            $result = array("error" => false, "message" => "Portfolio created successfully");
            // $this->createRSS();
        } else {
            $result = array("error" => true, "message" => "Fail while creating, please try again");
        }
        return $result;
    }

    //get portfolio
    public function getportfolio()
    {
        $finder = new Finder();

        // find all files in the current directory
        $finder->files()->in($this->file);
        $portf = [];
        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $document = $file->getContents();
                $parser = new Parser();
                $document = $parser->parse($document);
                $yaml = $document->getYAML();
                $body = $document->getContent();
                // $document = FileSystem::read($this->file);
                $parsedown  = new Parsedown();
                // $tags = isset($yaml['tags'])?$yaml['tags']:'';
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
                    $bd = preg_replace("/<img[^>]+\>/i", "", $bd);
                }
                $time = $parsedown->text($yaml['timestamp']);
                $url = $parsedown->text($yaml['post_dir']);
                $content['title'] = $title;
                $content['body'] = $this->trim_wordsP($bd, 200);
                $content['url'] = $url;
                $content['timestamp'] = $time;
                // $content['tags'] = $tags;
                $content['slug'] = $this->cleanP($slug);
                $content['preview_img'] = $first_img;
                // content['slug'] = $slug;
                $file = explode("-", $slug);
                $filename = $file[count($file) - 1];
                $content['filename'] = $filename;

                $SlugArray = explode('-', $this->clean($slug));
                $content['portfolio_id'] = end($SlugArray);
                array_pop($SlugArray);
                $content['post_title'] = implode('-', array_filter(array_map('trim', $SlugArray)));

                // content['timestamp'] = $time;
                $content['image'] = $image;
                // $content['date'] = date('d M Y ', $filename);

                array_push($portf, $content);
            }
            return ($portf);
        } else {
            return false;
        }
    }

    //trim_words used in triming strings by words
    function trim_wordsP($string, $limit, $break = ".", $pad = "...")
    {
        if (strlen($string) <= $limit) return $string;

        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }

        return $string;
    }

    ///use to clean slug special chars problem solved
    public function cleanP($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    //code for returnng details of each portfolio
    public function getEachPortfolio($id)   //mimics the getEach function in document.php
    {
        $finder = new Finder();
        // find all files in the current directory
        $finder->files()->in($this->file);
        $portf = [];
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
                    array_push($portf, $content);
                }
            }
            return $portf;
        }
    }
    //end of get a portfolio function

    public function getOnePortfolio($portf) //mimics getPost function in document.php
    {
        $finder = new Finder();
        // find portfolio in the current directory
        $finder->files()->in($this->file)->name($portf . '.md');
        $contentP = [];
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
                // $yamlTag = isset($yaml['tags']) ? $yaml['tags'] : [];

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
                $contentP['title'] = $title;
                $contentP['body'] = $bd;
                $contentP['url'] = $url;
                $contentP['timestamp'] = $time;
                $contentP['date'] = date('d M Y ', $portf);
                $contentP['crawlerImage'] = $first_img;
                $contentP['slug'] = $this->clean($slug);
                $SlugArray = explode('-', $this->clean($slug));
                $content['portfolio_id'] = end($SlugArray);
                array_pop($SlugArray);
                $content['post_title'] = implode('-', array_filter(array_map('trim', $SlugArray)));
            }
            return $contentP;
        }
    }

    public function getSinglePortfolio($id)
    {
        $directory = "./storage/portfolio/${id}.md";
        // var_dump($directory);
        $document = FrontMatter::parse(file_get_contents($directory));
        // var_dump($document);
        $content['title'] = $document['title'];
        $content['body'] = $document->getContent();
        // $content['url'] = $url;
        $content['timestamp'] = $document['timestamp'];

        return $content;
    }

    public function redirect($location)
    {
        header('Location:' . $location);
    }

    //delete a portfolio
    public function deletePortfolio($portf)
    {
        $finder = new Finder();
        // find post in the current directory
        $finder->files()->in($this->file)->name($portf . '.md');
        if (!$finder->hasResults()) {
            return $this->redirect('/404');
        } else {
            ///coming back for some modifications
            unlink($this->file . $portf . '.md');
            // $this->createRSS();
        }
    }

    public function delete($id)
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
            return $delete;
        }
    }

    ///use to clean slug special chars problem solved
    public function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}
