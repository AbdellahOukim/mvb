<?php

namespace Core;

class BaseController
{
    protected array $param = [];

    public function __construct()
    {
        $this->param = array_merge($_GET, $_POST, $_FILES);
    }

    protected function view($view, $param = [])
    {
        View::make($view, $param);
    }

    protected function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }

    protected function json(array $data, int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
