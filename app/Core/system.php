<?php

namespace Lucid\Core;

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
        if((self::validPHPVersion() == true)) {
            return true;
        }
        else{
            $result = array("error" => true, "message" => "System requires php 7+.");
            return $result;
        }
    }
}
