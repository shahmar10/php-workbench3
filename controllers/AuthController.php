<?php


namespace App\controllers;

use App\core\Controller;
use App\core\Request;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $this->setLayout('auth');
        if($request->isPost()){
            return 'submit';
        }


        return $this->render('register');
    }
}