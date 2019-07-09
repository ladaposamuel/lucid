<?php
namespace Lucid\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Template
{
    private $twig;


    public function __construct($templatePath)
    {
        $this->twig = new Environment(new FilesystemLoader($templatePath), $this->setTwigCaching());
    }

    public static function getSettings() {
        $file = "./src/config/auth.json";
        if (file_exists($file)) {
            $content = json_decode(file_get_contents($file), true);
			return $content;
		}
    }

    public static function getAppSettings() {
        $file = "./src/config/app.json";
        if (file_exists($file)) {
            $content = json_decode(file_get_contents($file), true);
			return $content;
		}
    }

    public static function getLoginUser() {
        $user = new Auth();
        if (!$user->is_logged_in()) {
            return new RedirectResponse("/");
        }
        else{
            $login_user = $user->is_logged_in();
            return $login_user['login_user'];
        }
    }

    private static function getUrlSha(){
        $user = new Auth();
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $host = $user->hash($url);
        return $host;
    }

    public function render($page, array $parameters = [])
    {
        $settings = self::getSettings();
        $user = self::getLoginUser();
        $url = self::getUrlSha();
        $appsettings = self::getAppSettings(); //load appsettings
        $this->twig->addGlobal('settings', $settings);
        $this->twig->addGlobal('user', $user);
        $this->twig->addGlobal('host', $url);
        $this->twig->addGlobal('appsettings', $appsettings);
        return $this->twig->render($page, $parameters);
    }

    private function setTwigCaching()
    {
        $data = [];

        if (ZIKI_PROD) {
            $data = [
                'auto_reload' => true,
                'cache' => ZIKI_BASE_PATH . '/storage/cache/views',
            ];
        } else {
                $data = [
                    'auto_reload' => true,
                    'cache' => false,
                ];
            }
        return $data;
    }
}
