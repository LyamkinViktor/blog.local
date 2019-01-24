<?php

namespace application\core;

class Router
{
    protected $routes = [];
    protected $params = [];


    /**
     * Router constructor.
     * Добавляет в add() маршрут и параметры
     */
    public function __construct()
    {
        $arr = require __DIR__ . '/../config/routes.php';
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
        //debug($this->routes);
    }

    /**
     * Функция на добавение маршрута
     *
     * @param $route
     * @param $params
     */
    public function add($route, $params) {
        $route = '#^' . $route . '$#';
        $this->routes[$route] = $params;
    }

    /**
     * Функция проверяет есть ли такой маршрут
     * @return bool
     */
    public function match(){
        $url = trim($_SERVER['REQUEST_URI'], '/');
        //debug($url);
        foreach ($this->routes as $route => $params) {
            //var_dump($route);
            if (preg_match($route, $url, $matches)) {
                //debug($matches);
                //var_dump($params);
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Функция запуска роутера
     */
    public function run(){
        if ($this->match()) {
            $patch = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($patch)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($patch, $action)) {
                    $controller = new $patch($this->params);
                    $controller->$action();
                } else {
                    echo 'Не найден экшен: ' . $action;
                }
            } else {
                echo 'Не найден контроллер: ' . $patch;
            }
        } else {
            echo 'маршрут не найден';
        }
    }
}