<?php 
namespace Lucid\Core;

class Page{

    public function setAboutPage($request)
    {
        $dir = './storage/page';
        if(!file_exists($dir))
        {
            mkdir($dir);
        }
        $fopen = fopen($dir.'/about.md','w');
        if(fwrite($fopen,$request['aboutMe']))
        {
            $response = ['success'=>true];
            return $response;
        }
        else
        {
            $response = ['error'=>true];
            return $response;
        }
    }

    public function getPage()
    {
        $page = './storage/page/about.md';
        if(file_exists($page))
        {
            return file_get_contents($page);
        }
    }
}

?>