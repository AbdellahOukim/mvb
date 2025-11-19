<?php

namespace Core;

class RedirectResponse
{
    protected string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function with(array $messages): static
    {
        $_SESSION['messages'] = $messages;
        $_SESSION['old'] = $_POST;
        return $this;
    }

    public function send()
    {
        header("Location: {$this->url}");
        exit;
    }
}
