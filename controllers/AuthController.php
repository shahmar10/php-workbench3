<?php


namespace App\controllers;

use App\core\Controller;
use App\core\Request;
use App\models\RegisterModel;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request)
    {
        $registerModel = new RegisterModel();
        //Post olarsa
        if($request->isPost()){

            $registerModel->loadData($request->getBody());
            var_dump($registerModel);
            if($registerModel->validate() && $registerModel->register()){
                return 'success';
            }
            return $this->render('register',[
                'model' => $registerModel
            ]);

        }

        //GET olarsa

        $this->setLayout('auth');
        return $this->render('register',[
            'model' => $registerModel
        ]);
    }
}