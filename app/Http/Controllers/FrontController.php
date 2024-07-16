<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Fundraising;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //
    public function index()
    {
        $categories = Category::all();

        $fundraisings = Fundraising::with(['category', 'fundraiser'])
            ->where('is_active', 1)
            ->orderBy('id')
            ->get();
        return view('front.views.index', compact('fundraisings', 'categories'));
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
