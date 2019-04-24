<?php

namespace App\Http\Controllers;

use Illuminate\View\Factory;

class DefaultController extends Controller
{
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function index($page = null)
    {
        if ($page === null) {
            return view('index');
        }

        if ($this->factory->exists('pages.' . $page)) {
            return view('pages.' . $page);
        }

        abort(404);
    }
}
