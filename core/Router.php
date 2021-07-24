<?php
namespace App\core;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }


    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path   = $this->request->getPath();
        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;

        if( $callback === false ){ //Route yoxdursa
            $this->response->setStatusCode(404);
            $error = "\"" .$path. "\" route is undefined.<br> Method: ".$method;
            return $this->renderView("_404",compact('error'));
        }

        if(is_string($callback)){ //Route string seklinde verilende - yeni view gonderir
            return $this->renderView($callback);
        }

        //else ozunun funksiyasini ise salir
        if(is_array($callback)){
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }
        if(method_exists($callback[0],$callback[1])){
            return call_user_func($callback,$this->request);
        }else{
            $this->response->setStatusCode(404);
            $error = "\"" .$callback[1]. "\" method is undefined.<br> Method: ".$method;
            return $this->renderView("_404",compact('error'));
        }


    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view,$params);
        return str_replace('{{ content }}', $viewContent,$layoutContent);
    }

    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key=>$value){
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

    /*protected function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{ content }}', $viewContent,$layoutContent);
    }*/


}