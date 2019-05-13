<?php

namespace Ziki\Core;

class System {
    /**
     * This function will get the system details
     */
    public static function isCurl()
    {
        if  (in_array  ('curl', get_loaded_extensions())) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function validPHPVersion() {
        $version = phpversion();
        if ($version < 7.0) {
            return false;
        }
        else{
            return true;
        }
    }

    public static function checkSystem () {
        if((self::isCurl() == true) && (self::validPHPVersion() == true)) {
            return true;
        }
        elseif((self::isCurl() == true) && (self::validPHPVersion() == false)){
            $result = array("error" => true, "message" => "Please upgrade your php version before installing.", "version" => phpversion());
            return $result;
        }
        else{
            $result = array("error" => true, "message" => "Please install or enable curl to use lucid.");
            return $result;
        }
    }
}
