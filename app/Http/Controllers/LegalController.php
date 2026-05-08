<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Display the privacy policy page.
     */
    public function privacy()
    {
        return view('legal.privacy', ['content' => null]);
    }

    /**
     * Display the terms of service page.
     */
    public function terms()
    {
        return view('legal.terms', ['content' => null]);
    }

    /**
     * Display the cookie policy page.
     */
    public function cookies()
    {
        return view('legal.cookies', ['content' => null]);
    }
}
