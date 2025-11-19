<?php

namespace App\controllers;


class HomeController extends Controller
{
    public function __construct() {}


    public function index()
    {
        return $this->view("home");
    }
}
