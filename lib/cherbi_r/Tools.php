<?php
namespace cherbi_r 
{
    class Tools {

        public static function getParam($paramName)
        {
            if (true === isset($_POST[$paramName])) {
                return $_POST[$paramName];
            }

            if (true === isset($_GET[$paramName])) {
                return $_GET[$paramName];
            }
            
            if (true === isset(Core::$param[$paramName])) {
                return Core::$param[$paramName];
            }
            
            return false;
        }
    }
}