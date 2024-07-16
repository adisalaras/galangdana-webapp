<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index()
    {
        return view('front.views.index');
    }

    public function category()
    {
        return view('front.views.category');
    }

    public function details()
    {
        return view('front.views.details');
    }

    public function support()
    {
        return view('front.views.support');
    }

    public function checkout()
    {
        return view('front.views.checkout');
    }

    public function store()
    {
        return view('front.views.store');
    }

}
