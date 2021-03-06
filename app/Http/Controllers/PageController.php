<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data = [
            'fname' => 'Evan',
            'lname' => 'Tolorio'
        ];
        
        return Inertia::render('Dashboard/Index', $data);
    }
}
