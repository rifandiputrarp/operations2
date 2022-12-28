<?php

namespace App\Http\Controllers\Lacak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LacakController extends Controller
{
    public function index(){
        return view('lacak.index');
    }
}
