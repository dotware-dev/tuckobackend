<?php
    namespace Core;

    use Core\View;
    use Core\Template;

    class Error
    {
        public static function errorHandler($level, $message, $file, $line)
        {
            if (error_reporting() !== 0) {
                throw new \ErrorException($message, 0, $level, $file, $line);
            }
        }

        public static function exceptionHandler($exception)
        {
            $code = $exception->getCode();
            if (!isset($code)||empty($code)||$code==null||$code==0) {
                $code=500;
            }
            http_response_code($code);
            if (\Config\Config::SHOW_ERRORS) {
                echo "<h1>Fatal error</h1>";
                echo "<p>Uncaught exception: '".get_class($exception)."'</p>";
                echo "<p>Message: '".$exception->getMessage()."'</p>";
                echo "<p>Stack trace:<pre>".$exception->getTraceAsString()."</pre></p>";
                echo "<p>Thrown in '".$exception->getFile()."' in line ".$exception->getLine()."</p>";
            } else {
                $log=dirname(__DIR__)."/logs/".date('Y-m-d').".txt";
                ini_set("error_log", $log); // Error/Exception file logging engine.
                $message="Uncaught exception: '".get_class($exception)."'";
                $message.="\n-> Message: '".$exception->getMessage()."'";
                $message.="\n-> Stack trace:".$exception->getTraceAsString();
                $message.="\n-> Thrown in '".$exception->getFile()."' in line ".$exception->getLine();
                error_log($message); // Error/Exception file logging engine.
                Template::view("errors/$code.html");
            }
        }
    }
