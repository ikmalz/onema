<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home.homepage'); 
    } 

    public function ikmal(){
        return view('home.detail');
    }
}
