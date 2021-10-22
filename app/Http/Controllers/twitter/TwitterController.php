<?php

namespace App\Http\Controllers\twitter;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TwitterController extends Controller
{
    /**
     * This method will prepare and show the twitter index view.
     */
    public function index(Request $request): View
    {
        return view('twitter.index');
    }
}
