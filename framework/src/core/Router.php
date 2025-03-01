<?php
namespace src\core;

class Router
{
    protected $controller = 'HomeController';
    protected $action = 'index';
    protected $params = [];

    /**
     * Основной метод маршрутизации запросов.
     * Анализирует URL, определяет контроллер, действие и параметры,
     * после чего вызывает соответствующий метод контроллера с переданными параметрами.
     */
    public function dispatch($url)
    {
        $url = $this->parseUrl($url);

        // Получение контроллера
        if (isset($url[0]) && !empty($url[0])) {
            
            $controllerName = ucfirst($url[0]) . 'Controller';
            
            if (file_exists(BASE_PATH . '/src/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            } else {
                $this->handleNotFound();
                return;
            }
        }

        $controllerClass = 'src\\controllers\\' . $this->controller;
        $controller = new $controllerClass();

        // Получение метода (действия)
        if (isset($url[1]) && !empty($url[1])) {
            if (method_exists($controller, $url[1])) {
                $this->action = $url[1];
                unset($url[1]);
            } else {
                $this->handleNotFound();
                return;
            }
        }

        // Получение параметров
        $this->params = $url ? array_values($url) : [];

        // Вызов метода контроллера с параметрами
        call_user_func_array([$controller, $this->action], $this->params);
    }

    // Преобразование URL в массив
    protected function parseUrl($url)
    {
        if ($url != '') {
            return explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }

    // Обработка 404 ошибки
    protected function handleNotFound()
    {
        header("HTTP/1.0 404 Not Found");
        include BASE_PATH . '/src/views/error/404.php';
    }
} 