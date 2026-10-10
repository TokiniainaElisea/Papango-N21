<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    //about
    public function about(){
        return view('preference.about');
    }
}
