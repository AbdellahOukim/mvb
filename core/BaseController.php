<?php

namespace Core;

class BaseController
{
    protected array $param = [];

    public function __construct()
    {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];
        $this->param = array_merge($_GET, $_POST, $_FILES, $data);
    }

    protected function view($view, $param = [])
    {
        View::make($view, $param);
    }

    protected function redirect(string $url)
    {
        return (new RedirectResponse($url));
    }

    protected function json(array $data, int $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
