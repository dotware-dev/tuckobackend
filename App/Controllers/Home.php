<?php
    namespace App\Controllers;

    use \Core\View;
    use \Core\Template;

    // use App\Models\Post;

    class Home extends \Core\Controller
    {
        public function indexAction()
        {
            Template::view('home/index');
        }
    }
