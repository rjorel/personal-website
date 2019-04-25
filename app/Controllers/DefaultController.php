<?php

namespace App\Controllers;

class DefaultController extends Controller
{
    public function index()
    {
        return $this->render('views/pages/index.html.twig');
    }

    public function skills()
    {
        return $this->render('views/pages/skills.html.twig');
    }

    public function achievements()
    {
        return $this->render('views/pages/achievements.html.twig');
    }

    public function contact()
    {
        return $this->render('views/pages/contact.html.twig');
    }

    public function about()
    {
        return $this->render('views/pages/about.html.twig');
    }
}
