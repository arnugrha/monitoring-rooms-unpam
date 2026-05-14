<?php
class App {
    protected $controller = "Home";
    protected $method = "index";
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        
        if(isset($url[0])) {
            // Cek file dengan akhiran Controller.php atau .php biasa
            $fileWithController = '../app/controllers/' . ucfirst($url[0]) . 'Controller.php';
            $fileWithoutController = '../app/controllers/' . ucfirst($url[0]) . '.php';
            
            if(file_exists($fileWithController)) {
                require_once $fileWithController;
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            } elseif(file_exists($fileWithoutController)) {
                require_once $fileWithoutController;
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            }
        }
        
        // Load controller default jika belum diload
        $controllerFile = '../app/controllers/' . $this->controller . '.php';
        if(!file_exists($controllerFile)) {
            die("Controller tidak ditemukan: " . $controllerFile);
        }
        
        if(!class_exists($this->controller)) {
            require_once $controllerFile;
        }
        
        $this->controller = new $this->controller;

        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if(!empty($url)) {
            $this->params = array_values($url);
        }
        
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}