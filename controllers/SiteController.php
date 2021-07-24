<?php

namespace App\controllers;

use App\core\Application;
use App\core\Controller;
use App\core\Request;

class SiteController extends Controller
{
    public function home()
    {
        $name = "Shahmar";
        return $this->render('home',compact('name'));
    }

    public function contact()
    {
        return $this->render('contact');
    }

    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        var_dump($body);
        return 'Submitted cont';
    }
}