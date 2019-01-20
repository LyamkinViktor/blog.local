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

        //debug($arr);
    }

    /**
     * Функция на добавение маршрута
     *
     * @param $route
     * @param $params
     */
    public function add($route, $params){

    }

    /**
     * Функция для проверки маршрута
     */
    public function match(){

    }

    /**
     * Функция запуска роутера
     */
    public function run(){
        echo 'start!';
    }
}