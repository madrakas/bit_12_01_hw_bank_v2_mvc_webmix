<?php

namespace Bank\App\Controllers;

use Bank\App\App;

class HomeController
{
    public function index($color)
    {
        // return '<h1>Home</h1>';

        $number = rand(1, 13);
        return App::view('home', [
            'homeNumber' => $number,
            'homeColor' => $color
        ]);
    }

}