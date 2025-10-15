<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        // Aquí podrías pasar datos del modelo, por ahora solo la vista
        return view('dashboard');
    }
}
