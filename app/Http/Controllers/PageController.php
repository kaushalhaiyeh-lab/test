<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::where('slug', 'home')->firstOrFail();

        return view('pages.home', compact('page'));
    }

    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('pages.show', compact('page'));
    }
}
