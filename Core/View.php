<?php
namespace Core;

    class View
    {
        /*
        Render a view file
        @param string $view The view file
        @param array $args Associative array of data to display in the view (optional)
        @return void
        */

        public static $bases=[];

        // public static function render($view, $args=[])
        // {
        //     extract($args, EXTR_SKIP);
        //     $file=dirname(__DIR__).'/App/Views/'.$view;
        //     if (file_exists($file)&&is_readable($file)) {
        //         require $file;
        //     } else {
        //         throw new \Exception("$file not found");
        //     }
        // }

        // public static function renderTemplate($template, $args=[])
        // {
        //     static $twig = null;
        //     if ($twig === null) {
        //         $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__).'/App/Views');
        //         $twig = new \Twig\Environment($loader, [
        //             'cache' => dirname(__DIR__).'/Storage/Framework/Cache',
        //         ]);
        //     }
        //     self::$bases=['url_basis'=>self::urlBasis()];
        //     echo $twig->render($template, array_merge(self::$bases, $args));
        // }
        // public static function urlBasis()
        // {
        //     $protocol=null;
        //     if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        //         $protocol = 'https://';
        //     } else {
        //         $protocol = 'http://';
        //     }
        //     return $protocol . $_SERVER['HTTP_HOST'] . '/apituko/';
        // }
    }
